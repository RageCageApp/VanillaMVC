<?php
define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

class UserAuth
{
	public $error;
	protected $models;
	protected $_application;

	public function __construct()
	{
		$this->_application =& Controller::get_instance();
		$this->_application->load_model('userModel');
		$this->_application->load_database();
		$this->_application->load_session();
	}

	function test()
	{
		var_dump($this->_application->get_model('userModel')->test());
	}

    /**
	 * Login user on the site. Return TRUE if login is successful
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function login($login, $password)
	{
		if ((strlen($login) > 0) AND (strlen($password) > 0)) {

			if (!is_null($user = $this->_application->get_model('userModel')->get_user_by_email($login))) {	// login ok
				
				// Does password match hash in database?
				$hasher = new PasswordHasher();
				if ($hasher->CheckPassword($password, $user[0]['password'])) {		// password ok

					$this->_application->session->setSessionUserData(array(
							'user_id'	=> $user[0]['id'],
							'email'		=> $user[0]['email'],
							'status'	=> ($user[0]['activated'] == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
					));

					if ($user[0]['activated'] == 0) {							// fail - not activated
						$this->error = 'User account not activated. Check your email for activation instructions.';
						return TRUE;

					} else {												// success
						return TRUE;
					}
					
				} 
			} 
		}
		$this->error = 'Email and Password don\'t match entry in database.';
		return FALSE;
	}

	/**
	 * Register user. Return TRUE if login is successful
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function register($login, $password)
	{
		if ((strlen($login) > 0) AND (strlen($password) > 0)) {

			if (is_null($user = $this->_application->get_model('userModel')->get_user_by_email($login))) {	// email not in database
			
				$hasher = new PasswordHasher();

				if($user_data = $this->_application->get_model('userModel')->create_new_user($login, $hasher->hashPassword($password))){		// success in creating new user in db									
					
					$this->_application->session->setSessionUserData(array(
							'user_id'	=> $user_data['id'],
							'email'		=> $user_data['email'],
							'status'	=> STATUS_NOT_ACTIVATED,
					));

					return $user_data;	
				
				} else {	// failed to create new user in DB
					$this->error = 'DB Error. Contact system admin.';
					return FALSE;
				}
			} 

			else 																							// email in database
				$this->error = 'Please try again. The email you entered is already registered in our system.';
		}
		return FALSE;
	}

	/**
	 * Activate account. Return TRUE if login is successful
	 *
	 * @param	int
	 * @param	int
	 * @return	bool
	 */
	function activate($id, $activation_key)
	{
		return $this->_application->get_model('userModel')->activate_user($id, $activation_key);
	}

	/**
	 * Return TRUE if user is logged in
	 *
	 * @param	bool
	 * @return	bool
	 */
	function isLoggedIn($activated = TRUE)
	{
		$sessionData = $this->_application->session->getSessionData();

		if(isset($sessionData['user_data']['status']))
			return $sessionData['user_data']['status'] === ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);

		return FALSE;
	}

	/**
	 * Return id of logged in user
	 *
	 * @return	bool
	 */
	function get_logged_in_user_id()
	{
		$sessionData = $this->_application->session->getSessionData();

		if(isset($sessionData['user_data']['user_id']))
			return $sessionData['user_data']['user_id'];

		return NULL;
	}

	/**
	 * Return id of logged in user
	 *
	 * @return	bool
	 */
	function get_user_data($user_id = 0)
	{
		//Certainly, we can get user's email from session data. However, if we want to get more information about the user later on
		//like name, age, etc., then querying the server is necessary
		return $this->_application->get_model('userModel')->get_user_by_id($user_id);
	}
}