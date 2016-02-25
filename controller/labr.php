<?php
class labr extends controller{

	//LAB RESULTS DATA CONTROLLER
	
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
	public function upload(){
		/*
		 * push
		 */
		
		
		$this->model->upload();


		}
	public function fetchall(){
					
			$this->model->fetchall();


		}		
	
}
?>