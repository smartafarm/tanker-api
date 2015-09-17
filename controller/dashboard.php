<?php
class dashboard extends controller{
	function __construct() {
		parent::__construct();
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
	public function getReadings(){
		$this->model->getReadings();
	}
	public function getDevices(){
		$this->model->getDevices();
	}
	public function getUpdate(){
		$this->model->getUpdate();
	}
}