<?php

include ('../libs/php/isConnected.php');

if ($_SESSION['user']['rank'] !=3) {
	header('location: ../index.php?error=accessUnauthorized');
}

include ('../libs/php/db/db_connect.php');

$req = $conn->prepare('SELECT * FROM membership WHERE id = ?');
$req->execute(array($_GET['id']));
$res = $req->fetch();

if (isset($_POST['changeButton'])) {

	// 1. on va supprimer le plan dans stripe avec cet id_plan
	// 2. on va recreer un plan avec les nouvelles modif
	// 3. on met a jour ce plan en bdd en changeant l'id et les nouvelles modif

	// 1
	require_once('../libs/stripe-php-master/init.php');
	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	$deleted_plan = \Stripe\Plan::retrieve($_POST["id_plan"]);
	$deleted_plan->delete();

	// 2.
	$newPlan = \Stripe\Plan::create([
	'currency' => 'eur',
	'amount' => intval($_POST['prix']) * 100,
	'interval' => 'month',
	'product' => 'prod_GmIrmkZZUKLyI1', // l'id du produit qui contient les differents plans tarifaires
	'nickname' => $_POST['nom'],
	'metadata' => [
		'openDays' => $_POST["openDays"],
		'openHours' => $_POST["openHours"],
		'closeHours' => $_POST["closeHours"],
		'hoursQuota' => $_POST["timeQuota"],
		'duration' => $_POST["duration"],
		'description' => $_POST["description"],
		]
	]);


	// echo "On a mis a jour le plan dans stripe<br>";


	$nouveau_id_du_plan = $newPlan["id"];

	// 3
	$queryUpdatePlan = $conn->prepare('UPDATE membership SET
		id_plan = ?,
		name = ?,
		price = ?,
		timeQuota = ?,
		openDays = ?,
		openHours = ?,
		closeHours = ?,
		description = ?,
		duration = ?
		WHERE id_plan = ?');

	$queryUpdatePlan->execute([
		$nouveau_id_du_plan,
		$_POST['nom'],
		intval($_POST['prix']),
		$_POST["timeQuota"],
		$_POST["openDays"],
		$_POST["openHours"],
		$_POST["closeHours"],
		$_POST["description"],
		$_POST["duration"],

		$_POST["id_plan"]
	]);


	// echo "On a update " . $_POST['nom'] . " en bdd, new plan id = " . $nouveau_id_du_plan . "<br>";

	// exit;

	header('location: subscription.php?status=worked');

}

?>




 <!DOCTYPE html>
 <html lang="fr" dir="ltr">
	<head>
	 <meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	 <link rel="stylesheet" href="../ressources/style/admin.css">
	 <link rel="stylesheet" href="../ressources/style/sidebar.css">
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
	 integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
	 <header>
	 <?php include('includes/headerNavigation.php'); ?>
	 </header>
	 <div class="container-fluid">
		<div class="row">
		 <?php include('includes/sidebar.php'); ?>
		 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="mx-auto border jumbotron col-md-6" id="jumboRole" style="margin-top: 75px;">
			 <br><br>
			 <form class="formModiMembership" action="" method="post">
				<div class="form-group col-md-8">
					<label for="exampleInputEmail1">Nom</label>
					<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"name="nom" value="<?php echo $res["name"] ?>">
				</div>
				<div class="form-group col-md-8">
					<label for="exampleInputEmail1">Prix (/an)</label>
					<input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"name="prix" value="<?php echo $res["price"] ?>">
				</div>
				<div class="form-group col-md-8">
					<label for="exampleInputEmail1">Nombre d'heure de services compris</label>
					<input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"name="timeQuota" value="<?php echo $res["timeQuota"] ?>">
				</div>
				<div class="form-group col-md-8">
					<label for="exampleInputEmail1">Nombre de jours ouvert (/7j)</label>
					<input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"name="openDays" value="<?php echo $res["openDays"] ?>">
				</div>
				<div class="form-group col-md-8">
					<label for="exampleInputEmail1">Heure d'ouverture</label>
					<input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"name="openHours" value="<?php echo $res["openHours"] ?>">
				</div>
				<div class="form-group col-md-8">
					<label for="exampleInputEmail1">Heure de fermeture</label>
					<input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"name="closeHours" value="<?php echo $res["closeHours"] ?>">
				</div>
				<div class="form-group col-md-8">
					<label for="exampleInputEmail1">Duree de l'abonnement (en mois)</label>
					<input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"name="duration" value="<?php echo $res["duration"] ?>">
				</div>
				<div class="form-group col-md-8">
					<label for="exampleInputEmail1">Description</label>
					<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"name="description" value="<?php echo $res["description"] ?>">
				</div>

				<input type="hidden" name="id_plan" value="<?= $res['id_plan'] ?>">
				<input type="submit" class="btn btn-primary" name="changeButton" value="Mettre à jour">
			 </form>
			</div>
		 </main>
		</div>
	 </div>
	</body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
 </html>
