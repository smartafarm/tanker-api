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
		$collection = $this->db->userMaster;
		
		$data['serverData']['password'] = "default123";
		$data['serverData']['device'] = new stdClass();
		$data['serverData']['genFunc'] = new stdClass();
		$response = $collection->insert($data['serverData']);
		if($response['ok'] == 0){
			http_response_code(202);
		}		
		header('Content-Type: application/json');
		echo json_encode( $response, JSON_PRETTY_PRINT);
	}
	public function getUsers() {

	/*
	 *
	 * Helper function to return all user
	 *
	 */	
	
		$collection = $this->db->userMaster;
		$readings = $collection->find();
		$result = Array();
		$result["users"] = array();	
		$index = 0;		
		foreach ( $readings as $id => $value )
		{
			$data = array();
			$data['uname'] = $value['uname'];
			$data['details']=$value['details'];
			$data['device'] = $value['device'];
			$data['genFunc'] = $value['genFunc'];
			array_push($result["users"], $data);			

		}				
	
	header('Content-Type: application/json');
	echo json_encode($result,JSON_PRETTY_PRINT);
	}

	public function getAllDevices() {

	/*
	 *
	 * Helper function to return all user
	 *
	 */	
	
		$collection = $this->db->DeviceMaster;
		$readings = $collection->find(array('EquipTypeID' => 'c1'));
		
		$result = array();	
		
		foreach ( $readings as $id => $device )
		{
			$data["_id"] = $device["_id"];
			$data["name"]	=  $device["EquipName"];
			$data["Desc"]	=  $device["Description"];
			$data["Status"]	=  $device["status"];
			array_push($result, $data);	

		}				
	
	header('Content-Type: application/json');
	echo json_encode($result,JSON_PRETTY_PRINT);
	}
	public function getDeviceFunc() {

	/*
	 *
	 * Helper function to return all user
	 *
	 */	
	
		$collection = $this->db->functionMaster;
		$readings = $collection->find(array('type' => 'Device'));
		$result = array();	
		
		foreach ( $readings as $id => $function )
		{
			
			array_push($result, $function);	

		}				
	
	header('Content-Type: application/json');
	echo json_encode($result,JSON_PRETTY_PRINT);
	}
	public function setDeviceAccess($data) {
	
		$collection = $this->db->userMaster;
		//print_r($data['serverData']);
		$username = $data['serverData']['uname'];		
		$access = $data['serverData']['dAccess'];
		$response =$collection->update(
		    array('uname' => $username),
		    array(
		        '$set' => array("device" => $access),
		    ),
		    array("upsert" => false)
		);
		
		if($response['n'] == 0){
			http_response_code(202);
		}		
		header('Content-Type: application/json');
		echo json_encode( $response, JSON_PRETTY_PRINT);
		/*$data['serverData']['password'] = "default123";
		$data['serverData']['device'] = new stdClass();
		$data['serverData']['genFunc'] = new stdClass();
		$collection->insert($data['serverData']);*/
	
	}
}