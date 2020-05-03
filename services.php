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
	
		<?php
			
			$queryHasMembership = $conn->prepare("SELECT customer_id FROM memberships_history WHERE user_id = ? AND status = 'active'");
			$queryHasMembership->execute([$_SESSION["user"]["id"]]);
			if ($queryHasMembership->fetch()):	
			
		?>	

				<!-- Recherche de services -->
				<section class="sizedSection">
					<div class="dataContainer">
						<div class="row" id="error-message">
						</div>
				
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

				<?php
				
				$queryServiceTime = $conn->prepare("SELECT serviceHoursRemaining FROM memberships_history WHERE user_id = ? AND status = 'active'");
				$queryServiceTime->execute([$_SESSION["user"]["id"]]);
				$serviceTime = $queryServiceTime->fetch()[0];

				if ($serviceTime > 0) {

				?>
					<h3 id="serviceTimeText">
						<p class="green">
							<svg class="bi bi-info-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
							  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
							  <circle cx="8" cy="4.5" r="1"/>
							</svg>
							Il vous reste <?= $serviceTime ?> h de services inclus
						</p>
					</h3>
				<?php } else { ?>
					<h3 id="serviceTimeText">
						<a href="dashboard.php#abonnements" class="red">
							<svg class="bi bi-info-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
							  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
							  <circle cx="8" cy="4.5" r="1"/>
							</svg>
							Vous avez dépassé votre nombre d'heures de service proposé, <br>optez pour un forfait qui correspond à vos besoins ou <br>attendez le mois prochain 
						</a>
					</h3>

				<?php } ?>


				<!-- Nos services -->
				<section class="sizedSection">
					<div class="dataContainer">
						<h2 class="text-center"><?php echo $nosServices[$langue]; ?></h2>
						<div class="row">
							<?php include("libs/php/views/servicesCardsList.php"); ?>
						</div>
					</div>
				</section>




				<!-- Besoin d'un service non liste ? -->
				<section class="sizedSection">
					<div class="dataContainer">
						<h2 class="text-center"><?php echo $serviceInconnu[$langue]; ?></h2>

						<form action="mes_services.php" method="POST" class="w-50 mx-auto">
							<p><?php echo $reseigneInfo[$langue]; ?></p>
							
							<div class="form-group">
								<label><?php echo $titre[$langue]; ?></label>
								<input type="text" id="service_title" class="form-control" placeholder="Titre de la demande">
							</div>

							<div class="form-group">
								<label>Date</label>
								<small>(Optionnel - Inclure une date nous permettra de vous donner un meilleur prix)</small>
								<input type="date" placeholder="Date de l'intervention" id="service_date" class="form-control" value="<?= date('Y-m-d', time()); ?>">
							</div>

							<div class="form-group" id="service_time_box">
								<label id="service_startTime_title">Heure</label>
								<small>(Optionnel)</small>
								<input type="time" id="service_startTime" class="form-control" value="09:00">
								<small>Votre demande nécessite une heure de fin ? <input type="checkbox" id="more_time"></small>
							</div>
							

							<div class="form-group" id="service_endTime_box" style="display: none;">
								<label id="service_endTime_title">Heure de fin</label>
								<input type="time" id="service_endTime" value="15:00" class="form-control">
							</div>

							<div class="form-group" id="">
								<label><?php echo $lieuIntervention[$langue]; ?></label>
								<input type="text" id="service_place" class="form-control" placeholder="Lieu de l'intervention" value="<?= $_SESSION['user']['address'] . ', ' . $_SESSION['user']['city'] ?>">
							</div>

							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" id="service_description" rows="3"></textarea>
							</div>

							<p>Nous reviendrons vers vous aussi vite que possible afin de donner suite à votre demande.</p>

							<button type="button" name="submit_devis" id="submit_devis" class="btn btn-primary"><?php echo $envoyerDemande[$langue]; ?></button>
						</form>
					</div>
				</section>


		<?php
			else:
		?>
				<!-- Message "prenez un abonnement" -->
				<section class="sizedSection">
					<div class="dataContainer">
						<div class="row" id="locked">
							<h2 class="text-center">Facilitez-vous la vie !</h2>
							<div class="row" id="abonnement_background"></div>
							<a href="dashboard.php#abonnements" id="abonnement_message">Souscrivez dès maintenant à un abonnement <br> pour découvrir tous nos services</a>
						</div>
					</div>
				</section>

		<?php
			endif;
		?>


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

				/* * * * * * * * 
				* RemoveBooking
				/* * * * * * * */
				function removeBooking(booking, plan_id, prix) {
					booking.parentNode.parentNode.parentNode.removeChild(booking.parentNode.parentNode);
					// jour_compteur -= 1;
					var maj = 1;
					$(".compteurjour").each(function(index) {
						// console.log($(".compteurjour")[index]);
						// $(".compteurjour")[index].html("Jour " + maj);0
						// $(".compteurjour")[index].text("Jour " + maj);
						// maj += 1;
					});
					
					document.querySelector(".totalprix_service_"+plan_id).innerHTML =  parseInt(document.querySelector(".totalprix_service_"+plan_id).innerHTML) - prix;
				}

				var jour_compteur = 2;






				/* * * * * * * * 
				* AddBooking
				* * * * * * * * */
				function addBooking(plan_, plan_id, prix) {


					var bookings_length = document.querySelectorAll(".booking_"+plan_id).length;
					if (!bookings_length && document.querySelector("#err_msg_"+plan_id)) {
						document.querySelector("#err_msg_"+plan_id).style.display = "none";
					}


					$("#"+plan_).append(`
						<div class=\"container booking_box booking_`+plan_id+` border m-0 mr-3\">
							<div class=\"form-group\">
								<span class=\"compteurjour\">Jour `+jour_compteur+`</span>
								<span aria-hidden="true" class=\"removeBooking\" onclick=\"removeBooking(this, '${plan_id}', ${prix})\">×</span>
								<input type=\"date\" class=\"form-control form-input jour_${plan_id}\" value=\"`+(new Date()).toISOString().substr(0,10)+`\">
							</div>

							<div class=\"form-group\">
								<label>Heure de début</label>
								<input type="time" class="form-control form-input tdebut_${plan_id}" value="09:00" min="09:00" max="20:00" step="900">
							</div>

							<div class=\"form-group\">
								<label>Heure de fin</label>
								<input type="time" class="form-control form-input tfin_${plan_id}" value="10:00" min="09:00" max="20:00" step="900">
							</div>
							
							<div>
								<p>Prix : <span class="prix">${prix}</span> €</p>
							</div>
						</div>`
					);

					document.querySelector(".totalprix_service_"+plan_id).innerHTML =  parseInt(document.querySelector(".totalprix_service_"+plan_id).innerHTML) + prix;

					jour_compteur += 1;

				}







				/* * * * * * * * 
				* RemovePanierItem
				* * * * * * * * */
				function removePanierItem(el, service, idx) {
					service = service.replace("\/", "");
					console.log(service);
					console.log(panier[service]);
					console.log("je supprime " + panier[service]["data"][idx].jour);

					// en fait, imagine chaque item dans le panier a un idx respectif, 1, 2, 3
					// si je supprime le premier, ca marche, mais maintenant tout s'est décalé a gauche d'un cran, a[1] est devenu a[0], ...
					// du coup, les idx initiaux sont d'un rang a droite de trop, il faudrait html-ment les mettre a jour, c chiant
					// du coup, on peut juste mettre lelement en question a vide, pas de decalage d'idx, et a la verification, on verifie que ca vaut pas rien
					panier[service]["data"].splice(idx, 1);
					// panier[service][idx] = undefined;

					el.parentNode.parentNode.removeChild(el.parentNode);
					document.querySelector("#panier_text").innerText = parseInt(document.querySelector("#panier_text").innerText) - 1;
					console.log(panier);

				}






				/* * * * * * * * 
				* AddPanier
				* * * * * * * * */
				function addPanier(el) {
					var service_name = $(el).attr("data-service-name");
					var service_plan_id = $(el).attr("data-service-plan_id");
					var service_price = $(el).attr("data-service-price");
					var service_id = $(el).attr("data-service-id");
					var customer_id = $(el).attr("data-customer-id");
					var stripe_cus_id = $(el).attr("data-customer-stripe-id");
					var address = $("#address_input_"+service_id).val();
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
						panier[service_name].service_id = service_id;
						panier[service_name].customer_id = customer_id;
						panier[service_name].stripe_cus_id = stripe_cus_id;
						panier[service_name].address = address;
						panier[service_name].nature = "service";
						panier[service_name].data = [];
					}

					// 1. creation du panier logique
					// 2. ajout au panier graphique

					// 1. creation du panier logique
					var bookings_length = document.querySelectorAll(".booking_"+service_id).length;

					var jours = document.querySelectorAll(".jour_"+service_id);
					var tdebuts = document.querySelectorAll(".tdebut_"+service_id);
					var tfins = document.querySelectorAll(".tfin_"+service_id);
					
					var err_msg = document.createElement("p");
					err_msg.setAttribute("style", "color:red");
					err_msg.setAttribute("id", "err_msg_"+service_id);



					if (bookings_length === 0) {
						if (!document.querySelector("#err_msg_"+service_id)) {
							err_msg.innerHTML = "Veuillez ajouter au moins une réservation pour commande ce service";
							document.querySelector("#form_"+service_id).appendChild(err_msg);
						} else {
							document.querySelector("#err_msg_"+service_id).style.display = "block";
						}
						return;
					}

					for (var i = 0; i < bookings_length; i++) {
						if (tdebuts[i].value > tfins[i].value) {
							// affichage du message d'erreur
							if (!document.querySelector("#err_msg_"+service_id)) {
								err_msg.innerHTML = "L'heure de fin ne peut pas etre avant celle du debut (" + (i+1) + "e jour)";
								document.querySelector("#form_"+service_id).appendChild(err_msg);
							} else {
								document.querySelector("#err_msg_"+service_id).style.display = "block";
							}

							return;
						}

						if (tdebuts[i].value == tfins[i].value) {
							// affichage du message d'erreur
							if (!document.querySelector("#err_msg_"+service_id)) {
								err_msg.innerHTML = "Les heures ne peuvent pas etre egales (" + (i+1) + "e jour)";
								document.querySelector("#form_"+service_id).appendChild(err_msg);
							} else {
								document.querySelector("#err_msg_"+service_id).style.display = "block";
							}

							return;
						}
					}
					
					if (document.querySelector("#err_msg_"+service_id))
						document.querySelector("#err_msg_"+service_id).style.display = "none";


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





					// 2. ajout au panier graphique

					// on n'ajoute une nouvelle categorie que si ce service na pas deja ete commande
					var rajouter = 1;
					$(".panier_title").each(function(index) {
						if ($(".panier_title")[index].innerText === service_name) {
							rajouter = 0;
						}
					});

					var service_name_id;
					service_name_id = service_name.replace(/ /g,'');
					service_name_id = service_name_id.replace(/\'/g,'');

					if (rajouter) {
						$("#panier").append(`
							<div class="container" id="panier_container_${service_name_id}">
								<h4 class="panier_title">${service_name}</h4>
								<ul id="panier_liste_${service_name_id}"></ul>
							</div>
						`);
					}

					for (var i = 0; i < bookings_length; i++) {
						var service_name2 = service_name.replace(/'/g,"\\'");

						$("#panier_liste_"+service_name_id).append(`
							<li>
								<input type="date" value="${panier[service_name].data[i].jour}">
								de
								<input type="time" value="${panier[service_name].data[i].tdebut}">
								à
								<input type="time" value="${panier[service_name].data[i].tfin}">
								<button class="btn btn-danger" onclick="removePanierItem(this, '${service_name2}', ${i})">
									<span aria-hidden="true">×</span>
								</button>
							</li>
						`);


					}


					$('#bookingModal'+service_id).modal('hide');

				}
















				/* * * * * * * * 
				* ValidateOrder
				* * * * * * * * */
				$("#validateOrder").click(function() {
					// on va faire une ajax pour toutes cateogires de services demandées (ex: babysitting, plomberie, ...)
					// on recupere les index associatifs qu'on avait mis en place avant
					var panier_keys = Object.keys(panier);

					// var stripe_items = [];

					// for (key of panier_keys) {
					// 	console.log(key);
					// 	console.log("Pour " + key + ", j'ai " + panier[key].data.length + " jours");
					// 	var total_heures = 0;
					// 	for (session of panier[key].data) {
					// 		// on a tdebut et tfin (temps debut temps fin) des String comme ca "10:00",
					// 		// on va slice "10" et le convertir en int puis soustraire pour avoir la difference
					// 		total_heures += parseInt(session.tfin.slice(0, 2)) - parseInt(session.tdebut.slice(0, 2));
					// 		// console.log(session);
					// 	}
					// 	console.log("En tout, pour " + key + ", j'ai " + total_heures + " h");

					// 	// stripe_items.push({"plan": panier[key].plan_id, quantity: total_heures});
					// 	stripe_items.push({"plan": panier[key].plan_id, quantity: 1});
					// 	break;
					// }

					// console.log(stripe_items);


					// let xhttp = new XMLHttpRequest();

					// xhttp.onreadystatechange = function() {
					// 	if (xhttp.readyState === 4 && xhttp.status === 200) {
					// 		console.log("here");
					// 		console.log(xhttp.responseText);
					// 	}
					// };

					// xhttp.open("GET", "libs/php/controllers/ajax_mirrors.php?form=stripe_service");

					// xhttp.send();

					// on envoie chaque categorie en json
					// BDD

					for (service of panier_keys) {
						doAjax('libs/php/controllers/ajax_mirrors.php', 'commandeService', JSON.stringify(panier[service]));
					}
					// console.log(service_plan_id); // plan_...

					// var stripe = Stripe('pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B');

					// stripe.redirectToCheckout({
					// 	items: stripe_items,

					// 	// Do not rely on the redirect to the successUrl for fulfilling
					// 	// purchases, customers may not always reach the success_url after
					// 	// a successful payment.
					// 	// Instead use one of the strategies described in
					// 	// https://stripe.com/docs/payments/checkout/fulfillment
					// 	successUrl: 'http://localhost/ESGI/PA2020/nsa-services-web/mes_services.php?status=serviceBooked',
					// 	cancelUrl: 'http://localhost/ESGI/PA2020/nsa-services-web/mes_services.php?status=cancel'
					// })
					// .then(function (result) {
					// 	if (result.error) {
					// 		// If `redirectToCheckout` fails due to a browser or network
					// 		// error, display the localized error message to your customer.
					// 		var displayError = document.getElementById('error-message');
					// 		displayError.textContent = result.error.message;
					// 	}
					// });

				});












				/* * * * * * * * 
				* MoreTime
				* * * * * * * * */
				// la petite gestion du checkbox : affiche/cacher l'input pour un temps de fin de service
				$("#more_time").click(function() {
					if ($("#service_startTime_title").text() == "Heure de début") {
						$("#service_startTime_title").text("Heure");
						$("#service_endTime").removeAttr("name");
					} else {
						$("#service_startTime_title").text("Heure de début");
						$("#service_endTime").attr("name", "service_endTime");
					}
					$("#service_endTime_box").toggle();
				});





				/* * * * * * * * 
				* Submit devis pour service
				* * * * * * * * */
				$("#submit_devis_service").click(function() {
					var panier_keys = Object.keys(panier);
					if (!panier_keys.length) {
						console.log("[Erreur] Demande de devis sans services - Veuillez ajouter des services");
						return;
					}

					for (service of panier_keys) {
						doAjax('libs/php/controllers/ajax_mirrors.php', 'askDevis', JSON.stringify(panier[service]));
					}
				});











				/* * * * * * * * 
				* SubmiteDevis
				* * * * * * * * */
				// quand on clique pour envoyer un service NON propose
				$("#submit_devis").click(function() {
					var title = $("#service_title").val();
					var date = $("#service_date").val();
					var start_time = $("#service_startTime").val();
					var address = $("#service_place").val();
					var description = $("#service_description").val();

					var data = {
						"customer_id" : "<?= $_SESSION["user"]["id"] ?>",
						"title" : title,
						"date" : date,
						"start_time" : start_time,
						"end_time" : null,
						"address" : address,
						"description" : description, 
						"nature" : "devis"
					};

					// si on a un attribut name sur l'input d'heure de fin, on ajoute sa valeur dans notre objet data
					if ($("#service_endTime").attr("name") === "service_endTime") {
						data["end_time"] = $("#service_endTime").val();
					}

					console.log(data);

					doAjax('libs/php/controllers/ajax_mirrors.php', 'askDevis', JSON.stringify(data));

				});


				$("#firstBookingBox").attr("value", (new Date()).toISOString().substr(0,10));

			// });

		</script>
	</body>
</html>
