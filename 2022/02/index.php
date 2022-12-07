<?php

$input = file_get_contents('input.txt');

$array = explode(chr(10), $input);
$score1 = 0;
$score2 = 0;

foreach ($array as $value) {
	$score1 += getScore($value[0], $value[2]);
	$score2 += getScorePart2($value[0], $value[2]);
}

echo '1) ' . $score1 . '<br>';
echo '2) ' . $score2;


function getScorePart2 ($first, $second) {
	if ('A' == $first) {
		if ('X' == $second ) {
			return (3+0);
		}
		if ('Y' == $second ) {
			return (1+3);
		}
		if ('Z' == $second ) {
			return (2+6);
		}
	}
	if ('B' == $first) {
		if ('X' == $second ) {
			return (1+0);
		}
		if ('Y' == $second ) {
			return (2+3);
		}
		if ('Z' == $second ) {
			return (3+6);
		}
	}
	if ('C' == $first) {
		if ('X' == $second ) {
			return (2+0);
		}
		if ('Y' == $second ) {
			return (3+3);
		}
		if ('Z' == $second ) {
			return (1+6);
		}
	}
	
}

function getScore ($first, $second) {
	if ('A' == $first) {
		if ('X' == $second ) {
			return (1+3);
		}
		if ('Y' == $second ) {
			return (2+6);
		}
		if ('Z' == $second ) {
			return (3+0);
		}
	}
	if ('B' == $first) {
		if ('X' == $second ) {
			return (1+0);
		}
		if ('Y' == $second ) {
			return (2+3);
		}
		if ('Z' == $second ) {
			return (3+6);
		}
	}
	if ('C' == $first) {
		if ('X' == $second ) {
			return (1+6);
		}
		if ('Y' == $second ) {
			return (2+0);
		}
		if ('Z' == $second ) {
			return (3+3);
		}
	}
	
}

