<?php
class device extends controller{
	
	
	
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

	public function get($data){
	/*
	 * get supplier data
	 */
	
	$this->model->get($data);

	}
	public function fetchall(){
	/*
	 * fetch data by device ID
	 */
	
	$this->model->fetchall();

	}
	public function update(){
		/*
		 * push
		 */
		
	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->update($data);


	}
}
?>