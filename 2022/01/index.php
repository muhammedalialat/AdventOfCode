<?php

$input = file_get_contents('input.txt');

$array = explode(chr(10), $input);

$elfs = [0];

foreach ($array as $value) {
	$value = trim($value);
	if (empty($value)) {
		$elfs[count($elfs)] = 0;
	} else {
		$elfs[count($elfs) - 1] += (int) $value;
	}
}

sort($elfs);

echo ($elfs[count($elfs) - 1] + $elfs[count($elfs) - 2] + $elfs[count($elfs) - 3]);
