<?php
class route extends controller{
	
	
	
	function __construct() {
		/*
		Checking request to the server and token values
		Setting headers for each request
		*/
		$request = new request();
		
	}
	
	public function pushstart(){
		/*
		 * push
		 */
		
		$data = json_decode(file_get_contents('php://input'), true);		
		$this->model->pushstart($data);


		}
	public function pushend(){
	/*
	 * push
	 */

	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->pushend($data);
	}

	public function get($data){
	/*
	 * fetch data by device id
	 */
	
	$this->model->get($data);

	}
	
	
}
?>