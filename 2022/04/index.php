<?php

$input = file_get_contents('input.txt');

$array = explode(chr(10), $input);

echo '1) ' . getPart1($array) . '<br>' . chr(10);
echo '2) ' . getPart2($array);

function getPart1($array) {
	$count = 0;

	foreach ($array as $line) {
		$elfs = explode(',', $line);
		$elfOne = explode('-', $elfs[0]);
		$elfTwo = explode('-', $elfs[1]);

		if ($elfOne[0] >= $elfTwo[0] && $elfOne[1] <= $elfTwo[1]) {
			$count++;
		} elseif ($elfOne[0] <= $elfTwo[0] && $elfOne[1] >= $elfTwo[1]) {
			$count++;
		}

	}

	return $count;
}


function getPart2($array) {
	$count = 0;
	
	foreach ($array as $line) {
		$elfs = explode(',', $line);
		$elfOne = explode('-', $elfs[0]);
		$elfTwo = explode('-', $elfs[1]);
		
		if ($elfOne[0] >= $elfTwo[0] && $elfOne[1] <= $elfTwo[1]) {
			$count++;
		} elseif ($elfOne[0] <= $elfTwo[0] && $elfOne[1] >= $elfTwo[1]) {
			$count++;
		} elseif ($elfOne[0] <= $elfTwo[0] && $elfOne[1] >= $elfTwo[0]) {
			$count++;
		} elseif ($elfTwo[0] <= $elfOne[0] && $elfTwo[1] >= $elfOne[0]) {
			$count++;
		}
		
	}
	
	return $count;
}