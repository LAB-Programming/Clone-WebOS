<?php

	require_once '../Lib/fileSystem.php';
	session_start();

	$file_system_Handle = new fileSystemInterface();
	$finalURL = '';
	$fileName = '';
	$fileDirectory = '';

	function saveFile($URL, $content){
		$file_Handle = fopen($URL, "w+");
		fwrite($file_Handle, $content);
		fclose($file_Handle);
	}

	if($_POST['Dir'] != "false" && $_POST['Dir'] != ''){
		$fileDirectory = $file_system_Handle->getFileDirectory($_POST['Dir']);
		$fileName = $_POST['SAVE'];
		$finalURL = '../../'.$_SESSION['Home'].$fileDirectory.'/'.$fileName;
	}else{
		$fileDirectory = '../../'.$_SESSION['Home'];
		$fileName = $_POST['SAVE'];
		$finalURL = $fileDirectory.'/'.$fileName;
	}
	saveFile($finalURL, $_POST['Cont']);


?>