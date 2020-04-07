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

$customers = \Stripe\Customer::all(['email' => "narek@ok.com"]);

var_dump($customers["data"][0]);
var_dump($customers["data"][0]["id"]);

?>