<?php
class Day {

	private $data = [];

	function __construct() {
		$array = explode(PHP_EOL, file_get_contents('input.txt'));
		foreach($array as $line) {
			$currentLine = explode(';', $line);
			$name = substr($currentLine[0], 6, 2);
			$rate = substr($currentLine[0], 23);
			$connections = explode(', ', substr($currentLine[1], 24));
			if (count($connections) == 1) {
				$connections = [trim(substr($currentLine[1], 23))];
			}
			$this->data[$name] = [$rate, [$name => 0], $connections];
		}

		foreach ($this->data as $pos => $data) {
			foreach ($data[2] as $destination) {
				$this->data[$pos][1][$destination] = 1;
				$this->getDestinations($pos, $destination);
			}
		}

		$remove = [];
		foreach ($this->data as $pos => $data) {
			if ($pos == 'AA') {
				continue;
			}
			if ($data[0] == 0) {
				unset ($this->data[$pos]);
				$remove[$pos] = true;
			}
		}

		foreach ($this->data as $pos => $data) {
			unset($this->data[$pos][2]);
			foreach (array_keys($remove) as $del) {
				if (empty($data[1][$del])) {
					continue;
				}

				unset ($this->data[$pos][1][$del]);
			}
		}
	}

	private function getDestinations($start, $from) {
		foreach ($this->data[$from][2] as $to) {
			if ($start == $to) {
				continue;
			}
			if (empty($this->data[$start][1][$to])) {
				$this->data[$start][1][$to] = $this->data[$start][1][$from] + 1;
				$this->getDestinations($start, $to);
			} elseif ($this->data[$start][1][$to] > ($this->data[$start][1][$from] + 1)) {
				$this->data[$start][1][$to] = $this->data[$start][1][$from] + 1;
				$this->getDestinations($start, $to);
			}
		}
	}

	public function getPart1() {
		return $this->getCost(30, 'AA', ['AA' => true], 0);
	}

	private function getCost($time, $from, $list, $cost) {
		if ($time == 0) {
			return $cost;
		}

		$max = $cost;
		foreach ($this->data[$from][1] as $destination => $distance) {
			if (!empty($list[$destination])) {
				continue;
			}
			if ($distance + 1 > $time) {
				continue;
			}

			$addCost = ($time - 1 - $distance) * $this->data[$destination][0];
			$newList = $list;
			$newList[$destination] = true;
			$curCost = $this->getCost(($time - 1 - $distance), $destination, $newList, ($cost+$addCost));
			if ($curCost > $max) {
				$max = $curCost;
			}
		}

		return $max;
	}

	public function getPart2() {
		return $this->getCost2([26, 26], ['AA', 'AA'], ['AA' => true], 0);
	}

	private function getCost2($time, $from, $list, $cost) {
		if (count($list) == count($this->data)) {
			return $cost;
		} elseif ($time[0] == 0 && $time[1] == 0) {
			return $cost;
		}

		if ($time[0] < $time[1]) {
			$tempTime = $time[0];
			$time[0] = $time[1];
			$time[1] = $tempTime;
			$tempFrom = $from[0];
			$from[0] = $from[1];
			$from[1] = $tempFrom;
		}

		$max = $cost;
		foreach ($this->data[$from[0]][1] as $destination => $distance) {
			if (!empty($list[$destination])) {
				continue;
			}
			if ($distance + 1 > $time[0]) {
				continue;
			}

			$newList = $list;
			$newList[$destination] = true;
			$addCost1 = ($time[0] - 1 - $distance) * $this->data[$destination][0];

			foreach ($this->data[$from[1]][1] as $destination2 => $distance2) {
				if (!empty($newList[$destination2])) {
					continue;
				}
				if ($distance2 + 1 > $time[1]) {
					continue;
				}

				$addCost2 = ($time[1] - 1 - $distance2) * $this->data[$destination2][0];
				$newList[$destination2] = true;
				$curCost = $this->getCost2([($time[0] - 1 - $distance), ($time[1] - 1 - $distance2)], [$destination, $destination2], $newList, ($cost+$addCost1+$addCost2));
				if ($curCost > $max) {
					$max = $curCost;
				}
				unset($newList[$destination2]);
			}
		}

		return $max;
	}

}

$day = new Day();
echo '1) ' . $day->getPart1() . '<br>' . chr(10);
echo '2) ' . $day->getPart2() . chr(10);
