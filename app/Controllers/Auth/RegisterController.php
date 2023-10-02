<?php

namespace App\Controllers\Auth;

use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Config\Auth AS AuthConfig;

use Bonfire\View\Themeable;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use App\Models\CaptchaModel;

class RegisterController extends ShieldRegister
{
    use Themeable;

    public function __construct()
    {
        $this->theme = 'Auth';
        helper(['auth', 'text', 'captcha']);
		$this->session = service('session');
		
		$this->auth = service('authentication');
		$this->config = config('Auth');
		
		$this->captchaModel = new CaptchaModel();
    }

    /**
     * Displays the registration form.
     */
    public function registerView()
    {
        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }
		
		$this->session->remove('captcha_id');
		
		$captcha = create_captcha();
		
		$data = array(
            'captcha_id'   => '',
            'captcha_time'  => $captcha['time'],
            'ip_address'    => self::getClientIpAddress(),
            'word'          => $captcha['word'],
            'imgName'       => $captcha['filename']
        );
        $insert_id = $this->captchaModel->insert($data);

        $this->session->set('captcha_id', $insert_id);

        //return $this->render(setting('Auth.views')['register']);
		return $this->render(setting('Auth.views')['register'], [
			'image' => base_url().'captcha/'.$captcha['filename'],
        ]);
    }
	
	/**
     * Attempts to register the user.
     */
    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }
		
		//Check captcha
		$captcha = $this->request->getPost('captcha');
		$captcha_id = $this->session->get('captcha_id');
		$captchaData = $this->captchaModel->find($captcha_id);		
		
		if (!$captchaData) {return redirect()->route('login')->withInput()->with('error', 'Time out error.');}
		
		$ip_address = self::getClientIpAddress();
		if (!(($captchaData->word == $captcha) && ($captchaData->ip_address == $ip_address)))
		{
			return redirect()->route('login')->withInput()->with('error', 'You must submit the word that appears in the image.');
		}
		
		$this->captchaModel->where('captcha_id', $captcha_id)->delete();		
		$this->session->remove('captcha_id');
		$expiration = microtime(true) - 600; // Ten Minutes limit
		$this->captchaModel->where('captcha_time < ', $expiration)->delete();

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }
		
		$users = $this->getUserProvider();

		// Validate basics first since some password rules rely on these fields
		$rules = [
			'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
			'email'    => 'required|valid_email|is_unique[auth_identities.secret]',
			'phone'    => 'required|numeric|min_length[10]|max_length[10]|is_unique[users.phone]',
			'password'     => 'required',
			'password_confirm' => 'required|matches[password]',
		];

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
		
		// Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));		

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);

        Events::trigger('register', $user);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $authenticator->startLogin($user);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->to('auth/a/show');
        }

        // Set the user active
        $user->activate();

        $authenticator->completeLogin($user);

        // Success!
        return redirect()->to(config('Auth')->registerRedirect())
            ->with('message', lang('Auth.registerSuccess'));
    }

    /**
     * Returns the URL the user should be redirected to
     * after a successful registration.
     */
    protected function getRedirectURL(): string
    {
        $url = setting('Auth.redirects')['register'];

        return strpos($url, 'http') === 0
            ? $url
            : rtrim(site_url($url), '/ ');
    }
	
	protected function getClientIpAddress()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //Checking IP From Shared Internet
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //To Check IP is Pass From Proxy
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}

	public function captcha($imageName)
    {

		$image = WRITEPATH.'/captcha/'.$imageName;
		if(file_exists($image))
		{
			if(($image = file_get_contents(WRITEPATH.'/captcha/'.$imageName)) === FALSE)
            show_404();

			// choose the right mime type
			$mimeType = 'image/jpg';

			$this->response
				->setStatusCode(200)
				->setContentType($mimeType)
				->setBody($image)
				->send();

		}

    }
	
	public function refreshCaptcha()
    {
		// Remove captcha
		$captcha_id = $this->session->get('captcha_id');		
		$this->captchaModel->where('captcha_id', $captcha_id)->delete();		
		$this->session->remove('captcha_id');

		$captcha = create_captcha();
		
		$data = array(
            'captcha_id'   => '',
            'captcha_time'  => $captcha['time'],
            'ip_address'    => self::getClientIpAddress(),
            'word'          => $captcha['word'],
            'imgName'       => $captcha['filename']
        );
        $insert_id = $this->captchaModel->insert($data);

        $this->session->set('captcha_id', $insert_id);
		
		$img = $captcha['image'];
		
		// choose the right mime type
		$mimeType = 'image/jpg';

		$this->response
			->setStatusCode(200)
			->setContentType($mimeType)
			->setBody($img)
			->send();
	
    }  	
	
}
