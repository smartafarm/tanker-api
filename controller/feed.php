<?php 
/*
 * @desc - Feed controller
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Feed API to handle the POST request on server for device data
 *
 */
class feed extends controller{
	function __construct() {
		parent::__construct(false);
	}
	public function index(){
		/*
		 * responds JSON encoded respose of the POST request based on params
		 */
		$this->model->getStatus();	
	}
	
}