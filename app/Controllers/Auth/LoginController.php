<?php

namespace App\Controllers\Auth;

use CodeIgniter\HTTP\RedirectResponse;
use Bonfire\View\Themeable;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLogins;

use App\Models\CaptchaModel;

require_once APPPATH.'Libraries/CryptoJsAes.php';
use Nullix\CryptoJsAes\CryptoJsAes;

class LoginController extends ShieldLogins
{
    use Themeable;
	protected $captchaModel; 

    public function __construct()
    {
        $this->theme = 'Auth';
		helper(['auth', 'text', 'captcha']);
		$this->session = service('session');
		
		$this->captchaModel = new CaptchaModel();
		$this->db = \Config\Database::connect();
    }

    /**
     * Display the login view
     */
    public function loginView(): string
    {
		$salt = random_string('alnum', 32);
		$this->session->set('salt', $salt);
		
		/** If need to use SimpleCaptcha use the following Code
		$vals = [
			'word'      => random_string('numeric', 8),
			'img_path'  => '.captcha/',
			'img_url'   => base_url() . '/captcha/',
		];
		$cap = Captcha::createCaptcha($vals);
		**/
		
		//Create Captcha using Codeigniter 3 Library and store the parameters in Dtabase / pass "id" in session		
		$vals = array(
				'word'          => random_string('numeric', 8),
				'img_path'      => WRITEPATH.'/captcha/',
				'img_url'       => '/captcha/',
				'font_path'     => '',
				'img_width'     => 150,
				'img_height'    => 40,
				'expiration'    => 7200,
				'word_length'   => 8,
				'font_size'     => 20,
				'img_id'        => 'Imageid',
				'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

				// White background and border, black text and red grid
				'colors'        => array(
						'background'	=> array(255,255,255),
						'border'	=> array(153,102,102),
						'text'		=> array(0,0,0),
						'grid'		=> array(255,182,182)
				)
		);
		
		$cap = create_captcha($vals);
		
		$data = array(
			'captcha_id'   => '',
			'captcha_time'  => $cap['time'],
			'ip_address'    => self::getClientIpAddress(),
			'word'          => $cap['word'],
			'imgName'       => $cap['time']
		);
		$insert_id = $this->captchaModel->insert($data);			
		
		$this->session->set('captcha_id', $insert_id);
		$this->session->set('image', $cap['image']);
		
        return $this->render(config('Auth')->views['login'], [
            'allowRemember' => setting('Auth.sessionConfig')['allowRemembering'],
        ]);
    }
	
	/**
     * Attempts to log the user in.
     */
    public function loginAction(): RedirectResponse
    {
		// First, delete old captchas
		$expiration = time() - 3600; // One hour limit
		
		$builder = $this->db->table('captcha');
		$builder->select('imgName');
		$builder->where('captcha_time < ', $expiration);
		$filter = $builder->get();
		
		foreach ($filter->getResult() as $row) {
			
			$image = WRITEPATH.'/captcha/'.$row->imgName.'.jpg';
			if(file_exists($image))
			{
			   unlink(WRITEPATH."/captcha/".$row->imgName.".jpg");
			}
			
		}		
		$this->captchaModel->where('captcha_time < ', $expiration)->delete();
		
		// Check Captcha. If Captcha wrong return to login.
		$captcha_id = $this->request->getPost('captcha_id');
		$captchaData = $this->captchaModel->find($captcha_id);
		
		$captcha = $this->request->getPost('captcha');
		$ip_address = self::getClientIpAddress();

		if (!(($captchaData->word == $captcha) && ($captchaData->ip_address == $ip_address)))
		{
			return redirect()->route('login')->withInput()->with('error', 'You must submit the word that appears in the image.');
		}
		
		$image = WRITEPATH.'/captcha/'.$captchaData->imgName.'.jpg';
		if(file_exists($image))
		{
		   unlink(WRITEPATH."/captcha/".$captchaData->imgName.".jpg");
		}
		$this->captchaModel->where('captcha_id', $captcha_id)->delete();		
		
		// Determine credential type
		$identity = $this->request->getPost('identity');
		$loginidentity = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' :  'username';			
		
        // Validate here first, since some things,
        // like the password, can only be validated properly here.
		if ($loginidentity == 'email') {
            $rules = $this->getValidationRulesEmail();
        } else {
            $rules = $this->getValidationRulesUsername();
        }   

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
		
		$credentials[$loginidentity]             = $this->request->getPost('identity');		
		
        $encoded = $this->request->getPost('password');
		$passhash = $this->request->getPost('salt');
		if ($passhash == "") $passhash = "1234";
		$credentials['password'] = CryptoJsAes::decrypt($encoded, $passhash);
		
        $remember                = (bool) $this->request->getPost('remember');

        // Attempt to login
        $result = auth('session')->remember($remember)->attempt($credentials);
        if (! $result->isOK()) {
            return redirect()->route('login')->withInput()->with('error', $result->reason());
        }

        // custom bit of information
        $user = $result->extraInfo();
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined for login, start it up.
        $hasAction = $authenticator->startUpAction('login', $user);
        if ($hasAction) {
            return redirect()->route('auth-action-show')->withCookies();
        }

        return redirect()->to(config('Auth')->loginRedirect())->withCookies();
    }
	
	/**
     * Returns the rules that should be used for validation.
     *
     * @return string[]
     */
    protected function getValidationRulesEmail(): array
    {
        return setting('Validation.login') ?? [
            'identity'    => config('AuthSession')->emailValidationRules,
            'password' => 'required',
        ];
    }
	
	protected function getValidationRulesUsername(): array
    {
        return setting('Validation.login') ?? [
            'identity' => config('AuthSession')->usernameValidationRules,
            'password' => 'required',
        ];
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
}
