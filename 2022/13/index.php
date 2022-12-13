<?php

class Day {

	private $data = [];

	function __construct() {
		$array = explode(chr(10), file_get_contents('input.txt'));

		foreach($array as $row => $line) {
			if (($row+1)%3==0) continue;

			$this->data[] = json_decode($line);
		}
	}

	public function getPart1() {
		$count = 0;
		for ($i = 0; $i < count($this->data) / 2; $i++) {
			if ($this->isOrderRight($this->data[($i*2)], $this->data[($i*2)+1]) < 1) {
				$count += ($i+1);
			}
		}

		return $count;
	}

	public function getPart2() {
		$array = $this->data;
		$array[] = [[2]];
		$array[] = [[6]];
		usort($array, [Day::class, 'isOrderRight']);

		$product = 1;
		foreach ($array as $row => $curArray) {
			if ($curArray == [[2]]) {
				$product *= ($row+1);
			}
			if ($curArray == [[6]]) {
				return ($product * ($row+1));
			}
		}
	}

	private static function isOrderRight($lineLeft, $lineRight) {
		if (empty($lineLeft)) {
			if (empty($lineRight)) {
				return 0;
			} else {
				return -1;
			}
		}

		foreach ($lineLeft as $key => $element) {
			if (!isset($lineRight[$key])) {
				return 1;
			}
			if (is_array($element)) {
				if (is_array($lineRight[$key])) {
					$order = self::isOrderRight($lineLeft[$key], $lineRight[$key]);
					if ($order != 0) {
						return $order;
					}
				} else {
					$order = self::isOrderRight($lineLeft[$key], [$lineRight[$key]]);
					if ($order != 0) {
						return $order;
					}
				}
			} elseif (is_array($lineRight[$key])) {
				$order = self::isOrderRight([$lineLeft[$key]], $lineRight[$key]);
				if ($order != 0) {
					return $order;
				}
			} else {
				if ($element < $lineRight[$key]) {
					return -1;
				} elseif ($element > $lineRight[$key]) {
					return 1;
				}
			}
		}

		if (count($lineLeft) < count($lineRight)) {
			return -1;
		}

		return 0;
	}

}

$day = new Day();

echo '1) ' . $day->getPart1() . '<br>' . chr(10);
echo '2) ' . $day->getPart2() . chr(10);
