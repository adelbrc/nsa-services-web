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
				<?php include('libs/php/footer.php'); ?>
				<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>
