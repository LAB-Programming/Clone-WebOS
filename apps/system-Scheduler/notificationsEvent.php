<?php
	require_once 'systemEvent.php';
	require_once 'notifiable.php';

	/* * * * * * * * * * * * * * * * * * * * * * * * * * 
     * by Giovanni Rescigno - Clone Computers GPL 2.0  *
     * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Discription: this system event is used for the  *
	 * Clone notification system. there is not much    *
	 * diffrence betwen the deafalt system event and   *
	 * this one. 									   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * */

	class PublicNotificationEvent extends Event implements Notifiable{


		private $Rank;//holds the importance of the notifcation  
		private $textBody;

		function __construct($appName, $time, $methodName, $methodFile, $body){
			parent::__construct($methodName, $methodFile, $appName, $time);
			$this->textBody = $body;
		}
		/*
		* this method return the type of notifcation that it is
		* @return String 	the type of event
		*/
		public function getType(){
			return "PublicNotificationEvent";
		}
		/*
		* this method returns the rank on a scale form 1-10 
		* @return int      	rank
		*/
		public function getRank(){
			return $this->Rank;
		}
		/*
		* this method is used by the notication controler to set a rank 
		* the Public Notification
		* @peram int      the rank number
		*/
		public function setRank($newRank){
			$this->Rank = $newRank;
		}
		/*
		* this method is used by the notifaction interface to save this 
		* system event
		* @return   the string that has all fo the info to be saved
		*/
		public function getRecord(){
			if($this->getId() != "unset"){
				return "#".$this->getId().", ".$this->getType().", ".$this->getTriggerFunction().", ".
						$this->getTriggerFile().", ".$this->getApplicationName().", ".$this->getTime().", ".
						$this->getRank().", ".$this->getBody()."\n";
			}else return 0;
		}
		/*
		* this method returns the body text of the notifcation
		* @return 			body text of the notifcation
		*/
		public function getBody(){
			return $this->textBody;
		}

		/**
		* this method sets the text body
		* 
		* @peram String 	textbody
		*/
		public function setBody($textBody){
			$this->textBody = $textBody;
		}
	}

?>