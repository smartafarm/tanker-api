<?php 
class feed extends controller{
	function __construct() {
		parent::__construct(false);
	}
	public function index(){
		$this->model->getStatus();	
	}
	
}