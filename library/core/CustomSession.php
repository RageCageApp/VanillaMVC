<?php
define('SESS_COOKIE_NAME', 'my_session');
define('COOKIE_TABLE_NAME', 'my_sessions');

class CustomSession
{
	protected $_application;

	protected $_sessionID;
	protected $_sessionUserData;

	public function __construct()
	{
		$this->_application =&Controller::get_instance();
		$this->_application->load_database();

		$this->_setSessionData();

		$this->_loadSessionData();
	}

	// Sets data of session
	protected function _setSessionData()
	{
		if(isset($_COOKIE[SESS_COOKIE_NAME]))
		{
			$this->_sessionID = $_COOKIE[SESS_COOKIE_NAME];
			$this->_loadSessionData();
		}
			
		else
			$this->_createNewSession();
	}

	// Creates new session
	protected function _createNewSession()
	{
		$sessid = '';
		while (strlen($sessid) < 32)
		{
			$sessid .= mt_rand(0, mt_getrandmax());
		}

		$this->_sessionUserData = array(
							'session_id'    => md5(uniqid($sessid, TRUE)),
							'user_data'		=> ''
							);

		$this->_application->db->insert('my_sessions', $this->_sessionUserData);

		setcookie(
			SESS_COOKIE_NAME,
			$this->_sessionUserData['session_id'],
			time()+10
		);
	}

	// Loads session data in userData class variable
	protected function _loadSessionData()
	{
		//lookup session in DB
		//unserialize the results
		//store unserialized results in $this->_userData
	}

	// Returns sessionData variable
	public function _getSessionData()
	{
		return $this->_sessionUserData;
	}

	// Destroys session data
	public function destroy()
	{
		if(isset($_COOKIE[SESS_COOKIE_NAME]));
			unset($_COOKIE[SESS_COOKIE_NAME]);

		$this->_sessionUserData = NULL;
	}
}