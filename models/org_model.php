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
class org_model extends model{
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
				
				$collection = $this->db->org;				
				$newrecord = 	array(
						//substring device id
						'orgName' => substr($r_string[0],2,strlen($r_string[0]) ),													
						'street'=>$r_string[1],
						'city'=>$r_string[2],						
				
						)	;			
				$result = $collection->insert($newrecord);

				if(isset($r_string[3])){
					
					if($r_string[3] == 'return')
					{
						$response = $newrecord['_id'];
					}
				}else
					{
						$response = $this->db->lastError();
						$response = $response['ok'];
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

	/*function get($data) {

	if(!isset($data)){
		http_response_code(400);	
		$msg  =		"BAD REQUEST"; 
		echo json_encode($msg);
		exit();
	}

	
	$collection = $this->db->processor;
	// if date is supplied 
	if (is_array($data))
	{
		$pid = $data[0];
		$destID = $data[1];
		$cursor = $collection->find(array('pid' => $pid , 'destID' => $destID));
		
		
	}
	else{

			$pid = $data;
			$cursor = $collection->find(array('pid' => $pid ))->sort(array('destID'=>1));
		}
	if($cursor->count() == 0){
		http_response_code(400);	
		$msg  =		"No Data Found"; 
		echo json_encode($msg);	
		}
	$result = array();		
			$index = 0;
			
			foreach($cursor as $key=>$value){	
				if($index == 0)	
				{
											
						//returning string		
							$string = 	'##'.$value['did' ] . ','.
										$value['pid'] . ','.
										$value['pname'] . ','.
										'#'.$value['destID'] . ','.
										$value['destName'] . ','.
										$value['lat'] . ','.
										$value['long'] .',';
									}
					else{
							$string.='#'.$value['destID'] . ','.
									$value['destName'] . ','.
									$value['lat'] . ','.
									$value['long'] .',';
						}
				$index++;
					
			}
			$string.= '*';
			array_push($result,$string);	
			header('Content-Type: application/json');
			echo json_encode( $result , JSON_PRETTY_PRINT);
	
	}
	*/
	function getID($user) {
	// geting the orgarnisation id of the user
	// when user setup is created this api call will return the user's org id for further data entry
	// 				
	$collection = $this->db->user;
	$cursor = $collection->find(array("userid" => $user));
	if($cursor->count() == 0){
		http_response_code(400);	
		$msg  =		"User Not Found"; 
		echo json_encode($msg);	}
	else
	{
		
		
		
		foreach($cursor as $key=>$value){
			
			foreach($value['orgId'] as $key1=>$value1)
			{
				$result=$value1;
			}
				
			
			
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
		
	}

	function fetchall() {
			
	$collection = $this->db->org;
	$cursor = $collection->find();
	if($cursor->count() == 0){
		http_response_code(400);	
		$msg  =		"Device Not Found"; 
		echo json_encode($msg);	}
	else
	{
		
		
		$result = array();	
		foreach($cursor as $key=>$value){
			
			
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
		$collection = $this->db->org;
		
	 
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
		$collection = $this->db->org;
		$response = $collection->remove(array('_id' => new MongoID( $data['query']['id'])));
		//$response = $this->db->lastError();
		header('Content-Type: application/json');
		echo json_encode( $response['n'], JSON_PRETTY_PRINT);
		
	}
}// end of class
?>