<?php
session_start();
$counter = 0; #vittorie dell'utente loggato
if (!isset($_SESSION['username'])) {
	# se l'utente non ha una sessione viene mandato a fare il login
	header("Location: index.php");
} else {
	# viene letto il file di utenti per capire se l'utente che sta accedendo va registrato
	$pointer = fopen('./data/users.json', 'r');
	$tuttoilfile = fread($pointer, filesize('./data/users.json'));
	$utenti = json_decode($tuttoilfile, true);
	# è anche un pretesto per mettere in $utenti la lista di utenti che servirà in fondo alla pagina
	if (isset($utenti[$_SESSION['username']])) {
		# se l'utente ha appena effettuato l'accesso per la prima volta non avrà alcuna sfida in attesa
		$pointer = fopen('./data/sfide.json', 'r');
		$tuttoilfile = fread($pointer, filesize('./data/sfide.json'));
		fclose($pointer);
		$sfide = json_decode($tuttoilfile, true);
		foreach ($sfide as $id => $sfida) {
			if ($sfida['utente2'] == $_SESSION['username'] && !isset($sfida['vincitore'])) { //sfida ricevuta dall'utente loggato
				# in questo array finiscono tutte le sfide RICEVUTE dall'utente loggato E NON TERMINATE (prive di vincitore)
				$sfide_giocabili[$id] = $sfida;
			} elseif ($sfida['utente1'] == $_SESSION['username'] || $sfida['utente2'] == $_SESSION['username']) {
				# in questo array finiscono invece tutte le altre sfide riguardanti questo giocatore
				$sfide_storiche[$id] = $sfida;
				if (isset($sfida['vincitore']) && $_SESSION['username'] == $sfida['vincitore']) {
					$counter++;
				}
			}
		}
	} else { //kind of registrazione
		# basta aggiungerlo in coda al file
		$utenti[$_SESSION['username']] = [];
		$pointer = fopen('./data/users.json', 'w');
		$tuttoilfile = fwrite($pointer, json_encode($utenti, JSON_PRETTY_PRINT));
		fclose($pointer);
	}
?>
<html>
	<head>
		<title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/basic.css" rel="stylesheet" type="text/css"/>
		<!--In questo .js c'è una funzione per mostrare e nascondere i dettagli partita-->
		<script src="js/homefunc.js"></script>
	</head>
	<body>
		<!--Sorta di navbar-->
		<div class="d-flex my-navbar">
			<span class="mr-auto profile">
				<?=$_SESSION['username']?>
				<div class="label label-info"><?=$counter?></div>
			</span>
			<?php
			if (isset($_SESSION['timer'])) {
			?>
			<a href="play.php" class="btn btn-danger margin-auto gip">Hai una partita in corso!</a>
			<?php
			}
			?>
			<a href="logout.php" class="logout ml-auto btn btn-primary">Log out</a>
		</div>
		<div class="container jumbotron">
			<h3>La tua home</h3>
			<div class="row">
				<div class="col-xs-12 col-sm-6">
				<?php
				if (!empty($sfide_storiche)) {
				?>
					<h2>Le sfide che hai sostenuto</h2>
					<div class="list-group">
						<?php
						foreach ($sfide_storiche as $id => $sfida) {
						?>
						<div class="list-group-item d-flex clickable" onclick="build_destroy(this.nextElementSibling)">
							<?=$sfida['utente1'] == $_SESSION['username'] ? $sfida['utente2'] : $sfida['utente1']?>
							<span class="ml-auto label label-<?=isset($sfida['vincitore']) ? ($sfida['vincitore'] == $_SESSION['username'] ? "success" : "danger") : "warning"?>"><?=$sfida['labirinto']?></span>
						</div>
						<div class="collassato">
							Hai impiegato <?=$_SESSION['username'] == $sfida['utente1'] ? $sfida['tempo1'] : $sfida['tempo2']?> secondi (un totale di <?=$_SESSION['username'] == $sfida['utente1'] ? $sfida['mosse1'] : $sfida['mosse2']?> mosse). <br>
							<?php
							if (isset($sfida['tempo2'])) {
							?>
							Il tuo avversario ha impiegato <?=$_SESSION['username'] == $sfida['utente2'] ? $sfida['tempo1'] : $sfida['tempo2']?> secondi (un totale di <?=$_SESSION['username'] == $sfida['utente2'] ? $sfida['mosse1'] : $sfida['mosse2']?> mosse).
							<?php
							}
							?>
						</div>
						<?php
						} // endforeach ($sfide_storiche as $id => $sfida)
						?>
					</div>
				<?php
				} // endif (!empty($sfide_storiche))
				?>
				</div>
				<div class="col-xs-12 col-sm-6">
					<?php
					if (!empty($sfide_giocabili)) {
					?>
					<h2>Hai ricevuto delle sfide!</h2>
					<form method="POST" action="setup.php">
						<div class="list-group">
							<?php
							foreach ($sfide_giocabili as $id => $sfida) {
							?>
							<button class="list-group-item d-flex" value="<?=$id?>" name="sfida">
								<?=$sfida['utente1']?>
								<span class="ml-auto label label-info"><?=$sfida['labirinto']?></span>
							</button>
							<?php
							}
							?>
						</div>
					</form>
					<?php
					} // endif (!empty($sfide_giocabili))
					?>
				</div>
			</div>
			<h3>Sfida gli altri utenti!</h3>
			<div class="row">
				<div class="col-xs-12">
					<div class="list-group">
						<form method="post" action="sfida.php">
						<?php
						foreach ($utenti as $utente => $dati) {
							if ($utente != $_SESSION['username']) {
								$counter = 0;
								if (!empty($sfide)) {
									foreach ($sfide as $sfida) {
										if (isset($sfida['vincitore']) && $utente == $sfida['vincitore']) {
											$counter++;
										}
									}
								}
								# per ogni altro utente con cui si potrebbe giocare viene un badge con il loro numero di vittorie totali
								?>
								<button name="avversario" value="<?=$utente?>" class="list-group-item">
									<?=$utente?>
									<span class="badge"><?=$counter?></span>
								</button>
							<?php
							}
						} // endforeach ($utenti as $utente => $dati)
						?>
						</form>
					</div>
				</div>
			</div>
			<hr class="my-4"/>
			<p class="lead">Ti annoi?</p>
			<div class="d-flex">
				<a href="sasso.php" class="margin-auto btn btn-success">Gioca a sasso carta e forbice!</a>
			</div>
		</div>
	</body>
</html>
<?php } //endif
