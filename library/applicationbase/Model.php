<?php
class Model{
	protected $db;

	public function __construct() {
        $this->db = new MySqlDataAdapter(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,DB_PORT);
	}
}
