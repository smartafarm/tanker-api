<?php
/*
 * @desc - Database Library
 * @author - Vandish Gandhi
 * @Version Control:
 * 1.0 - Initialized the controller to get readings and respond to the data poll.
 * 1.1 - Created database connection if does not exist and passing existing connection if it exists
 *
 */
class database {
	
	protected static $database;
	public static function get(){
	// checking if instance exist
	if (isset(self::$database)) {
            return self::$database;
        }else {
        	// setting options to auto connect
        	$options = array('connect' => false); // 
        	$connection = new MongoClient('mongodb://52.62.42.42:27017',$options);       	
        	// selecting the project database
        	self::$database = $connection->smartanker;
        	return self::$database;
        }
     
	}
		
	}// end of constructor

	