<?php
class photoModel extends Model
{
	protected $_application;

	protected $_error;

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

	// takes photo id and returns photo data
	public function get_photo($photo_id)
	{
		$query = 
		"SELECT 
			P.photo_id,
			P.owner_id,
			P.path,
			U.email
		FROM photos P
		LEFT JOIN users U ON P.owner_id = U.id
		WHERE 
			P.photo_id = ?
			AND P.deleted = 0";

		$result = $this->_application->db->query($query, array($photo_id));	

		if (count($result) == 1)
			return $result[0];

		return NULL;
	}

	// 'deletes' photo. doesn't actually delete entry from DB. instead changes deleted column to 1.
	public function delete($photo_id, $logged_in_user_id)
	{
		return $this->_application->db->update('photos', 
												array('deleted' => 1), 
												array('photo_id' => $photo_id, 'owner_id' => $logged_in_user_id));
	}

	// returns last saved error message
	public function get_error()
	{
		return $this->_error;
	}
}