<?php

if (isset($_GET["session_id"]) && !empty($_GET["session_id"])) {
	require_once('../libs/stripe-php-master/init.php');
	include('../libs/php/db/db_connect.php');

	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	// si on finit sur cette page c'est que normalement le paiment s'est bien passé
	// on devrait avoir un session_id qui est enregistré dans stripe
	// on veut enregistrer les infos de cette commande en bdd
	// 1. on retrouve les infos selon l'id de la session
	// 2. on l'insert en bdd

	$session = \Stripe\Checkout\Session::retrieve($_GET["session_id"]);

	$customer_id = $session["customer"]; // cus_...
	$subscribed_plan_id = $session["display_items"][0]["plan"]["id"]; // plan_...
	$subscription_id = $session["subscription"]; // sub_...
	$session_id = $session["id"]; // cs_...

	$payment_interval = $session["display_items"][0]["plan"]["interval"];
	$duration = $session["display_items"][0]["plan"]["metadata"]["duration"];

	$queryPlan_index = $conn->prepare("SELECT id FROM membership WHERE id_plan = ?");
	$queryPlan_index->execute([$subscribed_plan_id]);
	$plan_index = $queryPlan_index->fetch()[0];
	// echo $plan_index; // 20


	// on retrouve l'email du client pour interroger la bdd et inserer son id de bdd
	$db_customer_email = \Stripe\Customer::retrieve($customer_id);
	$db_customer_email = $db_customer_email["email"];
	// echo $db_customer_email; // test@ok.com

	$queryUser_index = $conn->prepare("SELECT id FROM user WHERE email = ?");
	$queryUser_index->execute([$db_customer_email]);
	$user_index = $queryUser_index->fetch()[0];
	// echo $user_index; // 1
	if ($user_index == NULL) {
		echo "Vous avez abonnez quelqu'un d'autre";
		exit;
	}


	$queryInsertSubscription = $conn->prepare("INSERT INTO memberships_history(
		user_id,
		membership_id,

		customer_id,
		plan_id,
		sub_id,
		session_id,
		beginning,
		ending,
		status

		) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
	);

	$date_now = date_create(date("Y-m-d"));

	$date_expire = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string($duration ." month"));
	
	$queryInsertSubscription->execute([
		$user_index,
		$plan_index,

		$customer_id,
		$subscribed_plan_id,
		$subscription_id,
		$session_id,
		$date_now->format("Y-m-d"),
		$date_expire->format("Y-m-d"),
		"active"

	]);

	if ($queryInsertSubscription->rowCount() == 1) {
		echo "Tout s'est bien passé";
	} else {
		echo "error";
	}



}

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Stripe Checkout Sample</title>
		<meta name="description" content="A demo of Stripe Payment Intents" />

		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="css/normalize.css" />
		<link rel="stylesheet" href="css/global.css" />
		<script src="https://js.stripe.com/v3/"></script>
	</head>

	<body>
		<div class="sr-root">
			<div class="sr-main">
			<header class="sr-header">
				<div class="sr-header__logo"></div>
			</header>
			<div class="sr-payment-summary completed-view">
				<h1>Your test subscription has started</h1>
				<h4>Checkout Session ID: <span id="session"></span></h4>
			</div>
			<div class="sr-content">
			<div class="pasha-image-stack">
				<img
					src="https://picsum.photos/280/320?random=1"
					width="140"
					height="160"
				/>
				<img
					src="https://picsum.photos/280/320?random=2"
					width="140"
					height="160"
				/>
				<img
					src="https://picsum.photos/280/320?random=3"
					width="140"
					height="160"
				/>
				<img
					src="https://picsum.photos/280/320?random=4"
					width="140"
					height="160"
				/>
			</div>
			</div>
		</div>
		<script>
			// Replace with your own publishable key: https://dashboard.stripe.com/test/apikeys
			var PUBLISHABLE_KEY = "pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B";
			
			var stripe = Stripe(PUBLISHABLE_KEY);
			var urlParams = new URLSearchParams(window.location.search);

			if (urlParams.has("session_id")) {
				document.getElementById("session").textContent = urlParams.get("session_id");

				// ajax request to save customer
			}
		</script>
	</body>
</html>
