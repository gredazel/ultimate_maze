<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<form name=form1 action=sasso.php method="POST">
		<div class="intro" style="margin-left:555px; font-size:20px;">
			<p>Scelta turno giocatore:</p>
		</div>
			<hr width=50% size=1 color=#C0C0C0>
			<div class="inizio" style="font-size:20px;">
				<label>Clicca</label>
				<input type="submit" name="submit" id="submit" value="start"/>
				<label>per vedere un sasso, carta e forbice automatico</label>
			</div>
<?php
	if(isset($_POST['submit'])){
		$giocatore1=rand(1,3);
		$giocatore2=rand(1,3);

		if($giocatore1==1){
			?><div class="giocatore1" style="margin-left:41%;"><img src="media/sasso.png" width="100px" height="100px"></div><?php
		}
		if($giocatore1==2){
			?><div class="giocatore1" style="margin-left:41%;"><img src="media/carta.png" width="100px" height="100px"></div><?php
		}
		if($giocatore1==3){
			?><div class="giocatore1" style="margin-left:41%;"><img src="media/forbice.png" width="100px" height="100px"></div><?php
		}
		if($giocatore2==1){
			?><div class="giocatore2"><img src="media/sasso.png" width="100px" height="100px"></div><?php
		}
		if($giocatore2==2){
			?><div class="giocatore2"><img src="media/carta.png" width="100px" height="100px"></div><?php
		}
		if($giocatore2==3){
			?><div class="giocatore2"><img src="media/forbice.png" width="100px" height="100px"></div><?php
		}

		if($giocatore1==1 && $giocatore2==1){
			echo "<div class=vincita style='margin-left:620px;'><h4>parit&agrave</h4></div>";
		}
		if($giocatore1==1 && $giocatore2==2){
			echo "<div class=vincita><h4>vince giocatore 2</h4></div>";
		}
		if($giocatore1==1 && $giocatore2==3){
			echo "<div class=vincita><h4>vince giocatore1</h4></div>";
		}
		if($giocatore1==2 && $giocatore2==1){
			echo "<div class=vincita><h4>vince giocatore1</h4></div>";
		}
		if($giocatore1==2 && $giocatore2==2){
			echo "<div class=vincita style='margin-left:620px;'><h4>parit&agrave</h4></div>";
		}
		if($giocatore1==2 && $giocatore2==3){
			echo "<div class=vincita><h4>vince giocatore2</h4></div>";
		}
		if($giocatore1==3 && $giocatore2==1){
			echo "<div class=vincita><h4>vince giocatore2</h4></div>";
		}
		if($giocatore1==3 && $giocatore2==2){
			echo "<div class=vincita><h4>vince giocatore1</h4></div>";
		}
		if($giocatore1==3 && $giocatore2==3){
			echo "<div class=vincita style='margin-left: 620px;'><h4>parit&agrave</h4></div>";
		}

	}
?>
</form>
</body>
</html>
