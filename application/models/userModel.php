<?php
class userModel extends Model
{
	protected $_application;

	public function __construct() 
	{ 
		// Load core controller functions 
		parent::__construct(); 
		$this->_application =& Controller::get_instance();
		$this->_application->load_database();
	}

	// takes in an email(str) and returns database entry that matches the email
	public function get_user_by_email($email)
	{
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

	// takes in an id and returns database entry that matches the id
	public function get_user_by_id($id)
	{
		$query = 
		"SELECT 
			U.id, 
			U.password, 
			U.email, 
			U.activated, 
			U.administrator 
		FROM users U 
		WHERE 
			U.id = ?";

		$result = $this->_application->db->query($query, array($id));	

		if (count($result))
			return $result[0];

		return NULL;
	}

	// returns all users of db
	public function get_all_users()
	{
		$query = 
		"SELECT 
			U.id, 
			U.email
		FROM users U";

		$result = $this->_application->db->query($query);	

		if (count($result))
			return $result;

		return NULL;
	}

	// takes in an email and password and creates a new entry in the database
	public function create_new_user($email, $password, $admin)
	{
		$insert_data = array(
			'email' => $email,
			'password' => $password,
			'activation_key' => rand(1000,9999),
			'administrator' => $admin
			);

		if($insert_id = $this->_application->db->insert('users', $insert_data)){

			$insert_data['id'] = $insert_id;

			return $insert_data;

		}

		return FALSE;
	}

	public function activate_user($id, $activation_key)
	{
		return $this->_application->db->update('users', 
												array('activated' => 1), 
												array('id' => $id, 'activation_key' => $activation_key));
	}
}