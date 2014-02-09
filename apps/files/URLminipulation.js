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
	this.findGET = function(GETkey){

		var key = GETkey;
		for(var i = 0; i < this.getArray.length; i++){
			if(this.getArray[i][0] === key){
				return this.getArray[i][1];
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
		var mainURL = this.pageUR.split("?");
		var GETrequest = "?";

		for(var i = 0; i < newGETArray.length; i++){
			GETrequest=GETrequest+newGETArray[i][0]+"="+newGETArray[i][1]+"&";
		}
		return GETrequest;
	}

}