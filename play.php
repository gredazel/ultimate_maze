<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['labirinto']) && isset($_SESSION['avversario'])) {
	$pointer = fopen('./data/conf.json', 'r');
	$tuttoilfile = fread($pointer, filesize('./data/conf.json'));
	fclose($pointer);
	$labirinto = json_decode($tuttoilfile, true)[$_SESSION['labirinto']];
	if (isset($_SESSION['mosse'])) {
		$old_i = $_SESSION['posizione'][0];
		$old_j = $_SESSION['posizione'][1];
		if (isset($_POST['cella_cliccata'])) {
			$pos = explode('_', $_POST['cella_cliccata']);
			$i = $pos[0];
			$j = $pos[1];
			$passa = false;
			if ($i == $old_i) {
				$passa = true;
				// siamo sulla stessa riga
				if ($j < $old_j) {
					//stiamo andando a sinistra
					while ($old_j > $j) {
						//echo intval($labirinto[$old_i][$old_j]['O']);
						$passa = !$labirinto[$old_i][$old_j]['O'] && $passa;
						$old_j--;
					}
				}
				if ($j > $old_j) {
					//stiamo andando a sinistra
					while ($old_j < $j) {
						$passa = !$labirinto[$old_i][$old_j]['E'] && $passa;
						$old_j++;
					}
				}
			} elseif ($j == $old_j) {
				$passa = true;
				// siamo sulla stessa colonna
				if ($i < $old_i) {
					//stiamo andando in alto
					while ($old_i > $i) {
						$passa = !$labirinto[$old_i][$old_j]['N'] && $passa;
						$old_i--;
					}
				}
				if ($i > $old_i) {
					//stiamo andando in basso
					while ($old_i < $i) {
						$passa = !$labirinto[$old_i][$old_j]['S'] && $passa;
						$old_i++;
					}
				}
			}
			if ($passa) {
				$_SESSION['posizione'] = [$i, $j];
				$_SESSION['mosse']++;
				$h = count($labirinto);
				$w = count($labirinto[0]);
				if ($i == $h-1 && $j == $w-1) {
					$_SESSION['timer'] = strtotime(date('Y-m-d H:i:s')) - strtotime($_SESSION['timer']);
					header("Location: finito.php");
				}
			}
		}
	} else {
		//è proprio il primo primo primo primo turno
		$_SESSION['timer'] = date('Y-m-d H:i:s');
		$_SESSION['mosse'] = 0;
		$_SESSION['posizione'] = [0, 0];
	}
?>
<html>
	<head>
		<title>Veloce!</title>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/basic.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div class="d-flex my-navbar">
			<a href="home.php" class="btn btn-primary mr-auto btn-home">Home</a>
			<a href="logout.php" class="logout ml-auto btn btn-primary">Log out</a>
		</div>
		<div class="container jumbotron text-center">
			<div class="row">
				<div class="col-xs-12">
					<form action="play.php" method="POST">
						<table class="walls-table">
							<tbody>
							<?php
							$i = 0;
							$h = count($labirinto);
							foreach ($labirinto as $riga) {
								$j = 0;
								$w = count($riga);
								?>
								<tr>
									<?php
									foreach ($riga as $cella) {
										$class = " class='isacell'";
										if ($i == $_SESSION['posizione'][0] && $j == $_SESSION['posizione'][1]) {
											//la cella 0:0 deve essere rossa
											$class = " class='targetcell'";
										}
										if (($i == $h - 1) && ($j == $w - 1)) {
											//anche la cella in basso a destra deve essere rossa
											$class = " class='arrivecell'";
										}
										$style = "";
										if ($cella["N"]) {
											$style .= "border-top: 1px solid black;";
										}
										if ($cella["S"]) {
											$style .= "border-bottom: 1px solid black;";
										}
										if ($cella["E"]) {
											$style .= "border-right: 1px solid black;";
										}
										if ($cella["O"]) {
											$style .= "border-left: 1px solid black;";
										}
										echo "<td style='".$style."' riga='$i' colonna='$j' $class><input type='submit' value='".$i."_".$j."' name='cella_cliccata' class='bottoncella'/></td>";
										$j++;
									}
									$i++;
									?>
								</tr>
							<?php
							}
							?>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
} else {
	header('Location: index.php');
}
