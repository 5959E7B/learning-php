<?php
	# if you call a string, php searches for a function named like the string and calls it

	function do_x() {
		echo "cursed\n";
	}

	"do_x"();

	$var = "do_x";
	$var();


	# actually a map
	$arr = array();

	echo "1" == 1; # True
	echo "1" === 1; # False
?>