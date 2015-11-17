<?php
class update extends controller{
	protected $bearer;
	function __construct() {
		if(request::checkReq()){
			// set the bearer for further processing if request and token are valid
			$this->bearer = $_SERVER['HTTP_BEARER'];
		}
	}
	
	public function deviceStatus(){
	/*
	 * toggles device status from active to in active
	 */
	$data = json_decode(file_get_contents('php://input'), true);
	$this->model->deviceStatus($data);

	}
	public function fname(){
	/*
	 * updates the friendly name of the device
	 */
	$data = json_decode(file_get_contents('php://input'), true);
	$this->model->fname($data);

	}

	
}