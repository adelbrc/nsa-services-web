<?php

// Listing all products
$plans = \Stripe\Plan::all();
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
		<div>

	<!-- les cards se chevauchent -->
		<!-- <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"> -->
			<div class="card serviceCard" style="width: 18rem;margin-right: 20px;">
				<img src="ressources/img/nsa-services.png" style="width:100px;height:100px;margin:auto" alt="...">
				<div class="card-body">
					<h5 class="card-title"><?php echo $service->getName(); ?></h5>
					<p class="card-text"><?php echo $service ->getDescription(); ?></p>
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item"><?php echo "Prix: " . $service->getPrice() . "€/h"; ?></li>
					<li class="list-group-item"><?php echo "Categorie: " . $service->getServiceCategory(); ?></li>
					<!-- <li class="list-group-item"><?php echo "Id Plan: " . $service->getStripeID(); ?></li> -->
				</ul>
				
				<div class="card-body">
					<!-- Button trigger modal -->
					<button 
						type="button" 
						class="btn btn-success" 
						data-toggle="modal" 
						data-target="#bookingModal<?= $service->getId() ?>">
					  Commander
					</button>
				</div>

			</div>

			<!-- Modal -->
			<div class="modal fade bd-example-modal-lg" id="bookingModal<?= $service->getId() ?>" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="bookingModalLabel">Commander : <?= $service->getName(); ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">


						<form action="" id="form_<?= $service->getID() ?>">
				

							<div class="form-group">
								<label>Lieu</label>
								<input type="text" class="form-control" id="address_input_<?= $service->getID() ?>" placeholder="Lieu de l'intervention" value="<?= $_SESSION['user']['address'] . ', ' . $_SESSION['user']['city'] ?>">
							</div>
							
							<div class="container">
								<button type="button" class="btn btn-primary" onclick="addBooking('bookings_container_<?= $service->getStripeID() ?>', '<?= $service->getID() ?>', <?= $service->getPrice() ?>)">Ajouter une plage horaire</button>
								<!-- <button type="button" class="btn btn-primary">Fermer</button> -->
							</div>

							<!-- 			
								<div class="form-group">
									<label>Heure de fin</label>
									<input type="time" class="form-control" id="intervention_fin" placeholder="Heure de fin">
								</div>
							-->
							<h4>Réservations : </h4>
							<div class="container border p-3 d-flex flex-row bookings_container" id="bookings_container_<?= $service->getStripeID() ?>">

								<div class="container booking_box booking_<?= $service->getId() ?> border m-0 mr-3">
									<div class="form-group">
										<span class="compteurjour">Jour 1</span>
										<span aria-hidden="true" class="removeBooking" onclick="removeBooking(this, '<?= $service->getID() ?>', <?= $service->getPrice() ?>)">×</span>
										<input type="date" class="form-control form-input jour_<?= $service->getID() ?>" id="firstBookingBox" value="<?= date('Y-m-d') ?>">
									</div>

									<div class="form-group">
										<label>Heure de début</label>
										<input type="time" class="form-control form-input tdebut_<?= $service->getID() ?>" value="09:00" min="09:00" max="20:00" step="900">
									</div>

									<div class="form-group">
										<label>Heure de fin</label>
										<input type="time" class="form-control form-input tfin_<?= $service->getID() ?>" value="10:00" min="09:00" max="20:00" step="900">
									</div>

									<div>
										<p>Prix : <span class="prix"><?= $service->getPrice() ?></span> €</p>
									</div>
								</div>
							</div>
							<h5>Total : <span class="totalprix_service_<?= $service->getId() ?>"><?= $service->getPrice() ?></span> €</h5>

						</form>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
							<button 
								type="button" 
								class="btn btn-success"
								>
								<!-- onclick="redirectToCheckout('<?php echo $service->getStripeID(); ?>', '<?php echo $service->getId(); ?>', '<?= $_SESSION["user"]["email"] ?>')" -->
								Paiement Direct
							</button>
							<button 
								type="button" 
								class="btn btn-primary"
								id="addPanier_button"
								data-service-name="<?= $service->getName() ?>"
								data-service-price="<?= $service->getPrice() ?>"
								data-service-plan_id="<?= $service->getStripeID() ?>"
								data-service-id="<?= $service->getId() ?>"
								data-customer-id="<?= $_SESSION["user"]["id"] ?>"
								data-customer-stripe-id="<?= $_SESSION["user"]["cus_id"] ?>"
								onclick="addPanier(this)"
								>
								Ajouter au panier
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php endforeach; ?>
