<?php

$input = file_get_contents('input.txt');
$array = explode(chr(10), $input);

echo '1) ' . getPart1($array) . '<br>' . chr(10);
echo '2) ' . getPart2($array);

function getPart1($array) {
	$count = 0;
	
	foreach ($array as $y => $row) {
		for ($x = 0; $x < strlen($row); $x++) {
			if ($y == 0 || $y == (count($array) - 1) || $x == 0 || $x == (strlen($row) - 1)) {
				$count++;
				continue;
			}

			$current = $array[$y][$x];
			$visible = true;
			for ($i = 0; $i < $x; $i++) {
				if ($array[$y][$i] >= $current) {
					$visible = false;
					break;
				}
			}
			if ($visible) {
				$count++;
				continue;
			}

			$visible = true;
			for ($i = ($x+1); $i < strlen($row); $i++) {
				if ($array[$y][$i] >= $current) {
					$visible = false;
					break;
				}
			}
			if ($visible) {
				$count++;
				continue;
			}

			$visible = true;
			for ($i = 0; $i < $y; $i++) {
				if ($array[$i][$x] >= $current) {
					$visible = false;
					break;
				}
			}
			if ($visible) {
				$count++;
				continue;
			}

			$visible = true;
			for ($i = ($y+1); $i < count($array); $i++) {
				if ($array[$i][$x] >= $current) {
					$visible = false;
					break;
				}
			}
			if ($visible) {
				$count++;
				continue;
			}

		}
	}

	return $count;
}

function getPart2($array) {
	$maxScore = 0;

	foreach ($array as $y => $row) {
		for ($x = 0; $x < strlen($row); $x++) {
			if ($y == 0 || $y == (count($array) - 1) || $x == 0 || $x == (strlen($row) - 1)) {
				continue;
			}
			$current = $array[$y][$x];

			$leftScore = 0;
			for ($i = ($x-1); $i >= 0; $i--) {
				$leftScore++;
				if ($array[$y][$i] >= $current) {
					break;
				}
			}

			$rightScore = 0;
			for ($i = ($x+1); $i < strlen($row); $i++) {
				$rightScore++;
				if ($array[$y][$i] >= $current) {
					break;
				}
			}

			$topScore = 0;
			for ($i = ($y - 1); $i >= 0; $i--) {
				$topScore++;
				if ($array[$i][$x] >= $current) {
					break;
				}
			}

			$downScore = 0;
			for ($i = ($y+1); $i < count($array); $i++) {
				$downScore++;
				if ($array[$i][$x] >= $current) {
					break;
				}
			}

			if (($leftScore * $rightScore * $topScore * $downScore) > $maxScore ) {
				$maxScore = ($leftScore * $rightScore * $topScore * $downScore);
			}
			
		}
	}
	
	return $maxScore;
}
