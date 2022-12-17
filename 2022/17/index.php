<?php
class Day {

	private $data = [];

	function __construct() {
		$this->data['figure'][0] = [[true, true, true, true]];
		$this->data['figure'][1] = [[false, true, false], [true, true, true], [false, true, false]];
		$this->data['figure'][2] = [[true, true, true], [false, false, true], [false, false, true]];
		$this->data['figure'][3] = [[true], [true], [true], [true]];
		$this->data['figure'][4] = [[true, true], [true, true]];

		$line = file_get_contents('input.txt');
		$this->data['pushes'] = [];
		for ($i = 0; $i < strlen($line); $i++) {
			$this->data['pushes'][] = substr($line, $i, 1) == '<';
		}

		$this->data['grid'] = [];
		$this->data['push'] = 0;
	}

	public function getPart1() {
		for ($i = 0; $i < 2022; $i++) {
			$pos = $this->getCoordinates($i%5);
			foreach ($this->data['figure'][$i%5] as $row => $columns) {
				foreach ($columns as $cell => $filled) {
					if ($filled) {
						$this->data['grid'][$pos[0] + $row][$pos[1] + $cell] = true;
					}
				}
			}
		}

		return count($this->data['grid']);
	}

	public function getPart2() {
		$this->data['grid'] = [];
		$this->data['push'] = 0;

		$pattern = [];
		$rest = 1000000000000;

		$patternHeight = 0;
		for ($i = 0; $i < $rest; $i++) {
			if ($i%5 == 0 && $patternHeight == 0) {
				if (empty($pattern[$this->data['push']])) {
					$pattern[$this->data['push']] = [1, 0];
				} elseif ($pattern[$this->data['push']][0] == 2) {
					$rounds = $i - $pattern[$this->data['push']][2];
					$turns = floor(($rest-$i) / $rounds);
					$patternHeight = $turns * (count($this->data['grid']) - $pattern[$this->data['push']][1]);

					$rest -= $turns * $rounds;
				} else {
					$pattern[$this->data['push']] = [2, count($this->data['grid']), $i];
				}
			}

			$pos = $this->getCoordinates($i%5);
			foreach ($this->data['figure'][$i%5] as $row => $columns) {
				foreach ($columns as $cell => $filled) {
					if ($filled) {
						$this->data['grid'][$pos[0] + $row][$pos[1] + $cell] = true;
					}
				}
			}
		}

		return count($this->data['grid']) + $patternHeight;
	}

	private function getCoordinates($figure) {
		$curFigure = $this->data['figure'][$figure];
		$gridHeight = count($this->data['grid']);
		$figureHeight = count($curFigure);
		$height = $gridHeight + 3;
		$left = 2;

		while(true) {
			$movedX = false;
			if ($this->data['pushes'][$this->data['push']]) {
				if ($left > 0) {
					$movedX = true;
					$left--;
				}
			} else {
				if ($left + count($curFigure[0]) < 7) {
					$movedX = true;
					$left++;
				}
			}
			if ($movedX) {
				if ($height - $figureHeight <= $gridHeight) {
					if ($this->hasCollision([$height, $left], $figure)) {
						if ($this->data['pushes'][$this->data['push']]) {
							$left++;
						} else {
							$left--;
						}
					}
				}
			}
			$this->data['push'] = ($this->data['push']+1)%(count($this->data['pushes']));

			$height--;
			if ($height - $figureHeight <= $gridHeight) {
				if ($this->hasCollision([$height, $left], $figure)) {
					return [$height+1, $left];
				}
			}

			if ($height < 0) {
				return [$height+1, $left];
			}
		}
	}

	private function hasCollision($pos, $figure) {
		foreach ($this->data['figure'][$figure] as $row => $columns) {
			foreach ($columns as $cell => $filled) {
				if ($filled) {
					if (empty($this->data['grid'][$pos[0] + $row][$pos[1] + $cell])) {
						continue;
					}
					if ($this->data['grid'][$pos[0] + $row][$pos[1] + $cell]) {
						return true;
					}
				}
			}
		}

		return false;
	}

}

$day = new Day();
echo '1) ' . $day->getPart1() . '<br>' . chr(10);
echo '2) ' . $day->getPart2() . chr(10);
