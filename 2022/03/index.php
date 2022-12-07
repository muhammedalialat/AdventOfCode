<?php

$input = file_get_contents('input.txt');

$array = explode(chr(10), $input);

echo '1) ' . getPart1($array) . '<br>' . chr(10);
echo '2) ' . getPart2($array);

function getPart1($array) {

	foreach ($array as $value) {
		$length = strlen($value);
		$pack = [];

		for($i = 0; $i < ($length/2); $i++) {
			//echo '[' . $i . '|' . $length . ']';
			$charOne = getOrderNumber($value[$i]);
			$charTwo = getOrderNumber($value[$length-1-$i]);

			$pack[$charOne][1] += 1;
			$pack[$charTwo][2] += 1;

			if ($pack[$charOne][2] > 0) {
				$found += $charOne;
				break;
			}

			if ($pack[$charTwo][1] > 0) {
				$found += $charTwo;
				break;
			}
		}
	}
	
	return $found;
}

function getPart2($array) {
	$found = 0;
	foreach ($array as $line => $value) {
		if ($line % 3 == 0) {
			$pack = [];
		}
	
		$length = strlen($value);
	
		for($i = 0; $i < $length; $i++) {
			$charOne = getOrderNumber($value[$i]);
			$pack[$charOne][$line%3] = true;
		}
	
		if ($line%3 == 2) {
			foreach ($pack as $char => $packs) {
				if (count($packs) == 3) {
					$found += $char;
					break;
				}
			}
		}
	}

	return $found;
}

function getOrderNumber($char) {
	$number = ord($char);
	if ($number > 96) {
		$number -= 96;
	} else {
		$number -= 38;
	}

	return $number;
}
