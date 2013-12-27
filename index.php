<?php

include 'loginMan.php';
include 'dataStructs.php';
include 'cloneMarkUp.php';
include 'mainUser.php';
session_start();

class systemLoader{

	private $userList = array();
	private $appList = array();
	private $settingsList = array();

	function __construct(){
		$userInfo = new UsersInfo("users.txt");

		$this->userList = $userInfo->getAllUsers();
		$this->loadApps();
		$this->loadSettings();

		$login = new LoginManger();
		if(isset($_GET['Logout'])){
			session_destroy();
			$login->openLogin();
		}else if($login->islogedin($this->userList) && $userInfo->isUsers()){
			$this->renderDesktop();
		}else if(isset($_POST['UserName']) && $userInfo->isUsers()){
			$login->loginNewUser($this->userList);
		}else if($userInfo->isUsers()){
			$login->openLogin();
		}else{
			echo '<html><body><script>window.location.href = "apps/users/users.php";</script></body></html>';
		}
	}
	/**
	* this function opens the apps text file than turns it into a list of objcets so that the
	* we can see all of the apps and then do suff with them
	*/
	function loadApps(){
	
		$appHandler = new MarkUpFile("apps/applist.txt");
		$appArrayRaw = $appHandler->Read();
		foreach($appArrayRaw as $singalElement){
			$this->appList = array_merge($this->appList, array(
				new application("app", $singalElement[1], $singalElement[3], $singalElement[2])
				));
		}
		$appHandler->Close();
	}
	/**
	*this function loads all of the settngs and turns them in to a list of objects
	*/
	function loadSettings(){
		$settinsHandler = new MarkUpFile("apps/settings.txt");
		$settingsArray = $settinsHandler->Read();
		foreach ($settingsArray as $settingElement){
			$this->settingsList = array_merge($this->settingsList, array(
				new application("set", $settingElement[1], $settingElement[3], $settingElement[2])
				));
		}
	}
	function renderDesktop(){
		$appString = '';
		foreach($this->appList as $instance){
			$appString = $appString.$instance->renderAppString();
		}
		$settingString = '';
		foreach($this->settingsList as $setInstance){
			$settingString = $settingString.$setInstance->renderAppString();
		}
		$desktopString = file_get_contents('desktop.html');
		$desktopString = str_replace("[%Apps%]", $appString, $desktopString);
		$desktopString = str_replace("[%Set%]", $settingString, $desktopString);
		echo $desktopString;
	}
}
$start = new systemLoader();


?>desktopString = str_replace("[%Apps%]", $appString, $desktopString);
		$desktopString = str_replace("[%Set%]", $settingString, $desktopString);
		echo $desktopString;
	}
}
$start = new systemLoader();


?>