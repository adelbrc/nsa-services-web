<?php

include("libs/php/isConnected.php");
include('libs/php/functions/translation.php');

require_once("libs/php/classes/DBManager.php");
$conn = DBManager::getConn();

if (isset($_GET['lang']))
	$langue = $_GET["lang"];
else
	$langue = 0;


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://js.stripe.com/v3/"></script>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="ressources/style/style.css">

		<title>Home Services | Page non trouvée</title>

	</head>
	<body>
		<header>
			<?php include('libs/php/includes/userHeader.php'); ?>
		</header>

		<main>
	
			<section class="sizedSection">
				<div class="dataContainer">			

					<h2 class="text-center">Page non trouvée !</h2>
					<p style="margin: 0">Vous vous êtes perdu ? Pas de soucis nous sommes là pour vous</p>
					<center>
						<img src="ressources/img/receptionnist.jpg" alt="" style="margin-bottom: 15px">
					</center>
					<div class="container d-flex justify-content-between">
						<a href="mes_services.php"><button class="btn btn-primary">Mes réservations</button></a>
						<a href="services.php"><button class="btn btn-primary">Réserver</button></a>
						<a href="invoices.php"><button class="btn btn-primary">Mes factures</button></a>
						<a href="dashboard.php"><button class="btn btn-primary">Les abonnements</button></a>
					</div>

				</div>
			</section>


		</main>


	</body>
</html>
