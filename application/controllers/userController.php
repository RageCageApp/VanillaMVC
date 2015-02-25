<?php
class userController extends Controller {   

	public function __construct($controller,$action) { 
		// Load core controller functions 
		parent::__construct($controller, $action); 

		// Load models
		$this->load_model('userModel'); 
	}

	
	public function index(){
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
	public function login(){
		$this->get_model('userModel')->test();
		// user logged in
			// show user dashboard
		// logged in but not activated
			// show resend email page
		// not logged in
			// show login/register page
		//phpinfo();
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
	public function logout(){

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
}