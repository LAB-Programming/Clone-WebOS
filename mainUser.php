<?php
	/*
	[Giovanni Rescigno - Clone Computers 2013 V1.0b GPL 2.0]
	this class holds info about the over state of all of the users in the system
	*/
	class UsersInfo{

		private $usersFileLocation;

		function __construct($fileLocation){
			$this->usersFileLocation = $fileLocation;
		}
		/*
		this method checks if are any users and 
		if there are not than it will return false
		*/
		function isUsers(){
			$userFileHandle = new MarkUpFile($this->usersFileLocation );
			if($userFileHandle->Read() == false){
				$userFileHandle->Close();
				return false;
			}
			else{
				$userFileHandle->Close();
				return true;
			}
		}
		/*
		this method returns all of the users in in a user object (refur to dataStructs.php and the User Class)
		so that the login system can see all of the users are that are on the system  
		*/
		function getAllUsers(){
			$systemUsersFile = new MarkUpFile($this->usersFileLocation);
			$systemUsersArray = $systemUsersFile->Read();

			$systemUsersObjectArray = array();
			foreach($systemUsersArray as $singaUser){
				$systemUsersObjectArray = array_merge($systemUsersObjectArray, array(
					new User(rtrim($singaUser[1], "\r "), rtrim($singaUser[2], "\r "), rtrim($singaUser[3], "\r "))
					));
			}
			$systemUsersFile->Close();
			return $systemUsersObjectArray;
		}
		/*
		this method adds a new user. 
		it has three perameters userName password (not hashed) and rank (admin or user)
		*/
		function createNewUser($userName, $UnhashedPass, $type){
			$systemUsersFileHandle = new MarkUpFile($this->usersFileLocation);
			$systemUsersFileHandle->Write(false, array(array($userName, password_hash($UnhashedPass, PASSWORD_DEFAULT), $type)));
			$systemUsersFileHandle->Close();
		}
	}
?>