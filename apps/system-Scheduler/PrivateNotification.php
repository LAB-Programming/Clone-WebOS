<?php
	require_once 'privateEvent.php'; 
	require_once 'notifiable.php';

	/* * * * * * * * * * * * * * * * * * * * * *
	 * By Giovanni Rescigno	- GPL 2.0		   *
	 * * * * * * * * * * * * * * * * * * * * * *
	 * this class is a private notifcation     *										    
	 * insted of haveing a public notifcation  *
	 * which every one can see there is a      *
	 * priavet one which only one user can see *
	 * * * * * * * * * * * * * * * * * * * * * */

	class PrivateNotificationEvent extends privateEvent implements Notifiable{

		private $Rank;//holds the importance of the notifcation  
		private $textBody;

		function __construct($user, $appName, $time, $methodName, $methodFile, $body){
			parent::__construct($methodName, $methodFile, $appName, $time, $user);
			$this->textBody = $body;
		}

		/**
		* this method return the type of notifcation that it is
		* @return String 	the type of event
		*/
		public function getType(){
			return "PrivateNotificationEvent";
		}

		/**
		* this method returns the rank on a scale form 1-10 
		* @return int      	rank
		*/
		public function getRank(){
			return $this->Rank;
		}

		/**
		* this method is used by the notication controler to set a rank 
		* the Public Notification
		* @peram int      the rank number
		*/
		public function setRank($newRank){
			$this->Rank = $newRank;
		}

		/**
		* this method is gets the mesage body from the
		* event
		* @return String
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
			$this->text = $textBody;
		}

		public function getRecord(){
			if($this->getId() != "unset"){
				return "#".$this->getId().", ".$this->getType().", ".$this->getTriggerFunction().", ".
						$this->getTriggerFile().", ".$this->getApplicationName().", ".$this->getTime().
						", ".$this->getRank().", ".$this->getBody().", ".$this->getUser()."\n";
			}else return 0;
		}


	}
?>