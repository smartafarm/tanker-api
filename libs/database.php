<?php
class database {
	public function __construct() {
		
		try	{
			$this->connection = new MongoClient();
			$this->db = $this->connection->selectDB('smartfarm');	
			}
			
		catch(MongoConnectionException $e)
		{
			die("Failed to connect to database ".$e->getMessage());
		}
		
	}// end of constructor
}