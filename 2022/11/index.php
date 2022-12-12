<?php

$input = file_get_contents('input.txt');
$array = explode(chr(10), $input);

$monkeys = structureInput($array);

echo '1) ' . getPart1($monkeys) . '<br>' . chr(10);
echo '2) ' . getPart2($monkeys) . chr(10);

function getPart1($monkeys) {

	for ($r = 0; $r < 20; $r++) {
		for ($m = 0; $m < count($monkeys); $m++) {
			$items = count($monkeys[$m]['items']);
			for ($i = 0; $i < $items; $i++) {
				$item = array_shift($monkeys[$m]['items']);
				if ($monkeys[$m]['operation'][0] == 'sq') {
					$item = $item * $item;
				} elseif ($monkeys[$m]['operation'][0] == '*') {
					$item *= $monkeys[$m]['operation'][1];
				} elseif ($monkeys[$m]['operation'][0] == '+') {
					$item += $monkeys[$m]['operation'][1];
				}

				$item = (int) ($item / 3);

				if ($item%$monkeys[$m]['divisible'][0] == 0) {
					$monkeys[$monkeys[$m]['divisible'][1]]['items'][] = $item;
				} else {
					$monkeys[$monkeys[$m]['divisible'][2]]['items'][] = $item;
				}

				$monkeys[$m]['count']++;
			}
		}
	}

	$max1 = 0;
	$max2 = 0;
	foreach ($monkeys as $monkey) {
		if ($monkey['count'] > $max1) {
			$max2 = $max1;
			$max1 = $monkey['count'];
		} elseif ($monkey['count'] > $max2) {
			$max2 = $monkey['count'];
		}
	}

	return ($max1 * $max2);
}

function getPart2($monkeys) {
	
	$maxDivider = 1;
	foreach ($monkeys as $monkey) {
		$maxDivider *= $monkey['divisible'][0];
	}

	for ($r = 0; $r < 10000; $r++) {
		for ($m = 0; $m < count($monkeys); $m++) {
			$items = count($monkeys[$m]['items']);
			for ($i = 0; $i < $items; $i++) {
				$item = array_shift($monkeys[$m]['items']);
				if ($monkeys[$m]['operation'][0] == 'sq') {
					$item = $item * $item;
				} elseif ($monkeys[$m]['operation'][0] == '*') {
					$item *= $monkeys[$m]['operation'][1];
				} elseif ($monkeys[$m]['operation'][0] == '+') {
					$item += $monkeys[$m]['operation'][1];
				}
				
				if ($item%$monkeys[$m]['divisible'][0] == 0) {
					$monkeys[$monkeys[$m]['divisible'][1]]['items'][] = $item%$maxDivider;
				} else {
					$monkeys[$monkeys[$m]['divisible'][2]]['items'][] = $item%$maxDivider;
				}
				
				$monkeys[$m]['count']++;
			}
		}
	}

	$max1 = 0;
	$max2 = 0;
	foreach ($monkeys as $monkey) {
		if ($monkey['count'] > $max1) {
			$max2 = $max1;
			$max1 = $monkey['count'];
		} elseif ($monkey['count'] > $max2) {
			$max2 = $monkey['count'];
		}
	}

	return ($max1 * $max2);
}

function structureInput($array) {
	$monkeys = [];
	
	for ($i = 0; $i < count($array); $i = $i+7) {
		$monkeys[($i/7)]['count'] = 0;

		$items = explode(',', substr(trim($array[$i+1]), 16));
		foreach ($items as $item) {
			$monkeys[($i/7)]['items'][] = (int) trim($item);
		}

		$operation = substr(trim($array[$i+2]), 17);
		if ($operation == 'old * old') {
			$monkeys[($i/7)]['operation'][0] = 'sq';
		} elseif (substr($operation, 0, 5) == 'old *') {
			$monkeys[($i/7)]['operation'][0] = '*';
			$monkeys[($i/7)]['operation'][1] = trim(substr($operation, 6));
		} elseif (substr($operation, 0, 5) == 'old +') {
			$monkeys[($i/7)]['operation'][0] = '+';
			$monkeys[($i/7)]['operation'][1] = trim(substr($operation, 6));
		}

		$monkeys[($i/7)]['divisible'][0] = (int) substr(trim($array[$i+3]), 19);
		$monkeys[($i/7)]['divisible'][1] = (int) substr(trim($array[$i+4]), 25);
		$monkeys[($i/7)]['divisible'][2] = (int) substr(trim($array[$i+5]), 26);
	}

	return $monkeys;
}

