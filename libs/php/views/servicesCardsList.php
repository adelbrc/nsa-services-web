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
					<!-- <li class="list-group-item"><?php echo "Id Plan: " . $service->getStripeID(); ?></li> -->
				</ul>
				
				<div class="card-body">
					<!-- Button trigger modal -->
					<button 
						type="button" 
						class="btn btn-success" 
						data-toggle="modal" 
						data-target="#bookingModal">
					  Commander
					</button>
				</div>

			</div>

			<!-- Modal -->
			<div class="modal fade bd-example-modal-lg" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" id="bookingModal2" role="document">
					<div class="modal-content" id="bookingModal3">
						<div class="modal-header">
							<h5 class="modal-title" id="bookingModalLabel">Commander : <?= $service->getName(); ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">


						<form action="">
				

							<div class="form-group">
								<label>Lieu</label>
								<input type="text" class="form-control" id="lieu_input" placeholder="Lieu de l'intervention" value="<?= $_SESSION['user']['address'] . ', ' . $_SESSION['user']['city'] ?>">
							</div>
							
							<div class="container">
								<button type="button" class="btn btn-primary" onclick="addBooking()">Ajouter une plage horaire</button>
								<!-- <button type="button" class="btn btn-primary">Fermer</button> -->
							</div>

							<!-- 			
								<div class="form-group">
									<label>Heure de fin</label>
									<input type="time" class="form-control" id="intervention_fin" placeholder="Heure de fin">
								</div>
							-->
							<h4>Réservations : </h4>
							<div class="container border p-3 d-flex flex-row" id="bookings_container">

								<div class="container booking_box border m-0 mr-3">
									<div class="form-group">
										<span class="compteurjour">Jour 1</span>
										<span aria-hidden="true" class="removeBooking" onclick="removeBooking(this)">×</span>
										<input type="date" class="form-control form-input jour" id="firstBookingBox" value="">
									</div>

									<div class="form-group">
										<label>Heure de début</label>
										<input type="time" class="form-control form-input tdebut" value="09:00" min="09:00" max="20:00" step="900">
									</div>

									<div class="form-group">
										<label>Heure de fin</label>
										<input type="time" class="form-control form-input tfin" value="10:00" min="09:00" max="20:00" step="900">
									</div>

									<div>
										<p>Prix : <span class="prix">10</span> €</p>
									</div>
								</div>
							</div>

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
