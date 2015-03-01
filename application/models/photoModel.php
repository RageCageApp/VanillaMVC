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
}