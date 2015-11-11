<?php
class fetch extends controller{
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
	
	public function getDevices(){
		/*
		 * get the devices and readings of the deivces
		 * responds array of Json
		 */
		$reqBearer = $this->bearer;
		$this->model->getDevices($reqBearer);
	}

	public function getUpdate(){
		// Triggers a notification if new reading has been added.
		// responds JSON data of reading to ajax poll.
		$reqBearer = $this->bearer;
		$this->model->getUpdate($_GET['t'],$reqBearer);
		
	}
	
	
}