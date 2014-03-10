<?php
	
	require_once '../files/file.php';
	/**
	******************************************
	* By Giovanni Rescigno - Clone Computers *
	* GPL 2.0 free software					 *
	******************************************
	* DISCRIPTION:						 
	* this class is the librarry interface for the file system it 
	* it alows you to both miniplate the file system and add new types
	* of files. 
	*/

	class fileSystemInterface{

		private $UserHomeDir;

		function __construct(){
			$this->UserHomeDir = '../../'.$_SESSION['Home'];
		}

		/*
		* this fuction takes in two preamitors that are strings, 
		* the first one is the Directory that is being copyed
		* the other is the houseing folder that will hold the copy
		* the destonation of the file.
		* both folders must be relitve to the Users home folder
		*/
		function copyDirectory($Direcotry, $Dest){

			$fullDirectory = $this->UserHomeDir.$Direcotry;
			$fullDest = $this->UserHomeDir.$Dest;

			if(is_dir($fullDest)){
        		exec("cp -R ".$fullDirectory." ".$fullDest);
        	}else{
        		return false;
        	}
		}
		/*
		* this function takes in two premitors that are strings one
		* takes in the starting direcitroy the other takes the 
		* ending directory
		* this fuction moves a file to a another file
		*/
		function moveDirectory($Directory, $Dest){
			$fullDirectory = $this->UserHomeDir.$Directory;
			$fullDest = $this->UserHomeDir.$Dest;

			if(is_dir($fullDest)){
        		exec("cp -R ".$fullDirectory." ".$fullDest);
        		$this->deleteFile($Directory);
        	}else{
        		return false;
        	}
		}
		/*
		* this function take a file Path relitve to the home folder of the
		* current user. and list all of the dirs inside it. it take only one
		* preamitor the file path and returns an array of file objects 
		* represnting all of the files
		*/
		function listDirectorys($filePath){
			$fileTypes = $this->getTypes();
			$fullUrl = $this->UserHomeDir.$filePath;

			exec('ls '.$fullUrl, $raw_dir_data);

			$files = array();
			foreach($raw_dir_data as $singleEnt){
				$files = array_merge($files, array(new file($filePath, $singleEnt, $fileTypes)));
			}
			return $files;
		}
		/*
		* this fuctino take only one poramitor which is the relitive filePath to
		* the file you wish to remove
		*/
		function deleteFile($filePath){
			
			$fullFilePath = $this->UserHomeDir.$filePath;
			if(is_dir($fullFilePath)){
				system('rm -rf '.$fullFilePath);
			}else{
				system('rm '.$fullFilePath, $runval);
			}
		}
		/*
		* this function takes in two arguments the path the the houseing folder
		* and the new folders name it returns nothing
		*/
		function addFolder($pathToHousingFolder, $folderName){

			exec('ls '.$this->UserHomeDir.$pathToHousingFolder, $raw_dir_data);
			foreach($raw_dir_data as $dircheck){
				if($dircheck == $folderName){return 0;}
			}
			mkdir($this->UserHomeDir.$pathToHousingFolder.'/'.$folderName.'/', 0777);
		}
		/*
		* this function rerutrns an array of type objects
		* an example of a type is a text file or a folder.
		* this fuction gives you all the types that the system knows of 
		*/
		function getTypes(){
			//opens up the types file
			$types_file_handle = new MarkUpFile('../Lib/fileTypes.txt'); 
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
		* this function takes in 3 preamiotrs, the app location
		* that can open this type of file, the extention of the file 
		* inquestion and the icon. this function adds a new file type
		* to the list of file types
		*/
		function addFileType($appLocation, $extention, $iconLocation){

			$fullAppLocation = '../'.$appLocation;
			$fullIconLocation = '../../images/'.$iconLocation;

			$types_file_handle = new MarkUpFile('../Lib/fileTypes.txt');
			$types_file_handle->Write(false, array(array($fullAppLocation, $extention, $fullIconLocation)));
			$types_file_handle->Close();

		}
	}
?>