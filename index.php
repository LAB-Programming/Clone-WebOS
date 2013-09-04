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

		function createUser($userName, $password, $rank='user'){
			$User = new User($userName, $userName, $password);
			$User->set_user_rank($rank);
		}

	}

	class User{

		function __construct($userName, $name, $password_hash){

			 $this->UserName = $userName;
			 $this->Name = $name;
			 $this->password_hash = $password_hash;
			 $this->Promitions = null; //and promition gose form [user] [sudoer] [admin]
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
			$this->LoginLissener();
		}
		function LoginLissener(){
			if (isset($_POST['UserName'])){
  				if (isset($this->usersList[$_POST['UserName']]) and $this->usersList[$_POST['UserName']]->password_hash == hash("ripemd160", $_POST['password'])){
  					echo "welcome ".$_POST['UserName'];
  				}
  				else {
  					echo hash("ripemd160" ,$_POST['password']);
  				}
  			}	
		}
	}

$Loader = new Loader();
?>
</body>
</html>

