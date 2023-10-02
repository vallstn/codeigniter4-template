<?php

namespace App\Controllers\Auth;

use Bonfire\View\Themeable;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Authentication\Passwords;
use SimpleCaptcha\Builder;
use App\Models\CaptchaModel;

require_once APPPATH.'Libraries/CryptoJsAes.php';
use Nullix\CryptoJsAes\CryptoJsAes;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;

class LoginController extends ShieldLogin
{
    use Themeable;

    public function __construct()
    {
        $this->theme = 'Auth';
        helper(['auth', 'text', 'captcha']);
		$this->session = service('session');
		
		$this->captchaModel = new CaptchaModel();
    }

    /**
     * Display the login view
     */
    public function loginView()
    {
        // prevent login page access to logged-in users
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }
		
		$salt = random_string('alnum', 32);
		$this->session->set('salt', $salt);

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

        return $this->render(config('Auth')->views['login'], [
			'image' => base_url().'captcha/'.$captcha['filename'],
            'allowRemember' => setting('Auth.sessionConfig')['allowRemembering'],
        ]);
    }
	
	/**
     * Attempts to log the user in.
     */
    public function loginAction(): RedirectResponse
    {
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
		
        // Validate here first, since some things,
        // like the password, can only be validated properly here.
		$login = $this->request->getPost('login');		
		
		// Determine credential type
		$type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($login) ? 'phone' : 'username');
		
        $rules = $this->getValidationRulesNew($type);
		
		$encrPassword = $this->request->getPost('password');
		$passhash = $this->session->get('salt');
		if ($passhash == "") $passhash = "1234";
		$password = CryptoJsAes::decrypt($encrPassword, $passhash);		
		
		$user = array(
            'csrf_l2c'   	=> $this->request->getPost('csrf_l2c'),
            'login'  		=> $login,
            'password'    	=> $password
        );
		
        if (! $this->validateData($user, $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        /** @var array $credentials */		
		$credentials[$type] 	 = $login;
        $credentials['password'] = $password;
        $remember                = (bool) $this->request->getPost('remember');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);
        if (! $result->isOK()) {
            return redirect()->route('login')->withInput()->with('error', $result->reason());
        }
		
		$this->captchaModel->where('captcha_id', $captcha_id)->delete();

        // If an action has been defined for login, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show')->withCookies();
        }

        return redirect()->to(config('Auth')->loginRedirect())->withCookies();
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, array<string>|string>>
     * @phpstan-return array<string, array<string, string|list<string>>>
     */
    protected function getValidationRulesNew($type): array
    {		
		if ($type == 'email') {
			return setting('Validation.login') ?? [				
				'login' => [
					'label' => 'Auth.login',
					'rules' => 'required|max_length[254]|valid_email',
				],				
				'password' => [
					'label'  => 'Auth.password',
					'rules'  => 'required|' . Passwords::getMaxLengthRule(),
					'errors' => [
						'max_byte' => 'Auth.errorPasswordTooLongBytes',
					],
				],
			];
		} else if ($type == 'username') {
			return setting('Validation.login') ?? [
				'login' => [
					'label' => 'Auth.login',
					'rules' => 'required|max_length[30]|min_length[3]|regex_match[/\A[a-zA-Z0-9\.]+\z/]',
				],				
				'password' => [
					'label'  => 'Auth.password',
					'rules'  => 'required|' . Passwords::getMaxLengthRule(),
					'errors' => [
						'max_byte' => 'Auth.errorPasswordTooLongBytes',
					],
				],
			];
		} else {
			return setting('Validation.login') ?? [				
				'login' => [
					'label' => 'Auth.login',
					'rules' => 'required|max_length[15]|min_length[10]|numeric',
				],
				'password' => [
					'label'  => 'Auth.password',
					'rules'  => 'required|' . Passwords::getMaxLengthRule(),
					'errors' => [
						'max_byte' => 'Auth.errorPasswordTooLongBytes',
					],
				],
			];
		}
    }

    /**
     * Logs the current user out.
     */
    public function logoutAction(): RedirectResponse
    {
        // Capture logout redirect URL before auth logout,
        // otherwise you cannot check the user in `logoutRedirect()`.
        $url = config('Auth')->logoutRedirect();

        auth()->logout();

        return redirect()->to($url)->with('message', lang('Auth.successLogout'));
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