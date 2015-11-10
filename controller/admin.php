<?php
class admin extends controller{
	protected $bearer;
	function __construct() {
		$reqHeader =apache_request_headers();
		if(!isset($reqHeader['Bearer'])){
			http_response_code(401);	
			die();
		}else{
		$this->bearer = $reqHeader['Bearer'];
		}
		if (!isset($reqHeader['X-Auth-Token'])){
			http_response_code(401);	
			die();
		}else{
			$token = $reqHeader['X-Auth-Token'];
			if(!Session::validate($token,$this->bearer)){
				http_response_code(401);	
				die();
			}
		}
	}
	
	public function createUser(){
		/*
		 * get new status updates
		 */
		$data = json_decode(file_get_contents('php://input'), true);
		$this->model->createUser($data);

		}
	

	
}