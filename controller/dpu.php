<?php
class dpu extends controller{
	
	//DAILY PICK UP DATA CONTROLLER
	
	function __construct() {
		/*
		Checking request to the server and token values
		Setting headers for each request
		*/
		$request = new request();
		
	}
	
	public function push(){
		/*
		 * push
		 */
		
		$data = json_decode(file_get_contents('php://input'), true);		
		$this->model->push($data);


		}
	public function fetch(){
	/*
	 * push
	 */
	
	$this->model->fetch();

	}
	
	
}
?>