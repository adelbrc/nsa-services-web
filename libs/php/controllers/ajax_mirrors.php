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
* 3. commandeDevis
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
	// 1. On insert la commande
	// 2. On recupere un prestataire aléatoirement en fonction de son role_id
	// 2Bis. On compare la date du service avec tout les autres services deja affecter au meme prestataire
	// 3. On insert la/les sessions / horaires à intervenir

	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	// 1. On insert la commande
	$queryInsertOrder = $conn->prepare("INSERT INTO `orders`(`customer_id`, `order_date`, `service_id`, address) VALUES (?, NOW(), ?, ?)");
	$res = $queryInsertOrder->execute([
		$booking->customer_id,
		$booking->service_id,
		$booking->address
	]);

	if ($res) {
		$message = "Order inserted";
	} else {
		echo json_encode(['status' => "error", "message" => "Order was not inserted"]);
	}
	$lastInsertId = $conn->lastInsertId();


	/*
	* For (pour chaque type de service commandé)
	*	1. On crée l'abonnement
	*	2. Pour autant de sessions commandées, on crée des "usage records" => des "entrées" d'utilisation
	*/

	// echo $booking->stripe_cus_id;
	$session_counter = 0;
	// 2. On recupere un prestataire aléatoirement en fonction de son role_id
	$querysearchPartner = $conn->prepare("SELECT * FROM partner WHERE role_id = ? ORDER BY RAND ( ) LIMIT 1 ");
	$querysearchPartner->execute([$booking->service_id]);
	$resta = $querysearchPartner->fetch();

	$queryCompareDatePartner = $conn->prepare("SELECT * FROM order_session WHERE partner_id = ?");
	$queryCompareDatePartner->execute([$resta['partner_id']]);
	$resCompareDatePartner = $queryCompareDatePartner -> fetchAll();

	$response = 1;

	while ($response == 0) {
	//

		//Je recupere tout les services du prestataire
		foreach ($resCompareDatePartner as $compareDate ) {

			//Je recupere le panier en cours pour le comparer avec les services deja commandé
			foreach ($booking->data as $sess) {
				$dateInBDD = $compareDate[2];
				$dateUnPanier = $sess->jour;

				//Si le prestataire est deja occuper ce jour alors on en cherche un autre
				if ($dateInBDD == $dateUnPanier) {
					$response = 0;
					//echo json_encode(['dateBDD' => $dateInBDD, "DatePanier" => $dateUnPanier]);
				} else {
					$response =1;
				}
			}
		}
		if ($response == 0) {
			$querysearchPartner = $conn->prepare("SELECT * FROM partner WHERE role_id = ? ORDER BY RAND ( ) LIMIT 1 ");
			$querysearchPartner->execute([$booking->service_id]);
			$resta = $querysearchPartner->fetch();

			$queryCompareDatePartner = $conn->prepare("SELECT * FROM order_session WHERE partner_id = ?");
			$queryCompareDatePartner->execute([$resta['partner_id']]);
			$resCompareDatePartner = $queryCompareDatePartner -> fetchAll();
		}
	}

	// 3. On insert la/les sessions / horaires à intervenir

	foreach ($booking->data as $session) {
		$queryInsertSession = $conn->prepare("INSERT INTO order_session(order_id, day, beginning, `end`, partner_id) VALUES (?, ?, ?, ?, ?)");
		$queryInsertSession->execute([
			$lastInsertId,
			$session->jour,
			$session->tdebut,
			$session->tfin,
			$resta['partner_id']
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



















function askDevis($conn, $nature, $booking) {

	// 1. On insert le devis general
	// 2. On insert les sessions du devis demandées
	// en fonction de la nature, le code de la query et les parametres donnés changent, on adapte donc le contexte




	switch ($nature) {
		// ce devis provient de services proposés
		case 'service':	
			$queryDevis = "INSERT INTO devis(
				customer_id,
				service_id,
				ordered_date,
				address
			) VALUES (?, ?, NOW(), ?)";

			$queryArray = [
				$booking->customer_id,
				$booking->service_id,
				$booking->address
			];
			break;

		case 'devis':
			$queryDevis = "INSERT INTO devis(
				customer_id,
				title,
				ordered_date,
				description,
				address
			) VALUES (?, ?, NOW(), ?, ?)";

			$queryArray = [
				$booking->customer_id,
				$booking->title,
				$booking->description,
				$booking->address
			];
			break;

		
		default:
			# code...
			break;
	}


	// 1. On insert le devis general
	$queryInsertDevis = $conn->prepare($queryDevis);

	$res = $queryInsertDevis->execute($queryArray);
	if (!$res) {
		echo json_encode(['status' => "error", "action" => "redirect", "link" => "mes_services.php?status=otherServiceBooked", "message" => "error de devis /"]);
	}

	$lastInsertId = $conn->lastInsertId();

	// on ajoute la/les sessions pour le type de devis demandé
	if ($nature == "service") {
		foreach ($booking->data as $session) {
			$queryInsertSession = $conn->prepare("INSERT INTO devis_session(
				devis_id_fk,
				devis_day,
				devis_begin_time,
				devis_end_time
				) VALUES (?, ?, ?, ?)");

			$queryInsertSession->execute([
				$lastInsertId,
				$session->jour,
				$session->tdebut,
				$session->tfin,
			]);
		}

		echo json_encode(['status' => "success", "action" => "redirect", "link" => "mes_services.php?status=serviceDevisBooked", "message" => "Devis reçu avec succès, nous reviendrons vers vous au plus vite"]);
		exit;

	} else if ($nature == "devis") {

		if (empty($booking->date))
			$booking->date = NULL;

		if (empty($booking->start_time))
			$booking->start_time = NULL;

		if (empty($booking->end_time))
			$booking->end_time = NULL;


		// si au moins date & start time sont vides, on n'entre pas de session
		if ($booking->date == NULL && $booking->start_time == NULL) {
			echo json_encode(['status' => "success", "action" => "redirect", "link" => "mes_services.php?status=otherServiceBooked", "message" => ""]);
			exit;
		}

		$queryInsertSessionDevis = $conn->prepare("INSERT INTO devis_session(
			devis_id_fk,
			devis_day,
			devis_begin_time,
			devis_end_time
		) VALUES (?, ?, ?, ?)");

		$queryInsertSessionDevis->execute([
			$lastInsertId,
			$booking->date,
			$booking->start_time,
			$booking->end_time
		]);
		
		echo json_encode(['status' => "success", "action" => "redirect", "link" => "mes_services.php?status=otherServiceBooked", "message" => ""]);
		exit;
	}



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

		case 'askDevis':
			askDevis($conn, $obj->nature, $obj);
			break;

		case 'stripe_service':
			// stripe_service($conn, $obj);
			break;

		default:
			header("Location: /".$form.".php");
			break;
	}

} else {
	echo json_encode(['status' => false, 'error' => isset($_POST["obj"])]);
}

?>
