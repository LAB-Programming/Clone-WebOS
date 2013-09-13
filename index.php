<html>
<head>
	<title>CloneOS</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="themes/CloneTheme.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>
<body>

<?php
	
	class admin{
		//adduser Functions
		function createUser($userName, $password, $rank){
					
			$system_file_Path = "home/".$userName."/";
			$user_Password = hash("ripemd160", $password);

			$New_User_connect = mysqli_connect("localhost","root","pies","CloneOSdata");
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
			exec("mkdir ".$userName."/files/; mkdir ".$userName."/config/;");

			//$apps_File = fopen($userName."/config/apps.txt/", "w");
			//fclose($apps_File);
			//copy("bin/defalt-apps.txt", $userName."/config/apps.txt/");
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
			$appData = new DOMDocument();
			$appData->load("home/bin/apps.xml");
			$all_apps = $appData->getElementsByTagName("apps");
			$appsArray = array();

			foreach ($all_apps as $app){
				$app_Names = $app->getElementsByTagName("name");
				$app_Name = $app_Names->item(0)->nodeValue;

				$Locations = $app->getElementsByTagName("url");
				$Location = $Locations->item(0)->nodeValue;

				$Location_of_icons = $app->getElementsByTagName("icon");
				$Location_of_icon = $Location_of_icons->item(0)->nodeValue;

				$appArray = array("name" => $app_Name, "location" => $Location, "icon" => $Location_of_icon); 
				$appsArray = array_merge($appsArray, array($appArray));
			}
			return $appsArray;
		}
		function render_App_HTML($appArrays){
			$app_icon_HTML = "";
			foreach ($appArrays as $appArray){
				$app_icon_HTML = $app_icon_HTML.'<div class="appIcon" id="'.$appArray["name"].'"><center><img src="home/bin/'.$appArray["icon"].'"
				></center><p>'.$appArray["name"].'</p></div>';
			}
			return $app_icon_HTML;
		}
		function render_App_JS($appArrays){
			$javascrpt_Loading_code = "";
			foreach($appArrays as $appArray){
				$javascrpt_Loading_code = $javascrpt_Loading_code.'$( "#'.$appArray["name"].'" ).click(function(){ 
					window.location = "http://'.$_SERVER['SERVER_ADDR'].'/home/bin/'.$appArray["location"].'"; });';
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
			$connection = mysqli_connect("localhost","root","pies","CloneOSdata");

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
				$Desktop_Object = new Desktop($this->usersList[$_COOKIE['UserName']]);
			}
			elseif (isset($_POST['UserName'])){//if the cookie is not set than 
  				if (isset($this->usersList[$_POST['UserName']]) && $this->usersList[$_POST['UserName']]->password_hash == hash("ripemd160", $_POST['password'])){
  					setcookie("UserName", $_POST['UserName']);
  					setcookie("password_hash", $_POST['password']);

  					$Desktop_Object = new Desktop($this->usersList[$_COOKIE['UserName']]);
  				}
  			}
  			else{echo "403";}
  			unset($_COOKIE['UserName']);	
		}
	}
//$admin = new admin();
//$admin->createUser("admin", "clone", "admin");

$Loader = new Loader();

?>
</body>
</html>

