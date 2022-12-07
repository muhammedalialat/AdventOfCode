<?php

$input = file_get_contents('input.txt');

echo '1) ' . getPart1($input) . '<br>' . chr(10);
echo '2) ' . getPart2($input);

function getPart1($input) {
	$count = 0;

	for ($i = 0; $i < strlen($input); $i++) {
		if (substr($input, $i, 1) == '(') {
			$count++;
		} else {
			$count--;
		}
	}

	return $count;
}

function getPart2($input) {
	$count = 0;
	
	for ($i = 0; $i < strlen($input); $i++) {
		if ($count == -1) {
			return $i;
		}
		if (substr($input, $i, 1) == '(') {
			$count++;
		} else {
			$count--;
		}
	}
}
