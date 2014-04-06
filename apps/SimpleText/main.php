<?php

	/* * * * * * * * * * * * * * * * * * * * * * * * 
	 * Giovanni Rescigno - Clone Computers GPL 2.0 *
	 * * * * * * * * * * * * * * * * * * * * * * * * 
	 * this is the text editor back end it takes   *
	 * in the URL of what file you want to open and*
	 * then you can edit it 					   *
	 * * * * * * * * * * * * * * * * * * * * * * * */

	session_start();

	$fileString = '';
	$EchoString = file_get_contents("SimpleText.html");

	if(isset($_GET['Dir'])){
		$FileURL = '../../'.$_SESSION['Home'].'/'.$_GET['Dir'];
		$fileString = file_get_contents($FileURL);
	}

	$EchoString = str_replace('{File Contents}', $fileString, $EchoString);

	echo $EchoString;



?>