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

		.vertical-menu a.header {
		    background-color: #FF4500; /* Add a orange color to the current link */
		    font-size: 1.1em;
		    font-weight: bold;
		    color: black;
		}

		.vertical-menu a.active {
		    background-color: #FF9F90; /* Add a orange color to the current link */
		    color: black;
		}
	</style>
</head>
<body>
	<h2>Zak's AB Testing - Check Out:</h2>
	<div class="vertical-menu" style="margin: 30px; float: left;">
		<a href="#" class="header">AB-TESTING</a>
		<br>
		<a href="#" class="active">Code:</a>
		<a href='AB-Code/clicks.php'><b>Click</b> through rate</a>
		<a href='AB-Code/dwell.php'><b>Dwell</b> time</a>
		<a href='AB-Code/return.php'><b>Return</b> rate</a>
		<a href='AB-Code/time.php'><b>Time</b> to click</a>
		<a href='AB-Code/chi.php'>Chi-Squared test</a>
		<a href='AB-Code/ttest.php'>T-Test</a>
		<br>
		<a href="#" class="active">Relevant Data:</a>
		<?php
		$path = "AB-Code";
		$dh = opendir($path);
		$i=1;
		while (($file = readdir($dh)) !== false) {
		    if($file != "." && $file != ".." && (strpos($file, 'php') === false) && $file != ".htaccess" && $file != "error_log" && $file != "cgi-bin") {
		        echo "<a href='$path/$file'>$file</a>\r\n";
		        $i++;
		    }
		}
		closedir($dh);
		?>
	</div>
	<div class="vertical-menu" style="margin: 30px; float: left;">
		<a href="#" class="header">Eye-Tracking</a>
		<br>
		<a href="#" class="active">Code:</a>
		<a href='Eye-Tracking/Code/heatmap.html'>Checkout the <b>Heatmap</b> here!</a>
		<a href='Eye-Tracking/Code/replay.html'>Checkout the <b>Eye Movements</b> here!</a>
		<br>
		<a href="#" class="active">Relevant Data:</a>
		<?php
		$path = "Eye-Tracking";
		$dh = opendir($path);
		$i=1;
		while (($file = readdir($dh)) !== false) {
		    if($file != "." && $file != ".." && $file != "index.php" && $file != ".htaccess" && $file != "error_log" && $file != "cgi-bin"
		    	&& $file != "heatmap.html" && $file != "replay.html") {
		        echo "<a href='$path/$file'>$file</a>\r\n";
		        $i++;
		    }
		}
		closedir($dh);
		?>
	</div>
</body>
</html>

