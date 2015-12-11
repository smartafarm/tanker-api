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
class tloc_model extends model{
	function __construct(database $database) {
		parent::__construct();		

	}
	
	public function push($text){
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
				exit();
			}else
			{
				if(!isset($r_string[4])){
					//if lat long not provided
					http_response_code(400);
					echo json_encode('Data not valid');
					exit();	
				}
				$dt1 = DateTime::createFromFormat('Ymd\THis\Z', $r_string[1]);
				$collection = $this->db->tlocData;
				$options = array('fsync'=>\TRUE);
				$collection->insert(
					array(
						//substring device id
						'did' => substr($r_string[0],2,strlen($r_string[0]) ),							
						//storing mongo date object
						'dt' => new MongoDate($dt1->getTimestamp()),
						//storing temprature value
						'lat'=>$r_string[2],
						'long'=>$r_string[3]
						));
				$response = $this->db->lastError();
				http_response_code(200);
				echo json_encode($response['ok']);
			}
			}
	}
	else
	{
		$msg = "400 BAD REQUEST";
		echo $msg;	
	}
	}// end of get status
	function fetch($data) {
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

	
	$collection = $this->db->tlocData;
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
			array_push($result,$value);
			$result[$index]["dt"] = date(DATE_ISO8601, $result[$index]["dt"]->sec);
			//unsetting mongo id from response data
			unset($result[$index]['_id']);
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
	
	
		
		
	}
}// end of class
?>