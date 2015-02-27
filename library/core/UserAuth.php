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
	 * @param	bool
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
						$this->error = 'User account not activated';

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
	 * Return TRUE if user is logged in
	 *
	 * @param	string
	 * @param	string
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
}