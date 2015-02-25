<?php
class userModel extends Model{

	public function __construct() { 
		// Load core controller functions 
		parent::__construct(); 
	}
	
	public function test(){
		$result = $this->db->query("SELECT * FROM users");	
		$resultArray = $this->db->fetchArray($result);
		var_dump($resultArray);
	}
}