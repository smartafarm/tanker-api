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
}// end of class
?>