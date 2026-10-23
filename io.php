<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PHP</title>
</head>
<body>
	<?php if (True): ?>
		<h1>Test</h1>
	<?php endif ?>

	<?php 
		$filename = "in.txt";

		if (file_exists($filename)) {
			# file() returns the an array of the lines of the file
			# fopen() exists but it should only be used if you *need* to use fwrite(), fseek() or fread(), always fopen with "b"
			$contents = file_get_contents($filename);
			echo "<p>" . $contents . "</p>";
		} else {
			echo "<p>No such file</p>";
		}

	 ?>
</body>
</html>