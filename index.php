<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Zak's AB Testing</title>
	<style type="text/css">
		.vertical-menu {
		    width: 300px; /* Set a width if you like */
		}

		.vertical-menu a {
		    background-color: #eee; /* Grey background color */
		    color: black; /* Black text color */
		    display: block; /* Make the links appear below each other */
		    padding: 12px; /* Add some padding */
		    text-decoration: none; /* Remove underline from links */
		    font-family: "AppleGothic", sans-serif;
		    border: 1px dashed black;
		}

		.vertical-menu a:hover {
		    background-color: #ccc; /* Dark grey background on mouse-over */
		}

		.vertical-menu a.active {
		    background-color: #FF4500; /* Add a orange color to the current link */
		    color: black;
		}
	</style>
</head>
<body>
	<h2>Zak's AB Testing - Check Out:</h2>
	<div class="vertical-menu" style="margin: 10px;">
		<a href="#" class="active">AB-TESTING</a>
		<?php
		$path = "Code";
		$dh = opendir($path);
		$i=1;
		while (($file = readdir($dh)) !== false) {
		    if($file != "." && $file != ".." && $file != "index.php" && $file != ".htaccess" && $file != "error_log" && $file != "cgi-bin") {
		        echo "<a href='$path/$file'>$file</a>\r\n";
		        $i++;
		    }
		}
		closedir($dh);
		?>
	</div>
	<br><br>
	<div class="vertical-menu" style="margin: 10px; float: left;">
		<a href="#" class="active">Eye-Tracking</a>
		<a href='Eye-Tracking/Code/heatmap.html'>Checkout the Heatmap here!</a>
		<a href='Eye-Tracking/Code/replay.html'>Checkout the Eye Movements here!</a>
		<?php
		$path = "Eye-Tracking";
		$dh = opendir($path);
		$i=1;
		while (($file = readdir($dh)) !== false) {
		    if($file != "." && $file != ".." && $file != "index.php" && $file != ".htaccess" && $file != "error_log" && $file != "cgi-bin") {
		        echo "<a href='$path/$file'>$file</a>\r\n";
		        $i++;
		    }
		}
		closedir($dh);
		?>
	</div>
</body>
</html>

