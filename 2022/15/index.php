<?php
class Day {

	private $data = [];
	private $count = 0;

	function __construct() {
		$array = explode(chr(10), file_get_contents('input.txt'));
		$sensorSortX = [];
		foreach($array as $row => $line) {
			$sensor = explode(',', substr($line, 9, stripos($line, ':') - 9));
			$sensor[0] = (int) substr($sensor[0], 3);
			$sensor[1] = (int) substr($sensor[1], 3);
			$beacon = explode(',', substr($line, stripos($line, ':') + 22 ));
			$beacon[0] = (int) substr($beacon[0], 3);
			$beacon[1] = (int) substr($beacon[1], 3);
			$newBeacon = [$beacon[1], $beacon[0]];
			$sensor[2] = abs($sensor[0] - $beacon[0]) + abs($sensor[1] - $beacon[1]);
			$newSensor = [$sensor[1], $sensor[0], $sensor[2]];
			if (empty($sensorSortX[100 * $sensor[0]])) {
				$sensorSortX[100 * $sensor[0]] = [$newSensor, $newBeacon];
			} else {
				$index = 100 * ($sensor[0] + ($row * 0.01));
				$sensorSortX[$index] = [$newSensor, $newBeacon];
			}
			$this->data['sensor'][] = [$newSensor, $newBeacon];

			$this->data['grid'][$newSensor[0]][$newSensor[1]] = 1;
			$this->data['grid'][$newBeacon[0]][$newBeacon[1]] = 2;
		}

		ksort($sensorSortX); 
		$this->data['sensor'] = array_values($sensorSortX);
	}

	public function getPart1() {
		$target = 2000000;
		foreach ($this->data['sensor'] as $sensor) {
			$this->fillEmpty($sensor[0], $sensor[0][2], $target);
		}

		$count = 0;
		foreach ($this->data['grid'][$target] as $posX) {
			if ($posX != 2) {
				$count++;
			}
		}

		return $count;
	}

	public function getPart2() {
		for ($i = 0; $i < 4000000; $i++) {
			$ranges = [];

			foreach ($this->data['sensor'] as $sensor) {
				$curRange = $this->getRange($sensor[0], $sensor[0][2], $i);
				if ($curRange[0] === false) {
					continue;
				}

				if (count($ranges) == 0) {
					$ranges[$curRange[0]] = $curRange[1];
					continue;
				}

				foreach ($ranges as $start => $end) {
					if ($start <= $curRange[0] && $end >= $curRange[0]) {
						if ($end < $curRange[1]) {
							$ranges[$start] = $curRange[1];
						}
					} elseif ($start <= $curRange[1] && $end >= $curRange[1]) {
						if ($start > $curRange[0]) {
							unset($ranges[$start]);
							$ranges[$curRange[0]] = $end;
							ksort($ranges);
						}
					} elseif($start > $curRange[0] && $end < $curRange[1]) {
						unset($ranges[$start]);
						$ranges[$curRange[0]] = $curRange[1];
						ksort($ranges);
					} else {
						$ranges[$curRange[0]] = $curRange[1];
					}

					$ranges = $this->mergeRanges($ranges);
				}
			}

			if (count($ranges) > 1) {
				$found = array_shift($ranges) + 1;
				return ($i + $found * 4000000);
			}
		}
	}

	private function mergeRanges($ranges) {
		if (count($ranges) < 2) {
			return $ranges;
		}

		$lastStart = false;
		$lastEnd = false;
		foreach ($ranges as $start => $end) {
			if ($lastStart === false) {
				$lastStart = $start;
				$lastEnd = $end;
				continue;
			}
			if ($start <= $lastStart && $end >= $lastEnd) {
				unset($ranges[$start]);
			} elseif ($start >= $lastStart && $end <= $lastEnd) {
				unset($ranges[$lastStart]);
				$lastStart = $start;
				$lastEnd = $end;
			} else {
				$lastStart = $start;
				$lastEnd = $end;
			}
		}

		return $ranges;
	}

	private function fillEmpty($pos, $d, $target) {
		if (($pos[0] - $d) < $target && ($pos[0] + $d) > $target) {
			$dx = $d - abs(($pos[0] - $target));
			for ($i = -$dx; $i <= $dx; $i++) {
				if (empty($this->data['grid'][$target][($pos[1] + $i)])) {
					$this->data['grid'][$target][$pos[1] + $i] = 3;
					$this->count++;
				}
			}
		}
	}

	private function getRange($pos, $d, $target) {
		if (($pos[0] - $d) < $target && ($pos[0] + $d) > $target) {
			$dx = $d - abs(($pos[0] - $target));
			return [max(($pos[1] - $dx), 0), min(($pos[1] + $dx),4000000)];
		}

		return [false, false];
	}
}

$day = new Day();
echo '1) ' . $day->getPart1() . '<br>' . chr(10);
echo '2) ' . $day->getPart2() . chr(10);
