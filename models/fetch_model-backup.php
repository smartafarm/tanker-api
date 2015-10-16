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
	
		define('MESSAGE_POLL_MICROSECONDS',500000);
		define('MESSAGE_TIMEOUT_SECONDS',11);
		
		$collection = $this->db->pollStatus;
		$readings = $collection->find();		
		set_time_limit(MESSAGE_TIMEOUT_SECONDS);
		$time_start = microtime(true); 	 
		$counter = MESSAGE_TIMEOUT_SECONDS;
		while($counter>0){
			if (microtime(true) - $time_start > 10){
			$readings = $collection->find();
			if($readings->count() != 0){
				break;
			}else{
				die(http_response_code(408));
			}
			}
			$readings = $collection->find();
			if($readings->count() != 0){
				break;
			}
			else{
			usleep(MESSAGE_POLL_MICROSECONDS);
			clearstatcache();
			$counter -= MESSAGE_POLL_MICROSECONDS/1000000;
			}
			
		}
			$readings = $collection->find();
			$result = Array();
			$result["readings"] = array();
	
			foreach ( $readings as $id => $value )
			{
				array_push($result["readings"], $value);
				$delID = $value['_id'];
			//	$collection->remove(array('_id' => new MongoId($delID)));
			}
				
		
		header('Content-Type: application/json');
		echo json_encode($result,JSON_PRETTY_PRINT);
	}

	function testSocket() {
	
		require 'bin/chat.php';

		/* Create new queue object */
		$queue = new ZMQSocket(new ZMQContext(), ZMQ::SOCKET_PUB);
		$queue->bind("tcp://127.0.0.1:8080");
		$queue->send("hello");
		//$push =  new chat();
		//$push->onMessage($queue,"hello");

		
	}
}	