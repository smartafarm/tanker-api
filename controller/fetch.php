<?php
class fetch extends controller{
	function __construct() {
				
	}
	
	public function getDevices(){
		/*
		 * get the devices and readings of the deivces
		 * responds array of Json
		 */
		$this->model->getDevices();
	}

	public function getUpdate(){
		// Triggers a notification if new reading has been added.
		// responds JSON data of reading to ajax poll.
		$this->model->getUpdate();
	}
}