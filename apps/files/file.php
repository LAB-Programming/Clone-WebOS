<?
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
		$this->fullURL = $this->location.$this->name;
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
?>