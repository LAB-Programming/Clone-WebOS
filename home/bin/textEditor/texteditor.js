
function doAction(action) {
	var noErrors = new Boolean(1);
	switch (action) {
		case "new":
			if (!isSaved()) {
				alert("Current Document is not Saved!");
				noErrors = new Boolean(0);
				break;
			}
			document.forms["texteditor"]["fileloc"].value = "";
			document.getElementById("textarea").value = "";
			document.getElementById("save").value = "";
			noErrors = new Boolean(0);
			break;
		case "open":
			if (!isSaved()) {
				alert("Current Document is not Saved!");
				noErrors = new Boolean(0);
			}
			break;
		case "save":
			if (isSaved()) {
				noErrors = new Boolean(0);
			}
			break;
		case "saveas":
			break;
		default:
			noErrors = new Boolean(0);
			break;
	}
	//alert("noErrors = " + noErrors);
	if (noErrors == true) {
		//alert("about to submit form " + noErrors);
		document.forms["texteditor"]["action"].value = action;
		document.getElementById("texteditform").submit();
	}
}

function isSaved() {
	return document.getElementById("textarea").value == document.getElementById("save").value;
}
