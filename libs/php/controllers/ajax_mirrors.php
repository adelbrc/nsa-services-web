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



function resilier($conn, $obj) {

	$querySubscriptionId = $conn->prepare("SELECT sub_id FROM memberships_history WHERE user_id = ?");
	$querySubscriptionId->execute([$obj->user_id]);
	$res = $querySubscriptionId->fetch();


	// normalement si le mec a cliqué sur "Resilier" c'est qu'il a un abonnement/une ligne dans la table
	// on verifie quand meme


	if ($querySubscriptionId->rowCount()) {
		$queryRemoveSubscription = $conn->prepare("UPDATE memberships_history SET status = 'canceled' WHERE sub_id = ?");
		$status = $queryRemoveSubscription->execute([$res["sub_id"]]);


		// Suppression de l'abonnement dans stripe
		if ($status) {
			$subscription = \Stripe\Subscription::retrieve($res["sub_id"]);


			try {
				$subscription->delete();
				echo json_encode(['status' => "success", "action" => "redirect", "link" => "dashboard.php", "Subscription canceled"]);
			} catch (Exception $e) {
				echo json_encode(['status' => "error", "data" => "This subscription ID has currently no subscription"]);
			}
		
		} else {
			echo json_encode(['status' => false, 'error' => 'removeSubRowCount', 'data' => $res["sub_id"]]);
		}

	} else {
		echo json_encode(['status' => false, 'error' => 'noSubscriptionYet']);
	}
}


function commandeService($conn, $booking) {	


	// partie stripe
	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');


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
	} else {
		echo json_encode(['status' => "error", "message" => "Order was not inserted"]);
	}

	// 2. On insert la/les sessions / horaires à intervenir
	$lastInsertId = $conn->lastInsertId();


	/*
	* For (pour chaque type de service commandé)
	*	1. On crée l'abonnement
	*	2. Pour autant de sessions commandées, on crée des "usage records" => des "entrées" d'utilisation
	*
	*
	*/


	// echo $booking->stripe_cus_id;


	$session_counter = 0;	
	foreach ($booking->data as $session) {
		$queryInsertSession = $conn->prepare("INSERT INTO order_session(order_id, day, beginning, `end`) VALUES (?, ?, ?, ?)");
		$queryInsertSession->execute([
			$lastInsertId,
			$session->jour,
			$session->tdebut,
			$session->tfin
		]);
		$session_counter += 1;
	}


	// stripe
	// on verifie si l'USER A DEJA un ABONNEMENT ACTIF a ce SERVICE
	$abonnement_a_ce_service_data = \Stripe\Subscription::all([
		'customer' => $booking->stripe_cus_id,
		'plan' => $booking->plan_id,
	]);

	$a_t_il_un_abonnement_a_ce_service = count($abonnement_a_ce_service_data["data"]);


	if ($a_t_il_un_abonnement_a_ce_service == 0) {
		// il n'a pas d'abonnement a ce service, il faut lui en creer un

		// // CREER UNE SUBSCRIPTION
		$sub_data = \Stripe\Subscription::create([
			// 'customer' => $booking->stripe_cus_id,
			'customer' => $booking->stripe_cus_id,
			'items' => [
				["plan" => $booking->plan_id]
			],
		]);
	} else {
		$sub_data = $abonnement_a_ce_service_data["data"][0];
	}


	$sub_ = $sub_data["id"]; // sub_...


	$si_ = $sub_data["items"]["data"][0]["id"]; // si_...

	// for (pour chaque session, creer un usage record)
	$a = \Stripe\SubscriptionItem::createUsageRecord(
		$si_,
		[
			'quantity' => $session_counter,
			'timestamp' => strtotime("now"),
			'action' => 'increment',
		]
	);


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
			resilier($conn, $obj);
			break;
		
		case 'commandeService':
			commandeService($conn, $obj);
			break;

		case 'commandeServiceSpontanee':
			commandeServiceSpontanee($conn, $obj);
			break;

		case 'stripe_service':
			stripe_service($conn, $obj);
			break;

		default:
			header("Location: /".$form.".php");
			break;
	}

} else {
	echo json_encode(['status' => false, 'error' => isset($_POST["obj"])]);
}

?>