<?php 
class feed extends controller{
	function __construct() {
		parent::__construct(false);
	}
	public function index(){
		$this->view->msg = $this->model->getStatus();
		echo  json_encode($this->view->msg);
		
	}
	
}