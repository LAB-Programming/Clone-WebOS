<?php

	require_once '../Lib/fileSystem.php';
	session_start();

	$file_system_Handle = new fileSystemInterface();
	$finalURL = '';
	$fileName = '';
	$fileDirectory = '';

	//error_log("the File ".$_POST['SAVE']);
	//error_log("the path ".$_POST['Dir']);
	function saveFile($URL, $content){
		$file_Handle = fopen($URL, "w+");
		fwrite($file_Handle, $content);
		fclose($file_Handle);

	}

	if($_POST['Dir'] != false){
		$fileDirectory = $file_system_Handle->getFileDirectory($_POST['Dir']);
		//error_log("shell dir: ".$fileDirectory);
		$fileName = $_POST['SAVE'];
		$finalURL = '../../'.$_SESSION['Home'].$fileDirectory.'/'.$fileName;
	}else{
		$fileDirectory = '../../'.$_SESSION['Home'];
		$fileName = $_POST['SAVE'];
		$finalURL = $fileDirectory.'/'.$fileName;
	}
	//error_log("the file URL: ".$finalURL);
	saveFile($finalURL, $_POST['Cont']);


?>