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
	
	public function render($name,$noInclude=true) {
	/*
	 * @desc - This will find the view when called and include it in the browser page
	 */	
		if ($noInclude == false){
			require 'Views/'.$name.'.php';
		}else {
			require 'Views/header.php';
			require 'Views/'.$name.'.php';
			require 'Views/footer.php';
		}// end if condition
	
	}// end of render class
	
}//end of view class
