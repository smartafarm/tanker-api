<?php

/*
 * @author- Vandish Gandhi
 * @desc -  Main controller class to request the view for the URL 
 * 
 * Version History:
 * 1.0 - initiated the class and extended it to its sub classes
 */
class controller {
	
	function __construct($check = true) {
		$this->view =  new View();
		
		// Setting session if the credentials are true and destroying if false
		if ($check) {
			Session::init();
			$logged = Session::get('loggedIn');
			if($logged ==false){
				Session::destroy();
				header('Location: login');
				exit;
			}
			
		}
		
		
	}
	public function loadModel($name) {
		// loading the model if it exists
		$path = 'models/'.$name.'_model.php';		
		if (file_exists($path)) {
			require $path;
			$modelName = $name.'_model';
			
			// passing database instance to each model
			$this->model = new $modelName (new database());
		}
	}
}