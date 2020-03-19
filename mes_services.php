<?php

require_once("libs/php/classes/User.php");
require_once("libs/php/classes/Service.php");
require_once("libs/php/classes/Order.php");
include("libs/php/functions/checkInput.php");



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
		<link rel="stylesheet" href="ressources/style/style.css">

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


		<script>

			document.addEventListener('DOMContentLoaded', function() {
				var calendarEl = document.getElementById('calendar');

				var calendar = new FullCalendar.Calendar(calendarEl, {
					columnHeaderHtml: function(date) {
						// if (date.getUTCDay() === 5) {
							var tab_jour = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
							return ""+tab_jour[date.getDay()]+"";
					},

					plugins: [  'dayGrid', 'timeGrid', 'bootstrap' ],
					defaultView: 'timeGridWeek',

					aspectRatio: 1.85,
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
					
					// cache mardi jeudi
					// hiddenDays: [ 2, 4 ], 

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
							start:"2020-03-18T10:00:00+00:00",
							end:"2020-03-18T11:00:00+00:00",
							allDay : false // will make the time show
						},

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


			<section class="sizedSection">
				
				<?php
					if ($success):
				?>

				<div class="alert alert-success w-50 mx-auto" role="alert">
					Votre demande a bien été prise en compte
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<?php endif; ?>	

				<div class="dataContainer">
					<h2 class="text-center">Services prévus</h2>

						<div id='calendar'></div>


<!-- 						<table class="table">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Prestation</th>
									<th scope="col">Lieu</th>
									<th scope="col">Date</th>
									<th scope="col">Prix</th>
									<th scope="col">Prestataire</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">1</th>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
									<td>@fat</td>
									<td>@twitter</td>
								</tr>
								<tr>
									<th scope="row">2</th>
									<td>Jacob</td>
									<td>Thornton</td>
									<td>@mdo</td>
									<td>@fat</td>
									<td>@fat</td>
								</tr>
								<tr>
									<th scope="row">3</th>
									<td>Larry</td>
									<td>the Bird</td>
									<td>@mdo</td>
									<td>@fat</td>
									<td>@twitter</td>
								</tr>
							</tbody>
						</table>
 -->
				</div>
			</section>



			<section class="sizedSection">
				<div class="dataContainer">
					<h2 class="text-center">Historique des demandes</h2>

						<table class="table">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Prestation</th>
									<th scope="col">Lieu</th>
									<th scope="col">Date</th>
									<th scope="col">Prix</th>
									<th scope="col">Prestataire</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">1</th>
									<td>Mark</td>
									<td>Otto</td>
									<td>@mdo</td>
									<td>@fat</td>
									<td>@twitter</td>
								</tr>
								<tr>
									<th scope="row">2</th>
									<td>Jacob</td>
									<td>Thornton</td>
									<td>@mdo</td>
									<td>@fat</td>
									<td>@fat</td>
								</tr>
								<tr>
									<th scope="row">3</th>
									<td>Larry</td>
									<td>the Bird</td>
									<td>@mdo</td>
									<td>@fat</td>
									<td>@twitter</td>
								</tr>
							</tbody>
						</table>


				</div>
			</section>


		</main>

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>


		<script src='libs/fullcalendar/packages/timegrid/main.js'></script>
		<script src='libs/fullcalendar/packages/daygrid/main.js'></script>
		<script src='libs/fullcalendar/packages/core/main.js'></script>

		<script src='libs/fullcalendar/packages/core/locales-all.js'></script>
		<script src='http://code.jquery.com/jquery-1.11.3.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.0/fullcalendar.min.js'></script>


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
