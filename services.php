<?php

require_once("libs/php/classes/User.php");
require_once("libs/php/classes/Service.php");
include("libs/php/isConnected.php");

require_once('libs/stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');


if (isset($_POST["submitDemande"])		&&
	isset($_POST["serviceTitle"])		&& !empty($_POST["serviceTitle"]) &&
	isset($_POST["servicePlace"])		&& !empty($_POST["servicePlace"]) &&
	isset($_POST["serviceDescription"]) && !empty($_POST["serviceDescription"])
) {

		var_dump($_POST);

		// les services spontanés sont facturés 24 h après
		$plan = \Stripe\Plan::create([
			'product' => "prod_GpapCVaO00gLke",

		]);

} else {
	$error = "Veuillez remplir tous les champs";
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="ressources/style/style.css">

		<title>Home Services | Offers</title>
	</head>
	<body>
		<header>
			<?php include('libs/php/includes/userHeader.php'); ?>

		</header>
		<main>
			<section class="sizedSection">
				<div class="dataContainer">
					<h2 class="text-center">Rechercher des services</h2>
					<form class="text-center searchServicesForm">
						<div class="form-row">
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<input class="customInput" autocomplete="off" type="search" placeholder="Garde d'enfants, plomberie, réparation informatique..." onkeyup="showResult(this.value)">
								<div id="serviceSearch">

								</div>
							</div>
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<input class="customInput" type="search" name="search_location" placeholder="Paris, Marseille...">
							</div>
						</div>
					</form>
				</div>
			</section>


			<section class="sizedSection">
				<h2 class="text-center">Nos services</h2>
				<div class="row">
					<?php include("libs/php/views/servicesCardsList.php"); ?>
				</div>
			</section>

			<section class="sizedSection">
				<div class="dataContainer">
					<h2 class="text-center">Besoin d'un service non listé ?</h2>

					<form action="" method="POST" class="w-50 mx-auto">
						<p>Renseignez les informations concernant votre service et nous reviendrons vers vous le plus vite possible</p>

						<div class="form-group">
							<label>Titre</label>
							<input type="text" name="serviceTitle" class="form-control" placeholder="Titre de la demande">
						</div>

						<div class="form-group">
							<label>Date et heure</label>
							<input placeholder="Date et heure du service demandé" type="text" id="date-picker-example" class="form-control datepicker">

							<!-- <input type="date" id="datetimepicker" class="form-control">
							<div class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
								<input size="16" type="text" value="" readonly>
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-calendar"></i></span>
							</div> -->
						</div>

						<div class="form-group">
							<label>Lieu de l'intervention</label>
							<input type="text" name="servicePlace" class="form-control" placeholder="Lieu de l'intervention">
						</div>

						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" name="serviceDescription" rows="3"></textarea>
						</div>

						<button type="submit" name="submitDemande" class="btn btn-primary">Envoyer ma demande</button>
					</form>
				</div>
			</section>

		</main>

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>



		<!-- JS -->
		<script src="libs/ajax/searchServices.js" charset="utf-8"></script>
		<script src="https://js.stripe.com/v3/"></script>
		<script src="libs/js/checkout.js" charset="utf-8"></script>

		<script>
			$(function () {

			});
		</script>
	</body>
</html>
