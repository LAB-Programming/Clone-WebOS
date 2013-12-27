<? 
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
			$fileString = fread($this->fileHandle, filesize($this->fileLoction));//opens the file and turns it into a str
			if ($fileString == ''){return false;}
			$segmentArray = explode("segment{", $fileString);//gets ecah segemnt
			unset($segmentArray[0]);//i do this because the frist thing is a ''

			foreach($segmentArray as $singalSeg){
				$singalSegarray = explode("-", $singalSeg);
				unset($singalSegarray[0]);
				$this->arrayTree = array_merge($this->arrayTree, array($singalSegarray[1] => $singalSegarray));
			}
			return $this->arrayTree;
		}
		/*
		* Write take two pramitors an OverWrite && DataToWrite (in an array same format as Read)
		* if the OverWrite = false; than it will concatiante the new data on the old other wise it 
		* just wipes the whole text file and adds the new data.
		*/
		function Write($OverWrite=false, $DataToWrite){
			$fileString = '';
			if(!$OverWrite){
				$fileString = fread($this->fileHandle, filesize($this->fileLoction));
			}
			foreach($DataToWrite as $Singalseg){
				$fileString = $fileString.$this->renderStr($Singalseg);
			}
			fwrite($this->fileHandle, $fileString);
			clearstatcache();

		}
		/* FOR INTREAL USE ONLY!!!!!!!ONLY!!!!!!ONLY!!!!!! 
		-said the dalek*/
		private function renderStr($segmentData){
			$Header = "segment{\r";

			foreach($segmentData as $element){
				$Header = $Header.'-'.$element."\r";
			}
			return $Header;
		}
		function Close(){
			fclose($this->fileHandle);
			clearstatcache();
		}
	}
	/*
	RANDOM COMMMENTS HA HA HA HA HA HA!!!!!!!!!
	i was going to write some thing but then i forgot what i was :)
	*/
?>