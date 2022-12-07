<?php

$input = file_get_contents('input.txt');

echo '1) ' . getResult($input, 4) . '<br>' . chr(10);
echo '2) ' . getResult($input, 14);

function getResult($input, $length) {
	for ($i = ($length - 1); $i < strlen($input); $i++) {
		$sequence = substr($input, ($i-$length), $length);
		$chars = [];
		$found = false;

		for ($j = 0; $j < $length; $j++) {
			$char = substr($sequence, $j, 1);
			if (empty($chars[$char])) {
				$chars[$char] = true;
			} else {
				$found = true;
				break;
			}
		}

		if ($found) {
			continue;
		}

		return $i;
	}
}
