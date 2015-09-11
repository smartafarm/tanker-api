<?php
class login_model extends Model {
	function __construct() {
		parent::__construct ();
	} // end of construct
	
	public function check($login, $password) {
		$this->connection = new MongoClient ();
		$this->db = $this->connection->smartfarm;
		$collection = $this->db->users1;
		$authenticate = array (
				"name" => $login,
				"password" => $password 
		);
		
		$result = $collection->count ( $authenticate );
	
		if ($result == 1) {
			Session::init();
			Session::set('loggedIn', true);
			Session::set('user',$login);
			header('location: ../dashboard');
		} else
		{
			Session::destroy();
			header('Location:../login');
			exit;
		}
	} // end of check
}
