<?
class LoginManger{

	function islogedin($arrayUsers){
	
		foreach($arrayUsers as $maybeUser){
			return ($_SESSION['UserName'] == $maybeUser->getUserName());	
		}
		return true;
		
	}
	function openLogin(){
		echo file_get_contents("login.html");
	}
	function loginNewUser($Userlist){
		foreach($Userlist as $UserInstnce){
			error_log($UserInstnce->getUserName()." && ".$_POST['UserName']);
			if ($_POST['UserName'] == $UserInstnce->getUserName() && hash('ripemd160', $_POST['password']) == $UserInstnce->getPassHash()){
				$UserInstnce->createPublicSession();
				echo "<html><body><script>location.reload();</script></body></html>";
			}
		}
	}
}
?>