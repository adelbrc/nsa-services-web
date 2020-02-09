<?php include ('libs/php/isConnected.php');
include('libs/php/db/db_connect.php');?>
<html>
	<head>
		<title>nsa</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="ressources/style/style.css">
	</head>
	<body>
		<?php include 'libs/php/mainHeader.php';
		if (isset($_GET['status']) && $_GET['status'] == 'deconnected') { ?>
			<div class="alert text-center alert-danger" role="alert">
				Vous etes deconnecter !
			</div>
		<?php }
		if (isset($_GET['error']) && $_GET['error'] == 'accessUnauthorized') { ?>
			<div class="alert text-center alert-danger" role="alert">
				Vous n'avez pas le droit d'accéder à cette page.
			</div>
		<?php } ?>
		<div id="video">
					VIDEO
				</div>
				<div id="sommeNous">
					<div class="col-md-6 quiSommeNous">
						<img src="ressources/img/premium-individuel-800x513.jpg" alt="">
					</div>
					<div class="col-md-6 quiSommeNous">
						<h3 id="h3qui">qui sommes nous ?</h3>
						<p id="quiSommeNousTexte">NSA Services est un service de conciergerie privée à destination d’une clientèle haut de gamme, exigeante, pressée, à qui nous offrons l’excellence, la perfection et le sur-mesure.</p>
					</div>
				</div><br>
				<h1 style="text-align:center;">Abonnement individuels</h2>
					<hr class="my-4">

				<div id="abon"class="scrollmenu">
					<?php
					$q = $conn->query('SELECT * FROM membership');
					while($result = $q->fetch()){
					 ?>
					<div class="col-md-4 mx-auto">
						<div class="jumbotron">
						  <h1 class="display-3" style="text-align: center;"><?php echo $result['name']?></h1>
							<hr class="my-4">
							<div>
								<p style="font-size: 22px; color: #00bcd4; text-align:center;"><b><?php echo $result['price']; ?> € TCC/AN </b></p>
							</div>
							<div>
								<p style="font-size: 22px; text-align:center;"><?php echo $result['description']; ?></p>
							</div>
							<div>
								<p style="font-size: 22px; text-align:center;">Ouvert <?php echo $result['openDays']; ?>j/7 de <?php echo $result['openHours']?>H a <?php echo $result['closeHours']; ?>H</p>
							</div>
							<div id="btnInteresser" class="mx-auto">
								<a style="margin-left: 25%;" type="button" class="btn btn-info" href="#">Je suis Interesse</a>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
	</body>
</html>
