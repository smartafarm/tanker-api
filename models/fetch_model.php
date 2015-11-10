<?php

class fetch_model extends Model{
	function __construct(database $database) {
		// getting the base properties for the parent model
		parent::__construct();

	}


	function getDevices($bearer) {
		/*
		 *
		 * Gets all the devices in the dataBase and passes Json array to the request
		 *
		 */
		

		$collection = $this->db->DeviceMaster;
		$collection1 = $this->db->deviceData;
		$devices = $collection->find();
		$result = Array();
		$result = array();
		$i=0;
		foreach ( $devices as $id => $device )
		{
			$data["_id"] = $device["_id"];
			$data["name"]	=  $device["EquipName"];
			$data["Desc"]	=  $device["Description"];
			$data["Status"]	=  $device["status"];
			$data["readings"] = array();
			$readings = $collection1->find(array('did' => $device["_id"]));
			$index = 0;
			foreach ($readings as $key => $reading) {
				/*"_id": {
                    "$id": "5626da24c2677bcc14000029"
                },
                "did": "s123xyz",
                "s_count": 4,
                "lat": "lattitude",
                "long": "longitude",
                "dt": {
                    "sec": 1445386788,
                    "usec": 0
                },
                "T01": "1",
                "T02": "23",
                "L01": "35",
                "L02": "45"*/

				array_push($data["readings"],$reading);
				$data["readings"][$index]["dt"] = date(DATE_ISO8601, $data["readings"][$index]["dt"]->sec);
				$index++;
			}
			array_push($result,$data);	
		
		}
		if(!isset($_SESSION['timestamps'][$bearer])){
			Session::set('timestamps', array($bearer => date('c')));
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
	
	function getUpdate($timestamp,$bearer) {
	
		/*
		 *
		 * Helper function to the ajax poll request, responds if any new data is posted
		 * Json array returned
		 *
		 */
		$lastReadings = Session::get('timestamps');
		$bearerLastReading = new MongoDate(strtotime($lastReadings[$bearer]));
		
		
		
			$time =  new MongoDate(strtotime($timestamp));
			
		//	echo $time;
			//find({"dt" : { $gte : $time }});
			$collection = $this->db->deviceData;			
			$condition = array('dt' => array(
				'$gte'=>$bearerLastReading,
				'$lte'=>$time
				) 
			);	
			$readings = $collection->find($condition);
			$result = Array();
			$result["readings"] = array();	
			$index = 0;		
			foreach ( $readings as $id => $value )
			{
				array_push($result["readings"], $value);
				$result["readings"][$index]["dt"] = date(DATE_ISO8601, $result["readings"][$index]["dt"]->sec);
				$index++;			
			}
				
		Session::set('timestamps', array($bearer => $timestamp));
		header('Content-Type: application/json');
		echo json_encode($result,JSON_PRETTY_PRINT);
	}

	
	
}	
//1445297068211 
//1445297090211