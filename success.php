<?php
require_once("libs/php/classes/User.php");
require_once("libs/php/classes/Membership.php");
require_once("libs/php/classes/Invoice.php");
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


	// Partie Abonnement
	$customer_id = $session["customer"]; // cus_...


	$subscribed_plan_id = $session["display_items"][0]["plan"]["id"]; // plan_...
	$subscription_id = $session["subscription"]; // sub_...
	$session_id = $session["id"]; // cs_...

	$payment_interval = $session["display_items"][0]["plan"]["interval"];
	$duration = $session["display_items"][0]["plan"]["metadata"]["duration"];

	$queryPlan_index = $conn->prepare("SELECT id, timeQuota FROM membership WHERE id_plan = ?");
	$queryPlan_index->execute([$subscribed_plan_id]);
	$res = $queryPlan_index->fetch();
	$plan_index = $res[0];
	$serviceTime = $res[1];


	// on retrouve l'email du client pour interroger la bdd et inserer son id de bdd
	$db_customer_email = \Stripe\Customer::retrieve($customer_id);
	$db_customer_email = $db_customer_email["email"];

	$queryUser_index = $conn->prepare("SELECT id FROM user WHERE email = ?");
	$queryUser_index->execute([$db_customer_email]);
	$user_index = $queryUser_index->fetch()[0];
	

	$queryInsertSubscription = $conn->prepare("INSERT INTO memberships_history (
		user_id,
		membership_id,

		customer_id,
		plan_id,
		sub_id,
		session_id,
		beginning,
		ending,
		status,
		serviceHoursRemaining

		) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
	);

	$date_now = date_create(date("Y-m-d"));

	$date_expire = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string($duration ." month"));

	try {
		$queryInsertSubscription->execute([
			$user_index,
			$plan_index,

			$customer_id,
			$subscribed_plan_id,
			$subscription_id,
			$session_id,
			$date_now->format("Y-m-d"),
			$date_expire->format("Y-m-d"),
			"active",
			$serviceTime
		]);
	} catch(Exception $e) {
		header("Location: ./dashboard.php?error=link_expired");
		// echo $e->getMessage();
	}

	if ($queryInsertSubscription->rowCount() == 1) {
		// echo "Tout s'est bien passé";
	} else {
		// echo "error";
	}

	// -------------------------------------------------
    // Récupération de l'objet User qui correspond à un customer
    $user = User::getUserByID($_SESSION["user"]["id"]);

    // Récupération de l'objet Membership qui correspond à l'abonnement choisi par le customer
    $membership = Membership::getMembershipById($plan_index);

    // Génération de la facture de l'abonnement choisi
    $user->generateMemberShipInvoice($membership);

	
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
