<?php

require_once("libs/php/classes/User.php");
require_once("libs/php/classes/Service.php");
require_once("libs/php/classes/Order.php");
include("libs/php/functions/checkInput.php");
include('libs/php/functions/translation.php');

if (isset($_GET['lang'])) {
	$langue = $_GET["lang"];
}else {
$langue = 0;
}


include("libs/php/isConnected.php");

$success = 0;

if (isset($_GET["session_id"]) && !empty($_GET["session_id"])) {
	require_once('libs/stripe-php-master/init.php');
	include('libs/php/db/db_connect.php');

	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	$session = \Stripe\Checkout\Session::retrieve($_GET["session_id"]);

	// Partie Service
	if (isset($_GET["type"]) && !empty($_GET["type"]) && $_GET["type"] == "service") {

		$service_id = $_GET["sid"];
		$service = Service::getServiceById($service_id);
		$order = new Order(NULL, $_SESSION["user"]["id"], date("Y-m-d-h-i-s"), 1, checkInput($service_id), 1, date("Y-m-d-h-i-s"), 1);
		Order::addOrder($order);

		$status = 1;
		$message = $demandeOk[$langue];

	}
}

if (isset($_GET["status"]) && !empty($_GET["status"])) {
	switch ($_GET["status"]) {
		case 'serviceBooked':
			$success = 1;
			$message = "Réservation effectuée avec succès !";
			break;

		case 'otherServiceBooked':
			$success = 1;
			$message = "Votre demande a bien été envoyée, nous vous notifierons dès qu'elle sera prise en charge par un prestataire";
			break;

		case 'cancel':
			$success = 1;
			$message = "Réservation annulée";
			break;

		case 'serviceDevisBooked':
			$success = 1;
			$message = "Devis reçu avec succès, nous reviendrons vers vous au plus vite";
			break;

		default:
			# code...
			break;
	}

}


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<title>Mes services - Home Services</title>

		<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
		<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />

		<link rel="stylesheet" href="ressources/style/style.css">

	</head>
	<body>
		<header>
			<?php include('libs/php/includes/userHeader.php'); ?>

		</header>
		<main>


			<section class="sizedSection">

				<?php
					if ($success):
				?>

				<div class="alert alert-success w-50 mx-auto" role="alert">
					<?= $message ?>

					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<?php endif; ?>

				<div class="dataContainer">
					<h2 class="text-center">Mes devis</h2>

						<table class="table">
							<thead>
								<tr>
									<th scope="col">Titre</th>
									<th scope="col">Date demande</th>
									<th scope="col">Prix</th>
									<th scope="col">Status</th>
									<th scope="col">Réponse</th>
								</tr>
							</thead>
							<tbody>
									
								<?php
									$queryGetDevis = $conn->prepare("SELECT * FROM devis WHERE customer_id = ?");
									$queryGetDevis->execute([$_SESSION["user"]["id"]]);
									$nbDevis = $queryGetDevis->rowCount();

									foreach ($queryGetDevis->fetchAll() as $devisArray):
										$thedate = new DateTime($devisArray["ordered_date"]);
									 ?>
										<tr>
											<td><?= $devisArray["title"] ?></td>
											<td><?= "Le " . $thedate->format('d/m/Y à H:i:s') ?></td>
											<td><?= !$devisArray["devis_cost"] ? "/" : $devisArray["devis_cost"];  ?></td>
											<td><?= $devisArray["status"] ?></td>
											<!-- <td><?= $devisArray["answer"] ?></td> -->
											<td>
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_devis_<?= $devisArray['devis_id'] ?>">Voir plus</button>
											</td>

											<!-- Modal -->
											<div class="modal fade" id="modal_devis_<?= $devisArray['devis_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content devis_modal">
														<div class="modal-header">
															<h5 class="modal-title">Votre devis n°<?= $devisArray["devis_id"] ?></h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body devis_modal_body">
															<h5>Réponse : </h5>
															<p><?= !$devisArray["answer"] ? "<i>En attente de réponse</i>" : $devisArray["answer"];  ?></p>
															
															<hr>

															<h5>Date réponse : </h5>
															<?php if ($devisArray["answer_date"]) {
																$answerDate = new DateTime($devisArray["answer_date"]);
															} ?>
															<p><?= !$devisArray["answer_date"] ? "<i>En attente de réponse</i>" : $answerDate->format("d/m/Y H:i:s");  ?></p>
															
															<hr>

															<h5>Adresse du devis : </h5>
															<p><?= !$devisArray["address"] ? "/" : $devisArray["address"];  ?></p>
															
															<hr>

															<h5>Montant du devis : </h5>
															<p><?= $devisArray["devis_cost"] ?></p>
															
															<hr>

															<h5>Description faite du devis : </h5>
															<p><?= $devisArray["title"] ?></p>
															
														</div>
														<div class="modal-footer">
															<!-- Si son devis a ete accepte, on lui affiche le bouton pour payer -->
															<?php if ($devisArray["status"] == "Valide"): ?>
																<button type="button" class="btn btn-primary" onclick="confirmDevis(<?= $devisArray["devis_id"] ?>, '<?= $devisArray["customer_id"] ?>')">Confirmer le devis de <?= $devisArray["devis_cost"] ?> €</button>
															<?php elseif ($devisArray["status"] == "Confirme"): ?>
																<button type="button" class="btn btn-success">Devis payé</button>
															<?php endif; ?>
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
														</div>
													</div>
												</div>
											</div>
										</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

						<?php
							// s'il n'y a pas de devis !0 = 1
							if (!$nbDevis): ?>
								<a href="services.php#devis_section"><button class="btn btn-primary">Réaliser un devis</button></a>
						<?php else: ?>
								<a href="services.php#devis_section"><button class="btn btn-primary">Demander un autre devis</button></a>
						<?php endif; ?>
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
			function confirmDevis(devis_id, customer_id) {

				let xhttp = new XMLHttpRequest();

				xhttp.onreadystatechange = function() {
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						var jsonResponse = JSON.parse(this.responseText);
						console.log(jsonResponse);
						if (jsonResponse.status === "success") {
							// si tout s'est bien passe on redirige vers son planning avec un msg vert
							document.location.href = "mes_services.php?status=devisBooked";
						} else if (jsonResponse.status === "error") {
							// $('#modalError').modal('show');
						}
					}
				};
				var url = "libs/php/controllers/ajax_mirrors.php";
				var form = "confirmDevis";
				var obj = JSON.stringify({"devis_id": devis_id, "customer_id": customer_id});

				xhttp.open("GET", url+"?form=" + form + "&obj=" + obj, true);
				xhttp.send();


			}

			$(function () {

			});
		</script>
	</body>
</html>
