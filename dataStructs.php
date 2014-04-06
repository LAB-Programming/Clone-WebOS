<?php
class User{

	private $userName;
	private $PasswordHash;
	private $homeFolder;
	private $Promitions;

	function __construct($NewUserName, $NewPasswordHash, $NewPromitions){
		$this->userName = $NewUserName;//sets all of the instance varuables
		$this->PasswordHash = $NewPasswordHash;
		$this->homeFolder = "home/".$this->userName;
		$this->Promitions = $NewPromitions;
	}
	function createPublicSession(){ //this function creates _SESSION vauables for public use you do this to set the active user
		$_SESSION['UserName'] = $this->userName;
		$_SESSION['Promitions'] = $this->Promitions;
		$_SESSION['Home'] = $this->homeFolder;
		$_SESSION['pass'] = $this->PasswordHash;
	}
	function setGroup($newPromitions){
		$this->Promitions = $newPromitions;
		$this->saveChanges(); //saves the new promitions
	}
	function saveChanges(){
		//i need to finnish this at some point
		return 0;
	}
	function getUserName(){
		return $this->userName;
	}
	function getPassHash(){
		return $this->PasswordHash;
	}
	function gethomeFolder(){
		return $this->homeFolder;
	}
	function getPromitions(){
		return $this->Promitions;
	}
}
/*
* this is class used to stor all of the exautables on the OS includeing apps, and settings
*/
class application{

	private $appName;
	private $appLocation;
	private $iconLocation;
	private $type; //this is "app" or "set"


	function __construct($type, $name, $location, $icon="NULL"){
		$this->type = $type;
		$this->appName = $name;
		$this->appLocation = $location;
		$this->iconLocation = $this->findicon($icon);
	}
	private function findicon($iconLocation){
		if ($iconLocation == "NULL"){
			return "images/clone_icon.png";
		} else {
			return $iconLocation;
		}
	}
	function renderAppString(){
		if ($this->type == "app"){
			return '<a href="apps/'.$this->appLocation.'"><div class="appIcon"><center><img src="
			'.$this->iconLocation.'"></center><p>'.$this->appName.'</p></div></a>';
		}else if($this->type == "set"){
			return '<a href="'.$this->appLocation.'"><div class="appIcon2"><center><img src="
			'.$this->iconLocation.'"></center><p>'.$this->appName.'</p></div></a>';
		}
	}
	function getAppName(){
		return $this->appName;
	}
	function getAppLocal(){
		return $this->appLocation;
	}
	function getIconLocal(){
		return $this->iconLocation;
	}
}
?>