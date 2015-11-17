<?php
/*
 * @desc - Session Library
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Basic session creating functions
 *
 */
use \Firebase\JWT\JWT;
class session {
	public static function init()
	{
		@session_start();
		//$_SESSION["TOKENS"] =array();
	}
	public static function set($key,$value){
		// sets the value in Session Global as per the request by server
		$_SESSION[$key] = $value;
	}
	public static function get($key){
		
		// returns the status of the session
		
		if(isset($_SESSION[$key]))
		{
		return $_SESSION[$key]; 
		}else return false;
	}
	
	public static function destroy() {
		@session_destroy();
	}
	public static function tokenCheck($request,$checkAdmin) {	
		// Checking token and beare from each request
		if(!isset($request['HTTP_BEARER']) || !isset($request['HTTP_X_AUTH_TOKEN'])){
		// If No Token			
	 	header("HTTP/1.1 401");
	    header("Content-Type: text/plain");
	    echo "Access Denied";
	    die();
		}else{
		if($checkAdmin == true){
			if($request['HTTP_BEARER'] != 'admin')			{
				header("HTTP/1.1 401 Unauthorized");
			    header("Content-Type: text/plain");
			    echo "Access Denied";
			    die();
			}
		}	

		$bearer = $request['HTTP_BEARER'];
		$token = $request['HTTP_X_AUTH_TOKEN'];
		// Validate token against the PHP session
			if(!self::validate($token,$bearer)){
				header("HTTP/1.1 401 401 Unauthorized");
			    header("Content-Type: text/plain");
			    echo "Access Denied";
			    die();
			}else
			{
				// Respond true if all checks are ok
				return true;
			}
		}

	}
	public static function validate($token,$bearer) {
		// checink token via JWT
		if(self::get($bearer) != $token)
		{
			return false;
		}else
		{
			//decoding token
			$decoded =(array) JWT::decode($token, TOKEN_KEY, array('HS256'));
			$user = $decoded['user'];
			// checking session value of user
			$validation = self::get($user);
			if(!$validation) {
				return false;
			}elseif($validation != $token){
				return false;
			}
			else{
				//return true if the token matches with token stored in session after decode
				return true;
			}
		}

	}
}// end session class