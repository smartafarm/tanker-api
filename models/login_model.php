<?php
/*
 * @desc - Login model
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Authenticates the login and creates session
 *
 */
use \Firebase\JWT\JWT;
error_reporting(E_ALL ^ E_NOTICE);
class login_model extends Model {
	function __construct(database $database) {
		parent::__construct();
	} // end of construct
	
	public function check($data) {
		
		$collection = $this->db->userMaster;
		$authenticate = array (
				"uname" => $data['credentials']['username'],
				"password" => $data['credentials']['password'] 				
		);		

		$result = $collection->count ($authenticate);
	
		if ($result == 1) {
		$readings = $collection->find($authenticate)	;
		// setting appropriate sessions and tokens for users
		
		
		 foreach ($readings as $key => $reading) {
		 	
		/*
		USER ARRAY SAMPLE
		(
		    [_id] => MongoId Object
		        (
		            [$id] => 561da244787d2fb7844b32a4
		        )

		    [username] => admin
		    [password] => admin
		    [user] => Array
		        (
		            [id] => admin
		            [role] => admin
		        )

		)*/

		$username = $data['credentials']['username'];
		$set = array(
			"timestamp" => time(),
		    "user" => $username		    
		);
		$jwt = JWT::encode($set, TOKEN_KEY);	

		//$decoded = JWT::decode($jwt, TOKEN_KEY, array('HS256'));		

		 		if (!Session::get($username))
		 		{
		 			Session::set($username,$jwt);					
		 		}
		 		$token = Session::get($username);
		 		$response = array(
		 			'token' => $token,
		 			'id'	=> $username,
		 			'role'	=> $reading['user']['role']
		 			 );
		 		header('Content-Type: application/json');
		 		echo json_encode($response);					
		 	}		
		 } 
		 else
		 {
		 	$data = array();
		 	$data["response"]  = "Invalid Login";			
     		http_response_code(401);
     		header('Content-Type: application/json');
		 	echo json_encode( $data , JSON_PRETTY_PRINT);		
		 }
	} // end of check


public function validate($data){
	//unset($_SESSION['timestamps']);
	print_r($_SESSION);
	if (Session::get($data['data']['user'])){
		$gettoken= Session::get($data['data']['user']);
			if ($data['data']['token'] == $gettoken['token']){
				http_response_code(200);		
			}else{
				unset($_SESSION[$data['data']['user']]);
				http_response_code(401);	
			}
	}else{
		http_response_code(401);
	} // eof validate

	}
public function destroy($data){
	
	unset($_SESSION[$data['user']]);

}
}
