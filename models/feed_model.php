<?php 
/*
 * @desc - class to receive data from the devices
 * @param - deviceID , Sesor Count , lat , long, date stamp ,readings , status code , * end
 * @variables 
 * 				$args = receiving the post query
 * 				$r_string = recevied string in request for evaluation
 *  Version History:
 *  1.0 - Inititalizing the file to receive the request
 */
class feed_model extends Model{
	function __construct() {
		$this->connection = new MongoClient ();
		$this->db = $this->connection->smartfarm;
		$this->param = array(0 => "DEVICE" , 1=>"SENSOR COUNT" ,2=>"LAT",3=>"LONG",4=>"TIME STAMP");
	}

	public function getStatus(){
	if ($_SERVER['REQUEST_METHOD'] == "POST"){	
		$args =$_POST;
		
		if (empty($args["query"])) {												// IF no string received
			$msg  =		"204 No Content"; 
			return 		$msg;
			}
		else{	
			$r_string = explode(",", $args["query"]);
			$device = 	$r_string[0];									
			
			$collection = $this->db->device;
			$query = array("_id" => $device);
			
			// checking device
				if (empty($collection->findOne($query))) {
					$msg = "401 NOT AUTHORIZED - DEVICE NOT FOUND";
					return $msg;
					exit;
				}
				else{
					
					for($i=1;$i<=4;$i++){
						if (empty($r_string[$i])) {
							$msg = "401 NOT AUTHORIZED - ".$this->param[$i]." NOT FOUND";
							return $msg;
							exit;
						}
					}
					
					$s_count = (int)$r_string[1];
					echo count($r_string)."<br>";
					$data =array(
					"did"		=> $r_string[0],		
					"s_count"	=>(int)$r_string[1],
					"lat" 		=>$r_string[2],
					"long" 		=>$r_string[3],
					"dt"		=>strtotime($r_string[4])
							
					);
					for ($i =5;$i<count($r_string)-2;$i++ )
					{ 
						$key = substr($r_string[$i], 0,3);									// Breaking string for readings
						$value =substr($r_string[$i], 3,strlen($r_string[$i]));				// Breaking string for value
						$data[$key] = $value;
					}
					
				
					return $data;
					
					
				}// end of device checking IF
			}
	}
	else
	{
		$msg = "400 BAD REQUEST";
		return $msg;	
	}
	
	}// end of get status
	
	
	
	
}// end of class

?>