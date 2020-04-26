<?php

// Recuperer les commandes faites par cet user
$queryOrders = $GLOBALS["conn"]->prepare("SELECT order_id, order_date, service_id FROM orders WHERE customer_id = ? -- AND payment_status = 'En attente'");
$queryOrders->execute([$user->getUID()]);
$userOders = $queryOrders->fetchAll();

foreach ($userOders as $order) {

	// Recup les infos du service courant concerne
	$queryServiceInfos = $GLOBALS["conn"]->prepare("SELECT name, price FROM service WHERE id = ?");
	$queryServiceInfos->execute([$order["service_id"]]);
	$serviceInfo = $queryServiceInfos->fetch();

	// Recup le nombre de sessions
	$querySessions = $GLOBALS["conn"]->prepare("SELECT beginning, `end` FROM order_session WHERE order_id = ?");
	$querySessions->execute([$order["order_id"]]);
	$sessionInfo = $querySessions->fetchAll();
	// var_dump($sessionInfo);
	$sess = count($sessionInfo);

	// on compte le nombre de sessions d'heure
	$hours = 0;
	foreach ($sessionInfo as $session) {
		// var_dump(intval(substr($session["end"],0, 2)) - substr($session["beginning"],0, 2));
		$hours += intval(substr($session["end"],0, 2)) - substr($session["beginning"],0, 2);
	}
	$total_price = $serviceInfo["price"] * $hours;

	?>
	
		<div class="container w-25 col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<p><b><?= $serviceInfo["name"] ?></b><br>
			<?= $hours ?> h (<?= $serviceInfo["price"] ?> € / h)</p>
			<div class="float-right">
				<a class="btn btn-success" href="#">Payer <?= $total_price ?> €</a>
			</div>
		</div>
		<hr>

<?php } ?>

