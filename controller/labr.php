<?php
class labr extends controller{
	
	function __construct() {
		/*
		Checking request to the server and token values
		Setting headers for each request
		*/
		$request = new request();
		
	}
	
	public function get($data){
		/*
		 * push
		 */
		
		//$data = json_decode(file_get_contents('php://input'), true);		
				
		
		$this->model->get($data);


		}
	public function fetch(){
	/*
	 * push
	 */
	
	$this->model->fetch();

	}
	
	
}
?>