<?php
class database {
	public function __construct() {
			$this->connection = new MongoClient();
			$this->db = $this->connection->selectDB('smartfarm');	
	}// end of constructor
}