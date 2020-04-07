<?php



// obj est un parametre de la requete ajax, on verifie qu'on execute ce code legitimement
if (!isset($_GET["obj"]) || empty($_GET["obj"])) {
	echo json_encode(['status' => false, 'error' => "obj empty"]);
	exit;
}

/*
* Sommaire des fonctions 
* 1. resilier()
* 2. commandeService()
* 3. commandeServiceSpontanee
*
*
*/



function resilier() {

	$querySubscriptionId = $conn->prepare("SELECT sub_id FROM memberships_history WHERE user_id = ?");
	$querySubscriptionId->execute([$obj->user_id]);
	$res = $querySubscriptionId->fetch();

	// var_dump($res);

	// normalement si le mec a cliqué sur "Resilier" c'est qu'il a un abonnement/une ligne dans la table
	// on verifie quand meme


	if ($querySubscriptionId->rowCount()) {
		$queryRemoveSubscription = $conn->prepare("UPDATE memberships_history SET status = 'canceled' WHERE sub_id = ?");
		$queryRemoveSubscription->execute([$res["sub_id"]]);


		// Suppression de l'abonnement dans stripe
		if ($queryRemoveSubscription->rowCount()) {
			$subscription = \Stripe\Subscription::retrieve($res["sub_id"]);

			echo json_encode(['status' => true]);
			$subscription->delete();

		} else {
			echo json_encode(['status' => false, 'error' => 'removeSubRowCount', 'data' => $res["sub_id"]]);
		}

	} else {
		echo json_encode(['status' => false, 'error' => 'noSubscriptionYet']);
	}
}


function commandeService($conn, $booking) {	

	// partie stripe
	\Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');


	// 1. On insert la commande
	// 2. On insert la/les sessions / horaires à intervenir
	// partie bdd

	// 1. On insert la commande
	$queryInsertOrder = $conn->prepare("INSERT INTO `orders`(`customer_id`, `total_price`, `order_date`, `service_id`) VALUES (?, ?, NOW(), ?)");
	$res = $queryInsertOrder->execute([
		$booking->customer_id,
		10.1,
		$booking->id
	]);

	if ($res) {
		$message = "Order inserted";
	}

	// 2. On insert la/les sessions / horaires à intervenir
	$lastInsertId = $conn->lastInsertId();


	// on doit creer une subscription au service en question avant
	// de créer des enregistrements d'utilisations qui correspondent a cette subscription
	echo $booking->stripe_cus_id;
	$create_sub = \Stripe\Subscription::create([
		// 'customer' => $booking->stripe_cus_id,
		'customer' => "cus_H3QRTFfeicc9CU",
		'items' => [
			["plan" => "plan_Gr4kriRIBVadVV"]
		],
	]);
	echo $create_sub["id"];


	
	foreach ($booking->data as $session) {

		// stripe
		// le mec chargé pour chaque heure,
		// on incremente le compteur dheure dans stripe a chaque nouvelle session
		\Stripe\SubscriptionItem::createUsageRecord(
			$create_sub["id"],
			[
				'quantity' => 1,
				'timestamp' => 1522893428,
				'action' => 'increment',
			]
		);

		$queryInsertSession = $conn->prepare("INSERT INTO order_session(order_id, day, beginning, `end`) VALUES (?, ?, ?, ?)");
		$queryInsertSession->execute([
			$lastInsertId,
			$session->jour,
			$session->tdebut,
			$session->tfin
		]);
	}

	echo json_encode(['status' => "success", "action" => "redirect", "link" => "mes_services.php?status=serviceBooked", "message" => $message . " and sessions added"]);

}


function commandeServiceSpontanee($conn, $data) {
	// var_dump($data);

	// partie stripe






	// partie bdd

	$now = date("Y-m-d H:i:s");

	$queryInsertSpontanService = $conn->prepare("INSERT INTO spontaneous_service(user_id, title, description, order_date, service_date, start_time, end_time, service_place) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
	$res = $queryInsertSpontanService->execute([
		$data->customer_id,
		$data->title,
		$data->description,
		$now,
		$data->date,
		$data->start_time,
		$data->end_time,
		$data->place
	]);

	if ($queryInsertSpontanService->rowCount())
		echo json_encode(['status' => "success", "action" => "redirect", "link" => "mes_services.php?status=otherServiceBooked", "message" => ""]);
	else
		echo json_encode(['status' => "error", 'message' => "Une erreur s'est produite, veuillez réessayer plus tard"]);

}







	
if (isset($_GET["form"]) && !empty($_GET["form"])) {

	$form = htmlentities($_GET["form"], ENT_QUOTES);
	$obj = json_decode($_GET["obj"]);

	require_once "../db/db_connect.php";
	require_once('../../stripe-php-master/init.php');
	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	switch ($form) {
		case 'resilier':
			resilier();
			break;
		
		case 'commandeService':
			commandeService($conn, $obj);
			break;

		case 'commandeServiceSpontanee':
			commandeServiceSpontanee($conn, $obj);
			break;

		default:
			header("Location: /".$form.".php");
			break;
	}

} else {
	echo json_encode(['status' => false, 'error' => isset($_POST["obj"])]);
}

?>