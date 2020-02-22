<?php

if(isset($_POST['formNewSub'])){
  if(!empty($_POST['nom']) AND !empty($_POST['Description']) AND !empty($_POST['duration'])  AND !empty($_POST['tarif'])  AND !empty($_POST['NbJrs'])  AND !empty($_POST['OpenHour']) AND !empty($_POST['CloseHour']) ){

	$name = htmlspecialchars($_POST['nom']);
	$price = htmlspecialchars($_POST['tarif']);
	$openDays = htmlspecialchars($_POST['NbJrs']);
	$openHours = htmlspecialchars($_POST['OpenHour']);
	$closeHours = htmlspecialchars($_POST['CloseHour']);
	$hoursQuota= htmlspecialchars($_POST['timeQuotas']);
	$description = htmlspecialchars($_POST['Description']);
	$monthsDuration = htmlspecialchars($_POST['duration']);



	// on va l'inserer (1) dans stripe puis (2) en bdd
	// comme ca on peut recuperer le id_plan genere par stripe pour le mettre en bdd

	// (1) Insert dans stripe
	require_once('../libs/stripe-php-master/init.php');
	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	// on stock cette requete parce qu'elle renvoie les infos du plan créé (comme l'id qu'on va stocker en bdd)
	$newPlan = \Stripe\Plan::create([
	'currency' => 'eur',
	'amount' => $price * 100,
	'interval' => 'month',
	'product' => 'prod_GmIrmkZZUKLyI1', // l'id du produit qui contient les differents plans tarifaires
	'nickname' => $name,
	'metadata' => [
		'openDays' => $openDays,
		'openHours' => $openHours,
		'closeHours' => $closeHours,
		'hoursQuota' => $hoursQuota,
		'duration' => $monthsDuration,
		'description' => $description,
		]
	]);


	echo "Nouveau plan ajouté dans stripe<br>";
	

	// (2)
	include('../libs/php/db/db_connect.php');
	$insertMembership = $conn->prepare("INSERT INTO membership(id_plan, name, price, openDays, openHours, closeHours, timeQuota, description, duration) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$insertMembership->execute(
		array(
			$newPlan["id"],
			$name, 
			$price, 
			$openDays, 
			$openHours, 
			$closeHours, 
			$hoursQuota, 
			$description, 
			$monthsDuration
		)
	);

	echo "Nouveau plan ajouté en base de donnees<br>";


	// var_dump($_POST);
	// exit;


	header('location:subscription.php?status=ajoutNewSub');
  }else{
	header('location:subscription.php?error=fieldblanks');
  }
}
 ?>
