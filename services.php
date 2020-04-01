<?php

require_once("libs/php/classes/User.php");
require_once("libs/php/classes/Service.php");
include("libs/php/isConnected.php");
include('libs/php/functions/translation.php');

if (isset($_GET['lang'])) {
	$langue = $_GET["lang"];
}else {
$langue = 0;
}
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
					<h2 class="text-center"><?php echo $chercherService[$langue]; ?></h2>
					<form class="text-center searchServicesForm">
						<div class="form-row">
							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<input class="customInput" autocomplete="off" type="search" placeholder="<?php echo $exPlacehorder[$langue]; ?>..." onkeyup="showResult(this.value)">
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
				<h2 class="text-center"><?php echo $nosServices[$langue]; ?></h2>
				<div class="row">
					<?php include("libs/php/views/servicesCardsList.php"); ?>
				</div>
			</section>

			<section class="sizedSection">
				<div class="dataContainer">
					<h2 class="text-center"><?php echo $serviceInconnu[$langue]; ?></h2>

					<form action="" method="POST" class="w-50 mx-auto">
						<p><?php echo $reseigneInfo[$langue]; ?></p>

						<div class="form-group">
							<label><?php echo $titre[$langue]; ?></label>
							<input type="text" name="serviceTitle" class="form-control" placeholder="Titre de la demande">
						</div>

						<div class="form-group">
							<label><?php echo $dateEtHeure[$langue]; ?></label>
							<input placeholder="Date et heure du service demandé" type="text" id="date-picker-example" class="form-control datepicker">

							<!-- <input type="date" id="datetimepicker" class="form-control">
							<div class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
								<input size="16" type="text" value="" readonly>
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-calendar"></i></span>
							</div> -->
						</div>

						<div class="form-group">
							<label><?php echo $lieuIntervention[$langue]; ?></label>
							<input type="text" name="servicePlace" class="form-control" placeholder="<?php echo $lieuIntervention[$langue]; ?>">
						</div>

						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" name="serviceDescription" rows="3"></textarea>
						</div>

						<button type="submit" name="submitDemande" class="btn btn-primary"><?php echo $envoyerDemande[$langue]; ?></button>
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
		<!-- le js ci-dessous (script.js) contient doAjax() -->
		<script src="ressources/js/script.js"></script>

		<script>
			var panier = [];

			// $(function () {
				function removeBooking(booking) {
					booking.parentNode.parentNode.parentNode.removeChild(booking.parentNode.parentNode);
					// jour_compteur -= 1;
					var maj = 1;
					$(".compteurjour").each(function(index) {
						// console.log($(".compteurjour")[index]);
						// $(".compteurjour")[index].html("Jour " + maj);0
						// $(".compteurjour")[index].text("Jour " + maj);
						// maj += 1;
					});
				}

				var jour_compteur = 2;

				function addBooking() {
					$("#bookings_container").append(`
						<div class=\"container booking_box border m-0 mr-3\">
							<div class=\"form-group\">
								<span class=\"compteurjour\">Jour `+jour_compteur+`</span>
								<span aria-hidden="true" class=\"removeBooking\" onclick=\"removeBooking(this)\">×</span>
								<input type=\"date\" class=\"form-control form-input jour\" value=\"`+(new Date()).toISOString().substr(0,10)+`\">
							</div>

							<div class=\"form-group\">
								<label>Heure de début</label>
								<input type="time" class="form-control form-input tdebut" value="09:00" min="09:00" max="20:00" step="900">
							</div>

							<div class=\"form-group\">
								<label>Heure de fin</label>
								<input type="time" class="form-control form-input tfin" value="10:00" min="09:00" max="20:00" step="900">
							</div>
						</div>`
					);

					jour_compteur += 1;

				}


				function removePanierItem(el, service, idx) {
					console.log("je supprime " + panier[service]["data"][idx].jour);
					panier[service]["data"].splice(idx, 1);
					// panier[service][idx] = null

					el.parentNode.parentNode.removeChild(el.parentNode);
					document.querySelector("#panier_text").innerText = parseInt(document.querySelector("#panier_text").innerText) - 1;
					console.log(panier);

				}


				function addPanier(el) {
					var service_name = $(el).attr("data-service-name");
					var service_plan_id = $(el).attr("data-service-plan_id");
					var service_price = $(el).attr("data-service-price");
					var service_id = $(el).attr("data-service-id");
					var customer_id = $(el).attr("data-customer-id");
					var booking = [];
					/*
					* Important :
					* Quand je fais : panier[0] = 1, length = 1 et l'index 0 renvoie 1
					* les tableau en JS sont 0-indéxés (commencent par 0)
					* par contre, quand je fais : panier["demo"] = {"name" : "eminem"}, length = 0 car (je suis pas sur encore mais ca marche pour linstant),
					* sauf que le premier element est a l'index 0 alors que la on a declare a l'index "demo", donc .length n'est pas adapté ici
					**/
					if (panier[service_name] == undefined) {
						panier[service_name] = new Object();
						panier[service_name].name = service_name;
						panier[service_name].plan_id = service_plan_id;
						panier[service_name].price = service_price;
						panier[service_name].id = service_id;
						panier[service_name].customer_id = customer_id;
						panier[service_name].data = [];
					}

					// 1. creation du panier logique
					// 2. ajout au panier graphique

					// 1. creation du panier logique
					var bookings_length = document.querySelectorAll(".booking_box ").length;
					var jours = document.querySelectorAll(".jour");
					var tdebuts = document.querySelectorAll(".tdebut");
					var tfins = document.querySelectorAll(".tfin");

					for (var i = 0; i < bookings_length; i++) {
						if (tdebuts[i].value > tfins[i].value) {
							console.log("L'heure de fin ne peut pas etre avant celle du debut " + (i+1) + "e jour)");
							return;
						}

						if (tdebuts[i].value == tfins[i].value) {
							console.log("Les heures ne peuvent pas etre egales (" + (i+1) + "e jour)");
							return;
						}
					}

					for (var i = 0; i < bookings_length; i++) {
						panier[service_name].data.push({
							"jour": jours[i].value,
							"tdebut": tdebuts[i].value,
							"tfin": tfins[i].value
						});

						document.querySelector("#panier_text").innerText = parseInt(document.querySelector("#panier_text").innerText) + 1;
					}

					console.log(panier);
					// console.log(Object.keys(panier));
					// console.log(Object.keys(panier).length);
					// console.log(panier.length);

					$("#validateOrder").click(function() {
						// on va faire une ajax pour toutes cateogires de services demandées (ex: babysitting, plomberie, ...)
						// on recupere les index associatifs qu'on avait mis en place avant
						var panier_keys = Object.keys(panier);
						for (var i = 0; i < panier_keys.length; i++) {
							// on envoie chaque categorie en json
							doAjax('libs/php/controllers/ajax_mirrors.php', 'commandeService', JSON.stringify(panier[panier_keys[i]]));
						}
					});


					// 2. ajout au panier graphique

					// on n'ajoute une nouvelle categorie que si ce service na pas deja ete commande
					var rajouter = 1;
					$(".panier_title").each(function(index) {
						if ($(".panier_title")[index].innerText === service_name) {
							rajouter = 0;
						}
					});

					var service_name_id = service_name.replace(/ /g,'');

					if (rajouter) {
						$("#panier").append(`
							<div class="container" id="panier_container_${service_name_id}">
								<h4 class="panier_title">${service_name}</h4>
								<ul id="panier_liste_${service_name_id}"></ul>
							</div>
						`);
					}

					for (var i = 0; i < bookings_length; i++) {

						$("#panier_liste_"+service_name_id).append(`
							<li>
								<input type="date" value="` + panier[service_name].data[i].jour + `">
								de
								<input type="time" value="` + panier[service_name].data[i].tdebut + `">
								à
								<input type="time" value="` + panier[service_name].data[i].tfin + `">
								<button class="btn btn-danger" onclick="removePanierItem(this, '${service_name}', ` + i + `)"><span aria-hidden="true">×</span></button>
							</li>
						`);
					}


					$('#bookingModal').modal('hide');

				}

				// $("#addPanier_button").on("click", addPanier);
				$("#firstBookingBox").attr("value", (new Date()).toISOString().substr(0,10));

			// });

		</script>
	</body>
</html>
