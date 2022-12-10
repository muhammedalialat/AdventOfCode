<?php

$input = file_get_contents('input.txt');
$array = explode(chr(10), $input);

echo '1) ' . getPart1($array) . '<br>' . chr(10);
echo '2) <pre>';
getPart2($array);
echo '</pre>';

function getPart1($array) {
	$x = 1;
	$cycle = 1;
	$sum = 0;

	foreach ($array as $line) {

		$command = explode(' ', $line);
		if ($command[0] == 'noop') {
			if (($cycle+20)%40 == 0) {
				$sum += ($cycle * $x);
			}
			$cycle++;
		} else {
			if (($cycle+20)%40 == 0) {
				$sum += ($cycle * $x);
			} elseif (($cycle+21)%40 == 0) {
				$sum += (($cycle+1) * $x);
			}

			$cycle += 2;
			$x += (int) $command[1];
		}
	}

	return $sum;
}

function getPart2($array) {
	$x = 1;
	$cycle = 1;

	foreach ($array as $line) {
		if (($cycle - 1 - $x) * ($cycle - 1 - $x) < 2) {
			echo 'X';
		} else {
			echo '.';
		}

		$command = explode(' ', $line);
		if ($command[0] == 'noop') {
			if ($cycle%40 == 0) {
				$x += 40;
				echo chr(10);
			}
			$cycle++;
		} else {
			if (($cycle%40) == 0) {
				$x += 40;
				echo chr(10);
			}
			if (($cycle - $x) * ($cycle  - $x) < 2) {
				echo 'X';
			} else {
				echo '.';
			}
			
			if (($cycle+1)%40 == 0) {
				$x += 40;
				echo chr(10);
			}

			$cycle += 2;
			$x += (int) $command[1];
		}
	}
}
