<?php
class admin extends controller{
	protected $bearer;
	function __construct() {
		if($_SERVER['REQUEST_METHOD'] == "GET")
{

    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: accept, bearer, x-auth-token');
    $this->bearer = $_SERVER['HTTP_BEARER'];
  
   
}
elseif($_SERVER['REQUEST_METHOD'] == "OPTIONS")
{
    // Tell the Client we support invocations from arunranga.com and that this preflight holds good for only 20 days
    if($_SERVER['HTTP_ORIGIN'] == "http://localhost")
    {
    header('Access-Control-Allow-Origin: http://smartafarm.com.au');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: accept,bearer,x-auth-token');
    header('Access-Control-Max-Age: 1728000');
    header("Content-Length: 0");
    header("Content-Type: application/json");
  
    //exit(0);
    }
    else
    {
    header("HTTP/1.1 403 Access Forbidden");
    header("Content-Type: text/plain");
    echo "You cannot repeat this request";
   
    }
}
elseif($_SERVER['REQUEST_METHOD'] == "POST")
{
    /* Handle POST by first getting the XML POST blob, and then doing something to it, and then sending results to the client
    */
    if($_SERVER['HTTP_ORIGIN'] == "http://smartafarm.com.au")
    {
            // $postData = file_get_contents('php://input');
            // $document = simplexml_load_string($postData);
            
            // // do something with POST data

            // $this->bearer = $_SERVER['bearer'];
           
                       
            header('Access-Control-Allow-Origin: http://smartafarm.com.au');
            header('Content-Type: text/plain');
            // some string response after processing
    }
    else
        die("POSTing Only Allowed from http://smartafarm.com.au");
}
else
    die("No Other Methods Allowed");

	/*	$reqHeader =apache_request_headers();
		if(!isset($reqHeader['Bearer'])){
			http_response_code(401);	
			die();
		}else{
		$this->bearer = $reqHeader['Bearer'];
		}
		if (!isset($reqHeader['X-Auth-Token'])){
			http_response_code(401);	
			die();
		}else{
			$token = $reqHeader['X-Auth-Token'];
			if(!Session::validate($token,$this->bearer)){
				http_response_code(401);	
				die();
			}
		}*/
	}
	
	public function createUser(){
		/*
		 * get new status updates
		 */
		$data = json_decode(file_get_contents('php://input'), true);
		$this->model->createUser($data);

		}
	public function getUsers(){
		// Triggers a notification if new reading has been added.
		// responds JSON data of reading to ajax poll.
		
		$this->model->getUsers();
		
	}
	public function getAllDevices(){
		/*
		 * get the devices and readings of the deivces
		 * responds array of Json
		 */
		$this->model->getAllDevices();
	}
	public function getDeviceFunc(){
		/*
		 * get the devices and readings of the deivces
		 * responds array of Json
		 */
		$this->model->getDeviceFunc();
	}
	public function setDeviceAccess(){
		/*
		 * get new status updates
		 */
		$data = json_decode(file_get_contents('php://input'), true);
		$this->model->setDeviceAccess($data);

		}
	

	
}