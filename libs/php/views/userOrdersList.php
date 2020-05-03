<?php
$list = Order::getUserOrders($user->getUID());
?>

<div class="dataContainer">
	<h3 class="text-center"><?php echo $historiqueCommande[$langue]; ?></h3>
	<div class="row">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Date</th>
						<th scope="col"><?php echo $quantite[$langue]; ?></th>
						<th scope="col">Service</th>
						<th scope="col"><?php echo $etatPaiement[$langue]; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $key => $order): ?>
						<tr>
							<th scope="row"><?php echo $order->getOrderId(); ?></th>
							<td><?php $thedate = new DateTime($order->getOrderDate()); echo $thedate->format('d/m/Y H:i:s'); ?></td>
							<td></td>
							<td><?php echo $order->getServiceId(); ?></td>
							<td><?php echo $order->getPaymentStatus(); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
