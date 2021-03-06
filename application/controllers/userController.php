<?php
class userController extends Controller {   

	public function __construct($controller,$action) 
	{ 
		// Load core controller functions 
		parent::__construct($controller, $action); 

		// Load models
		$this->load_model('UserAuth');
		$this->load_model('photoModel');
		$this->load_model('userModel');
	}

	
	public function index()
	{
		if($this->get_model('UserAuth')->isLoggedIn())
		{
			$logged_in_id = $this->get_model('UserAuth')->get_logged_in_user_id();

			if(!$this->get_model('UserAuth')->isAdmin($logged_in_id)) { 			// user not an admin
				$data['user_data'] = $this->get_model('UserAuth')->get_user_data($logged_in_id);
				$data['photos'] = $this->get_model('photoModel')->get_user_photos($logged_in_id);
		
				$this->get_view()->render('user/logged_in_view', $data);
			
			} else {															// user is an admin
				$data['users'] = $this->get_model('userModel')->get_all_users();
				$data['photos'] = $this->get_model('photoModel')->get_all_photos();
		
				$this->get_view()->render('user/admin_view', $data);
			}
			
		}
		else if($this->get_model('UserAuth')->isLoggedIn(FALSE))
			HelperFunctions::redirect('user/resend_activation_email');
		else
			HelperFunctions::redirect('user/login');
	}

	/**
	 * View photos of particular user
	 *
	 * @return void
	 */
	public function view_user($user_id = NULL)
	{
		if($this->get_model('UserAuth')->isLoggedIn() && is_numeric($user_id))
		{	
			$logged_in_id = $this->get_model('UserAuth')->get_logged_in_user_id();
			if($this->get_model('UserAuth')->isAdmin($logged_in_id) // user is an admin
				|| $user_id == $logged_in_id) 	// user owns profile
			{
				$data['user_data'] = $this->get_model('UserAuth')->get_user_data($user_id);
				$data['photos'] = $this->get_model('photoModel')->get_user_photos($user_id);
				
				if(!is_null($data['user_data']))
					$this->get_view()->render('user/user_view', $data);
				else 
					echo 'Can\'t find user.';
			
			} else {																							// user is not an admin
				echo 'You need to be an admin to see other\'s photos.';
			}
			
		}
		else if($this->get_model('UserAuth')->isLoggedIn(FALSE))
			HelperFunctions::redirect('user/resend_activation_email');
		else
			HelperFunctions::redirect('user/login');
	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	public function login()
	{
		if($this->get_model('UserAuth')->isLoggedIn())
			HelperFunctions::redirect('user/index');
		else if($this->get_model('UserAuth')->isLoggedIn(FALSE))
			HelperFunctions::redirect('user/resend_activation_email');
		else
		{
			if(isset($_POST['email']) && isset($_POST['password'])){
				// Sanitize email POST value. No ned to sanitize password because we will be hashing it later anyway.
				// This is by no means the best way to sanitize POST values. There are libraries that we can use
				// to sanitize user input more effectively; but, for this exercise, this should do.
				$email 		= filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
				$password 	= $_POST['password'];

				if($this->get_model('UserAuth')->login($email,$password)) // successful login
					HelperFunctions::redirect('user/index');
			}

			$data['error'] = $this->get_model('UserAuth')->error;
			
			$this->get_view()->render('user/login_view', $data);
		}
	}

	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	public function register()
	{
		if($this->get_model('UserAuth')->isLoggedIn())
			HelperFunctions::redirect('user/index');
		else if($this->get_model('UserAuth')->isLoggedIn(FALSE))
			HelperFunctions::redirect('user/resend_activation_email');
		else
		{
			if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])){
				// Sanitize email POST value. No ned to sanitize password because we will be hashing it later anyway.
				// This is by no means the best way to sanitize POST values. There are libraries that we can use
				// to sanitize user input more effectively; but, for this exercise, this should do.
				$email 		= filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
				$password 	= $_POST['password'];
				$password2 	= $_POST['password2'];
				$admin 		= ($_POST['type'] == 1) ? 1 : 0;

				/**
				 *CODE IMPROVEMENT NEEDED: need to run validation of POST values to make sure:
				 *		1) email submitted by user is a valid email
				 *		2) passwords match		
				 */

				if($user_data = $this->get_model('UserAuth')->register($email,$password,$password2,$admin)) {// successful login
					$this->send_email($user_data['id'], $user_data['email'], $user_data ['activation_key']);
					HelperFunctions::redirect('user/index');
				}	
			}

			$data['error'] = $this->get_model('UserAuth')->error;
			
			$this->get_view()->render('user/register_view', $data);
		}
	}

	/**
	 * Update user's email
	 *
	 * @return void
	 */
	public function update_email()
	{
		if($this->get_model('UserAuth')->isLoggedIn()){

			$logged_in_id = $this->get_model('UserAuth')->get_logged_in_user_id();

			if(isset($_POST['email'])){		// user has inputed a value in email field
				
				// Sanitize email POST value. This is by no means the best way to sanitize POST values. 
				// There are libraries that we can use to sanitize user input more effectively; but, for this exercise, 
				// this should do.
				$email 		= filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

				/**
				 *CODE IMPROVEMENT NEEDED: need to run validation of POST values to make sure:
				 *		1) email submitted by user is a valid email	
				 */

				if($user_data = $this->get_model('UserAuth')->update_email($logged_in_id, $email)) {// successful email update
					HelperFunctions::redirect('user/index');

				} else {	// failed to update email
					echo $this->get_model('UserAuth')->error;
				}
			} else {	// lacking email input
				echo 'Please enter valid email.';
			}

		} else {
			HelperFunctions::redirect('user/index');
		}
	}
	
	/**
	 * Activate user account.
	 *
	 * @return void
	 */
	public function activate($id = NULL, $activation_key = NULL)
	{
		$data['message'] = '';

		if(is_numeric($id) && is_numeric($activation_key)) {
			
			if($this->get_model('UserAuth')->activate($id,$activation_key)){	// successful activation
			
				$data['message'] = 'Account Activated';

			} else {														// activation failed

				$data['message'] = 'Account Activation Failed';

			}
		} else {
			HelperFunctions::redirect('user/index');
		}

		$data['error'] = $this->get_model('UserAuth')->error;
			
		$this->get_view()->render('user/activated_view', $data);
	}

	/**
	 * Send activation email again to logged in email address
	 *
	 * @return void
	 */
	public function resend_activation_email()
	{
		if($this->get_model('UserAuth')->isLoggedIn(FALSE))
			$this->get_view()->render('user/resend_activation_email');
		else
			HelperFunctions::redirect('user/index');
	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->session->destroy();
		HelperFunctions::redirect('user/index');
	}

	/**
	 * Send activation email
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	private function send_email($id, $email, $activation_code)
	{
		$activationUrl = sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['HTTP_HOST'].'/user/activate/'.$id.'/'.$activation_code
        );
		$title   = "Activate your Vanila MVC account"; 
		$message = "To activate your account, click the link: {$activationUrl}"; 

		mail($email, $title, $message); 
	}
}