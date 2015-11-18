<?php
class fetch extends controller{
	protected $bearer;
	function __construct() {
		$this->bearer = $_SERVER['HTTP_BEARER'];
		/*if(request::checkReq()){
			// set the bearer for further processing if request and token are valid
			$this->bearer = $_SERVER['HTTP_BEARER'];
		}*/
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