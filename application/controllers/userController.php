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
		//var_dump($this->get_model('UserAuth')->login('myromac87@gmail.com','polosport'));
		//var_dump($this->session->getSessionData());
		if($this->get_model('UserAuth')->isLoggedIn())
			echo 'redirect to index'
		else if($this->get_model('UserAuth')->isLoggedIn(FALSE))
			echo 'Redirect to resend email';
		else
			$this->get_model('UserAuth')->login('myromac87@gmail.com','polosport');
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

	/*
	private function redirect()
	{
		
		$baseUrl = sprintf(
			"%s://%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME']
		);

		header( 'Location: {$baseUrl}' );

	}*/
}