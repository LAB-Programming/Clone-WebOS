function URL(rawPageURL){
	this.pageURL = rawPageURL;
	//this.getArray = this.getGETs();

	/*
	* this fuction takse in a raw URL and then finds all of the 
	* HTTP GET and then returns an array this fuction dose not realy
	* get called out side this class. if you what to find a spific
	* GET than use the findGET method
	**/
	this.getGETs = function(){
		if(this.pageURL.indexOf("?") != -1){
			var HGETarray = [];
			var HGETString = this.pageURL.split("?")[1];
			var SingleGET = HGETString.split("&");
			for(var i = 0; i < SingleGET.length; i++){
				HGETarray[i] = SingleGET[i].split("=");
			}
			return HGETarray;
		}else{
			return false;
		}
	}
	/*
	* ueseing the Get list that has been created by getGETs this function
	* takes in a key and serches thought the array of gets to find something with
	* maching key it returns the string if it has been found it return false if it
	* has not been found. 
	*/
	this.findGET = function(GETkey, GETArray){

		var key = GETkey;
		for(var i = 0; i < GETArray.length; i++){
			if(GETArray[i][0] === key){
				return GETArray[i][1];
			}
		}
		return false;//returns false if the "key" is not found
	}
	/*
	* this fuction takes an array that is in the same format 
	* that getGETs reutrns 
	* EXAMPLE:
	*[["key", "message"], ["anohterKey", "anotherMessage"]]
	* this fuction returns a String that is the new URL (not includeing pervusGets)
	*/
	this.sendGET = function(newGETArray){
		var mainURL = this.pageURL.split("?")[0];
		var GETrequest = "?";

		for(var i = 0; i < newGETArray.length; i++){
			GETrequest=GETrequest+newGETArray[i][0]+"="+newGETArray[i][1]+"&";
		}
		return mainURL+GETrequest;
	}
	/**
	*this function take a URL string and than finds the parinet drectory
	*URL this can be mores useful than it looks
	*/
	this.removeLastSegment = function(Directory){
		var LastIndex = Directory.lastIndexOf('/');
		if(LastIndex === -1){
			return false;
		}else{
			return Directory.substr(0, LastIndex);
		}
	}

}