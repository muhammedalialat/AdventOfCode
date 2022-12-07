<?php

$input = file_get_contents('input.txt');

$array = explode(chr(10), $input);
$fs = getFileSystem($array);

echo '1) ' . getPart1($fs) . '<br>' . chr(10);
echo '2) ' . getPart2($fs);

function getPart1($fs) {
	$dirs = 0;
	$found = false;
	
	$files = getSumOfDir($fs);
	foreach ($fs as $entry) {
		if (is_array($entry)) {
			$found = true;
			$dirs += getPart1($entry);
		}
	}
	
	if ($found) {
		if ($files < 100000) {
			return ($files + $dirs);
		}
		return $dirs;
	} else {
		if ($files < 100000) {
			return $files;
		}
	}
	
	return 0;
}

function getPart2($fs) {
	$found = getSumOfDir($fs);
	$todelete = $found - 40000000;

	return getSumForPart2($fs, $todelete, $found);
}

function getSumForPart2($fs, $size, $found) {

	$files = getSumOfDir($fs);
	if ($files > $size) {
		if ($found > $files) {
			$found = $files;
		}
	}

	foreach ($fs as $entry) {
		if (is_array($entry)) {
			$found = getSumForPart2($entry, $size, $found);
		}
	}

	return $found;
}
function getSumOfDir($fs) {
	$sum = 0;

	foreach($fs as $entry) {
		if (is_array($entry)) {
			$sum += getSumOfDir($entry);
		} else {
			$sum += $entry;
		}
	}

	return $sum;
}

function getFileSystem($array) {
	$fs = [];
	$path = [];
	foreach($array as $line) {
		$command = explode(' ', $line);

		if ($command[0] == '$') {
			if ($command[1] == 'cd') {
				if ($command[2] == '/') {
					$path = [];
				} elseif ($command[2] == '..') {
					array_pop($path);
				} else {
					$path[] = $command[2];
				}
			}
		} else {
			$curArray = &$fs;
			foreach ($path as $dir) {
				$curArray = &$curArray[$dir];
			}

			if ($command[0] == 'dir') {
				$curArray[$command[1]] = [];
			} else {
				$curArray[$command[1]] = (int)$command[0];
			}
		}
	}

	return $fs;
}
