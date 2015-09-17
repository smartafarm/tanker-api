<?php
class dashboard_model {
	function __construct() {
		$this->connection = new MongoClient ();
		$this->db = $this->connection->smartfarm;		;
	}
	
	function getReadings() {
		$collection = $this->db->deviceData;
		$readings = $collection->find();
		$result = Array();
		foreach ( $readings as $id => $value )
			{
				array_push($result, $value);
			}
			echo json_encode($result);
	}
	function getDevices() {
		$collection = $this->db->device;
		$readings = $collection->find();
		$result = Array();
		foreach ( $readings as $id => $value )
		{
			array_push($result, $value);
		}
		echo json_encode( $result );
	}
	
	function getUpdate() {
		$collection = $this->db->pollStatus;
		$readings = $collection->find();
		$result = Array();
		$result = Array(0 => array("flag"=>0));
		if($readings->count() != 0){
			$result = Array(0 => array("flag"=>1));
		
		foreach ( $readings as $id => $value )
			{
				array_push($result, $value);
				$delID = $value['_id'];
				$collection->remove(array('_id' => new MongoId($delID)));
			}
			
		}
		echo json_encode($result);
	} 
}