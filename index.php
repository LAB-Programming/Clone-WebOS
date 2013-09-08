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
		function find_Load_page(){
			if (isset($_GET["app"])){
				echo "404";
			}
			else{
				$this->Load_Desktop();
			} 
		}
		function Load_Desktop(){
			$this->Desktop = file_get_contents("desktop.html");
			echo $this->Desktop;
		}
	}
	class Loader{

		function __construct(){

			$this->usersList = array();
			$connection = mysqli_connect("localhost","root","pies","CloneOSdata");

			$userTableData = $connection->query("SELECT * FROM users");
			while($TableData = $userTableData->fetch_array(MYSQLI_USE_RESULT)){
				$this->User = new User($TableData['UserName'], $TableData['name'], $TableData['Password_hash']);
				$this->User->set_user_rank($TableData['Promitions']);
				$this->User->set_home_folder($TableData['HomeFolder']);

				$this->usersList = array_merge($this->usersList, array($this->User->UserName => $this->User));

			}
			mysqli_close($connection);
			$this->LoginLissener();
		}
		function LoginLissener(){
			if (isset($this->usersList[$_COOKIE['UserName']]) && $this->usersList[$_COOKIE['UserName']]->password_hash == hash("ripemd160", $_COOKIE['password_hash'])){
				echo "your are loged in :)";
				$this->usersList[$_COOKIE['UserName']]->find_Load_page();
			}
			
			elseif (isset($_POST['UserName'])){
  				if (isset($this->usersList[$_POST['UserName']]) && $this->usersList[$_POST['UserName']]->password_hash == hash("ripemd160", $_POST['password'])){
  					echo "welcome ".$_POST['UserName'];
  					setcookie("UserName", $_POST['UserName']);
  					setcookie("password_hash", $_POST['password']);
  					echo "cookie: ".$_COOKIE['UserName']." is set";
  					$this->usersList[$_COOKIE['UserName']]->$find_Load_page();
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

