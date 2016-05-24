<?php 
/*
 * @desc - class to receive data from tankers for daily pickup
 * @variables 
 * 				$args = receiving the post query
 * 				$r_string = recevied string in request for evaluation
 *  Version History:
 *  1.0 - Inititalizing the file to receive the request
 */
class dpu_model extends model{
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
				$collection = $this->db->dpu;
				$dt1 = DateTime::createFromFormat('Ymd\THis\Z', $r_string[2]);	
				$newrecord = 	array(
						//substring device id
						'did' => substr($r_string[0],2,strlen($r_string[0]) ),							
						'routeScheduleid' => $r_string[1],
						'dt' => new MongoDate($dt1->getTimestamp()),						
						'lat'=>$r_string[3],
						'long'=>$r_string[4],
						'supplier'=>$r_string[5],
						'route'=>$r_string[6],
						'tavg'=>$r_string[7],
						'tmin'=>$r_string[8],
						'tmax'=>$r_string[9],
						'vol'=>$r_string[10],
						'sno' => $r_string[11]
						)	;			
				$result =$collection->insert($newrecord);

				if(isset($r_string[12])){
					
					if($r_string[12] == 'return')
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
	function fetch() {
	
		
		$userCollection = $this->db->rawData;
		$cursor = $userCollection->find();
		$result = array();
		foreach($cursor as $key=>$value){
			array_push($result,$value['msg']);
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}

	function fetchdpu() {
		//fetching display data
		$userCollection = $this->db->dpu;
		$cursor = $userCollection->find();
		$result = array();
		foreach($cursor as $key=>$value){
			$value["dt"] = date('Y-m-d H:i:s', $value["dt"]->sec);
			array_push($result,$value);
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
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
		$collection = $this->db->dpu;
		
	 
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

	function delete($data){
		//print_r($data);
		if(!isset($data['query'])){
			http_response_code(400);	
			$msg  =		"No Content"; 
			echo json_encode($msg);
			exit;
		}
		$collection = $this->db->dpu;
		$response = $collection->remove(array('_id' => new MongoID( $data['query']['id'])));
		//$response = $this->db->lastError();
		header('Content-Type: application/json');
		echo json_encode( $response['n'], JSON_PRETTY_PRINT);
		
	}
}// end of class
?>