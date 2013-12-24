<?
class LoginManger{

	function islogedin($arrayUsers){
	
		foreach($arrayUsers as $maybeUser){
			error_log($maybeUser->getUserName());
			return ($_SESSION['UserName'] == $maybeUser->getUserName());	
		}
		return true;
		
	}
	function openLogin(){
		echo file_get_contents("login.html");
	}
	function loginNewUser($Userlist){
		foreach($Userlist as $UserInstnce){
			if ($_POST['UserName'] == $UserInstnce->getUserName() && hash('ripemd160', $_POST['password']) == $UserInstnce->getPassHash()){
				$UserInstnce->createPublicSession();
				echo "<html><body><script>location.reload();</script></body></html>";
			}
		}
	}
}
/*class dataBaseMan{

	private $DataBaseName;
	private $DBcurser;

	function __construct($dataBaseName){
		$this->DataBaseName = $dataBaseName;
		$this->DBcurser = mysql_connect("root",)
	}
	function isDbExist(){
		
	}
}*/
?>