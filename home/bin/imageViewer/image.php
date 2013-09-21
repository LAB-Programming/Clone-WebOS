<!DOCTYPE html>
<html>
	<head>
		<title>Image Viewer</title>
		<style>
			img.bordered {
				border-style:dotted;
				border-width:1px;
			}
		</style>
		<?php
			$img = "";
			if ($_SERVER["REQUEST_METHOD"] == "GET") {
				$img = $_GET["img"];
			}
		?>
	</head>
	<body>
		<form action="<?php $_SERVER["PHP_SELF"];?>" method="get">
			Image Filepath/URL: <input id="imageLoc" name="img" type="text" autofocus="autofocus" value="<?php echo $img; ?>" />
			<button type="submit">Load Image</button>
			<br /><br />
		</form> 
		<img class="bordered" id="img" src="<?php echo $img; ?>" />
	</body>
</html>