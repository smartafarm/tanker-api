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
		/*
		@var - $data - user credentials recevived from controller
	 	*/
		
		$collection = $this->db->userMaster;
		$authenticate = array (
				"uname" => $data['credentials']['username'],
				"password" => $data['credentials']['password'] 				
		);		

		$result = $collection->count ($authenticate);
	
		if ($result == 1) {
		// if credentials are true
		$readings = $collection->find($authenticate)	;
		
		foreach ($readings as $key => $reading) {		
		$username = $data['credentials']['username'];
		$set = array(
			"timestamp" => time(),
		    "user" => $username		    
		);
		// creating a JSON web TOKEN
		$jwt = JWT::encode($set, TOKEN_KEY);	
 		if (!Session::get($username))
 		{
 			//create session for user
 			Session::set($username,$jwt);					
 		}
 		$token = Session::get($username);
 		// sign token to forward on client side
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
		// if user not found	 	
	 	$data = array();
	 	$data["response"]  = "Invalid Login";			
 		http_response_code(401);
 		header('Content-Type: application/json');
	 	echo json_encode( $data , JSON_PRETTY_PRINT);		
	 }
} // end of check


public function validate($data){
	// validating user token 
	// currently un used as preflight request already validates token	
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
	// destroy user session and token
	unset($_SESSION[$data['user']]);

}
}
