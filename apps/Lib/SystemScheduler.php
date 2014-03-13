<?php
	require_once '../system-Scheduler/systemEvent.php';
	require_once '../system-Scheduler/privateEvent.php';

   /* * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* By Giovanni Rescigno - Clone Computers   			  *
	* GPL 2.0 Free Software							      *
	* * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* Discrption:                                         *
	* the system Scduler is a central library that holds  *
	* "events" and puts a timer on them. these events are *
	* class           									  *
	* * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	class SystemScheduler{

		private $eventList = array();
		private $importerList = array();
		private $applicationName;
		private $eventFile = "../system-Scheduler/events.txt";

		function __construct($currentApplication){
			$this->applicationName = $currentApplication;
			$this->eventList = $this->getAllEvents();
			//var_dump($this->eventList);
		}
		/**
		* this function takes in a nothing and than return all of the 
		* system events in the events.txt as the corespoding type of 
		* event
		*/
		private function getAllEvents(){
			$handle = fopen($this->eventFile, "r");
			$fileString = fread($handle, filesize($this->eventFile));
			$rawEventdata = $this->parceFile($fileString);
			fclose($handle);
			return $this->toEventObj($rawEventdata);
		}
		/**
		* this function takes in the raw data from the events file
		* and then turns it in to an array that we can work with
		*/
		private function parceFile($fileString){
			$EventStringArray = explode("#", $fileString);
			$EventStringArray = array_slice($EventStringArray, 1, count($EventStringArray));
			$ReturnArray = array();
			foreach($EventStringArray as $EventString){
				$EventString = trim($EventString, "\n\r ");
				$EventArray = explode(", ", $EventString);
				$ReturnArray = array_merge($ReturnArray, array($EventArray));
			}
			return $ReturnArray;
		}
		/**
		* this function takes in the raw array of event data an then
		* turns it into the corisponding type of event baced on its 
		* event type and then returns an array of event objects
		*/
		private function toEventObj($eventArray){
			$EventObjectArray = array();

			foreach($eventArray as $event){
				switch($event[1]){//index 1 holds the type
					case 'defalt':
						$mergableObject = new Event($event[2], $event[3], $event[4], (int)$event[5]);
						$mergableObject->setId((int)$event[0]);
						$EventObjectArray = array_merge($EventObjectArray, array($mergableObject));
						break;
					case 'privateEvent':



						break;
				}
			}
			return $EventObjectArray;
		}
		/**
		* this function takes in an event object and then
		* saves it to the events text file
		*/
		public function addEvent($newEvent){

			$this->eventList = $this->getAllEvents();//refreshes the Event List
			$newEvent->setId(count($this->eventList)+1);
			$this->eventList = array_merge($this->eventList, array($newEvent));
			$this->saveCurrentEvents();

		}
		/**
		* this function save the current events in to the
		* event text file. 
		* @peram newEvent - this takes in the new event
		* so if the events file is locked than it can try
		* again
		*/
		private function saveCurrentEvents(){

			$EventfileString = '';
			foreach($this->eventList as $eventObj){
				$EventfileString = $EventfileString.$eventObj->getRecord();
			}

			$fileHandle = fopen($this->eventFile, "r+");

			if(flock($fileHandle, LOCK_EX)){//if a lock can be establihsed

				ftruncate($fileHandle, 0);//clears the file
				fwrite($fileHandle, $EventfileString);
				fflush($fileHandle);//flushes the file input
				flock($fileHandle, LOCK_UN); //unlocks the file
				fclose($fileHandle);

			}else{//if a lock can not be established it trys again

				fclose($fileHandle);
				$this->saveCurrentEvents();//yes i know that i am uesing recurtion dont freak out plz

			}
		}
		/**
		* this funciton takes nothing and returns all of 
		* the expired events as objects
		*/
		public function getEvents(){

			$this->eventList = $this->getAllEvents();
			$returnArray = array();

			foreach($this->eventList as $singleEvent){
				
				$singleEvent->ImportTriggerFile();
				
				if($singleEvent->hasExpired()){
					$returnArray = array_merge($returnArray, array($singleEvent));
				}
			}
			return $returnArray;
		}
		/**
		* this function takes in the user name and
		* returns the all the expired events with the
		* speified user
		*/		
		public function getEvent($user){
			$this->eventList = $this->getAllEvents();//refreches the list of events
			$returnArray = array();

			foreach($this->eventList as $singleEvent){

				$singleEvent->ImportTriggerFile();

				if($singleEvent->hasExpired() && ('private' == $singleEvent->getType())){
					$returnArray = array_merge($returnArray, array($singleEvent));
				}
			}
			return $returnArray;
		}
	}
?>