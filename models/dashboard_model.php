<?php
/*
 * @desc - Dashboard Model
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Base model class , get passes the database instance
 *
 */
class dashboard_model extends Model{
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
		$readings = $collection->find();
		$result = Array();
		$result["device"] = array();
		foreach ( $readings as $id => $value )
		{
			array_push($result["device"], $value);
		}
		$collection = $this->db->deviceData;
		$readings = $collection->find();
		$result["readings"] = array();
		foreach ( $readings as $id => $value )
		{
			array_push($result["readings"], $value);
		}
		header('Content-Type: application/json');
		echo json_encode( $result );
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