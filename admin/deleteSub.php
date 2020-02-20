<?php
include('../libs/php/db/db_connect.php');

$deleteSubs = $conn->prepare("INSERT INTO membership(name, price, openDays, openHours, closeHours) VALUES(?, ?, ?, ?, ?)");
$deleteSubs->execute(array($nom, $tarif, $NbJrs, $OpenHour, $CloseHour));

// wtf pourquoi insert into dans "delete" ?

/* * * * * * *
* Stripe API 
* On supprime aussi l'abonnement côté Stripe
* * * * * * */

// \Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

// $plan = \Stripe\Plan::retrieve('gold');
// $plan->delete();

/* * * * * * * * *
* FIN Stripe API *
* * * * * * * * */

?>
