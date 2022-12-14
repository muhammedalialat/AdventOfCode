<?php
class Day {

	private $data = [];
	private $sand = [];
	private $ground = 0;

	function __construct() {
		$array = explode(chr(10), file_get_contents('input.txt'));
		foreach($array as $line) {
			$commands = explode(' -> ', $line);
			$last = explode(',', array_shift($commands));
			foreach ($commands as $pos) {
				$coord = explode(',', $pos);

				if ($last[0] == $coord[0]) {
					$from = $last[1];
					$to = $coord[1];
					if ($last[1] > $coord[1]) {
						$from = $coord[1];
						$to = $last[1];
					}
					for ($i = $from; $i <= $to; $i++) {
						$this->data[$i][$last[0]] = true;
					}
				} else {
					$from = $last[0];
					$to = $coord[0];
					if ($last[0] > $coord[0]) {
						$from = $coord[0];
						$to = $last[0];
					}
					for ($i = $from; $i <= $to; $i++) {
						$this->data[$last[1]][$i] = true;
					}
				}

				$last = $coord;
			}
		}
		ksort($this->data);
		$this->ground = array_key_last($this->data);
	}

	public function getPart1() {
		$count = 0;
		$falling = true;

		while($falling) {
			$sand = $this->fallingSand([0,500]);
			if ($sand[0] > $this->ground) {
				$falling = false;
			} else {
				$this->sand[$sand[0]][$sand[1]] = true;
				$count++;
			}
		}

		return $count;
	}

	public function getPart2() {
		$count = 0;
		$falling = true;
		$this->sand = [];

		while($falling) {
			$sand = $this->fallingSand([0,500]);
			if ($sand[0] == 0) {
				$falling = false;
				$count++;
			} else {
				$this->sand[$sand[0]][$sand[1]] = true;
				$count++;
			}
		}

		return $count;
	}

	private function fallingSand($pos) {
		if ($pos[0] > $this->ground) {
			return $pos;
		}
		if ($this->isEmpty([$pos[0]+1, $pos[1]])) {
			return $this->fallingSand([$pos[0]+1, $pos[1]]);
		}
		if ($this->isEmpty([$pos[0]+1, $pos[1]-1])) {
			return $this->fallingSand([$pos[0], $pos[1]-1]);
		}
		if ($this->isEmpty([$pos[0]+1, $pos[1]+1])) {
			return $this->fallingSand([$pos[0], $pos[1]+1]);
		}

		return $pos;
	}

	private function isEmpty($pos) {
		if (!empty($this->data[$pos[0]][$pos[1]])) {
			return false;
		}
		if (!empty($this->sand[$pos[0]][$pos[1]])) {
			return false;
		}

		return true;
	}
}

$day = new Day();
echo '1) ' . $day->getPart1() . '<br>' . chr(10);
echo '2) ' . $day->getPart2() . chr(10);
