<?php

/*
 * @author- Vandish Gandhi
 * @desc -  Main controller class to request the view for the URL 
 * 
 * Version History:
 * 1.0 - initiated the class and extended it to its sub classes
 */
class controller {
	function __construct() {
		$this->view =  new View();
	}
}