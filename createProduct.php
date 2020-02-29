<?php

require_once('libs/stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');


$product = \Stripe\Product::create([
	'name' => 'Limited Edition T-Shirt',
	'type' => 'good',
	'attributes' => ['size', 'gender', 'color'],
	'description' => 'Super awesome, one-of-a-kind t-shirt',
]);

echo "Produit créé : id = " . $product["id"];

$sku1 = \Stripe\SKU::create([
	'currency' => 'usd',
	'inventory' => [
		'type' => 'finite',
		'quantity' => 500,
	],
	'price' => 1500,
	'product' => $product["id"],
	'attributes' => [
		'size' => 'Medium',
		'gender' => 'Unisex',
		'color' => 'Cyan',
	],
]);

echo "<br>SKU associé au produit";

?>





<html>
	<head>
		<meta charset="utf-8">
	</head>

	<body>
		
	</body>
</html>