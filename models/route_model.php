<?php 
/*
 * @desc - class to receive data from 
 *
 * @variables 
 * 				$args = receiving the post query
 * 				$r_string = recevied string in request for evaluation
 *  Version History:
 *  1.0 - Inititalizing the file to receive the request
 */
class route_model extends model{
	function __construct(database $database) {
		parent::__construct();		

	}
	
	public function pushstart($text){
		//handling data from POST request
	if ($_SERVER['REQUEST_METHOD'] == "POST"){			
		
		if(empty($text)){			
			$args=$_POST;
		}
		else{
			$args = $text;
		}
		
		// for raw data testing from device
		$collection = $this->db->rawData;
		$options = array('fsync'=>\TRUE);
		$collection->insert(array('msg'=>$args["query"]));

		// data insert			
		if (empty($args["query"])) {												// IF no string received
			http_response_code(400);	
			$msg  =		"No Content"; 
			echo json_encode($msg);
			exit;
			}
		else{	
			$r_string = explode(",", $args["query"]);
			
			if(substr($r_string[0],0,2) != '##' || $r_string[count($r_string) -1 ] != '*'){
				http_response_code(400);
				echo json_encode('Data not valid');
				exit();
			}else
			{
				
				$dt1 = DateTime::createFromFormat('Ymd\THis\Z', $r_string[1]);
				$collection = $this->db->route;
				$options = array('fsync'=>\TRUE);
				$newrecord= 
					array(
						//substring device id
						'did' => substr($r_string[0],2,strlen($r_string[0]) ),							
						//storing mongo date object
						'dt' => new MongoDate($dt1->getTimestamp()),
						//route no
						'rno'=>$r_string[2],
						//driver id 
						'dvrid' => $r_string[3],
						//lat
						'lat' => $r_string[4],
						//long
						'long' => $r_string[5],
						//processor reference no
						'prno' => $r_string[6],
						);
				$result =$collection->insert($newrecord);

				if(isset($r_string[7])){
					
					if($r_string[7] == 'return')
					{
						$response = $newrecord['_id'];
					}else
					{
						$response = $this->db->lastError();
						$response = $response['ok'];
					}
				}
				
				http_response_code(200);
				echo json_encode($response);
			}
			}
	}
	else
	{
		$msg = "400 BAD REQUEST";
		echo $msg;	
	}
	}// end of push start

public function pushend($text){
		//handling data from POST request
	if ($_SERVER['REQUEST_METHOD'] == "POST"){			
		
		if(empty($text)){			
			$args=$_POST;
		}
		else{
			$args = $text;
		}
		
		// for raw data testing from device
		$collection = $this->db->rawData;
		$options = array('fsync'=>\TRUE);
		$collection->insert(array('msg'=>$args["query"]));

		// data insert			
		if (empty($args["query"])) {												// IF no string received
			http_response_code(400);	
			$msg  =		"No Content"; 
			echo json_encode($msg);
			exit;
			}
		else{	
			$r_string = explode(",", $args["query"]);
			
			if(substr($r_string[0],0,2) != '##' || $r_string[count($r_string) -1 ] != '*'){
				http_response_code(400);
				echo json_encode('Data not valid');
				exit();
			}else
			{
				
				$dt1 = DateTime::createFromFormat('Ymd\THis\Z', $r_string[1]);
				$collection = $this->db->routeend;
				$options = array('fsync'=>\TRUE);
				$newrecord =
					array(
						//substring device id
						'did' => substr($r_string[0],2,strlen($r_string[0]) ),							
						//storing mongo date object
						'dt' => new MongoDate($dt1->getTimestamp()),
						//route no
						'rno'=>$r_string[2],
						//lat
						'lat' => $r_string[3],
						//long
						'long' => $r_string[4],
						//sample ice box avg temprature
						'sibtemp' => $r_string[5],
						//milk load average temprature
						'mltemp' => $r_string[6],
						//factory reference no
						'frno' => $r_string[7],
						);
				$result =$collection->insert($newrecord);

				if(isset($r_string[8])){
					
					if($r_string[8] == 'return')
					{
						$response = $newrecord['_id'];
					}else
					{
						$response = $this->db->lastError();
						$response = $response['ok'];
					}
				}
				
				http_response_code(200);
				echo json_encode($response);
			}
			}
	}
	else
	{
		$msg = "400 BAD REQUEST";
		echo $msg;	
	}
	}// end of push end

	function get($data) {
		/*		 
		 * Gets all the devices in the dataBase based on the user
		 * @var - $bearer - user received from fetch controller  		 
		 */
	if(!isset($data)){
		http_response_code(400);	
		$msg  =		"BAD REQUEST"; 
		echo json_encode($msg);
		exit();
	}

	
	$collection = $this->db->routedata;
	$cursor = $collection->find(array('did' => $data));
	if($cursor->count() == 0){
		http_response_code(400);	
		$msg  =		"Device Not Found"; 
		echo json_encode($msg);	}
	else
	{
		
		
		$result = array();
		$index = -1;
		foreach($cursor as $key=>$value){
			$index++;
			array_push($result,$value['result']);
			//$result[$index]["dt"] = date(DATE_ISO8601, $result[$index]["dt"]->sec);
			//unsetting mongo id from response data
			//unset($result[$index]['_id']);
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
		
	}


	function fetchallstart() {
		//fetching display data
		$userCollection = $this->db->route;
		$cursor = $userCollection->find();
		$result = array();
		foreach($cursor as $key=>$value){
			$value["dt"] = date('Y-m-d H:i:s', $value["dt"]->sec);
			array_push($result,$value);
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
	function fetchallend() {
		//fetching display data
		$userCollection = $this->db->routeend;
		$cursor = $userCollection->find();
		$result = array();
		foreach($cursor as $key=>$value){
			$value["dt"] = date('Y-m-d H:i:s', $value["dt"]->sec);
			array_push($result,$value);
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}


	function updatestart($data) {
	/*
	@var - $data - revices device id and friendly name
	 */
	if(!isset($data['query'])){
		http_response_code(400);	
		$msg  =		"No Content"; 
		echo json_encode($msg);
		exit;
	}
	$collection = $this->db->route;
	
 
	$response = $collection->update(
	    array("_id" => new MongoID( $data['query']['id'] )),
	    array(
	        '$set' => array($data['query']['change'] => $data['query']['value']),
	    ),
	    array("upsert" => false)
	);
	//$response = $this->db->lastError();
	header('Content-Type: application/json');
	echo json_encode( $response['n'], JSON_PRETTY_PRINT);
}

function updateend($data) {
	/*
	@var - $data - revices device id and friendly name
	 */
	if(!isset($data['query'])){
		http_response_code(400);	
		$msg  =		"No Content"; 
		echo json_encode($msg);
		exit;
	}
	$collection = $this->db->routeend;
	
 
	$response = $collection->update(
	    array("_id" => new MongoID( $data['query']['id'] )),
	    array(
	        '$set' => array($data['query']['change'] => $data['query']['value']),
	    ),
	    array("upsert" => false)
	);
	//$response = $this->db->lastError();
	header('Content-Type: application/json');
	echo json_encode( $response['n'], JSON_PRETTY_PRINT);
}
}// end of class
?>