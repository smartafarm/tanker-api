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
	
	}// end of get
	public function upload(){

	if (isset($_FILES['file'])) {				
		
		date_default_timezone_set('Australia/Sydney');
		$date = date('d_m_Y_h_i', time());
		$collection = $this->db->upload;
		$filename =  $date . '_' .$_FILES['file']['name'];
	  	$destination = 'upload/' . $filename ;	  	
	  	move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );
	  	$newrecord = array( 'name' => $filename , 'path' => $destination);
	  	$collection->insert($newrecord);	  
	  	header('Content-Type: application/json');
		echo json_encode($newrecord, JSON_PRETTY_PRINT);
	  }
	else
	{
		$msg = "400 BAD REQUEST";
		echo $msg;	
	}
}

function fetchall() {
		//fetching display data
		$userCollection = $this->db->upload;
		$cursor = $userCollection->find();
		$result = array();
		foreach($cursor as $key=>$value){
			if(file_exists($value['path'])){
				array_push($result,$value);
			}	else
			{
				//remove deleted files
				$userCollection->remove(array('_id' => new MongoID( $value['_id'] )));
			}		
		}
		header('Content-Type: application/json');
		echo json_encode( $result , JSON_PRETTY_PRINT);
	}
}//eof class
?>