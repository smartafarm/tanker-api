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
	public static function validate($token,$bearer) {
		if(self::get($bearer) != $token)
		{
			return false;
		}else
		{
			$decoded =(array) JWT::decode($token, TOKEN_KEY, array('HS256'));
			$user = $decoded['user'];
			$validation = self::get($user);
			if(!$validation) {
				return false;
			}elseif($validation != $token){
				return false;
			}
			else{
				return true;
			}
		}

	}
}// end session class