<?php
class userModel extends Model{
	protected $_application;

	public function __construct() { 
		// Load core controller functions 
		parent::__construct(); 
		$this->_application =& Controller::get_instance();
	}

	// takes in an email(str) and returns database entry that matches the email
	public function get_user_by_email($email){
		$query = 
		"SELECT 
			U.id, 
			U.password, 
			U.email, 
			U.activated, 
			U.administrator 
		FROM users U 
		WHERE 
			U.email = ?";

		$result = $this->_application->db->query($query, array($email));	

		if (count($result))
			return $result;

		return NULL;
	}
}