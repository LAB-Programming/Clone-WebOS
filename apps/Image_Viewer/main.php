<?php

session_start();
$ViewerGUI = file_get_contents("imageViewer.html");

if(isset($_GET['Dir'])){
	echo str_replace("[imageURL]", '../../'.$_SESSION['Home'].'/'.$_GET['Dir'], $ViewerGUI);
}else{
 echo $ViewerGUI;
}

?>