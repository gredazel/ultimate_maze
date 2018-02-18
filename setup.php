<?php
session_start();
if (!isset($_SESSION['username'])) {
	header('Location: index.php');
}
if (!isset($_POST['name']) && !isset($_SESSION['labirinto'])) {
	if (isset($_POST['sfida'])) {
		$pointer = fopen('./data/sfide.json', 'r');
		$tuttoilfile = fread($pointer, filesize('./data/sfide.json'));
		fclose($pointer);
		$sfide = json_decode($tuttoilfile, true);
		$sfida = $sfide[$_POST['sfida']];
		$_SESSION['sfida'] = $_POST['sfida'];
		$_SESSION['labirinto'] = $sfida['labirinto'];
		$_SESSION['avversario'] = $sfida['utente1'];
	} else {
		header('Location: home.php');
	}
}
$_SESSION['labirinto'] = isset($_SESSION['labirinto']) ? $_SESSION['labirinto'] : $_POST['name'];
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
			<div class="d-flex">
				<a href="play.php" class="btn btn-primary margin-auto">Quando sei pronto, clicca; partirà il timer!</a>
			</div>
		</div>
	</body>
</html>
