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
	 		$url = $_GET['url']; 									//get the URL string (.htacess) re-routes everything to index.php in main folder
	 		$url = trim($url,'/');
	 		$url = explode('/', $url) ; 
	 		
	 									// creating the url array
 		}else{
 			header('location:login'); 
 		}
 		
 		$file = 'controller/'.$url[0].'.php';						// including the page called in the index to trigger a view
 		
 		if (file_exists($file)){									// checking if the called page exist or not
 			require $file;
 		}else{
 		 require 'controller/error.php';							// if file not found , reroute to error and terminate the program
 		 $controller = new error();
 		 return false;
 		}
 		
 		$controller = new $url[0];
 		$controller->loadModel($url[0]);
 		
 		
	 	if (isset($url[2])) {
				$controller->{$url[1]}($url[2]);

			} elseif (isset($url[1])) {
					$controller->{$url[1]}();
			}else {
				$controller->index();								// calling the index function by default if nothing is called
			}
 		
 	}
 }
