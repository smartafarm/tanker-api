<?php
/*
 * @desc - Dashboard Model
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Base model class , get passes the database instance
 *
 */
class admin_model extends Model{
	function __construct(database $database) {
		// getting the base properties for the parent model
		parent::__construct();
		
	}
	
	public function createUser($data){
		print_r($data);
	}
}