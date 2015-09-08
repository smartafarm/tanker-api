<?php
/*
 * @author - Vandish Gandhi
 * @desc - The main view navigator. This is called by the controller to create a view based on the request
 */

class View {
	function __construct() {
		/*
		 * @desc - constructor of the main view class
		 */
		
	}// end of constructor
	
	public function render($name) {
	/*
	 * @desc - This will find the view when called and include it in the browser page
	 */	
		require 'views/'.$name.'.php';
		
	}// end of render class
	
}//end of view class
