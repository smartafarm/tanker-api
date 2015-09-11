<?php
class login extends controller{
	function __construct() {
		parent::__construct(false);
	}
	public function index(){
		
		$this->view->render('login/index',false);
	}
	public function fail(){
		$this->msg = "Login Failed";
		$this->view->render('login/index',false);
		
	}
	public function authenticate(){
		
		$check = $this->model->check($_POST['username'],$_POST['password']);
		
	}
}