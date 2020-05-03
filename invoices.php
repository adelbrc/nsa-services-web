<?php

require_once('libs/php/classes/User.php');
include('libs/php/isConnected.php');
include('libs/php/functions/translation.php');

if (isset($_GET['lang'])) {
		$langue = $_GET["lang"];
}else {
$langue = 0;
}
if (!isConnected()) {
		header("Location: login.php");
		exit;
}

$user = User::getUserByID($_SESSION["user"]["id"]);

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="ressources/style/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Compte | Factures</title>
	</head>

	<body>
		<header>
			<?php include("libs/php/includes/userHeader.php"); ?>
		</header>

		<main>
			<div class="container-fluid">
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h1 class="h2" id='user'>Factures</h1>
					<div class="btn-toolbar mb-2 mb-md-0">
						<div class="btn-group mr-2">
							<ul class="nav justify-content-center" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="membership-tab" data-toggle="tab" href="#membership" role="tab" aria-controls="membership" aria-selected="true"><button type="button" class="btn btn-sm btn-outline-primary">Abonnements</button></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="service-tab" data-toggle="tab" href="#service" role="tab" aria-controls="service" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Services</button></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Commandes</button></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-content" id="myProfileContent">
					<div class="tab-pane fade show" id="service" role="tabpanel" aria-labelledby="service">
						<h2 style="text-align: center;">Service</h2>
						<div class="dataContainer">
							<div class="row d-flex flex-wrap">
							<?php include("libs/php/views/userServicesInvoicesList.php"); ?>
							</div>
						</div>
					</div>
					<div class="tab-pane fade show active" id="membership" role="tabpanel" aria-labelledby="membership">
						<h2 style="text-align: center;">Abonnements</h2>
						<!-- <div class="dataContainer">
							<div class="row d-flex flex-wrap">

							</div>
						</div> -->
						<?php include("libs/php/views/userMembershipsInvoicesList.php"); ?>
					</div>

					<div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders">
						<?php include("libs/php/views/userOrdersInvoicesList.php"); ?>
					</div>
				</div>
			</div>
		</main>



		<!-- Modal -->
		<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Erreur de transaction</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
						  <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
						  <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
						  <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
						</svg>

						<p>Oops, il semblerait que vous ayiez déjà payé pour cette réservation, pas d'inquiétude, vous ne serez pas facturé une 2e fois</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Fermer</button>
					</div>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

		<script>
			function payServices(btn, modalid) {
				btn.innerHTML = `Achat en cours <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>`;


				var total = btn.getAttribute("data-total");
				var cus = btn.getAttribute("data-cus");
				var plan = btn.getAttribute("data-service-id");
				var name = btn.getAttribute("data-service-name");
				var uid = btn.getAttribute("data-uid");
				var oid = btn.getAttribute("data-order-id");



				let xhttp = new XMLHttpRequest();

				xhttp.onreadystatechange = function() {
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						var jsonResponse = JSON.parse(this.responseText);
						console.log(jsonResponse);
						if (jsonResponse.status === "success") {
							// on affiche le modal
							$('#'+modalid).modal('show');

							// on change le button
							btn.innerHTML = "Payé " + jsonResponse.total + " €, Télécharger la facture";
							btn.classList.remove("btn-primary");
							btn.classList.add("btn-success");
							btn.onclick = "";

						} else if (jsonResponse.status === "error") {
							$('#modalError').modal('show');
						}
					}
				};
				var url = "libs/php/controllers/ajax_mirrors.php";
				var form = "payServices";
				var obj = JSON.stringify({"total": total, "cus": cus, "plan": plan, "name": name, "uid": uid, "oid" : oid});

				xhttp.open("GET", url+"?form=" + form + "&obj=" + obj, true);
				xhttp.send();

			}
		</script>

	</body>
</html>
