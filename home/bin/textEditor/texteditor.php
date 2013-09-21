<?php

	$fileLoc="";
	$contents="";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		switch ($_POST["action"]) {
			case "save":
				$fileLoc = htmlspecialchars_decode($_POST["fileloc"]);
				$contents = $_POST["textarea"];
				if (!save(false)) {
					exit("Save Failed!"); //Look for a better way to notify user
				}
				error_log("case save");
				break;
			case "saveas":
				$contents = $_POST["textarea"];
				if (!save(true)) {
					exit("Save As Failed!"); //better way?
				}
				error_log("case saveas");
				break;
			case "open":
				if (!open()) {
					error_log("open failed");
					$contents = $_POST["textarea"]; //notify user in some way
				}
				break;
			case "":
				$contents = $_POST["testarea"];
				$fileLoc = htmlspecialchars_decode($_POST["fileloc"]);
				error_log("got empty string for action");
				break;
			default:
				exit("Error unexpected value for action: '" . $_POST["action"] . "");
				break;
		}
	}
	
	$html = file_get_contents("texteditorhtml.txt");
	echo str_replace(array("<<SERVER>>", "<<FILE_LOC>>", "<<CONTENT>>"), array($_SERVER["PHP_SELF"], htmlspecialchars($fileLoc), $contents), $html);
	
	

	function pickFileToOpen() {
		//Gio needs to finish this
		return "test.txt";
	}

	function pickLocationToSave() {
		//Gio needs to finish this
		return "test.txt";
	}

	function save($saveAs) {
		global $fileLoc, $contents;
		if ($saveAs || strlen($fileLoc) == 0) {
			$theFileLoc = pickLocationToSave();
			if (file_exists($theFileLoc) && true/*Placeholder for user input on overwrite*/) {
				return false;
			}
		} else {
			$theFileLoc = $fileLoc;
		}
		if (!(is_writable($theFileLoc) && is_file($theFileLoc))) {
			error_log("Save (as) Failed, theFileLoc=$theFileLoc is_writable=" . is_writable($theFileLoc) . " is_file=" . is_file($theFileLoc));
			return false;
		}
		$saveFile = fopen($theFileLoc, "w");
		fwrite($saveFile, htmlspecialchars_decode($contents));
		$fileLoc = $theFileLoc;
		fclose($saveFile);
		return true;
	}

	function open() {
		global $contents, $fileLoc;
		$openFileLoc = pickFileToOpen();
		if (!(file_exists($openFileLoc) && is_readable($openFileLoc) && is_file($openFileLoc))) {
			return false;
		}
		$fileContents = file_get_contents($openFileLoc);
		$contents = htmlspecialchars($fileContents);
		$fileLoc = $openFileLoc;
		return true;
	}

?>
