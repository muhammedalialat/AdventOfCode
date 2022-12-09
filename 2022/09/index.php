<?php

$input = file_get_contents('input.txt');
$array = explode(chr(10), $input);

echo '1) ' . getPart1($array) . '<br>' . chr(10);
echo '2) ' . getPart2($array);

function getPart1($array) {
	$visits = [
		0 => [0 => true]
	];

	$head = [0,0];
	$tail = [0,0];

	foreach ($array as $line) {
		$instruction = explode(' ', $line);
		for ($i = 0; $i < $instruction[1]; $i++) {
			$head = walkHead($head, $instruction[0]);
			$tail = getPositionTail($tail, $head);
			$visits[$tail[0]][$tail[1]] = true;
		}
	}

	$count = 0;
	foreach ($visits as $visitedRow) {
		$count += count($visitedRow);
	}
	return $count;
}

function getPart2($array) {
	$visits = [
		0 => [0 => true]
	];

	$parts = [
		[0,0],
		[0,0],
		[0,0],
		[0,0],
		[0,0],
		[0,0],
		[0,0],
		[0,0],
		[0,0],
		[0,0]
	];

	foreach ($array as $line) {
		$instruction = explode(' ', $line);
		for ($i = 0; $i < $instruction[1]; $i++) {
			$parts[0] = walkHead($parts[0], $instruction[0]);
			for ($j = 1; $j < 10; $j++) {
				$parts[$j] = getPositionTail($parts[$j], $parts[$j-1]);
			}
			$visits[$parts[9][0]][$parts[9][1]] = true;
		}
	}

	$count = 0;
	foreach ($visits as $visitedRow) {
		$count += count($visitedRow);
	}

	return $count;
}

function walkHead($position, $direction) {
	switch ($direction) {
		case 'U': $position[1]++; break;
		case 'D': $position[1]--; break;
		case 'R': $position[0]++; break;
		case 'L': $position[0]--; break;
	}

	return $position;
}

function getPositionTail($tail, $head) {
	if ($head[0] == $tail[0]) {
		if ($head[1] == $tail[1]) {
			return $tail;
		}
		if (($head[1] - $tail[1]) > 1) {
			$tail[1]++;
			return $tail;
		}
		if (($head[1] - $tail[1]) < -1) {
			$tail[1]--;
			return $tail;
		}
		return $tail;
	}
	if ($head[1] == $tail[1]) {
		if (($head[0] - $tail[0]) > 1) {
			$tail[0]++;
			return $tail;
		}
		if (($head[0] - $tail[0]) < -1) {
			$tail[0]--;
			return $tail;
		}
		return $tail;
	}

	if (($head[0] - $tail[0]) == 2) {
		$tail[0]++;
		if (($head[1] - $tail[1]) == 2) {
			$tail[1]++;
		} elseif (($head[1] - $tail[1]) == -2) {
			$tail[1]--;
		} else {
			$tail[1] = $head[1];
			return $tail;
		}
	}

	if (($head[0] - $tail[0]) == -2) {
		$tail[0]--;
		if (($head[1] - $tail[1]) == 2) {
			$tail[1]++;
		} elseif (($head[1] - $tail[1]) == -2) {
			$tail[1]--;
		} else {
			$tail[1] = $head[1];
			return $tail;
		}
		
	}

	if (($head[1] - $tail[1]) == 2) {
		$tail[0] = $head[0];
		$tail[1]++;
		return $tail;
		
	}

	if (($head[1] - $tail[1]) == -2) {
		$tail[0] = $head[0];
		$tail[1]--;
		return $tail;
	}

	return $tail;
}
