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
		$path = 'models/'.$name.'_model.php';
		if (file_exists($path)) {
			require $path;
		
			$modelName = $name.'_model';
			$this->model = new $modelName ();
		}
	}
}