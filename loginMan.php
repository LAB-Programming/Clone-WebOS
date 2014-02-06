<?php
class LoginManger{

	function islogedin($arrayUsers){
	
		foreach($arrayUsers as $maybeUser){
			if (isset($_SESSION['UserName']) && $_SESSION['UserName'] == $maybeUser->getUserName()){
				return true;
			}	
		}
		return false;
		
	}
	function openLogin(){
		echo file_get_contents("login.html");
	}
	function loginNewUser($Userlist){
		foreach($Userlist as $UserInstnce){
			error_log($UserInstnce->getUserName()." && ".$_POST['UserName']);
			if ($_POST['UserName'] == $UserInstnce->getUserName() && password_verify($_POST['password'], $UserInstnce->getPassHash())) {
				$UserInstnce->createPublicSession();
				error_log("loged in as: ".$_SESSION['UserName']);
				echo "<html><body><script>location.reload();</script></body></html>";
			}
		}
	}
}
?>