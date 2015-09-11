<?php
class dashboard extends controller{
	function __construct() {
		parent::__construct();
		
	}
	public function index(){
		$this->view->render('dashboard/index');
	}
	public function logout(){
		Session::destroy();
		header('Location: ../login');
		exit;
	}
}