<?php

// pour lister les differents plans tarifaires du container de type "Plan" nommé "Abonnements"

require_once('libs/stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

// $plans = \Stripe\Plan::all(["limit" => 3]);
$plans = \Stripe\Plan::all();

foreach ($plans as $key => $plan) {
	echo "<b>" . $plans["data"][$key]["nickname"] . "</b><br>";
	echo $plans["data"][$key]["amount"] / 100 . " € / mois";

	$metadata = $plans["data"][$key]["metadata"];

	echo "<br>openDays : " . $metadata["openDays"] . "<br>";
	echo "openHour : " . $metadata["openHour"] . "<br>";
	echo "closeHour : " . $metadata["closeHour"] . "<br>";
	echo "hoursQuota : " . $metadata["hoursQuota"] . "<br><br><br>";
}


$products = \Stripe\Product::all();

echo "<b>Les products</b><br>";

foreach ($products as $key => $value) {
	echo $products["data"][$key]["name"] . "<br>";
}


?>