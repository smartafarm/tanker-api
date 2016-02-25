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
class device_model extends model{
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
			}else
			{
				
				$collection = $this->db->device;				
				$newrecord = 	array(
						//substring device id
						'did' => substr($r_string[0],2,strlen($r_string[0]) ),													
						'tankid'=>$r_string[1],
						'truckid'=>$r_string[2],
						'dstatus'=>$r_string[3]
						
						)	;			
				$result = $collection->insert($newrecord);

				if(isset($r_string[4])){
					
					if($r_string[4] == 'return')
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
	}

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

	
	$collection = $this->db->device;
	$cursor = $collection->find(array('did' => $data));
	if($cursor->count() == 0){
		http_response_code(400);	
		$msg  =		"Device Not Found"; 
		echo json_encode($msg);	}
	else
	{
		
		
		$result = array();
		
		foreach($cursor as $key=>$value){
				$string = 	'##'.$value['did'] . ','.
						$value['tankid'] . ','.
						$value['truckid'] . ','.						
						$value['dstatus'] . ',*';
			array_push($result,$string);		
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
		
	}

	function fetchall() {
			
	$collection = $this->db->device;
	$cursor = $collection->find();
	if($cursor->count() == 0){
		http_response_code(400);	
		$msg  =		"Device Not Found"; 
		echo json_encode($msg);	}
	else
	{
		
		
		$result = array();	
		foreach($cursor as $key=>$value){
			
			$value["dt"] = date('Y-m-d H:i:s', $value["dt"]->sec);
			array_push($result,$value);
			
			//unsetting mongo id from response data
			
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
		
	}

	function update($data) {
		/*
		@var - $data - revices device id and friendly name
		 */
		if(!isset($data['query'])){
			http_response_code(400);	
			$msg  =		"No Content"; 
			echo json_encode($msg);
			exit;
		}
		$collection = $this->db->device;
		
	 
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