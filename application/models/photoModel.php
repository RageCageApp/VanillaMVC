<?php
class photoModel extends Model
{
	protected $_application;

	public function __construct() 
	{ 
		// Load core controller functions 
		parent::__construct(); 
		$this->_application =& Controller::get_instance();
		$this->_application->load_database();
		$this->_application->load_session();
	}

	public function create_new_photo($path, $owner_id)
	{
		$insert_data = array(
			'path' => $path,
			'owner_id' => $owner_id,
			);

		return $this->_application->db->insert('photos', $insert_data);
	}	

	// takes in a user's id and returns list of photos of that user
	public function get_user_photos($user_id)
	{
		$query = 
		"SELECT 
			P.path
		FROM photos P
		WHERE 
			P.owner_id = ?
			AND P.deleted = 0";

		$result = $this->_application->db->query($query, array($user_id));	

		if (count($result))
			return $result;

		return NULL;
	}
}