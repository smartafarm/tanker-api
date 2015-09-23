<?php
/*
 * @desc - Dashboard controller
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Initialized the controller to get readings and respond to the data poll.
 * 
 */
class dashboard extends controller{
	function __construct() {
		parent::__construct();
		// array of all javascritps and css to load as per the view
		$this->view->js = array('dashboard/js/default.js','dashboard/js/notify.js');
		$this->view->css = array('dashboard/css/default.css');
	}
	public function index(){
		$this->view->render('dashboard/index');		
	}
	public function logout(){
		Session::destroy();
		header('Location: ../login');
		exit;
	}

	public function getDevices(){
		/*
		 * get the devices and readings of the deivces
		 * responds array of Json
		 */
		$this->model->getDevices();
	}
	public function getUpdate(){
		// Triggers a notification if new reading has been added. 
		// responds JSON data of reading to ajax poll.
		$this->model->getUpdate();
	}
}