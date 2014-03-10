<?php
/* * * * * * * * * * * * * * * * * * * * * *
 * By Giovanni Rescigno - Clone Computers  *
 * GPL 2.0 Free software 				   * 
 * * * * * * * * * * * * * * * * * * * * * * 
 * Discription: Event   				   *
 * this class is a basic event Object	   *
 * there are other types of events with    *
 * sperlised funtions for diffrent perups  * 
 * * * * * * * * * * * * * * * * * * * * * */

class Event{

	private $triggerFunction; 
	private $triggerFile; 
	private $applicantionName;
	private $timeExpire;//tells you when he event should go off
	private $EventId = 'unset';//this is the defalt id value



	function __construct($PHPtrigerFunction, $PHPtriggerFile, $appName, $time){
		$this->triggerFunction = $PHPtrigerFunction; //must be a string
		$this->triggerFile = $PHPtriggerFile;
		$this->applicantionName = $appName;
		$this->timeExpire = $time;
	}
	/**
	* this function gets the type of event this is 
	* being that this is the defalt event it is called
	* defalt
	*/
	public function getType(){
		return 'defalt';
	}
	/**
	* returns the name of the application that 
	* created this event
	*/
	public function getApplicationName(){
		return $this->applicantionName;
	}
	/**
	* this function reutrns the full write able Record
	* in as an array for the main system Scheduler. so that 
	* this event can be loged in events.txt.
	*/
	public function getRecord(){

		if(!($this->EventId == 'unset')){

			return "#".$this->EventId.", ".$this->getType().", ".$this->triggerFunction.", ".
				$this->triggerFile.", ".$this->applicantionName.", ".$this->timeExpire."\n";

		} else return 0;
	}
	/**
	* this function runs the trigger function that was
	* spesfied in the constructor. note that the trigger 
	* file must be included in order for this to work 
	* if it is not it wont work.
	*/
	public function runTriger(){
		$this->triggerFunction();
	}
	/**
	* this function sets the id to a value spified this function
	* is normaly called via the system secular so that it may 
	* keep track of this event
	*/
	public function setId($idVal){
		$this->EventId = $idVal;
	}
	/**
	* this function returns the trigger file so that the system seceduler
	* can see it and than import it
	*/
	public function getTriggerFile(){
		return $this->triggerFile;
	}
}

?>