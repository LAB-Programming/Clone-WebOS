<?php

	require_once 'systemEvent.php';

	class privateEvent extends Event implements runable{
		
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
		/**
		* this event returns the type of event this is 
		* in this case it is a priavte event
		*/
		public function getType(){
			return 'private';
		}
		/**
		* this method returns the record that will be saved in the events text file
		* it is like the defalt events Recored expet it saves the user that has spawned
		* it
		*/
		public function getRecord(){

			if(!($this->getId() == 'unset')){

				return "#".$this->getId().", ".$this->getType().", ".$this->getTriggerFunction().", ".
					$this->getTriggerFile().", ".$this->getApplicationName().", ".$this->getTime().", ".$this->getUser()."\n";

			} else return 0;
		}
		public function hasExpired(){
			return (parent::hasExpired() && $this->getUser() == $_SESSION['UserName']);
		}
	} 
?>