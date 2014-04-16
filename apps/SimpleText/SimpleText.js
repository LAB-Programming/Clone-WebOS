
$( document ).ready(function() {

	var GETobject = new URL(document.URL);
	var filePath = GETobject.findGET("Dir", GETobject.getGETs());

	$('.editor').jqte();//init the rich text editor

	$('.realSave').click(function() {
		var text = $(".jqte_editor").text();
		$.post("saveScirpt.php", {
			SAVE : text,
			Dir : filePath, 
		});
	});
});