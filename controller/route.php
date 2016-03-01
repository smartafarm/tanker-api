<?php
class route extends controller{
	
	
	
	function __construct() {
		/*
		Checking request to the server and token values
		Setting headers for each request
		*/
		$request = new request();
		
	}
	public function pushdata(){
	/*
	 * push
	 */
	
	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->pushdata($data);


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

	public function fetchallstart(){
	/*
	 * fetch
	 */
	
	$this->model->fetchallstart();

	}
	public function fetchalldata(){
	/*
	 * fetch
	 */
	
	$this->model->fetchalldata();

	}

	public function fetchallend(){
	/*
	 * fetch
	 */
	
	$this->model->fetchallend();

	}

	public function updatestart(){
	/*
	 * push
	 */
	
	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->updatestart($data);


	}
	public function updateend(){
	/*
	 * push
	 */
	
	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->updateend($data);


	}
	public function updatedata(){
	/*
	 * push
	 */
	
	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->updatedata($data);


	}
	public function deletestart(){
	/*
	 * push
	 */
	
	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->deletestart($data);


	}
	public function deleteend(){
	/*
	 * push
	 */
	
	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->deleteend($data);


	}
	public function deletedata(){
	/*
	 * push
	 */
	
	$data = json_decode(file_get_contents('php://input'), true);		
	$this->model->deletedata($data);


	}
	
}
?>