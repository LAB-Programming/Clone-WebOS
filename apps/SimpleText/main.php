<?php
		
	require_once '../Lib/fileSystem.php';

	/* * * * * * * * * * * * * * * * * * * * * * * * * 
	 * Giovanni Rescigno - Clone Computers GPL 2.0   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * this is the text editor back end it takes     *
	 * in the URL of what file you want to open and  *
	 * then you can edit it. this script simply loads*
	 * the file in to the editor 					 *
	 * * * * * * * * * * * * * * * * * * * * * * * * */

	session_start();//alows me to use session varuables

	$fileString = '';//this holds all of the content
	$EchoString = file_get_contents("SimpleText.html");//this holds all the html
	$FileURL = '';//inial value of the files URL
	$directoryName = 'Untitled.txt';
	$filePath = '../../'.$_SESSION['Home'];
	$file_System_Handle = new fileSystemInterface();

	function saveFile($URL){
		$fileHandle = fopen($URL, "w+");

	}


	if(isset($_GET['Dir'])){

		$FileURL = '../../'.$_SESSION['Home'].'/'.$_GET['Dir'];//gets the directory of the file
		$fileString = file_get_contents($FileURL);
		$directoryName = $file_System_Handle->getFileName($FileURL);
		$filePath = $file_System_Handle->getFileDirectory($FileURL);
	}

	$EchoString = str_replace('{File Contents}', $fileString, $EchoString);
	$EchoString = str_replace('{fileName}', $directoryName, $EchoString);


	echo $EchoString;
?>