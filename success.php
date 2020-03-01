<?php
require_once("libs/php/classes/User.php");
require_once("libs/php/classes/Service.php");
require_once("libs/php/classes/Order.php");

include("libs/php/functions/checkInput.php");

include ('libs/php/isConnected.php');
if (!isConnected()) {
	header('Location: index.php?error=accessUnauthorized');
	exit;
}


if (isset($_GET["session_id"]) && !empty($_GET["session_id"])) {
	require_once('libs/stripe-php-master/init.php');
	include('libs/php/db/db_connect.php');

	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	// si on finit sur cette page c'est que normalement le paiment s'est bien passé
	// on devrait avoir un session_id qui est enregistré dans stripe
	// on veut enregistrer les infos de cette commande en bdd
	// 1. on retrouve les infos selon l'id de la session
	// 2. on l'insert en bdd

	$session = \Stripe\Checkout\Session::retrieve($_GET["session_id"]);

	// Partie Service
	if (isset($_GET["type"]) && !empty($_GET["type"]) && $_GET["type"] == "service") {

		print_r($session);
		$service_id = $_GET["sid"];
		$service = Service::getServiceById($service_id);
		$order = new Order(NULL, $_SESSION["user"]["id"], date("Y-m-d-h-i-s"), 1, checkInput($service_id), 1, date("Y-m-d-h-i-s"), 0);
		Order::addOrder($order);
		exit;

	}


	// Partie Abonnement
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
		<link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
		<link rel="stylesheet" href="css/normalize.css" />
		<link rel="stylesheet" href="css/global.css" />
		<script src="https://js.stripe.com/v3/"></script>
	</head>

	<body>

		<?php include('libs/php/includes/userHeader.php');
		include('libs/php/db/db_connect.php');
		?>
		<div>
			<h2 style="text-align: center; font-size: 50px; padding-top: 50px">Abonnement réalisé avec succès</h2>
		</div>

		<hr class="my-4">

		<div class="alert alert-success bg-success w-50 mx-auto" role="alert">
			<h4 class="alert-heading text-light">Félicitations !</h4>
			<p class="text-light">Votre abonnement vient de commencer, découvrez dès maintenant tous les services que nous proposons. </p>
			<hr>
			<p class="mb-0 text-light">N'hésitez pas à nous solliciter pour n'importe quel service dont vous auriez besoin !</p>
			<hr>
			<!-- <div class="modal-footer w-25 mx-auto"> -->
			<a href="services.php">
				<button type="button" class="btn btn-primary">Consulter les services</button>
			</a>
		</div>
	</body>
</html>
