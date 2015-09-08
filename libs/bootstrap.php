<?php
/*
 * @author- Vandish Gandhi
 * @Description
 * Version History
 * 1.0 - giving the application initial route to index.php (8/9/15)
 * 
 */
 class bootstrap {
 	
 	function __construct() {
 		
 		if(isset($_GET['url']))
 		{
	 		$url = $_GET['url']; 										//get the URL string (.htacess) re-routes everything to index.php in main folder
	 		$url = trim($url,'/');
	 		$url = explode('/', $url) ; 								// creating the url array
 		}else{
 			$url[0] = 'login'; 
 		}
 		
 		$file = 'controller/'.$url[0].'.php';						// including the page called in the index to trigger a view
 		
 		if (file_exists($file)){									// checking if the called page exist or not
 			require $file;
 		}else{
 		 require 'controller/error.php';								// if file not found , reroute to error and terminate the program
 		 $controller = new error();
 		 return false;
 		}
 		$controller = new $url[0];									// calling the constructor of the controller class.
 		
 		if (isset($url[2])){
 			$controller->{$url[1]}($url[2]);						// eg localhost/help/contactus/  || contract us is method || phone is the argument
 		}
 		
 	}
 }
