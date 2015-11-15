<?php

class update_model extends Model{
	function __construct(database $database) {
		// getting the base properties for the parent model
		parent::__construct();

	}


	function deviceStatus($data) {
		$collection = $this->db->DeviceMaster;
		$collection->update(
		    array('_id' => $data['serverData']['_id']),
		    array(
		        '$set' => array("status" => $data['serverData']['status']),
		    ),
		    array("upsert" => false)
		);
		$response = $this->db->lastError();
		header('Content-Type: application/json');
		echo json_encode( $response['ok'], JSON_PRETTY_PRINT);
	}

		function fname($data) {
		$collection = $this->db->DeviceMaster;
		$collection->update(
		    array('_id' => $data['serverData']['_id']),
		    array(
		        '$set' => array("EquipName" => $data['serverData']['newname']),
		    ),
		    array("upsert" => false)
		);
		$response = $this->db->lastError();
		header('Content-Type: application/json');
		echo json_encode( $response['ok'], JSON_PRETTY_PRINT);
	}

	
}	
