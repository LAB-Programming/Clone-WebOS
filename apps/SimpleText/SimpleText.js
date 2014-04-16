
$( document ).ready(function() {

	var GETobject = new URL(document.URL);
	var filePath = GETobject.findGET("Dir", GETobject.getGETs());

	$('.editor').jqte();//init the rich text editor

	$('.realSave').click(function() {
		var text = $(".jqte_editor").text();
		var fileContent = $(".text").attr("value");
		alert(fileContent);
		$.post("saveScirpt.php", {
			SAVE : fileContent,
			Cont : text,
			Dir : filePath, 
		});
	});
});