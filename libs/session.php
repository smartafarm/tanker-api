<?php
/*
 * @desc - Session Library
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Basic session creating functions
 *
 */
class session {
	public static function init()
	{
		@session_start();
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
}// end session class