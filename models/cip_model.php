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
class cip_model extends model{
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
				echo json_encode('Data not valid');
				exit();
			}else
			{
				
				$dt1 = DateTime::createFromFormat('Ymd\THis\Z', $r_string[1]);
				$collection = $this->db->cipData;
				$options = array('fsync'=>\TRUE);
				$collection->insert(
					array(
						//substring device id
						'did' => substr($r_string[0],2,strlen($r_string[0]) ),							
						//storing mongo date object
						'dt' => new MongoDate($dt1->getTimestamp()),
						//storing temprature value
						'temp'=>$r_string[2]
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
	function fetch() {
		/*		 
		 * Gets all the devices in the dataBase based on the user
		 * @var - $bearer - user received from fetch controller  		 
		 */
		
		
		$userCollection = $this->db->cipData;
		$cursor = $userCollection->find();
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
}// end of class
?>