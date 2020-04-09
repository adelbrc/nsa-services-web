<?php

require_once('libs/stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');


// creation d'un service de type babysitting

// $res = \Stripe\Plan::create([
// 	'amount' => 1500,
// 	'currency' => 'eur',
// 	'nickname' => "thisisit",
// 	'interval' => 'week',
// 	'product' => "prod_GpCXWFLVjr3PXh",

// 	'interval_count' => '1',
// 	'usage_type' => 'metered',
// 	'billing_scheme' => "per_unit",
// 	'aggregate_usage' => "sum"

// ]);


// commande d'unité de babysitting

// $customers = \Stripe\Customer::all(['email' => "narek@ok.com"]);



	// babysitting
$plan_ = "plan_H3gDiUCmHpTw4V";

	// anglais
// $plan_ = "plan_H3RcKDN3MIT23E";


// on verifie si l'USER A DEJA un ABONNEMENT ACTIF a ce SERVICE
$abonnement_a_ce_service_data = \Stripe\Subscription::all([
	'customer' => "cus_H47YJ8qFDX2Esf",
	'plan' => $plan_,
]);

$a_t_il_un_abonnement_a_ce_service = count($abonnement_a_ce_service_data["data"]);

// echo $a_t_il_un_abonnement_a_ce_service;


if ($a_t_il_un_abonnement_a_ce_service == 0) {
	// il n'a pas d'abonnement a ce service, il faut lui en creer un

	echo "on lui cree un abonnement";

	// // CREER UNE SUBSCRIPTION
	$sub_data = \Stripe\Subscription::create([
		// 'customer' => $booking->stripe_cus_id,
		'customer' => "cus_H47YJ8qFDX2Esf",
		'items' => [
			["plan" => $plan_]
		],
	]);
} else {
	echo "il a deja un abonnement a ce service, on le selectionne juste";
	$sub_data = $abonnement_a_ce_service_data["data"][0];
}

// var_dump($sub_data);
// var_dump(get_object_vars($))

$sub_ = $sub_data["id"]; // sub_...


$si_ = $sub_data["items"]["data"][0]["id"]; // si_...

// for (pour chaque session, creer un usage record)
$a = \Stripe\SubscriptionItem::createUsageRecord(
	$si_,
	[
		'quantity' => 3,
		'timestamp' => strtotime("now"),
		'action' => 'increment',
	]
);


echo "<br>3 Enregistrements ajoutés !";

// // recuperer l'id de la subscription : 
// echo $s["id"];

// echo $create_sub["id"];
// var_dump($create_sub);



// var_dump($a);
// var_dump($a["data"]);


// \Stripe\Invoice::upcoming(["customer" => "cus_H48whZXwlGNrGj"]);

?>