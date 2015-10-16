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
		$data = json_decode(file_get_contents('php://input'), true);		
		$check = $this->model->check($data);
		
	}
	public function validate(){
		/*
		 * responds to the login credintials
		 */
		$data = json_decode(file_get_contents('php://input'), true);		
		$check = $this->model->validate($data);
		
	}
	public function destroy(){
		/*
		 * responds to the login credintials
		 */
		$data = json_decode(file_get_contents('php://input'), true);		
		$check = $this->model->destroy($data);
		
	}
}