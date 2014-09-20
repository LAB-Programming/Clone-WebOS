<?php

session_start();
$ViewerGUI = file_get_contents("imageViewer.html");

if(isset($_GET['Dir'])){
	$ViewerGUI = str_replace('<a href="../../apps/files/files.php">', "", $ViewerGUI);
	$ViewerGUI = str_replace('</a>', "", $ViewerGUI);
	echo str_replace("[imageURL]", '../../'.$_SESSION['Home'].'/'.$_GET['Dir'], $ViewerGUI);
}else{
	echo str_replace("[imageURL]", '../../images/noImageFound.png', $ViewerGUI);
}

?>