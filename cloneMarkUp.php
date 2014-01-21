<?php 
	class MarkUpFile{

		private $fileLoction;//holds the file location of the the file opend
		private $arrayTree = array();//holds the foramted data
		private $fileHandle;//holds the file handle you dont need to worry about this

		function __construct($fileLocation){
			clearstatcache();
			$this->fileLoction = $fileLocation;//creates an instance of the filelocation
			$this->fileHandle = fopen($this->fileLoction, "c+");//creates file handle
		}
		/*
		*this function returns the data in the text file as a 2D a array the key to each 2D array is the first elemnt for example
		* EXAMPLE CODE:
		***********************
		* segment{			  * 
		* -cake               *
		* -pie                * 
		***********************
		* the key would be 'cake' for that data or you can just cycal thought it with a foreach loop :P
		*/
		function Read(){
			clearstatcache();
			$this->arrayTree = array();
			$fileString = fread($this->fileHandle, max(filesize($this->fileLoction), 1));//opens the file and turns it into a str
			if (trim($fileString) == ''){return false;}
			$segmentArray = explode("segment{", $fileString);//gets ecah segemnt
			unset($segmentArray[0]);//i do this because the frist thing is a ''

			foreach($segmentArray as $singalSeg){
				$singalSegarray = $this->cml_decode(explode("-", $singalSeg)); // decode the data after it has been exploded
				unset($singalSegarray[0]);
				$this->arrayTree = array_merge($this->arrayTree, array($singalSegarray[1] => $singalSegarray));
			}
			return $this->arrayTree;
		}
		/*
		* Write take two pramitors an OverWrite && DataToWrite (in a string array array same format as Read)
		* if the OverWrite = false; than it will concatiante the new data on the old other wise it 
		* just wipes the whole text file and adds the new data.
		*/
		function Write($OverWrite=false, $DataToWrite){
			$fileString = '';
			$oldFile = '';
			if(!$OverWrite){
				$oldFile = fread($this->fileHandle, filesize($this->fileLoction));
				error_log("reading file predata: ".$oldFile);
			}
			foreach($DataToWrite as $Singalseg){
				$fileString .= $this->renderStr($Singalseg);
			}
			error_log("final String: ".$fileString);
			fwrite($this->fileHandle, $fileString);

		}
		/* FOR INTREAL USE ONLY!!!!!!!ONLY!!!!!!ONLY!!!!!! 
		-said the dalek*/
		private function renderStr($segmentData){
			$str = "segment{\r";
			$segmentData = $this->cml_sanitize($segmentData); // sanitize all the data so people can't do code injection
			foreach($segmentData as $element){
				$str .= '-'.$element."\r"; // Append each element preceded by as dash (-)
			}
			return $str;
		}
		function Close(){
			fclose($this->fileHandle);
			clearstatcache();
		}
		
		/* Replace all ampersands (&), open curly braces ({), and dashes (-)
		 * With the appropriate code (&a, &b, &d, respectively)
		 * Works on both individual string and string arrays
		 */
		function cml_sanitize($str) {
			return str_replace(array("&", "{", "-"), array("&a", "&b", "&d"), $str);
		}
		
		/* Inverse of cml_sanitize($str)
		 * This should be run when CML is read directly from a file
		 * Works on both individual string and string arrays
		 */
		function cml_decode($str) {
			return str_replace(array("&d", "&b", "&a"), array("-", "{", "&"), $str);
		}
	}
	/*
	RANDOM COMMMENTS HA HA HA HA HA HA!!!!!!!!!
	i was going to write some thing but then i forgot what i was :)
	*/
?>