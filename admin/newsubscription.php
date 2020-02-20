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

	include('../libs/php/db/db_connect.php');
	$insertRole = $conn->prepare("INSERT INTO membership(name, price, openDays, openHours, closeHours, timeQuota, closeDays, description, duration) VALUES(?, ?, ?, ?, ?, ?,0, ?, ?)");
	$insertRole->execute(array($name, $price, $openDays, $openHours, $closeHours, $hoursQuota, $description, $monthsDuration));

	// on recupere le last Id pour pouvoir le supprimer et update plus tard
	$lastInsertId = $conn->lastInsertId();

	/* * * * * * *
	* Stripe API 
	* On ajoute cet abonnement comme Produit dans l'API Stripe
	* * * * * * */
	require_once('../libs/stripe-php-master/init.php');
	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	\Stripe\Plan::create([
	'amount' => $price * 100,
	'currency' => 'eur',
	'interval' => 'month',
	'product' => [
		'name' => $name,
		'id' => $lastInsertId,
		'metadata' => [
			'description' => $description,
			'openDays' => $openDays,
			'openHours' => $openHours,
			'closeHours' => $closeHours,
			'hoursQuota' => $hoursQuota,
			'duration' => '12'
			]]
	]);

	/* * * * * * * * *
	* FIN Stripe API *
	* * * * * * * * */


	header('location:subscription.php?status=ajoutNewSub');
  }else{
	header('location:subscription.php?error=fieldblanks');
  }
}
 ?>
