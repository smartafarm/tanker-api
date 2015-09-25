<?php
class fetch_model extends Model{
	function __construct(database $database) {
		// getting the base properties for the parent model
		parent::__construct();

	}


	function getDevices() {
		/*
		 *
		 * Gets all the devices in the dataBase and passes Json array to the request
		 *
		 */


		$collection = $this->db->device;
		$collection1 = $this->db->deviceData;
		$devices = $collection->find();
		$result = Array();
		$result = array();
		$i=0;
		foreach ( $devices as $id => $device )
		{
			$data["_id"] = $device["_id"];
			$data["readings"] = array();
			$readings = $collection1->find(array('did' => $device["_id"]));
			foreach ($readings as $key => $reading) {
				array_push($data["readings"],$reading);
			}
			array_push($result,$data);
				
		
		}
		
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
	
	function getUpdate() {
	
		/*
		 *
		 * Helper function to the ajax poll request, responds if any new data is posted
		 * Json array returned
		 *
		 */
	
	
		$collection = $this->db->pollStatus;
		$readings = $collection->find();
		$result = Array();
		$result = Array("flag" => 0);
		if($readings->count() != 0){
			$result["flag"] = 1;
			$result["readings"] = array();
	
			foreach ( $readings as $id => $value )
			{
				array_push($result["readings"], $value);
				$delID = $value['_id'];
				$collection->remove(array('_id' => new MongoId($delID)));
			}
				
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}	