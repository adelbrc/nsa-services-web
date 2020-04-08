<?php


if (!isset($_GET["obj"]) || empty($_GET["obj"])) {
	echo json_encode(['status' => false, 'error' => "obj empty"]);
	exit;
}

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
	// 1. On insert la commande
	// 2. On recupere un prestataire aléatoirement en fonction de son role_id
	// 2Bis. On compare la date du service avec tout les autres services deja affecter au meme prestataire
	// 3. On insert la/les sessions / horaires à intervenir

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
	$lastInsertId = $conn->lastInsertId();

	// 2. On recupere un prestataire aléatoirement en fonction de son role_id
  $response = 0;
  while ($response != 1) {

		$querysearchPartner = $conn->prepare("SELECT * FROM partner WHERE role_id = ? ORDER BY RAND ( ) LIMIT 1 ");
		$querysearchPartner->execute([$booking->id]);
		$resta = $querysearchPartner->fetch();

		$queryCompareDatePartner = $conn->prepare("SELECT * FROM order_session WHERE partner_id = ?");
		$queryCompareDatePartner->execute([$resta['partner_id']]);
		$resCompareDatePartner = $queryCompareDatePartner -> fetchAll();

		//Je recupere tout les services du prestataire
		foreach ($resCompareDatePartner as $compareDate ) {

			//Je recupere le panier en cours pour le comparer avec les services deja commandé
			foreach ($booking->data as $sess) {
				$dateInBDD = $compareDate[2];
				$dateUnPanier = $sess->jour;

				//Si le prestataire est deja occuper ce jour alors on en cherche un autre
				if ($dateInBDD == $dateUnPanier){
					$response = 0;
					//echo json_encode(['dateBDD' => $dateInBDD, "DatePanier" => $dateUnPanier]);
				}else
				$response =1;
			}
		}
	 }


	// 3. On insert la/les sessions / horaires à intervenir

	foreach ($booking->data as $session) {
		$queryInsertSession = $conn->prepare("INSERT INTO order_session(order_id, day, beginning, `end`, partner_id) VALUES (?,?, ?, ?, ?)");
		$queryInsertSession->execute([
			$lastInsertId,
			$session->jour,
			$session->tdebut,
			$session->tfin,
			$resta['partner_id']
		]);
	}
	echo json_encode(['status' => "success", "action" => "redirect", "link" => "mes_services.php?status=serviceBooked", "message" => $message . " and sessions added"]);

}




function commandeServiceSpontanee($conn, $data) {
	// var_dump($data);

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
