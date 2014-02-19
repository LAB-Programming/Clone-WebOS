<?php
class fileType{

	private $extention;//holds the extention of the type (like .txt)
	private $appName;//holds the url of the app that opens a given type of file
	private $imageURL;//holdes the url of the icon for this type of folder

	function __construct($exten, $appName, $imageURL){
		$this->extention = $exten;
		$this->appName = $appName;
		$this->imageURL = $imageURL;
	}
	/*
	this function checks if the folowing extention is a compatable file if it is this
	method will return true. returns a boolen
	*/
	function canOpen($testingExtention){
		return ($testingExtention == rtrim($this->extention, " \n")) || ($testingExtention == rtrim($this->extention, " \r"));
	}
	/*
	this method will create a standered _GET queary to an app with the url of a given 
	file. returns a string
	*/
	function getReply($URL){
		return rtrim($this->appName, " \n")."?Dir=".$URL;
	}
	/*
	this function gets the image url for this type of file
	*/
	function getImage(){
		return $this->imageURL;
	}

}
class file{

	private $location;
	private $name;
	private $fullURL;
	private $type;

	function __construct($location, $name, $allFileTypes){
		$this->location = $location;
		$this->name = $name;
		$this->fullURL = $this->location.'/'.$this->name;
		$this->type = $this->findType($allFileTypes);
	}
	/*
	this function find the type of the file that has been given based off of its extention
	or lack there of
	*/
	function findType($fileTypes){
		$extention = explode('.', $this->name);
		if(isset($extention[1])){
			$extention = $extention[1];
		}else{
			$extention = "NONE";
		}
		foreach($fileTypes as $fileType){
			if($fileType->canOpen($extention)){
				return $fileType;
			}
		}
	}
	/*
	this function just gets the location of this instance of 
	a file (the directory above it)
	*/
	function getLocation(){
		return $this->location;
	}
	/*
	this function gets the name of the directory or file in question 
	and then returns it as a string
	*/
	function getname(){
		return $this->name;
	}
	/*
	this function retruns the full url of the file or directory so that you 
	go to this file
	*/
	function getURL(){
		return $this->fullURL;
	}
	/*
	this function reutns a fileType object with the file type of this instance
	of a file
	*/
	function getType(){
		return $this->type;
	}
}
class filesSystem{
	/*
	* this function rerutrns an array of type objects
	* an example of a type is a text file or a folder.
	* this fuction gives you all the types that the system knows of 
	*/
	function getTypes(){
		//opens up the types file
		$types_file_handle = new MarkUpFile('types.txt'); 
		$types_file_arrayList = $types_file_handle->Read();
		$types_file_handle->Close();
		//types is the array that holds all of the types
		$types = array();
		//loads all the types in to types
		foreach($types_file_arrayList as $single_type){
			$types = array_merge($types, array(new fileType($single_type[2], $single_type[1], $single_type[3])));
		}
		return $types;
	}
	/*
	takes in two arugments which is the url you want to get the files from and all of the system types
	and returns an array of file objects (with types)
	*/
	function getFiles($currentURL, $types, $relitaveURL){
		//runs the ls command to get all of the files in the directory
		exec('ls '.$currentURL, $raw_dir_data);

		$files = array();
		foreach($raw_dir_data as $singleEnt){
			$files = array_merge($files, array(new file($relitaveURL, $singleEnt, $types)));
		}
		return $files;
	}
	/*
	* this function makes a directory 
	* it takes in two arugments the url and the name
	*/
	function makeDirectory($URL, $name){
		//exec('mkdir '.$URL.'/'.$name.'/', $didFail);
		exec('ls '.$URL, $raw_dir_data);
		foreach($raw_dir_data as $dircheck){
			if($dircheck == $name){return 0;}
		}
		mkdir($URL.'/'.$name.'/', 0777);
	}
	/*
	*this function takes two poramitors a url and a directo
	*name. this function deleats a drectory
	*/ 
	function delDirectory($URL){
		if(is_dir($URL)){
			system('rm -rf '.$URL);
		}else{
			system('rm '.$URL, $runval);
		}
	}
    /*
     * this function takes two peramitors the file you what to
     * copy and the file you what to copy it into. this fuction
     * moves the dir were you want it
     * */
    function copyFile($source, $dest){
        // Simple copy for a file
        exec("cp -R ".$source." ".$dest);
    }
}
?>