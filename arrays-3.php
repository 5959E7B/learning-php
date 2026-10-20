<?php 
	$lets_go_2d = [
		[1, 2, 3],
		[4, 5, 6],
		[7, 8, 9],
	];

	print_r($lets_go_2d);

	# ok but that's lame
	echo "\n\n\n";

	$not_lame = [
		"USERID" => [
			"name" => "NAME",
			"surname" => "SURNAME",
			"age" => 0,
		],
		"1" => [
			"name" => "John",
			"surname" => "Smith",
			"age" => 30,
		],
		"2" => [
			"name" => "Elyzabeth",
			"surname" => "Mcqueen",
			"age" => 25,
		],
		"3" => [
			"name" => "Glorp",
			"surname" => "Ylon",
			"age" => 328,
		],
		# there is nothing enforcing the schema
		"fuck you" => [
			"AHAHAHAHA" => NAN,
			0 => 3,
		],
	];

	# var_dump($not_lame);

	unset($not_lame["fuck you"]);
	unset($not_lame["USERID"]);
	$not_lame = array_values($not_lame);

	var_dump($not_lame);
	
	foreach ($not_lame as $key => $value) {
		# couldn't think of a better example for substr so, well.. this is just $value["name"][0]
		print(substr($value["name"], 0, 1) . "." . substr($value["surname"], 0, 1) . "." . "" . "\n");
		print($value["name"] . " " . $value["surname"] . "\n");

		# var_dump($value["name"][0]); # string(1), lol uhm actually, is that the number of codepoints or bytes?
	}

	$utf8_str = "衝撃の事実！"; # - Chaika
	# 6 chars
	print(strlen($utf8_str)); # 18, so it's bytes

	echo "\n";
	for ($i=0; $i<strlen($utf8_str); $i++) {
		print($utf8_str[$i] . " ");
	} # � � � � � � � � � � � � � � � � � � 
	echo "\n";

	# aha!
	print(mb_strlen($utf8_str)); # 6
	print(grapheme_strlen($utf8_str)); # should be more accurate as it also takes into account combination chars

	# copy pasted code

	$string = "Hello, 世界 🌍 👨‍👩‍👧‍👦";
	// \X matches a single extended grapheme cluster. 
	// The 'u' modifier enables UTF-8 support.
	preg_match_all('/\X/u', $string, $matches);

	foreach ($matches[0] as $grapheme) { # matches[0]?
	    echo $grapheme . PHP_EOL;
	}

	# var_dump($matches); # huh?? why is it a len 1 array of an array? oh well, just [0] ig

	$anagrams = implode(",", ["anagram","magraan","graaanam"]);
	var_dump($anagrams);

	$anagrams = explode(",", "anagram,magraan,granama");
	var_dump($anagrams);

	foreach ($anagrams as $i) {
		print($i . PHP_EOL);
	}

	while (False) {
		# unreachable()
		continue;
		break;
	}

	# include("lib.php")
 ?>