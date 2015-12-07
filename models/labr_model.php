<?php 
error_reporting(E_ERROR);
class labr_model extends model{
	function __construct(database $database) {
		parent::__construct();		

	}
	
	public function get($data){
	if(!isset($data)){
		http_response_code(400);	
		$msg  =		"BAD REQUEST"; 
		echo json_encode($msg);
		exit();
	}

	$str = ltrim($data, '0');	
	$collection = $this->db->labResults;
	$result = $collection->find(array('supID' => (int)$str));
	if($result->count() == 0){
		http_response_code(400);	
		$msg  =		"Supplier Not Found"; 
		echo json_encode($msg);	}
	else
	{
		$response = array();
		foreach($result as $key=>$value){
				array_push($response,$value['result']);
			}
		header('Content-Type: application/json');
		echo json_encode( $response, JSON_PRETTY_PRINT);
	}
	
	}// end of class
}
?>