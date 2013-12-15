<?php

include 'loginMan.php';
include 'dataStructs.php';
include 'cloneMarkUp.php';
session_start();

class systemLoader{

	private $userList = array();
	private $appList = array();
	private $noficationList = array();


	function __construct(){
		$this->userList = $this->loadUsers();
		$this->loadApps();

		$login = new LoginManger();
		if($login->islogedin($this->userList)){
			//echo "<html><body>hello world</body></html>";
			echo file_get_contents("desktop.html");
		}else if(isset($_POST['UserName'])){
			$login->loginNewUser($this->userList);
		}else{
			$login->openLogin();
		}
	}
	/**
	* this function loads all of the users form a mysql data bace it dose not do this yet; 
	* this is very much under constrution
	 */
	function loadUsers(){
		return array(new User("Gio", hash('ripemd160', "pies"), "admin"), new User("bob", hash('ripemd160', "12345"), "user"));
	}	
	/**
	* this function opens the apps text file than turns it into a list of objcets so that the
	* we can see all of the apps and then do suff with them
	*/
	function loadApps(){
	
		$appHandler = new MarkUpFile("apps/applist.txt");
		$appArrayRaw = $appHandler->Read();
		foreach($appArrayRaw as $singalElement){
			$this->appList = array_merge($this->appList, array(new application($singalElement[1], $singalElement[3], $singalElement[2])));
		}
		$appHandler->Close();
	}
	function renderDesktop(){
		$desktopString = file_get_contents('desktop.html');
	}
}
$start = new systemLoader();


?>