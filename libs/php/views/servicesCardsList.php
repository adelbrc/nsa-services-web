<?php

// Listing all products
$plans = \Stripe\Plan::all(['limit' => 10]);
$list = Service::getAllServices();


?>


<?php foreach ($list as $key => $service): ?>

	<?php

	foreach ($plans as $key => $plan) {
		if ($plan["id"] == $service->getId()) {
			$id_product = $plan["id"];
		}
	}

	?>


	<!-- les cards ne se chevauchent pas  -->
	<!-- <div class=""> -->

	<!-- les cards se chevauchent -->
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
			<div class="card serviceCard" style="width: 18rem;">
				<img src="ressources/img/nsa-services.png" style="width:100px;height:100px;margin:auto" alt="...">
				<div class="card-body">
					<h5 class="card-title"><?php echo $service->getName(); ?></h5>
					<p class="card-text"><?php echo $service ->getDescription(); ?></p>
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item"><?php echo "Prix: " . $service->getPrice() . "€/h"; ?></li>
					<li class="list-group-item"><?php echo "Categorie: " . $service->getServiceCategory(); ?></li>
					<li class="list-group-item"><?php echo "Id Plan: " . $service->getStripeID(); ?></li>
				</ul>
				
				<div class="card-body">
					<!-- Button trigger modal -->
					<button 
						type="button" 
						class="btn btn-success" 
						data-toggle="modal" 
						data-target="#exampleModal">
					  Commander
					</button>
				</div>

			</div>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
							<button 
								type="button" 
								class="btn btn-primary"
								onclick="redirectToCheckout('<?php echo $service->getStripeID(); ?>', '<?php echo $service->getId(); ?>', '<?= $_SESSION["user"]["email"] ?>')">
								Passer au paiement
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>


<?php endforeach; ?>
