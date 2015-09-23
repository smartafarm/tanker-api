<?php
/*
 * @desc - Model class
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Base model class , get passes the database instance
 *
 */
class Model {
	public function __construct() {		
		$dbobj = new database();
		$this->db = $dbobj->get();
	}
}