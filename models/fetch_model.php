<?php
error_reporting(E_NOTICE);
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
		$dAccess = array();
		$userCollection = $this->db->userMaster;
		$dAccessResponse = $userCollection->find(array('uname'=>$bearer), array("device"));	
		foreach($dAccessResponse as $key=> $value)
		{
			$alldAccess = $value['device'];

		}	
		foreach($alldAccess as $key=> $value)
		{
			array_push($dAccess, $value['_id'][0]);
		}	
		
		$collection = $this->db->DeviceMaster;
		$collection1 = $this->db->deviceData;
		$devices = $collection->find(array('_id'=>array('$in' => $dAccess)));
		$result = Array();
		$result = array();
		$i=0;
		foreach ( $devices as $id => $device )
		{
			$data["_id"] = $device["_id"];
			$data["name"]	=  $device["EquipName"];
			$data["Desc"]	=  $device["Description"];
			$data["Status"]	=  $device["status"];
			foreach($alldAccess as $key=> $value)
			{
				if ($value['_id'][0] == $device["_id"])
				{
					$data["func"] = $value['func'];
				}
			}	
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
		$dAccess = array();
		$userCollection = $this->db->userMaster;
		$dAccessResponse = $userCollection->find(array('uname'=>$bearer), array("device"));	
		foreach($dAccessResponse as $key=> $value)
		{
			$alldAccess = $value['device'];

		}	
		foreach($alldAccess as $key=> $value)
		{
			array_push($dAccess, $value['_id'][0]);
		}	
		$lastReadings = Session::get('timestamps');
		$bearerLastReading = new MongoDate(strtotime($lastReadings[$bearer]));
		
		
		
			$time =  new MongoDate(strtotime($timestamp));
			
		//	echo $time;
			//find({"dt" : { $gte : $time }});
			$collection = $this->db->deviceData;			
			$condition = array('dt' => array(
				'$gte'=>$bearerLastReading,
				'$lte'=>$time
				) ,
			'did'=>array('$in' => $dAccess)
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