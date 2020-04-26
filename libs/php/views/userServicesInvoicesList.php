<?php

// Recuperer les commandes faites par cet user
$queryOrders = $GLOBALS["conn"]->prepare("SELECT order_id, order_date, service_id FROM orders WHERE customer_id = ? -- AND payment_status = 'En attente'");
$queryOrders->execute([$user->getUID()]);
$userOders = $queryOrders->fetchAll();

foreach ($userOders as $order) {

	// Recup les infos du service courant concerne
	$queryServiceInfos = $GLOBALS["conn"]->prepare("SELECT name, price, id_service FROM service WHERE id = ?");
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
				<a class="btn btn-success" href="#" onclick="payServices(this, 'modal<?= $order['service_id'] . $order['order_id'] ?>')" 
					data-service-id="<?= $serviceInfo["id_service"] ?>" 
					data-service-name="<?= $serviceInfo['name'] ?>" 
					data-total="<?= $total_price ?>" 
					data-cus="<?= $_SESSION["user"]["cus_id"] ?>"
					>Payer <?= $total_price ?> €</a>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="modal<?= $order['service_id'] . $order['order_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						...
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>

<?php } ?>

