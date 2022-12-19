<?php
class Day {

	private $directions = [[-1,0,0],[1,0,0],[0,-1,0],[0,1,0],[0,0,-1],[0,0,1]];
	private $data = [];
	private $outside = [];
	private $visits = [];

	function __construct() {
		$array = explode(PHP_EOL, file_get_contents('input.txt'));

		foreach ($array as $line) {
			$coords = explode(',', $line);
			$this->data[$coords[0]][$coords[1]][$coords[2]] = true;
		}
	}

	public function getPart1() {
		$count = 0;
		foreach ($this->data as $x => $yz) {
			foreach ($yz as $y => $zCubes) {
				foreach (array_keys($zCubes) as $z) {
					foreach ($this->directions as $dxyz) {
						if (empty($this->data[$x+$dxyz[0]][$y+$dxyz[1]][$z+$dxyz[2]])) {
							$count++;
						}
					}
				}
			}
		}

		return $count;
	}

	public function getPart2() {
		$count = 0;
		for ($i = 0; $i < 20; $i++) {
			for ($j = 0; $j < 20; $j++) {
				$this->outside[-1][$i][$j] = true;
				$this->outside[-1][$j][$i] = true;
				$this->outside[$i][-1][$j] = true;
				$this->outside[$j][-1][$i] = true;
				$this->outside[$i][$j][-1] = true;
				$this->outside[$j][$i][-1] = true;

				$this->outside[20][$i][$j] = true;
				$this->outside[20][$j][$i] = true;
				$this->outside[$i][20][$j] = true;
				$this->outside[$j][20][$i] = true;
				$this->outside[$i][$j][20] = true;
				$this->outside[$j][$i][20] = true;
			}
		}

		for ($ix = 0; $ix < 20; $ix++) {
			for ($iy = 0; $iy < 20; $iy++) {
				for ($iz = 0; $iz < 20; $iz++) {
					$this->outside[$ix][$iy][$iz] = false;
				}
			}
		}

		foreach ($this->data as $x => $yz) {
			foreach ($yz as $y => $zCubes) {
				foreach (array_keys($zCubes) as $z) {
					foreach ($this->directions as $dxyz) {
						if (empty($this->data[$x+$dxyz[0]][$y+$dxyz[1]][$z+$dxyz[2]])) {
							$this->visits = [];
							if ($this->isOutside($x+$dxyz[0], $y+$dxyz[1], $z+$dxyz[2])) {
								$count++;
							}
						}
					}
				}
			}
		}

		return $count;
	}

	private function isOutside($x, $y, $z) {
		if($this->outside[$x][$y][$z]) {
			return true;
		}

		foreach ($this->directions as $dxyz) {
			if($this->outside[$x+$dxyz[0]][$y+$dxyz[1]][$z+$dxyz[2]]) {
				$this->outside[$x][$y][$z] = true;
				return true;
			}
		}

		foreach ($this->directions as $dxyz) {
			if (empty($this->visits[$x+$dxyz[0]][$y+$dxyz[1]][$z+$dxyz[2]])) {
				if (empty($this->data[$x+$dxyz[0]][$y+$dxyz[1]][$z+$dxyz[2]])) {
					$this->visits[$x+$dxyz[0]][$y+$dxyz[1]][$z+$dxyz[2]] = true;
					if ($this->isOutside($x+$dxyz[0], $y+$dxyz[1], $z+$dxyz[2])) {
						$this->outside[$x][$y][$z] = true;
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
