<?php
session_start();
echo '<pre>',var_dump($_SESSION),'</pre>';
$pointer = fopen('./data/sfide.json', 'r');
$sfide = fread($pointer, filesize('./data/sfide.json'));
fclose($pointer);
$sfide = json_decode($sfide, true);
if (isset($_SESSION['sfida'])) { //se è una risposta e non una sfida appena lanciata
	$sfide[$_SESSION['sfida']]['tempo2'] = $_SESSION['timer'];
	$sfide[$_SESSION['sfida']]['mosse2'] = $_SESSION['mosse'];
	if ($sfide[$_SESSION['sfida']]['tempo2'] < $sfide[$_SESSION['sfida']]['tempo1']) {
		$sfide[$_SESSION['sfida']]['vincitore'] = $sfide[$_SESSION['sfida']]['utente2'];
	} elseif($sfide[$_SESSION['sfida']]['tempo2'] > $sfide[$_SESSION['sfida']]['tempo1']) {
		$sfide[$_SESSION['sfida']]['vincitore'] = $sfide[$_SESSION['sfida']]['utente1'];
	} else {
		$sfide[$_SESSION['sfida']]['vincitore'] = null;
	}
} else {
	$sfide[] = [
		'utente1' => $_SESSION['username'],
		'utente2' => $_SESSION['avversario'],
		'mosse1' => $_SESSION['mosse'],
		'tempo1' => $_SESSION['timer'],
		'labirinto' => $_SESSION['labirinto']
	];
}
$pointer = fopen('./data/sfide.json', 'w');
fwrite($pointer, json_encode($sfide, JSON_PRETTY_PRINT));
fclose($pointer);
header('Location: home.php');
unset($_SESSION['labirinto']);
unset($_SESSION['avversario']);
unset($_SESSION['mosse']);
unset($_SESSION['timer']);
unset($_SESSION['posizione']);
