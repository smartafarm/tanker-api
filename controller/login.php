<?php
class login extends controller{
	function __construct() {
		parent::__construct();
		$this->view->render('login/index');
	}
}