<?
class User{

	private $userName;
	private $PasswordHash;
	private $homeFolder;
	private $Promitions;

	function __construct($NewUserName, $NewPasswordHash, $NewPromitions){
		$this->userName = $NewUserName;//sets all of the instance varuables
		$this->PasswordHash = $NewPasswordHash;
		$this->homeFolder = "home/".$this->userName."/";
		$this->Promitions = $NewPromitions;
	}
	function createPublicSession(){ //this function creates _SESSION vauables for public use you do this to set the active user
		$_SESSION['UserName'] = $this->userName;
		$_SESSION['Promitions'] = $this->Promitions;
		$_SESSION['Home'] = $this->homeFolder;
		$_SESSION['pass'] = $this->PasswordHash;
		error_log("you are loging in!!!!".$_SESSION['UserName']);
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
class application{

	private $appName;
	private $appLocation;
	private $iconLocation;


	function __construct($name, $location, $icon="NULL"){
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
		return '<a href="apps/'.$this->appLocation.'"><div class="appIcon"><center><img src="
		'.$this->iconLocation.'"></center><p>'.$this->appName.'</p></div></a>';
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