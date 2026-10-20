<?php
	$map = []; # same as doing array()

	$map["0"] = "Test";

	if ($map["0"] == $map[0]) {
		echo "Oh God...\n";
	}

	$map[10] = 3;
	$map["John"] = "Smith";

	print_r($map);

	$string = "asdfg";

	for ($i=0; $i<strlen($string); $i++) {
		echo $string[$i], "\t";
	}
	echo "\n";

	if (array_key_exists("John", $map)) {
		echo $map["John"], "\n";
	}

	echo "=== Keys ===\n";
	foreach (array_keys($map) as $key => $value) {
		echo $value, "\n";
	}

	echo "=== Values ===\n";
	foreach (array_values($map) as $key => $value) {
		echo $value, "\n";
	}

 ?>