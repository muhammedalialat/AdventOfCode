<?php

$input = file_get_contents('input.txt');
$array = explode(chr(10), $input);

$matrix = structureInput($array);

echo '1) ' . getPart1($matrix) . '<br>' . chr(10);
echo '2) ' . getPart2($matrix) . chr(10);

function getPart1($matrix) {
	$distance = [];
	$distance[$matrix[1][0]][$matrix[1][1]] = 1;

	goNextStep($matrix[1], $matrix[0], $distance);

	return $distance[$matrix[2][0]][$matrix[2][1]] - 1;
}

function getPart2($matrix) {
	$distance = [];
	foreach ($matrix[0] as $y => $row) {
		foreach ($row as $x => $column) {
			if ($column == ord('a')) {
				$distance[$y][$x] = 1;
				goNextStep([$y, $x], $matrix[0], $distance);
			}
		}
	}

	return $distance[$matrix[2][0]][$matrix[2][1]] - 1;
}

function goNextStep($from, &$matrix, &$distance) {
	$y = $from[0];
	$x = $from[1];

	if ($y > 0) {
		$newY = $y - 1;
		if ( ($matrix[$y][$x] - $matrix[$newY][$x]) > -2) {
			if (empty($distance[$newY][$x])) {
				$distance[$newY][$x] = $distance[$y][$x] + 1;
				goNextStep([$newY, $x], $matrix, $distance);
			} elseif (($distance[$y][$x] + 1) < $distance[$newY][$x]) {
				$distance[$newY][$x] = $distance[$y][$x] + 1;
				goNextStep([$newY, $x], $matrix, $distance);
			}
		}
	}
	if ($y < count($matrix) - 1) {
		$newY = $y + 1;
		if ( ($matrix[$y][$x] - $matrix[$newY][$x]) > -2) {
			if (empty($distance[$newY][$x])) {
				$distance[$newY][$x] = $distance[$y][$x] + 1;
				goNextStep([$newY, $x], $matrix, $distance);
			} elseif (($distance[$y][$x] + 1) < $distance[$newY][$x]) {
				$distance[$newY][$x] = $distance[$y][$x] + 1;
				goNextStep([$newY, $x], $matrix, $distance);
			}
		}
	}
	if ($x > 0) {
		$newX = $x - 1;
		if ( ($matrix[$y][$x] - $matrix[$y][$newX]) > -2) {
			if (empty($distance[$y][$newX])) {
				$distance[$y][$newX] = $distance[$y][$x] + 1;
				goNextStep([$y, $newX], $matrix, $distance);
			} elseif (($distance[$y][$x] + 1) < $distance[$y][$newX]) {
				$distance[$y][$newX] = $distance[$y][$x] + 1;
				goNextStep([$y, $newX], $matrix, $distance);
			}
		}
	}
	if ($x < count($matrix[$y]) - 1) {
		$newX = $x + 1;
		if ( ($matrix[$y][$x] - $matrix[$y][$newX]) > -2) {
			if (empty($distance[$y][$newX])) {
				$distance[$y][$newX] = $distance[$y][$x] + 1;
				goNextStep([$y, $newX], $matrix, $distance);
			} elseif (($distance[$y][$x] + 1) < $distance[$y][$newX]) {
				$distance[$y][$newX] = $distance[$y][$x] + 1;
				goNextStep([$y, $newX], $matrix, $distance);
			}
		}
	}
}

function structureInput($array) {
	$matrix = [];
	$start = [];
	$end = [];

	foreach($array as $y => $row) {
		for ($x = 0; $x < strlen($row); $x++) {
			$matrix[$y][$x] = ord(substr($row, $x, 1));
			if (substr($row, $x, 1) == 'S') {
				$start = [$y, $x];
				$matrix[$y][$x] = ord('a');
			} elseif (substr($row, $x, 1) == 'E') {
				$end = [$y, $x];
				$matrix[$y][$x] = ord('z');
			}
		}
	}

	return [$matrix, $start, $end];
}

