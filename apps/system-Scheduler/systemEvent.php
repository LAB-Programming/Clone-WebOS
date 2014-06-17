<?php

/* * * * * * * * * * * * * * * * * * * * * * *
 *	By giovanni Rescigno - Clone Computers   *								 
 *	GPL 2.0 Free software				     *					
 * * * * * * * * * * * * * * * * * * * * * * *
 * Disciption: runable 						 *
 * runable is an interface that requiers a   *
 * single funciton that runs a sciprt when   *
 * the events time is up                     *
 * * * * * * * * * * * * * * * * * * * * * * */

interface runable{
	//returns what the scirpt returns
	public function runScript();//a methoed that returns something when the time has expired
	public function ImportTriggerFile();//imports the file that the trigger function is located
	public function getRecord();//gets a recored of event so i can be stored in a text file
	public function hasExpired();//checks if the event has expired
	public function getApplicationName();//gets the name of the applicaion that has spawned the event
	public function getType();//gets the type of the Event
	public function setId($idVal);//changes the id
	public function getId();//gets he id
	
}

/* * * * * * * * * * * * * * * * * * * * * *
 * By Giovanni Rescigno - Clone Computers  *
 * GPL 2.0 Free software 				   * 
 * * * * * * * * * * * * * * * * * * * * * * 
 * Discription: Event   				   *
 * this class is a basic event Object	   *
 * there are other types of events with    *
 * sperlised funtions for diffrent perups  * 
 * * * * * * * * * * * * * * * * * * * * * */

class Event implements runable{

	private $triggerFunction; 
	private $triggerFile; 
	private $applicantionName;
	private $timeExpire;//tells you when he event should go off
	private $EventId = 'unset';//this is the defalt id value
	private $hasImported = false;



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
	public function runScript(){
		if($this->hasImported){//checks to see if the trigger file is imported
			return call_user_func($this->triggerFunction);
		}else return false;//other wise returns false
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
	* this method returs the id of this event 
	* so that the event knows who it is 
	*/
	public function getId(){
		return $this->EventId;
	}
	/**
	* this function returns nothing nor takes any thing it simply
	* imports the 
	*/
	public function ImportTriggerFile(){
		$this->hasImported = true;
		require_once $this->triggerFile;
	}
	/**
	* this method returns the trigger file url so that i can be
	* imported and recored
	*/
	public function getTriggerFile(){
		return $this->triggerFile;
	}
	/**
	* this function returns the name of the trigger function
	* returns a string
	*/
	public function getTriggerFunction(){
		return $this->triggerFunction;
	}
	/**
	* this funciton reutnrs true if this event has expired 
	* and false if it has not yet expired
	*/
	public function hasExpired(){
		if($this->hasImported){
			return ($this->getTime() <= time());
		}else return false;
	}
	/**
	* this method returns the time at which the event will 
	* expire. 
	*/
	public function getTime(){
		return $this->timeExpire;
	}
}

?>