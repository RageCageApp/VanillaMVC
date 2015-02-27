<?php
class userController extends Controller {   

	public function __construct($controller,$action) { 
		// Load core controller functions 
		parent::__construct($controller, $action); 

		// Load models
		$this->load_model('UserAuth');
	}

	
	public function index(){
		echo 'index';
		// user logged in 
			// show after login page
		// user not logged in 
			// show login/register page

	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	public function login()
	{
		if($this->get_model('UserAuth')->isLoggedIn())
			echo 'Redirect to index';
		else if($this->get_model('UserAuth')->isLoggedIn(FALSE))
			echo 'Redirect to resend email';
		else
		{
			if(isset($_POST['email']) && isset($_POST['password'])){
				// Sanitize email POST value. No ned to sanitize password because we will be hashing it later anyway.
				// This is by no means the best way to sanitize POST values. There are libraries that we can use
				// to sanitize user input more effectively; but, for this exercise, this should do.
				$email 		= filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
				$password 	= $_POST['password'];

				if($this->get_model('UserAuth')->login($email,$password)) // successful login
					echo 'Redirect to index';
			}

			$data['error'] = $this->get_model('UserAuth')->error;
			
			$this->get_view()->render('user/login_view', $data);
		}
	}
	
	/**
	 * Activate user account.
	 *
	 * @return void
	 */
	public function activate($email, $activation_key){

	}

	/**
	 * Send activation email again to logged in email address
	 *
	 * @return void
	 */
	public function resend_activation_email(){

	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->session->destroy();
	}

	/**
	 * Send activation email
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	private function send_email($email, $activation_code){
		
	}

	
	private function redirect()
	{
		/*
		$baseUrl = sprintf(
			"%s://%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME']
		);

		header( 'Location: {$baseUrl}' );*/

	}
}