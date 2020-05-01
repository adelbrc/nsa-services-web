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

//Annulation du service commandé
if(isset($_POST['annulerService'])){
	$req = $conn->prepare('UPDATE order_session SET orderStatus = ? WHERE session_id = ?');
	$req->execute(array('Cancelled', $_POST['idOrder']));
	header('location:mes_services.php?orderStatus=cancelled');
 }

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<title>Mes services - Home Services</title>


		<link href='libs/fullcalendar/packages/core/main.css' rel='stylesheet' />
		<link href='libs/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />

		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.0/fullcalendar.css' />


		<link href='libs/fullcalendar/packages/core/main.css' rel='stylesheet' />
		<link href='libs/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
		<link href='libs/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />

		<script src='libs/fullcalendar/packages/core/main.js'></script>
		<script src='libs/fullcalendar/packages/daygrid/main.js'></script>
		<script src='libs/fullcalendar/packages/timegrid/main.js'></script>

		<!-- <link rel='stylesheet' href='themes/base/jquery-ui.min.css' /> -->

		<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
		<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />

		<link rel="stylesheet" href="ressources/style/style.css">


		<script>

			document.addEventListener('DOMContentLoaded', function() {
				var calendarEl = document.getElementById('calendar');

				var calendar = new FullCalendar.Calendar(calendarEl, {
					columnHeaderHtml: function(date) {
						// if (date.getUTCDay() === 5) {
							var tab_jour = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
							return ""+tab_jour[date.getDay()]+"";
					},
					eventClick: function(info) {
			      var eventObj = info.event;

						//alert('Service ' + eventObj.title);
						displayModal(eventObj.id, eventObj.title, eventObj.start, eventObj.end );

							// alert('st ' + eventObj.start);

							$(document).ready(function(){
								$("#myModal").modal('show');
							});

			    },
					plugins: [  'dayGrid', 'timeGrid', 'bootstrap' ],
					defaultView: 'timeGridWeek',

					// aspectRatio: 1.85,
					// height: 600,
					// contentHeight: 500,

					theme: true,

					// header
					header: {
					  left: 'prev,next today',
					  center: 'title',
					  right: 'timeGridDay,timeGridWeek,dayGridMonth'
					},

					firstDay: 1,
					locale: "fr",
					// l'interval de temps sur la colonne de gauche
					slotDuration:'00:30:00',
					// l'heure du debut du planning
					minTime: "09:00:00",
					// l'heure de fin
					maxTime: "21:00:00",

					events: [

						{
							title:"Meeting1",
							start:"2020-04-18T10:00:00+00:00",
							end:"2020-03-18T11:00:00+00:00",
							allDay : false // will make the time show
						},
						<?php
							$rechercheCommande = $conn->prepare("SELECT * FROM orders WHERE customer_id = ?");
							$rechercheCommande->execute([$_SESSION['user']['id']]);
							$resCommande = $rechercheCommande -> fetchAll();



							foreach ($resCommande as $resCommandes) {

								$rechercheNomService = $conn->prepare("SELECT * FROM service WHERE id = ?");
								$rechercheNomService->execute([$resCommandes['service_id']]);
								$resNomService = $rechercheNomService -> fetch();

								$rechercheOrderSession = $conn->prepare("SELECT * FROM order_session WHERE order_id = ?");
								$rechercheOrderSession->execute([$resCommandes[0]]);
								$resOrderSession = $rechercheOrderSession -> fetchAll();
								foreach ($resOrderSession as $resOrderSessions) {
									if ($resOrderSessions['orderStatus']  != 'Cancelled') {
						?>
								{
									id: "<?php echo $resOrderSessions[0]; ?>",
									title:"<?php echo  $resNomService['name'] ?>",
									start:"<?php echo  $resOrderSessions[2]."T".$resOrderSessions[3];?>",
									end:"<?php echo  $resOrderSessions[2]."T".$resOrderSessions[4];?>",
									allDay : false // will make the time show
								},

						<?php
									}
								}
							}
						 	?>
						{
							title:"Meeting2",
							start:"2020-03-18T12:30:00+00:00",
							end:"2020-03-18T14:30:00+00:00",
							allDay : false // will make the time show
						},
						{
							title:"Meeting3",
							start:"2020-03-18T14:30:00+00:00",
							end:"2020-03-18T16:30:00+00:00",
							allDay : false // will make the time show
						},
					]
				});

				calendar.render();
			});

		</script>


	</head>
	<body>
		<header>
			<?php include('libs/php/includes/userHeader.php'); ?>

		</header>
		<main>
			<div class="form-group col-md-12">
				<?php if (isset($_GET['orderStatus']) && $_GET['orderStatus'] == "cancelled") {
					echo '<div class="alert alert-success col-md-9 mx-auto" role="alert" style="margin-top: 20px; text-align: center;">' ."Le service à bien été annuler". '</div>';
				}?>
			</div>

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
					<h2 class="text-center">Planning - <?php echo $servicePrevu[$langue]; ?></h2>
					
					<?php
						$queryUserHasMembership = $conn->prepare("SELECT user_id FROM memberships_history WHERE user_id = ? AND status = 'active'");
						$queryUserHasMembership->execute([$_SESSION["user"]["id"]]);
						$hasMembership = $queryUserHasMembership->fetch();
						if (!$hasMembership):
					?>
						<h4 class="text-center"><a href="dashboard.php?#abonnements" style="text-decoration: underline; color: red">Souscrivez à un abonnement pour commencer à réserver !</a></h2>
					<?php endif; ?>
					
						<div id='calendar'></div>
				</div>
			</section>


			<section class="sizedSection">
				<div class="dataContainer" style="max-height : 3500px; overflow-y: scroll; scrollbar-width: thin;">
					<h2 class="text-center">Liste - <?php echo $servicePrevu[$langue]; ?></h2>

						<table class="table"  >
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Service</th>
									<th scope="col">Date</th>
									<th scope="col"><?php echo $prestataire[$langue]; ?></th>
									<th scope="col">Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// !!!! la table order est aussi un mot clé ORDER BY donc faut mettre les ``
								$queryMyServices = $conn->prepare("SELECT * FROM `orders` WHERE customer_id = ?");
								$queryMyServices->execute([$_SESSION["user"]["id"]]);

								while (($row = $queryMyServices->fetch())):
									$queryNameService = $conn->prepare("SELECT name FROM service WHERE id = ?");
									$queryNameService->execute([$row["service_id"]]);
									$queryNameServiced = $queryNameService->fetch();

									$queryIdPresta = $conn->prepare("SELECT partner_id FROM order_session WHERE order_id = ?");
									$queryIdPresta->execute([$row["order_id"]]);
									$queryIdPrestaa = $queryIdPresta->fetch();

									$queryNamePresta = $conn->prepare("SELECT firstname FROM partner WHERE partner_id = ?");
									$queryNamePresta->execute([$queryIdPrestaa[0]]);
									$queryNamePrestaa = $queryNamePresta->fetch();
									?>

									<tr>
										<th scope="row"><?= $row["order_id"] ?></th>
										<td><?= $queryNameServiced[0] ?></td>
										<td><?= $row['order_date'] ?></td>
										<td><?= $queryNamePrestaa[0] ?></td>
										<td>OK</td>
									</tr>

								<?php endwhile; ?>

							</tbody>
						</table>
				</div>
			</section>

		</main>

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>


		<script src='libs/fullcalendar/packages/timegrid/main.js'></script>
		<script src='libs/fullcalendar/packages/daygrid/main.js'></script>
		<script src='libs/fullcalendar/packages/core/main.js'></script>

		<script src='libs/fullcalendar/packages/core/locales-all.js'></script>
		<script src='http://code.jquery.com/jquery-1.11.3.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.0/fullcalendar.min.js'></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

		<script>



		function displayModal(id, titre, debut, fin) {

			document.body.innerHTML+= `<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Description du service #${id}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" name="formCancelOrder" method="post">
          <div class="form-group">
            <h4>Service</h4>
            <p>${titre}</p>
          </div>
          <div class="form-group">
						<h4>Date de début</h4>
						<p>${debut}</p>
          </div>
					<div class="form-group">
						<h4>Date de fin</h4>
						<p>${fin}</p>
						<input type="text" class="form-control" id="exampleInputNom" aria-describedby="NomHelp" name="idOrder" value="${id}" hidden>
          </div>
					<div class="modal-footer">
						<button type="submit" name="annulerService" class="btn btn-danger">Annuler le service</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
        </form>
      </div>

    </div>
  </div>
</div>`
			}
		</script>

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
