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
\Stripe\SubscriptionItem::createUsageRecord(
	'si_GxDyoFvXXkslHr',
	[
		'quantity' => 100,
		'timestamp' => 1522893428,
		'action' => "increment",
	]
);

?>