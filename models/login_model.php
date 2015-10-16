<?php
/*
 * @desc - Login model
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Authenticates the login and creates session
 *
 */
error_reporting(E_ALL ^ E_NOTICE);
class login_model extends Model {
	function __construct(database $database) {
		parent::__construct();
	} // end of construct
	
	public function check($data) {
		
		$collection = $this->db->users1;
		$authenticate = array (
				"username" => $data['credentials']['username'],
				"password" => $data['credentials']['password'] 				
		);		

		$result = $collection->count ($authenticate);
		
		if ($result == 1) {
		$readings = $collection->find($authenticate)	;
		// setting appropriate sessions and tokens for users
		
		$token = rand(0,5000000000);
		foreach ($readings as $key => $reading) {

				if (!Session::get($data['credentials']['username']))
				{
					Session::set($data['credentials']['username'],$token);					
				}
				$response = array(
					'token' => Session::get($data['credentials']['username']),
					'id'	=> $data['credentials']['username'],
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
	print_r($_SESSION);
	if (Session::get($data['data']['user'])){
		$gettoken= Session::get($data['data']['user']);
			if ($data['data']['token'] == $gettoken){
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
