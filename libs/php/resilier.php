<?php


if (isset($_GET["obj"]) && !empty($_GET["obj"])) {

	$obj = json_decode($_GET["obj"]);

	require_once "db/db_connect.php";
	require_once('../stripe-php-master/init.php');
	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	$querySubscriptionId = $conn->prepare("SELECT sub_id FROM memberships_history WHERE user_id = ?");
	$querySubscriptionId->execute([$obj->user_id]);
	$res = $querySubscriptionId->fetch();

	// var_dump($res);

	// normalement si le mec a cliqué sur "Resilier" c'est qu'il a un abonnement/une ligne dans la table
	// on verifie quand meme


	if ($querySubscriptionId->rowCount()) {
		$queryRemoveSubscription = $conn->prepare("UPDATE memberships_history SET status = 'unactive' WHERE sub_id = ?");
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
} else {
	echo json_encode(['status' => false, 'error' => isset($_POST["obj"])]);
}

?>