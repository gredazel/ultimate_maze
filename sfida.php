<?php
session_start();
if ((isset($_POST['avversario']) || isset($_SESSION['avversario'])) && isset($_SESSION['username'])) {
	$_SESSION['avversario'] = isset($_SESSION['avversario']) ? $_SESSION['avversario'] : $_POST['avversario'];
?>
<html>
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/basic.css" rel="stylesheet" type="text/css"/>
		<title>Labirinto</title>
	</head>
	<body>
		<div class="d-flex my-navbar">
			<a href="home.php" class="btn btn-primary mr-auto btn-home">Home</a>
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
			<h3 class="display-4">Scegli con che configurazione giocare</h3>
			<div class="row">
				<form method="POST" action="setup.php">
					<div class="col-xs-12 list-group">
					<?php
						$pointer = fopen('./data/conf.json', 'r');
						$tuttoilfile = fread($pointer, filesize('./data/conf.json'));
						fclose($pointer);
		                $configurazioni = json_decode($tuttoilfile, true);
						foreach ($configurazioni as $nome => $configurazione) { ?>
						<input type="submit" name="name" value="<?=$nome?>" class="list-group-item"/>
					<?php } ?>
					</div>
				</form>
			</div>
			<hr class="my-5"/>
			<div class="jumbotron text-center">
				<h3>Crea la tua configurazione</h3>
				<p class="lead">I labirinti che ci sono non ti bastano?</p>
				<hr class="my-4"/>
				<a class="btn btn-primary btn-lg" href="newconf-dim.php">Creane uno!</a>
			</div>
		</div>
	</body>
</html>
<?php
} else {
	header('Location: index.php');
}
