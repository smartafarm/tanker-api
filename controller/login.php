<?php
/*
 * @desc - Dashboard controller
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Main Login controller. Authentication not implemented.  
 * 
 *
 */
class login extends controller{
	function __construct() {
		parent::__construct(false);
	}
	public function index(){
		$this->view->render('login/index',false);
	}

	public function authenticate(){
		/*
		 * responds to the login credintials
		 */
		$check = $this->model->check($_POST['username'],$_POST['password']);
		
	}
}