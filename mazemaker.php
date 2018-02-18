<?php
session_start();
?>
<html>
	<head>
		<title>Automatico</title>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/basic.css" rel="stylesheet" type="text/css"/>
	</head>
	<body style="background-color: #ededed;">
		<div class="container">
			<div class="card">
				<div class="card-body">
					<?php
					$w = $_SESSION['colonne'];
					$h = $_SESSION['righe']; # va a prendere le dimensioni dalla sessione
					function arethereunvisitedcells($arr) {
						# funzione per verificare la presenza di celle mai visitate nell'algoritmo di generazione labirinto
						$w = $_SESSION['colonne'];
						$h = $_SESSION['righe'];
						$bool = 0;
						for ($i = 0; $i < $h; $i ++) {
							for ($j = 0; $j < $w; $j++) {
								if ($arr[$i][$j]['visited'] == false) {
									return true;
								}
							}
						}
						return false;
					}

					for ($i = 0; $i < $h; $i ++) { #inizializzo la $griglia con tutti i muri
						for ($j = 0; $j < $w; $j++) {
							$griglia[$i][$j] = [
								"N" => $i > 0,
								"E" => $j < $w-1,
								"S" => $i < $h-1,
								"O" => $j > 0,
								"visited" => false
							];
						}
					}
					$griglia[0][0]['visited'] = true;
					$y = 0;
					$x = 0;
					$stack = [];
					# algoritmo preso da wikipedia e trasformato in php https://en.wikipedia.org/wiki/Maze_generation_algorithm
					while ($res = arethereunvisitedcells($griglia)) {
						$muri = $griglia[$y][$x];
						unset($muri['visited']);
						foreach ($muri as $key => $muro) {
							if (!$muro) {
								unset($muri[$key]);
							} else {
								switch ($key) {
									case "N":
										if ($griglia[$y-1][$x]["visited"]) {
											unset($muri[$key]);
										}
										break;
									case "E":
										if ($griglia[$y][$x+1]["visited"]) {
											unset($muri[$key]);
										}
										break;
									case "S":
										if ($griglia[$y+1][$x]["visited"]) {
											unset($muri[$key]);
										}
										break;
									case "O":
										if ($griglia[$y][$x-1]["visited"]) {
											unset($muri[$key]);
										}
										break;
								}
							}
						}
						if (empty($muri)) {
							$pop = array_pop($stack);
							$y = $pop[0];
							$x = $pop[1];
						} else {
							$stack[] = [$y, $x];
							$min = 1;
							$max = count($muri);
							$chosen = rand($min, $max);
							foreach ($muri as $key => $muro) {
								$chosen--;
								if ($chosen == 0) {
									$griglia[$y][$x][$key] = false;
									switch ($key) {
										case "N":
											$y = $y-1;
											$griglia[$y][$x]["S"] = false;
											$griglia[$y][$x]["visited"] = true;
											break;
										case "E":
											$x = $x+1;
											$griglia[$y][$x]["O"] = false;
											$griglia[$y][$x]["visited"] = true;
											break;
										case "S":
											$y = $y+1;
											$griglia[$y][$x]["N"] = false;
											$griglia[$y][$x]["visited"] = true;
											break;
										case "O":
											$x = $x-1;
											$griglia[$y][$x]["E"] = false;
											$griglia[$y][$x]["visited"] = true;
											break;
									}
									break;
								}
							}
						}
					}
					$w = $_SESSION['colonne'];
					$h = $_SESSION['righe'];
					$bool = 0;
					for ($i = 0; $i < $h; $i ++) {
						for ($j = 0; $j < $w; $j++) {
							unset($griglia[$i][$j]['visited']);
						}
					}
					$pointer = fopen('./data/conf.json', 'r');
					$confs = fread($pointer, filesize('./data/conf.json'));
					fclose($pointer);
					$confs = json_decode($confs, true);
					$confs[isset($_POST['nome']) ? $_POST['nome'] : "casuale".rand(0, 2000)] = $griglia;
					$pointer = fopen('./data/conf.json', 'w');
					fwrite($pointer, json_encode($confs, JSON_PRETTY_PRINT));
					fclose($pointer);
					header('Location: home.php');
					?>
				</div>
			</div>
		</div>
	</body>
</html>
