<?php
/*
 * @desc - Login model
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Authenticates the login and creates session
 *
 */
class login_model extends Model {
	function __construct(database $database) {
		if(Session::get('loggedIn') ==true){
			header('location: dashboard');
		}
		parent::__construct();
	} // end of construct
	
	public function check($login, $password) {
		
		$collection = $this->db->users1;
		$authenticate = array (
				"name" => $login,
				"password" => $password 
		);
		
		$result = $collection->count ( $authenticate );
	
		if ($result == 1) {
			
			// setting appropriate sessions and tokens for users
			
			Session::set('loggedIn', true);
			Session::set('user',$login);
			header('location: ../dashboard');
		} 
		else
		{
			Session::destroy();
			header('Location:../login');
			exit;
		}
	} // end of check
}
