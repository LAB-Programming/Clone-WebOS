<?
include '../../dataStructs.php';
include '../../cloneMarkUp.php';
include '../../mainUser.php';

if(isset($_POST['userName'])){
	$newUser = new UsersInfo("../../users.txt");
	$newUser->createNewUser($_POST['userName'], $_POST['password1'], "admin");
	echo '<html><body><script>window.location.href = "../../index.php";</script></body></html>';
}else{
	echo file_get_contents("startPage.html");
}

?>