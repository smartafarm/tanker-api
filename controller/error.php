<?php

class error extends controller{
	function __construct() {
		parent::__construct();
	}
	public function index(){
		$this->view->render('error/index');
	}
}