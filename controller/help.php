<?php

class help extends controller{
	function __construct() {
		parent::__construct();
	}
	public function index(){
		$this->view->render('help/index');
	}
}