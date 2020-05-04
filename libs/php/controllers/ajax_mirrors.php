<?php

require_once("../classes/User.php");
require_once("../classes/Service.php");
require_once("../classes/Invoice.php");
include("../isConnected.php");

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

	$querySubscriptionId = $conn->prepare("SELECT sub_id FROM memberships_history WHERE user_id = ? AND status = 'active'");
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
				echo json_encode(['status' => "error", "data" => "This subscription ID has currently no subscription : " . $e->getMessage()]);
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

	// on recupere le nombre d'heures de services restantes
	$queryServiceTime = $conn->prepare("SELECT serviceHoursRemaining FROM memberships_history WHERE user_id = ? AND status = 'active'");
	$queryServiceTime->execute([$booking->customer_id]);
	$serviceTime = $queryServiceTime->fetch()[0];

	if (!isset($booking->special_status))
		$booking->special_status = 0;

	if ($serviceTime > 0) {
		$params = [
			$booking->customer_id,
			$booking->service_id,
			$booking->address,
			"included"
		];
	} else if ($booking->special_status == 1) {
		$params = [
			$booking->customer_id,
			$booking->service_id,
			$booking->address,
			'Paid'
		];
	} else {
		$params = [
			$booking->customer_id,
			$booking->service_id,
			$booking->address,
			'En attente'
		];
	}
	// 1. On insert la commande
	$queryInsertOrder = $conn->prepare("INSERT INTO orders(customer_id, order_date, service_id, address, payment_status) VALUES (?, NOW(), ?, ?, ?)");
	$res = $queryInsertOrder->execute($params);

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
				$hourDebutInDBB = $compareDate['beginning'];
				$hourDebutInPanier = $sess->tdebut;
				$hourFinInBDD = $compareDate['end'];
				$hourFinInPanier = $sess->tFin;
				$dateInBDD = $compareDate[2];
				$dateUnPanier = $sess->jour;

				//Si le prestataire est deja occuper ce jour alors on en cherche un autre
				if ($dateInBDD == $dateUnPanier) {
					if ($hourDebutInDBB == $hourDebutInPanier || $hourFinInBDD == $hourFinInPanier) {
							$response = 0;
					}

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

	$total_hours = 0;

	foreach ($booking->data as $session) {
		$queryInsertSession = $conn->prepare("INSERT INTO order_session(order_id, day, beginning, `end`, partner_id, orderStatus) VALUES (?, ?, ?, ?, ?, ?)");
		$queryInsertSession->execute([
			$lastInsertId,
			$session->jour,
			$session->tdebut,
			$session->tfin,
			$resta['partner_id'],
			"Prevu"
		]);

		$total_hours += intval(substr($session->tfin, 0, 2)) - intval(substr($session->tdebut, 0, 2));
	}



	// invoice
	$queryInsertInvoice = $conn->prepare("INSERT INTO invoice(stripe_id, customer_id, amount_paid, date_issue, service_id, file_path) VALUES (?, ?, ?, ?, ?, ?)");
	$queryInsertInvoice->execute([
		$booking->stripe_cus_id,
		$booking->customer_id,
		$booking->price * $total_hours,
		date("Y-m-d", strtotime("+1 week")),
		$booking->service_id,
		""
	]);



	// si on est en train d'enregistrer un service sans abonnement,
	// pas besoin de prendre un abonnement,
	// on affiche le message et on quitte
	if ($booking->special_status) {
		echo json_encode(['status' => "success", "action" => "redirect", "link" => "mes_services.php?status=serviceBooked", "message" => $message . " and sessions added"]);
		exit;
	}



	// on decremente son nombre d'heures de services incluses s'il en a
	if ($serviceTime) {
		$queryServiceTime = $conn->prepare("UPDATE memberships_history SET serviceHoursRemaining = ? WHERE user_id = ? AND status = 'active'");
		$queryServiceTime->execute([$serviceTime - $total_hours, $booking->customer_id]);
	}
	// s'il n'en a pas, on le fait payer normalement






	// stripe
	// on verifie si l'USER A DEJA un ABONNEMENT ACTIF a ce SERVICE
	$abonnement_a_ce_service_data = \Stripe\Subscription::all([
		'customer' => $booking->stripe_cus_id,
		'plan' => $booking->plan_id,
		'status' => 'active'
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
			'quantity' => $total_hours,
			'timestamp' => strtotime("now"),
			'action' => 'increment',
		]
	);


	// invoice
	// $queryInsertInvoice = $conn->prepare("INSERT INTO invoice(stripe_id, customer_id, amount_paid, date_issue, service_id, file_path) VALUES (?, ?, ?, ?, ?, ?)");
	// $queryInsertInvoice->execute([
	// 	$booking->stripe_cus_id,
	// 	$booking->customer_id,
	// 	$booking->price * $total_hours,
	// 	date("Y-m-d", strtotime("+1 week")),
	// 	$booking->service_id,
	// 	""
	// ]);


	$user = User::getUserById($_SESSION["user"]["id"]);

	$service = Service::getServiceById($booking->service_id);
	$totalPrice = $booking->price * $total_hours;

	$user->generateServiceInvoice($service, $booking->stripe_cus_id, $totalPrice);

	echo json_encode(['status' => "success", "action" => "redirect", "link" => "mes_services.php?status=serviceBooked", "message" => $message . " and sessions added"]);
}





function searchUser($conn, $obj){
	$idOrder = $obj->id;

	$quesryService = $conn->prepare("SELECT order_id FROM order_session WHERE session_id = ? ");
	$quesryService->execute([$idOrder]);
	$resService = $quesryService->fetch();


	$queryOrders = $conn->prepare("SELECT customer_id FROM orders WHERE order_id = ? ");
	$queryOrders->execute([$resService[0]]);
	$resOrder = $queryOrders->fetch();

	$queryUser = $conn->prepare("SELECT * FROM user WHERE id = ? ");
	$queryUser->execute([$resOrder[0]]);
	$resUser = $queryUser->fetch();

	echo json_encode(['status' => "success", "dataUser" => $resUser]);

}













function askDevis($conn, $nature, $booking) {

	// 1. On insert le devis general
	// 2. On insert les sessions du devis demandées
	// en fonction de la nature, le code de la query et les parametres donnés changent, on adapte donc le contexte

	switch ($nature) {
		// ce devis provient de services proposés
		case 'service':
			$queryDevis = "INSERT INTO devis(
				title,
				customer_id,
				service_id,
				ordered_date,
				address
			) VALUES (?, ?, ?, NOW(), ?)";

			$queryArray = [
				"Devis pour : " . $booking->name,
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



function handleDoublon($conn, $obj) {

	// echo $obj->id;
	// echo $obj->email;

	$queryRemoveDoublons = $conn->prepare("DELETE FROM partner WHERE email = ? AND partner_id != ?");
	// $queryRemoveDoublons = $conn->prepare("SELECT email FROM partner WHERE email = ? AND partner_id != ?");
	$queryRemoveDoublons->execute([$obj->email, $obj->id]);
	// echo $queryRemoveDoublons->rowCount();

	echo json_encode(['status' => "success", "action" => "show", "message" => $queryRemoveDoublons->rowCount() . " doublons effacés"]);

}





function payServices($conn, $obj) {
	$total = $obj->total;
	$cus = $obj->cus;
	$name = $obj->name;
	$plan = $obj->plan;
	$uid = $obj->uid;
	$oid = $obj->oid;

	// echo $uid . " (" . $cus . ") " . " veut payer " . $name . " (" . $plan . ") sans carte (cus id de creation)<br>";


	$queryRightCus = $conn->prepare("SELECT customer_id FROM memberships_history WHERE user_id = ? AND status = 'active'");
	$queryRightCus->execute([$uid]);
	$rightCus = $queryRightCus->fetch()[0];

	// echo "Le cus id de ". $uid . " avec lequel il a l'abonnement familiale donc la carte est : " . $rightCus . "<br>";


	// echo "Je demande le sub id composé de " . $cus . " avec " . $plan . "<br>";
	// on annule le prochain paiement automatique de stripe
	$retrieveSub = \Stripe\Subscription::all([
		"customer" => $cus,
		"plan" => $plan
	]);


	if (count($retrieveSub["data"]) == 0) {
		var_dump($retrieveSub["data"]);
		// on rentre ici si on avait deja annule cet abonnement et qu'on essaie d'annuler un truc deja annule
		echo json_encode(['status' => "error", "message" => "Reservation deja annulee, on vous facture pas 2 fois"]);
		exit;
	} else {
		// SI ON A UN ABONNEMENT ACTIF et bien on l'annule
		try {
			$subscription = \Stripe\Subscription::retrieve(
				$retrieveSub["data"][0]["id"]
			);
			$subscription->delete();

		} catch(Exception $e) {
			echo json_encode(['status' => "error", "message" => "Reservation deja payee : " . $e->getMessage()]);
			exit;
		}
	}


	// on met la methode par de paiement par defaut du mec
	$res = \Stripe\Customer::retrieve($rightCus);


	$pm = $res["invoice_settings"]["default_payment_method"];


	// on passe au paiement
	$invoice_item = \Stripe\InvoiceItem::create([
		'customer' => $rightCus,
		'amount' => $total * 100,
		'currency' => 'eur',
		'description' => 'Paiement manuel pour : ' . $name,
	]);


	$createdInvoice = \Stripe\Invoice::create([
	  'customer' => $rightCus,
	  'default_payment_method' => $pm,
	  // 'auto_advance' => true, /* auto-finalize this draft after ~1 hour */
	  'auto_advance' => false, // // //  auto-finalize this draft after ~1 hour
	]);

	// // on paie en avance
	$invoice = \Stripe\Invoice::retrieve($createdInvoice["id"]);
	$invoice->finalizeInvoice();
	$invoice->pay();

	// on met la ligne en bdd table orders comme Paid
		// Recup les infos du service courant concerne
	$querySetPaid = $GLOBALS["conn"]->prepare("UPDATE orders SET payment_status = 'Paid' WHERE order_id = ?");
	$resQuerySetPaid = $querySetPaid->execute([$oid]);
	if (!$querySetPaid->rowCount()) {
		echo json_encode(['status' => "error", "message" => "Erreur lors de la modification du statut du paiement"]);
	}

	echo json_encode(['status' => "success", "message" => "Service payé avec succès", "total" => $total]);


}


function confirmDevis($conn, $obj) {
	$devis_id = $obj->devis_id;
	$customer_id = $obj->customer_id;



	/* on va deplacer la reservation du devis de la table devis/devis_session à orders/order_session
	* 1. On selectionne le devis
	* 2. On selectionne sa session
	* 3. On insert into orders les infos du devis
	* 4. On insert into order session les infos de l'order avec l'id de l'order
	* 5. On fait l'achat par stripe
	* 6. On update ce devis comme "Confirmé"
	*/

	// 1
	$queryGetDevis = $conn->prepare("SELECT * FROM devis WHERE devis_id = ? AND customer_id = ?");
	$queryGetDevis->execute([$devis_id, $customer_id]);
	$queryGetDevisRes = $queryGetDevis->fetch();

	$service_id = $queryGetDevisRes["service_id"] != 0 ? $queryGetDevisRes["service_id"] : NULL;

	// 2
	$queryGetDevisSession = $conn->prepare("SELECT * FROM devis_session WHERE devis_id_fk = ?");
	$queryGetDevisSession->execute([$devis_id]);
	$queryGetDevisSessionRes = $queryGetDevisSession->fetch();


	// 3
	$queryTransformDevis = $conn->prepare("INSERT INTO orders(
		customer_id,
		order_date,
		service_id,
		address,
		payment_status) VALUES (?, NOW(), ?, ?, ?)");
	$queryTransformDevis->execute([
		$customer_id,
		$service_id,
		$queryGetDevisRes["address"],
		"En attente"
	]);


	// 4
	$lastInsertId = $conn->lastInsertId();

	$queryTransformDevisSession = $conn->prepare("INSERT INTO order_session(
		order_id,
		day,
		beginning,
		`end`,
		partner_id,
		orderStatus) VALUES (?, ?, ?, ?, ?, ?)");
	$queryTransformDevisSession->execute([
		$lastInsertId,
		$queryGetDevisSessionRes["devis_day"],
		$queryGetDevisSessionRes["devis_begin_time"],
		$queryGetDevisSessionRes["devis_end_time"],
		NULL,
		"Paid"
	]);

	// 5 achat du devis - stripe








	// 6
	$queryUpdateDevis = $conn->prepare("UPDATE devis SET status = 'Confirme' WHERE devis_id = ?");
	$queryUpdateDevis->execute([$devis_id]);

	echo json_encode(['status' => "success", "message" => "Devis transforme en order"]);



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

		case 'searchUser':
			searchUser($conn, $obj);
			break;
		case 'commandeService':
			commandeService($conn, $obj);
			break;

		case 'askDevis':
			askDevis($conn, $obj->nature, $obj);
			break;

		case 'doublon':
			handleDoublon($conn, $obj);
			break;

		case 'payServices':
			payServices($conn, $obj);
			break;

		case 'confirmDevis':
			confirmDevis($conn, $obj);
			break;

		default:
			header("Location: /".$form.".php");
			break;
	}

} else {
	echo json_encode(['status' => false, 'error' => isset($_POST["obj"])]);
}

?>
