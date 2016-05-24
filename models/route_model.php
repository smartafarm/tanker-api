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
				$collection = $this->db->routeScheduler;
				$routeScheduleid = $r_string[1];
				$recordChecker = $collection->find(array('routeScheduleid' => (int)$routeScheduleid));
				
				if($recordChecker->count() == 0){
					echo json_encode("Route Schedule Not Found ");
					http_response_code(400);
					exit();
				}
				$startStamp = DateTime::createFromFormat('Ymd\THis\Z', $r_string[2]);
				 
				$response = $collection->update(
				    array(
			    	"routeScheduleid" => (int)$routeScheduleid
			    	),
				    array(
				        '$set' => array(
				        	"startStamp" => new MongoDate($startStamp->getTimestamp()),
				        	"driverid" => $r_string[4],
				        	"latStart" => $r_string[5],
				        	"longStart" => $r_string[6],
				        	"fref" => $r_string[7]
				        	)
				    ),
				    array("upsert" => false)
				);

				$response = $this->db->lastError();
				$response = $response['n'];
				
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
public function pushdata($text){
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
				$collection = $this->db->routedata;
				$options = array('fsync'=>\TRUE);
				$newrecord= 
					array(
						//substring device id
						'did' => substr($r_string[0],2,strlen($r_string[0])),							
						
						'dt' => new MongoDate($dt1->getTimestamp()),
						
						'routeid'=>$r_string[2],

						'pid' => $r_string[3],
						
						'destID' => $r_string[4],
						
						'supplier' => $r_string[5],
						
						'suppliercrn' => $r_string[6]
						
						
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
				
				$collection = $this->db->routeScheduler;
				$routeScheduleid = $r_string[1];
				$recordChecker = $collection->find(array('routeScheduleid' => (int)$routeScheduleid));
				
				if($recordChecker->count() == 0){
					echo json_encode("Route Schedule Not Found ");
					http_response_code(400);
					exit();
				}
				$endStamp = DateTime::createFromFormat('Ymd\THis\Z', $r_string[2]);
				 
				$response = $collection->update(
				    array(
			    	"routeScheduleid" => (int)$routeScheduleid
			    	),
				    array(
				        '$set' => array(
				        	"endStamp" => new MongoDate($endStamp->getTimestamp()),				        	
				        	"latEnd" => $r_string[4],
				        	"longEnd" => $r_string[5],
				        	"sibTemp" => $r_string[6],
				        	"mlTemp" => $r_string[7],
				        	"frsn" => $r_string[9],
				        	)
				    ),
				    array("upsert" => false)
				);

				$response = $this->db->lastError();
				$response = $response['n'];
				
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
		 */
	if(!isset($data)){
		http_response_code(400);	
		$msg  =		"BAD REQUEST"; 
		echo json_encode($msg);
		exit();
	}
	$existFlag = false;
	$collection = $this->db->routedata;
	// if date is supplied 
	if (is_array($data)){
		$device = $data[0]; 

		// creating date range for mongo
		$fromdate = DateTime::createFromFormat('dmYHis', $data[1].'000000');
		$todate = DateTime::createFromFormat('dmYHis', $data[1].'000000');
		if(!$fromdate){
			http_response_code(400);	
			$msg  =		"DATE FORMAT INVALID"; 
			echo json_encode($msg);
			exit();
		}
		$fromdate->sub(new DateInterval('PT01M'));
		$todate->add(new DateInterval('P1D')); 		
		//date timestamps
		$from = new MongoDate($fromdate->getTimestamp());
		$to = new MongoDate($todate->getTimestamp());
		// fetching values by date range
		$cursor = $collection->find(array('did' => $device , 'dt' => array('$gt'=>$from , '$lt' => $to)))->sort(array('dt' => 1) );
		$routeidindex = 0;
		foreach($cursor as $key=>$value){
			if($routeidindex == 0){
				$routeid = $value["routeid"];
			}
			$routeidindex++;
		}
	}else{
		http_response_code(400);	
		$msg  =		"DATE NOT PROVIDED"; 
		echo json_encode($msg);
		exit();
		/*$device = $data;
		$cursor = $collection->find(array('did' => $device));*/
	}
	
	
	if($cursor->count() == 0){
		// responding last found data of the route		
		$cursor = $collection->find(array('did' => $device))->sort(array('dt'=>-1))->limit(1);
		if($cursor->count() == 0){
			echo json_encode("Route Not Found");
		exit();
		}	
		foreach($cursor as $key=>$value){
			$routeid = $value["routeid"];
			$captureLastDate = DateTime::createFromFormat('U', $value["dt"]->sec );
			$captureLastDate->setTimezone(new DateTimezone ('Australia/Brisbane'));
			
			$fromdate = DateTime::createFromFormat('dmYHis', $captureLastDate->format('dmY').'000000');
			$todate = DateTime::createFromFormat('dmYHis', $captureLastDate->format('dmY').'000000');
			$fromdate->sub(new DateInterval('PT01M'));
			$todate->add(new DateInterval('P1D')); 	

			//date timestamps
			$from = new MongoDate($fromdate->getTimestamp());
			$to = new MongoDate($todate->getTimestamp());
			
			$cursor1 = $collection->find(array('did' => $device , 'dt' => array('$gt'=>$from , '$lt' => $to)))->sort(array('dt' => 1) );
		}				
		
		}

		//getting route Schedule id
		$searchDate =  DateTime::createFromFormat('dmYHis', $data[1].'000000');
		$searchDate->sub(new DateInterval('PT01M'));
		$todate = DateTime::createFromFormat('dmYHis', $data[1].'000000');		
		$todate->add(new DateInterval('P1D')); 
		$searchFrom = new MongoDate($searchDate->getTimestamp());
		$to = new MongoDate($todate->getTimestamp());
		
		//creating route schedule id 
		$schedullerCollection =  $this->db->routeScheduler;
		$scheduleCursor = $schedullerCollection->find(array('routeid' => $routeid , 'dt' => array('$gt'=>$searchFrom , '$lt' => $to)));
		
		if($scheduleCursor->count() == 0){
			$getNewScheduleid = $schedullerCollection->find(array('routeid' => $routeid))->sort(array('routeScheduleid' => -1))->limit(1);
			foreach($getNewScheduleid as $key=>$value){				
				$routeScheduleid = $value["routeScheduleid"] + 1;
			}
			//setting route date
			$fromdate = DateTime::createFromFormat('dmYHis', $data[1].'000000');
			$from = new MongoDate($fromdate->getTimestamp());
			$newrecord =

					array(
						
						'routeScheduleid' => $routeScheduleid,
						
						'routeid' =>$routeid,
						
						'supplier'=>"",
						
						'expQty' => "",
						
						'dt' => $from,
						
						'driverid' => "",
						
						'latStart' => "",
						
						'longStart' => "",
						
						'startStamp' => "",
						
						'latEnd' => "",
						
						'longEnd' => "",
						
						'endStamp'=>"",
						
						'sibTemp' => "",
						
						'mlTemp' => "",
						
						'fref' => "",
						
						'frsn' => ""

						);
			$schedullerCollection->insert($newrecord);
			
		}else{
			foreach($scheduleCursor as $key=>$value){	
					
				$routeScheduleid = $value["routeScheduleid"];
			}
		}
		
		$result = array();		
		$index = 0;
		if(isset($cursor1)){
			$cursor = $cursor1 ; 
			$existFlag = true;
		}
		foreach($cursor as $key=>$value){	
			if($index == 0)	
			{
				//setting date as per fetched result
				if($existFlag){
					$value["dt"] = $fromdate->format(DATE_ISO8601);
				}else
				{
					$value["dt"] = date(DATE_ISO8601, $value["dt"]->sec);
				}
						
					//returning string		
						$string = 	'##'.$value['did' ] . ','.
									$routeScheduleid. ','.
									$value['dt'] . ','.
									$value['routeid'] . ','.
									$value['pid'] . ','.
									$value['destID'] . ','.
									$value['supplier'] . ','.
									$value['suppliercrn'] .',';
								}
				else{
						$string.=$value['supplier'] . ','.
						$value['suppliercrn']. ',' ;
					}
			$index++;
				
		}
		
	
		$string.= '*';
		array_push($result,$string);	
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
		
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

	function fetchalldata() {
		//fetching display data
		$userCollection = $this->db->routedata;
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

function updatedata($data) {
	/*
	@var - $data - revices device id and friendly name
	 */
	if(!isset($data['query'])){
		http_response_code(400);	
		$msg  =		"No Content"; 
		echo json_encode($msg);
		exit;
	}
	$collection = $this->db->routedata;
	
 
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
function deletestart($data){
		//print_r($data);
		if(!isset($data['query'])){
			http_response_code(400);	
			$msg  =		"No Content"; 
			echo json_encode($msg);
			exit;
		}
		$collection = $this->db->route;
		$response = $collection->remove(array('_id' => new MongoID( $data['query']['id'])));
		//$response = $this->db->lastError();
		header('Content-Type: application/json');
		echo json_encode( $response['n'], JSON_PRETTY_PRINT);
		
	}
function deleteend($data){
		//print_r($data);
		if(!isset($data['query'])){
			http_response_code(400);	
			$msg  =		"No Content"; 
			echo json_encode($msg);
			exit;
		}
		$collection = $this->db->routeend;
		$response = $collection->remove(array('_id' => new MongoID( $data['query']['id'])));
		//$response = $this->db->lastError();
		header('Content-Type: application/json');
		echo json_encode( $response['n'], JSON_PRETTY_PRINT);
		
	}
function deletedata($data){
	//print_r($data);
	if(!isset($data['query'])){
		http_response_code(400);	
		$msg  =		"No Content"; 
		echo json_encode($msg);
		exit;
	}
	$collection = $this->db->routedata;
	$response = $collection->remove(array('_id' => new MongoID( $data['query']['id'])));
	//$response = $this->db->lastError();
	header('Content-Type: application/json');
	echo json_encode( $response['n'], JSON_PRETTY_PRINT);
	
}
}// end of class
?>