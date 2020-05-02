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

		<title>Mes interventions - Home Services</title>

		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/../libs/fullcalendar/2.6.0/fullcalendar.css' />

		<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
		<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />
		<link rel="stylesheet" href="../ressources/style/style.css">
	</head>
	<body>
		<header>
      <?php include('../libs/php/includes/partnerHeader.php');?>
		</header>
		<main>


			<section class="sizedSection">

				<div class="dataContainer">
					<h2 class="text-center">Mon historiques des interventions</h2>
          <table class="table"  >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Heure debut</th>
                <th scope="col">Heure Fin</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // !!!! la table order est aussi un mot clé ORDER BY donc faut mettre les ``
              $queryMyServices = $conn->prepare("SELECT * FROM `order_session` WHERE partner_id = ?");
              $queryMyServices->execute([$_SESSION["user"]["partner_id"]]);
              while (($row = $queryMyServices->fetch())):

                ?>

                <tr>
                  <th scope="row"><?= $row["session_id"] ?></th>
                  <td><?= date('d-m-Y', strtotime($row['day'])); ?></td>
                  <td><?= $row['beginning'] ?></td>
                  <td><?= $row['end'] ?></td>
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

		<script src='http://code.jquery.com/jquery-1.11.3.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.0/fullcalendar.min.js'></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



		<!-- JS -->
		<script src="../libs/ajax/searchServices.js" charset="utf-8"></script>
		<script src="https://js.stripe.com/v3/"></script>
		<script src="../libs/js/checkout.js" charset="utf-8"></script>
		<script src="../ressources/js/script.js" charset="utf-8"></script>

	</body>
</html>
