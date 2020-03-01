<?php


// if (isset($_GET["user_id"]) && !empty($_GET["user_id"]) &&
// 	isset($_GET["membership_id"]) && !empty($_GET["membership_id"])
// 	) {

if (isset($_GET["obj"]) && !empty($_GET["obj"])) {

	$obj = json_decode($_GET["obj"]);

	require_once "db/db_connect.php";
	require_once('../stripe-php-master/init.php');
	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	$querySubscriptionId = $conn->prepare("SELECT sub_id FROM memberships_history WHERE user_id = ?");
	$querySubscriptionId->execute([$obj->user_id]);
	$res = $querySubscriptionId->fetch();

	// normalement si le mec a cliqué sur "Resilier" c'est qu'il a un abonnement/une ligne dans la table
	// on verifie quand meme
	if ($querySubscriptionId->rowCount()) {
		$queryRemoveSubscription = $conn->prepare("DELETE FROM memberships_history WHERE sub_id = ?");
		$queryRemoveSubscription->execute([$res["sub_id"]]);
		if ($queryRemoveSubscription->rowCount()) {
			$subscription = \Stripe\Subscription::retrieve($res["sub_id"]);
			$subscription->delete();

			// on annule l'abonnement sur stripe aussi
			echo 1;
		}

	}



	// pour supprimer la souscription sur stripe on a besoin de l'id de souscription "sub_.." qu'on a dans notre bdd



}

?>