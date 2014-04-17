
$( document ).ready(function() {

	var GETobject = new URL(document.URL);
	var filePath = GETobject.findGET("Dir", GETobject.getGETs());

	$('.editor').jqte();//init the rich text editor

	$('.realSave').click(function() {

		var text = $(".jqte_editor").html();
		var fileContent = $(".text").val();

		$.post("saveScirpt.php", {
			SAVE : fileContent,
			Cont : text,
			Dir : filePath, 
		});
		//this is were the rdirecntion happens 
		setInterval(function(){ //i wait here for 1 sec to let the php save script write to the file
			if($(".text").attr("value") !== fileContent){

				filePath = filePath.replace($(".text").attr("value"), fileContent);
				window.location = "main.php?Dir="+filePath+"";

			}else if(filePath === false){
				window.location = "main.php?Dir=/"+fileContent;
			}

		},1000);
	});
});