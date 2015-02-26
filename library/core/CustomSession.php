<?php
class CustomSession
{
	protected $_application;

	protected $_sessionID;
	protected $_sessionData;

	protected $_userData;

	public function __construct()
	{
		$this->_application =&Controller::get_instance();
		$this->_application->load_database();

		$this->_setSessionID();

		$this->_loadSessionData();
	}

	protected function setSessionID()
	{
		if(isset($_COOKIE['ci_session']))
			$_sessionID = $_COOKIE['ci_session'];
		else
			$this->createNewSession();
	}

	protected function createNewSession()
	{
		$sessid = '';
		while (strlen($sessid) < 32)
		{
			$sessid .= mt_rand(0, mt_getrandmax());
		}

		$this->_userData = array(
							'session_id'	=> md5(uniqid($sessid, TRUE)),
							'user_data'		=> ''
							);

		$this->CI->db->query($this->CI->db->insert_string($this->sess_table_name, $this->userdata));

		// Write the cookie
		$this->_set_cookie();
	}

	protected function loadSessionData()
	{
		$_COOKIE[$_sessionID];
	}

	protected function getSessionData()
	{
		return $this->_sessionData;
	}

	protected function setSessionData($data)
	{
		$this->_sessionData = $data;
	}
}