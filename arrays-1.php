<?php 
 	$array = [10, 20, 30, 40, 50, 60];
 	print_r($array);

 	echo count($array), "\n";

 	unset($array[2]);
 	# oh god now the array indexes are 0,1,3,4,5
 	echo "\$array[2] removed\n";

 	echo count($array), "\n";

 	print_r($array);

 	array_push($array, 999); # append to end of array
 	print_r($array);

 	array_pop($array); # return and remove from end of array
 	print_r($array);

 	echo "\n";
 	
 	# a for i loop won't work,
 	# this will
 	foreach ($array as $key => $value) {
 		echo $key, "\t", "$value", "\n";
 	}

 	# however, if we reindex the array
 	$array = array_values($array);

 	print_r($array);

 	for ($i=0; $i < count($array); $i++) { 
 		echo $i, "\t", $array[$i], "\n";
 	}

 	# reset($array) to get array[0]
 	# end($array) to get array[count($array) -1]

 	array_unshift($array, 999); # append to start of array, as always push is more performant
 	
 	$first = reset($array);
 	echo $first, "\n";

 	$also_first = array_shift($array); # return and remove from start of array

 	if ($first == $also_first) {
 		echo "yeah that worked\n";
 	}

 	$other_array = array();
 	for ($i=1; $i < 20; $i++) {
 		array_push($other_array, $i * 2);
 	}

 	$third_array = array_merge($array, $other_array);
 	sort($third_array);
 	$third_array = array_slice($third_array, 4, 12);

 	# splice also removes from original, slice just returns another array

 	print_r($third_array);
 ?>