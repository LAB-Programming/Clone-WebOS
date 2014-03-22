<?php
/*
Clone Files: Giovanni Rescigno 2013
V: 0.2

DISCRIPTION:
Clone files is the file browser for clone web os (much like finder on a mac) but is actrly a web site
you can veiw files in your user folder or files that have been shared with you form other users on your
system
*/

include 'file.php';
include '../../cloneMarkUp.php';
include '../Lib/fileSystem.php';

session_start();
$relitaveURL = '';
$currentURL = '';
$types = array();
$files = array();
$fileInterface = new fileSystemInterface();

/*
this function takes in one vaurable which holds an array of all of the files in a given
directory than turns each of them in to a icon of html and then renders the file GUI
for the frontend and then echos it
*/
function renderGUI($filesArray, $relitaveURL){
	$file_GUI = file_get_contents('files.html');

	$file_icons = '';
	foreach($filesArray as $fileInstance){
	        $file_icons = $file_icons.'<div class="iconHolder">
	<table><tr><td><a href='.$fileInstance->getType()->getReply($fileInstance->getURL()).'
	><div class="appIcon" ><center><img src="'.$fileInstance->getType()->getImage().'">
	</center><p>'.$fileInstance->getname().'</p></div></a></tr></td></table></div>';
	}

	$file_GUI = str_replace('[%allfiles%]', $file_icons, $file_GUI);
	$file_GUI = str_replace('{/dir/}', $relitaveURL, $file_GUI);
	echo $file_GUI;
}


/*
* reads all of the navagation stuffs
*/
if(isset($_GET['Dir']) && isset($_GET['Alldir'])){
	$currentURL = '../../'.$_GET['Dir'];
	$relitaveURL = $currentURL;

}else if(isset($_GET['Dir'])){//checks if there is get
	$currentURL = '../../'.$_SESSION['Home'].'/'.$_GET['Dir'];
    $relitaveURL = $_GET['Dir'];
}else{
	$currentURL = '../../'.$_SESSION['Home'];
	$relitaveURL = '';
}
/*
*sees if any commands have been invoced and
*than runs them though the fileSystem class
*/
if(isset($_GET['mkdir'])){
	$fileInterface->addFolder($relitaveURL ,$_GET['mkdir']);
	echo '<html><body><script>window.location.href = "files.php?Dir='.$relitaveURL.'";</script></body></html>';
}else if(isset($_GET['rmdir'])){
	$fileInterface->deleteFile($relitaveURL.'/'.$_GET['rmdir']);
	echo '<html><body><script>window.location.href = "files.php?Dir='.$relitaveURL.'";</script></body></html>';
}else if(isset($_GET['cpDir']) && isset($_GET['cpDest'])){
    $fileInterface->moveDirectory($_GET['cpDir'], $_GET['cpDest']);
    echo '<html><body><script>window.location.href = "files.php?Dir='.$relitaveURL.'";</script></body></html>';
}

$files = $fileInterface->listDirectorys($relitaveURL);
renderGUI($files, $relitaveURL);

?>