<?php
	session_start();
	# condizione per effettuare il login:
		# la sessione è vuota o manca la username (improbabile che succeda la seconda senza la prima)
		# non c'è il campo username nella richiesta (quindi è la prima volta nella pagina)
	if ((empty($_SESSION) || !isset($_SESSION['username'])) && !isset($_POST['username'])) { ?>
<html>
	<head>
		<title>Log in</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!--Bootstrap è una libreria front-end di css e js (non abbiamo usato js però)-->
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="css/basic.css" rel="stylesheet" type="text/css"/>
	</head>
	<body style="background-color: #ededed">
		<div class="container jumbotron text-center smallinputs">
			<div class="card">
				<div class="card-heading">
					<h2>Effettua l'accesso</h2>
				</div>
				<div class="card-body">
					<!--Questo form richiama la pagina stessa per inserire in sessione QUI la username-->
					<!--Ok, non c'è una password, per cui si sarebbe potuto fare nella home-->
					<!--Però qui è più semplice perché nella home arrivano richieste post anche di altre pagine-->
					<form action="index.php" method="POST">
						<div class="input-group">
							<input type="text" class="form-control" name="username" required/>
							<span class="input-group-addon">
								User
							</span>
						</div>
						<div class="d-flex">
							<input type="submit" class="btn btn-primary margin-auto" value="Accedi"/>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
	<?php } else {
		# inserire in sessione il nome con cui si vuole accedere
		if (isset($_POST['username'])) {
			$_SESSION['username'] = $_POST['username'];
		}
		#reindirizzare alla home per questo utente
		header("Location: home.php");
	}
