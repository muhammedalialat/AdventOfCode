<?php

$input = file_get_contents('input.txt');

$array = explode(chr(10), $input);

$stacks = getStacks(array_slice($array,0,8));

echo '1) ' . getPart1($array, $stacks) . '<br>' . chr(10);
echo '2) ' . getPart2($array, $stacks);

function getPart1($array, $stacks) {
	foreach (array_slice($array,10) as $line) {
		$command = explode(' ', $line);
		for ($i = 0; $i < (int)$command[1]; $i++) {
			$currentElement = array_pop($stacks[(int)$command[3]]);
			$stacks[(int)$command[5]][] = $currentElement;
		}
	}

	$result = '';
	foreach ($stacks as $current) {
		$result .= array_pop($current);
	}

	return $result;
}


function getPart2($array, $stacks) {
	foreach (array_slice($array,10) as $line) {
		$command = explode(' ', $line);
		$crane = [];
		for ($i = 0; $i < (int)$command[1]; $i++) {
			$crane[] = array_pop($stacks[(int)$command[3]]);
		}

		$stacks[(int)$command[5]] = array_merge($stacks[(int)$command[5]], array_reverse($crane));
	}


	$result = '';
	foreach ($stacks as $current) {
		$result .= array_pop($current);
	}
	
	return $result;
}

function getStacks($array) {
	$stacks = [];

	foreach ($array as $line) {
		for ($i = 0; $i < 9; $i++) {
			$char = trim(substr($line,($i*4)+1, 1));
			if (empty($char)) {
				continue;
			}
			if(empty($stacks[($i+1)])) {
				$stacks[($i+1)] = [];
			}
			array_unshift($stacks[($i+1)], $char);
		}
	}
	ksort($stacks);

	return $stacks;
}
