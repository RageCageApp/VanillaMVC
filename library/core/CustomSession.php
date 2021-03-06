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

		$this->_sessionID = $this->_sessionUserData['session_id'];

		if($this->_application->db->insert('my_sessions', $this->_sessionUserData))
			setcookie(
				SESS_COOKIE_NAME,
				$this->_sessionUserData['session_id'],
				time()+3600,
				'/'
			);
		else
			die('Error inserting session data in database');
	}

	// Loads session data in userData class variable
	protected function _loadSessionData()
	{
		//lookup session in DB
		$query = 
		"SELECT 
			MS.session_id, MS.user_data
		FROM my_sessions MS 
		WHERE 
			MS.session_id = ?
		LIMIT 1";

		$result = $this->_application->db->query($query, array($this->_sessionID));	

		if(count($result) > 0)
			$this->_sessionUserData = array(
								'session_id'    => $this->_sessionID,
								'user_data'		=> unserialize($result[0]['user_data'])
								);
		else
			$this->_createNewSession();
	}

	// Returns sessionData variable
	public function getSessionData()
	{
		return $this->_sessionUserData;
	}

	// Set sessionUserData
	public function setSessionUserData($data)
	{
		if (count($data) > 0)
		{
			$this->_sessionUserData['user_data'] = array();
			foreach ($data as $key => $val)
			{
				$this->_sessionUserData['user_data'][$key] = $val;
			}

			if(!$this->_application->db->update('my_sessions', 
											array('user_data' => serialize($this->_sessionUserData['user_data'])), 
											array('session_id' => $this->_sessionID)))
				die('Error updating session data');
		}
	}

	// Destroys session data
	public function destroy()
	{
		unset($_COOKIE[SESS_COOKIE_NAME]);
	    setcookie(
			SESS_COOKIE_NAME,
			null,
			time()-3600,
			'/'
		);

		$this->_sessionUserData = NULL;
	}
}