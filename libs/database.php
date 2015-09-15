<?php
class database {
	public function __construct() {
			$this->connection = new MongoClient();
			$this->db = $this->connection->smartfarm;
			}
	}// end of constructor

