<?php
include('../../libs/php/db/db_connect.php');
if (isset($_GET['user_id']) && !empty($_GET['user_id']) ) {
	$requeteSupprime =$conn->prepare('DELETE FROM user WHERE id = ?');
	$requeteSupprime ->execute(array(
		$_GET['user_id'],
	));
	exit;
}
if (isset($_GET['service_id']) && !empty($_GET['service_id']) ) {
	$requeteSupprime =$conn->prepare('DELETE FROM service WHERE id = ?');
	$requeteSupprime ->execute(array(
		$_GET['service_id'],
	));
	exit;
}
if (isset($_GET['id_plan']) && !empty($_GET['id_plan']) ) {
	// 1. on supprime sur stripe
	// 2. on supprime en bdd

	// 1
	require_once('../../libs/stripe-php-master/init.php');
	\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

	$deleted_plan = \Stripe\Plan::retrieve($_GET["id_plan"]);
	$deleted_plan->delete();


	// 2
	$requeteSupprime =$conn->prepare('DELETE FROM membership WHERE id_plan = ?');
	$requeteSupprime ->execute(array(
		$_GET['id_plan']
	));
	exit;
}
if (isset($_GET['category_id']) && !empty($_GET['category_id']) ) {
	$requeteSupprime =$conn->prepare('DELETE FROM category WHERE id = ?');
	$requeteSupprime ->execute(array(
		$_GET['category_id'],
	));
	exit;
}
if (isset($_GET['id_devis']) && !empty($_GET['id_devis']) ) {
	$requeteSupprime =$conn->prepare("UPDATE devis SET status = 'Rejeter' WHERE devis_id = ? ");
	$requeteSupprime ->execute(array(
		$_GET['id_devis'],
	));
	exit;
}
 ?>
