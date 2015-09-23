<?php
/*
 * @desc - Error Controller
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Initial error controller
 * 
 */
class error extends controller{
	function __construct() {
		parent::__construct();
	}
	public function index(){
		$this->view->render('error/index');
	}
}