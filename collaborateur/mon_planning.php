<?php

require_once("../libs/php/classes/User.php");
require_once("../libs/php/classes/Service.php");
require_once("../libs/php/classes/Order.php");
include("../libs/php/functions/checkInput.php");
include('../libs/php/functions/translation.php');

if (isset($_GET['lang'])) {
	$langue = $_GET["lang"];
}else {
$langue = 0;
}

include("../libs/php/isConnected.php");
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/../libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<title>Mes services - Home Services</title>


		<link href='../libs/fullcalendar/packages/core/main.css' rel='stylesheet' />
		<link href='../libs/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />

		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/../libs/fullcalendar/2.6.0/fullcalendar.css' />


		<link href='../libs/fullcalendar/packages/core/main.css' rel='stylesheet' />
		<link href='../libs/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
		<link href='../libs/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />

		<script src='../libs/fullcalendar/packages/core/main.js'></script>
		<script src='../libs/fullcalendar/packages/daygrid/main.js'></script>
		<script src='../libs/fullcalendar/packages/timegrid/main.js'></script>

		<!-- <link rel='stylesheet' href='themes/base/jquery-ui.min.css' /> -->

		<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
		<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />

		<link rel="stylesheet" href="../ressources/style/style.css">
		<script>

		function displayModalCollab(id, titre, debut, fin) {
			alert('Service ' + id);
			var resId;
			let xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					console.log(this.responseText);
					resId = JSON.parse(this.responseText);
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
							<div class="form-group">

								<h2>Information sur le client</h2>
								<h4> Prenom</h4>
								<p> ${resId.dataUser.firstname}</p>
								<input type="text" class="form-control" id="exampleInputNom" aria-describedby="NomHelp" name="idOrder" value="${id}" hidden>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" name="cancelledOrder" class="btn btn-primary">Annuler le RDV</button>
							</div>
						</form>
					</div>
				</div>
				</div>
				</div>`
				}
			};
			xhttp.open("GET","../libs/php/controllers/ajax_mirrors.php"+"?form=searchUser&obj=" + JSON.stringify({"id":id}), true);
			xhttp.send();

			// dataUser = JSON.parse(resId.dataUser);


			}
		</script>
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
						displayModalCollab(eventObj.id, eventObj.title, eventObj.start, eventObj.end );

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
            <?php
            $querySelectDate = $conn->prepare("SELECT * FROM order_session WHERE partner_id = ?");
            $querySelectDate->execute([$_SESSION['user']['partner_id']]);
            $resSelectDate = $querySelectDate -> fetchAll();



            foreach ($resSelectDate as $selectDates ) {
              $quesryService = $conn->prepare("SELECT service_id FROM orders WHERE order_id = ? ");
          		$quesryService->execute([$selectDates[1]]);
          		$resOrder = $quesryService->fetch();

              $quesryService = $conn->prepare("SELECT name FROM service WHERE id = ? ");
          		$quesryService->execute([$resOrder[0]]);
          		$resService = $quesryService->fetch();
              //var_dump($selectDates[2]);
             ?>
            {
							id: "<?php echo $selectDates[0]; ?>",
              title:"<?php echo $resService[0] ?>",
              start:"<?php echo $selectDates[2]."T".$selectDates[3]; ?>",
              end:"<?php echo $selectDates[2]."T".$selectDates[4];; ?>",
              allDay : false // will make the time show
            },

            <?php } ?>
						// {
						// 	title:"Meeting3",
						// 	start:"2020-04-15T14:30:00+00:00",
						// 	end:"2020-04-15T16:30:00+00:00",
						// 	allDay : false // will make the time show
						// },

					]
				});

				calendar.render();
			});

		</script>


	</head>
	<body>
		<header>
      <?php include('../libs/php/includes/partnerHeader.php');?>
		</header>
		<main>


			<section class="sizedSection">

				<div class="dataContainer">
					<h2 class="text-center">Planning - <?php echo $servicePrevu[$langue]; ?></h2>

						<div id='calendar'></div>
				</div>
			</section>

		</main>

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

		<script src='../libs/fullcalendar/packages/timegrid/main.js'></script>
		<script src='../libs/fullcalendar/packages/daygrid/main.js'></script>
		<script src='../libs/fullcalendar/packages/core/main.js'></script>

		<script src='../libs/fullcalendar/packages/core/locales-all.js'></script>
		<script src='http://code.jquery.com/jquery-1.11.3.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.0/fullcalendar.min.js'></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



		<!-- JS -->
		<script src="../libs/ajax/searchServices.js" charset="utf-8"></script>
		<script src="https://js.stripe.com/v3/"></script>
		<script src="../libs/js/checkout.js" charset="utf-8"></script>
		<script src="../ressources/js/script.js" charset="utf-8"></script>
		<script>
			$(function () {

			});
		</script>
	</body>
</html>
