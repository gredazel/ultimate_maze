<?php
session_start();
?>
<html>
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Nuova configurazione</title>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/basic.css" rel="stylesheet" type="text/css"/>
		<script src="js/wallselecter.js"></script>
	</head>
	<body>
		<div class="container jumbotron text-center">
			<h4 class="display-5">Creazione labirinto:</h4>
		<?php
			if (!isset($_POST['wallsdata'])): ?>
			<p>Imposta quali saranno i muri</p>
			<hr class="my-4"/>
			<form method="POST" action="newconf-muri.php">
				<!--
				Questa select qui sotto serve a tenere tutte le celle nella $_POST
				il javascript la manipola per aggiornarne i valori
				-->
				<select name="wallsdata[]" id="wallsdata" class="hidden" multiple>
				<?php
				$w = $_SESSION['colonne'];
				$h = $_SESSION['righe'];
				for ($i = 0; $i < $h; $i++) {
					for ($j = 0; $j < $w; $j++) {
						echo "<option id='opt_".$i."_".$j."' selected value='0'>";
					}
				}
				?>
				</select>
				<input type="text" name="nome" class="form-control" placeholder="Nome labirinto"/>
				<hr class="my-2"/>
				<p class="lead">Clicca <button class="btn btn-primary" type="submit">Continua</button> quando hai fatto</p>
			</form>
			<form action="mazemaker.php" method="POST">
				<div class="smallinputs">
					<h4>Oppure... fallo fare al server (potrebbe venire esageratamente facile)</h4>
					<div class="input-group">
						<input class="form-control" name="nome"/>
						<div class="input-group-addon no-padding"><input type="submit" class="btn btn-danger btn-left-borderless"/></div>
					</div>
			</form>
			<div class="row">
				<div class="col-sm-6">
					<table class="walls-table">
						<tbody>
						<?php
							$w = 2 * $_SESSION['colonne'] - 1;
							$h = 2 * $_SESSION['righe'] - 1;
							for ($i = 0; $i < $h; $i++) {
								echo "<tr>";
								for ($j = 0; $j < $w; $j++) {
									$class = "";
									if ($i % 2 != 0 && $j % 2 != 0) {
										//nelle coordinate di tipo dispari:dispari ci sono gli "angoli"
										$class = " class='unselectable'";
									}
									if ($i % 2 == 0 && $j % 2 == 0) {
										//alle coordinate pari:pari ci sono le celle dove ci si muove.
										$class = " class='isacell'";
										if ($i == 0 && $j == 0) {
											//la cella 0:0 deve essere rossa
											$class = " class='targetcell'";
										}
										if (($i == $h - 1) && ($j == $w - 1)) {
											//anche la cella in basso a destra deve essere rossa
											$class = " class='targetcell'";
										}
									}
									echo "<td riga='$i' colonna='$j' $class></td>";
									// echo "<td riga='$i' colonna='$j'", (($i % 2 != 0) && ($j % 2 != 0)) ? " class='unselectable'" : ((($i % 2 == 0) && ($j % 2 == 0)) ? ((($j == 0 && $i == 0) or ($j == $w - 1 && $i == $h - 1)) ? "class='targetcell'" : " class='isacell'") : "" ),"></td>";
								}
								echo "</tr>";
							}
						?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-6">
					<table>
						<tbody class="preview-table">
							<?php
							$w = $_SESSION['colonne'];
							$h = $_SESSION['righe'];
							for ($i = 0; $i < $h; $i++) {
								echo "<tr>";
								for ($j = 0; $j < $w; $j++) {
									echo "<td id='" . $i . "_" . $j . "' " . (($i == 0 && $j == 0 || ($i == $h - 1 && $j == $w - 1)) ? "class='targetcell'" : "") . "></td>";
								}
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		<?php else:
			$wallsdata = $_POST['wallsdata'];
			$w = $_SESSION['colonne'];
			$h = $_SESSION['righe'];
			$k = 0;
			for ($i = 0; $i < $h; $i++) {
				for ($j = 0; $j < $w; $j++) {
					$muri = isset($wallsdata[$k]) ? $wallsdata[$k] : 0;
					$griglia[$i][$j] = [
						"N" => ($muri & 1) > 0,
						"E" => ($muri & 2) > 0,
						"S" => ($muri & 4) > 0,
						"O" => ($muri & 8) > 0,
					];
					$k++;
				}
			}
			$pointer = fopen('./data/conf.json', 'r');
			$vecchidati = fread($pointer, filesize('./data/conf.json'));
			json_decode($vecchidati, true);
			fclose($pointer);
			$vecchidati[isset($_POST['nome']) ? $_POST['nome'] : "undefined"] = $griglia;
			$pointer = fopen('./data/conf.json', 'w');
			fwrite($pointer, $vecchidati);
			json_encode($vecchidati, JSON_PRETTY_PRINT);
			fclose($pointer);
			header('Location: index.php');
			endif; ?>

		</div>
	</body>
</html>
