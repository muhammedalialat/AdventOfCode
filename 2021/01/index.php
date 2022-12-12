<?php

$input = file_get_contents('input.txt');

$array = explode(chr(10), $input);

echo '1) ' . part1($array) . chr(10);
echo '2) ' . part2($array);

function part1($array) {
	$count = 0;
	$last = array_shift($array);
	foreach ($array as $value) {
		if ($last < $value) $count++;
		$last = $value;
	}
	
	return $count;
}

function part2($array) {
	$count = 0;
	$last = $array[0] + $array[1] + $array[2];
	for ($i = 3; $i < count($array); $i++) {
		$next = $array[$i-2] + $array[$i-1] + $array[$i];
		if ($last < $next) $count++;
		$last = $next;
	}

	return $count;
}
