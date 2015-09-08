<?php

class error extends controller{
	function __construct() {
		parent::__construct();
		$this->view->render('error/index');
	}
}