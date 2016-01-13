<?php
class supplier extends controller{
	
	
	
	function __construct() {
		/*
		Checking request to the server and token values
		Setting headers for each request
		*/
		$request = new request();
		
	}
	
	

	public function get($data){
	/*
	 * get supplier data
	 */
	
	$this->model->get($data);

	}
	
	
}
?>