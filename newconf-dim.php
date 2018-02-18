<?php
session_start();
?>
<html>
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Nuova configurazione</title>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/basic.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div class="container jumbotron text-center">
			<h4 class="display-5">Creazione labirinto:</h4>
		<?php
			if (empty($_POST) or !isset($_POST['righe']) or !isset($_POST['colonne']) or !is_numeric($_POST['righe']) or !is_numeric($_POST['colonne'])): ?>
			<p>Scegli le dimensioni della griglia di gioco</p>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
				<div class="smallinputs">
					<div class="input-group">
						<input id="colonne" type="number" name="colonne" class="form-control" min-value="0"/>
						<div class="input-group-addon">
							Colonne
						</div>
					</div>
				</div>
				<div class="smallinputs">
					<div class="input-group">
						<div class="input-group-addon">
							Righe
						</div>
						<input id="righe" type="number" name="righe" class="form-control" min-value="0"/>
					</div>
				</div>
				<button class="btn btn-primary" type="submit">Continua</button>
			</form>
		<?php else:
			$_SESSION['righe'] = intval($_POST['righe']);
			$_SESSION['colonne'] = intval($_POST['colonne']);
			header('Location: newconf-muri.php');
			endif; ?>
		</div>
	</body>
</html>
