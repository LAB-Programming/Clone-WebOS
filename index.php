<?php header('Content-type: text/html; charset=utf-8'); ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="desktop.css">
	<link rel="stylesheet" href="themes/CloneTheme.min.css" />
	<link rel="stylesheet" href="jquery/jquery.mobile.structure-1.3.2.min.css" />
	<script src="jquery/jquery-1.9.1.min.js"></script>
	<script src="jquery/jquery.mobile-1.3.2.min.js"></script>

<?php
	
	class admin{
		//adduser Functions
		function createUser($userName, $password, $rank){
					
			$system_file_Path = "home/".$userName."/";
			$user_Password = hash("ripemd160", $password);

			$New_User_connect = mysqli_connect("localhost","root","clone","CloneOSdata");
			if (mysqli_connect_errno($New_User_connect)){
				echo "MYSQL Error";
			}
			$test = $New_User_connect->query("SELECT * FROM users");
			while ($test2 = $test->fetch_array(MYSQLI_USE_RESULT)){
				//echo var_dump($test2);
			}
			$new_user = "INSERT INTO users VALUES ('".$userName."', '".$user_Password."', '".$rank."', '".$system_file_Path."', '".$userName."')";
			$New_User_connect->query($new_user);
			mysqli_close($New_User_connect);

			$this->CreateFileSystem($userName);
			echo "created user files";

		}
		function CreateFileSystem($userName){
			chdir("/var/www/home");
			exec("mkdir ".$userName);
			exec("mkdir ".$userName."/documents/; mkdir ".$userName."/images/;");
		}

	}
	//User classes
	class User{

		function __construct($userName, $name, $password_hash){

			 $this->UserName = $userName;
			 $this->Name = $name;
			 $this->password_hash = $password_hash;
			 $this->Promitions = null; //and promition gose form [user] [admin]
			 $this->HomeFolder = null;

		}
		function set_user_rank($newRank){
			if ($newRank == 'user' || $newRank == 'admin'){
				$this->Promitions = $newRank;
			}
			else {return 1;}
		}
		function set_home_folder($newFolder){
			$this->HomeFolder = $newFolder;
		}
		function Create_Setion(){
			session_start();

			$_SESSION['UserName'] = $this->UserName;
			$_SESSION['Promitions'] = $this->Promitions;
			$_SESSION['Home'] = $this->HomeFolder;

		}
	}
	class Desktop{

		function __construct($UserObject){
			$this->List_Of_Apps_Array = $this->get_apps_data();
			$this->Desktop = file_get_contents("desktop.html");

			$this->Desktop = str_replace("<iconsGoHere>", $this->render_App_HTML($this->List_Of_Apps_Array), $this->Desktop);
			$this->Desktop = str_replace("<scriptGoseHere>", $this->render_App_JS($this->List_Of_Apps_Array), $this->Desktop);

			echo $this->Desktop;
		}
		function get_apps_data(){
			$appXML = new DOMDocument();
			$appXML->load("home/bin/apps.xml");
			/*//echo '<script>'.$appData->getElementsByTagName('apps')->length.'</script>';
			$appsArray = array();
			//echo '<script>console.log("get_app_data [works]")</scirpt>';
			//echo $appData->getElementsByTagName('apps')->length;
			foreach($appData as $apps){
				$appArray = array();
				foreach($apps as $all_app){
					$app_Name  = $all_app;*/

			$AppsDocEl = $appXML->documentElement;
			$appsArray = array();
			//error_log("----------------" . $AppsDocEl->childNodes->length);
			for ($i = 0; $i < $AppsDocEl->childNodes->length; $i++) { //loop the number of times there are app tags in apps
				$display_name = $AppsDocEl->getElementsByTagName("displayName")->item($i); //get the display name of the first app
				if (gettype($display_name) == "NULL") break;
				$app_Name = $AppsDocEl->getElementsByTagName("name")->item($i); //get the name of the first app
				$Location = $AppsDocEl->getElementsByTagName("url")->item($i); //get the location of the first app
				$Location_of_icon = $AppsDocEl->getElementsByTagName("icon")->item($i); //get the icon of the first app
				//error_log("=====================" . $i);
				$appArray = array("displayName" => $display_name->nodeValue, "name" => $app_Name->nodeValue, "location" => $Location->nodeValue, "icon" => $Location_of_icon->nodeValue); 
				$appsArray = array_merge($appsArray, array($appArray));
			}
			//error_log('Apps array = "' . print_r($appsArray, true) . '"');
			return $appsArray;
		}
		function render_App_HTML($appArrays){
			$app_icon_HTML = "";
			foreach ($appArrays as $appArray){
				$app_icon_HTML = $app_icon_HTML.'<div class="appIcon" id="'.$appArray["name"].'"><center><img src="home/bin/'.$appArray["icon"].'"
				></center><p>'.$appArray["displayName"].'</p></div>';
			}
			return $app_icon_HTML;
		}
		function render_App_JS($appArrays){
			$javascrpt_Loading_code = "";
			foreach($appArrays as $appArray){
				//$externalIp = "192.168.2.2";//file_get_contents('http://phihag.de/ip/');    HACK
				//$javascrpt_Loading_code = $javascrpt_Loading_code.'$( "#'.$appArray["name"].'" ).click(function(){ 
				//	window.location = "http://'.$_SERVER['SERVER_ADDR'].'/home/bin/'.$appArray["location"].'"; });';
				$javascrpt_Loading_code = $javascrpt_Loading_code.'$( "#'.$appArray["name"].'" ).click(function(){ 
					window.location = "home/bin/'.$appArray["location"].'"; });';
			}
			return $javascrpt_Loading_code;
		}
	}
	//Loder starts the system
	class Loader{

		function __construct(){

			$this->usersList = $this->LoadUsers();
			$this->LoginLissener();
		}
		function LoadUsers(){
			$this->usersList = array();
			$connection = mysqli_connect("localhost","root","clone","CloneOSdata");

			$userTableData = $connection->query("SELECT * FROM users");
			while($TableData = $userTableData->fetch_array(MYSQLI_USE_RESULT)){
				$this->User = new User($TableData['UserName'], $TableData['name'], $TableData['Password_hash']);
				$this->User->set_user_rank($TableData['Promitions']);
				$this->User->set_home_folder($TableData['HomeFolder']);

				$this->CloneusersList = array_merge($this->usersList, array($this->User->UserName => $this->User));

			}
			mysqli_close($connection);
			return $this->CloneusersList;
		}
		function LoginLissener(){
			//if the user cookie is set than it will atuicate the cookie (check if it is the databace) and than load the deskt top
			if (isset($this->usersList[$_COOKIE['UserName']]) && $this->usersList[$_COOKIE['UserName']]->password_hash == hash("ripemd160", $_COOKIE['password_hash'])){
				$this->usersList[$_COOKIE['UserName']]->Create_Setion();
				$Desktop_Object = new Desktop($this->usersList[$_COOKIE['UserName']]);
			}
			elseif (isset($_POST['UserName'])){//if the cookie is not set than 
  				if (isset($this->usersList[$_POST['UserName']]) && $this->usersList[$_POST['UserName']]->password_hash == hash("ripemd160", $_POST['password'])){
  					setcookie("UserName", $_POST['UserName']);
  					setcookie("password_hash", $_POST['password']);

  					$this->usersList[$_COOKIE['UserName']]->Create_Setion();
  					$Desktop_Object = new Desktop($this->usersList[$_COOKIE['UserName']]);
  				}
  			}
  			else{echo "403 <br> You are probably not logged in.  <a href=\"login.html\">Login</a>";}
  			unset($_COOKIE['UserName']);	
		}
	}
//$admin = new admin();
//$admin->createUser("admin", "clone", "admin");

$Loader = new Loader();

?>
</body>
</html>

