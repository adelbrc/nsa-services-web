<?php include ('libs/php/isConnected.php');
if (!isConnected()) {
	header('location: index.php?error=accessUnauthorized');
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>dashboard</title>
	<link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="ressources/style/user.css">


</head>
<body>
	<?php include('libs/php/includes/userHeader.php');
	include('libs/php/db/db_connect.php');
	?>
	<div>
		<h2 style="text-align: center; font-size: 50px; padding-top: 50px">Découvrez nos services</h2>
	</div>
	<hr class="my-4">




	<div class="container d-flex justify-content-around">

	<?php

		// on recupere et affiche tous les abonnements
		$queryMemberships = $conn->query("SELECT * FROM membership");
		$queryMemberships->execute();
		$memberships = $queryMemberships->fetchAll();
		foreach ($memberships as $membership):
	?>

			<div class="card text-center" style="width: 18rem;">
			  <img class="card-img-top" src="https://via.placeholder.com/300x250.png" alt="Card image cap">
			  <div class="card-body">
			    <h5 class="card-title"><?= $membership["name"] ?></h5>
			    <p class="card-text"><?= $membership["description"] ?></p>
			  </div>
			  <ul class="list-group list-group-flush">
			    <li class="list-group-item"><?= $membership["price"] ?> €</li>
			    <li class="list-group-item"><?= $membership["timeQuota"] ?> heures de services par mois</li>
			    <li class="list-group-item">Disponibilité <?= $membership["openDays"] ?>j / 7j</li>
			    <li class="list-group-item">De <?= $membership["openHours"] ?> h à <?= $membership["closeHours"] ?> h</li>
			    <li class="list-group-item">(Sans)/Engagement <?= $membership["duration"] ?> mois</li>
			  </ul>
			  <div class="card-body">
			    <a href="#" class="btn btn-primary" id="<?= $membership['id'] ?>">Je choisis <?= $membership["name"]; ?></a>
			  </div>
			</div>

		<?php endforeach; ?>


		

	</div>


	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
