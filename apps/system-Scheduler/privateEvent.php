<?php

	require_once 'systemEvent.php';

	class privateEvent extends Event{
		
		private $userName;

		function __construct($PHPtrigerFunction, $PHPtriggerFile, $appName, $time, $currentUser){
			//call the parent constructer
			 parent::__construct($PHPtrigerFunction, $PHPtriggerFile, $appName, $time);
			 $this->userName = $currentUser;
		}
		/**
		* this function returns the user that created this event
		*/
		public function getUser(){
			return $this->userName;
		}
		public function getType(){
			return 'private';
		}
	} 
?>