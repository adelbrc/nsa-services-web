<?php include ('libs/php/isConnected.php');
if (!isConnected()) {
	header('location: index.php?error=accessUnauthorized');
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>dashboard</title>

	<!-- Stripe -->
	<!-- <link rel="stylesheet" type="text/css" href="./ressources/css/global.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="./ressources/css/normalize.css"> -->
    <script src="https://js.stripe.com/v3/"></script>
	<!-- Fin Stripe -->

	<!-- My styles -->
	<link rel="stylesheet" type="text/css" href="./ressources/style/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./ressources/style/user.css">
	<!-- Fin My styles -->

</head>
<body>
	<?php include('libs/php/includes/userHeader.php');
	include('libs/php/db/db_connect.php');
	?>
	<div>
		<h2 style="text-align: center; font-size: 50px; padding-top: 50px">Découvrez nos services</h2>
	</div>
	<hr class="my-4">




	<div class="container d-flex justify-content-around">

	<?php

		require_once('libs/stripe-php-master/init.php');
		\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

		$plans = \Stripe\Product::all();


		// on recupere et affiche tous les abonnements
		$queryMemberships = $conn->query("SELECT * FROM membership");
		$queryMemberships->execute();
		$memberships = $queryMemberships->fetchAll();
		foreach ($memberships as $membership):
	?>

			<div class="card text-center" style="width: 18rem;">
			  <img class="card-img-top" src="https://via.placeholder.com/300x250.png" alt="Card image cap">
			  <div class="card-body">
			    <h5 class="card-title"><?= $membership["name"] ?></h5>
			    <p class="card-text"><?= $membership["description"] ?></p>
			  </div>
			  <ul class="list-group list-group-flush">
			    <li class="list-group-item"><?= $membership["price"] ?> €</li>
			    <li class="list-group-item"><?= $membership["timeQuota"] ?> heures de services par mois</li>
			    <li class="list-group-item">Disponibilité <?= $membership["openDays"] ?>j / 7j</li>
			    <li class="list-group-item">De <?= $membership["openHours"] ?> h à <?= $membership["closeHours"] ?> h</li>
			    <li class="list-group-item">(Sans)/Engagement <?= $membership["duration"] ?> mois</li>
			  </ul>
			  <div class="card-body">
			    <a href="./#" class="btn btn-primary" id="<?= $membership['id'] ?>" data-toggle="modal" data-target="#paymentModal<?= $membership['id'] ?>">Je choisis <?= $membership["name"]; ?></a>
			  </div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="paymentModal<?= $membership['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="paymentModalLabel">Modal title<?= $membership['id'] ?></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">

						<!-- Stripe Form -->
						<form id="payment-form">
						  <div id="card-element">
						    <!-- Elements will create input elements here -->
						  </div>

						  <!-- We'll put the error messages in this element -->
						  <div id="card-errors" role="alert"></div>

						  <button id="submit">Pay</button>
						</form>

						<?php

							global $id_plan;

							$plans = \Stripe\Product::all();

							foreach ($plans as $plan) {
								var_dump($plan);
								// echo $plan["product"] . ' = ' . $plan["name"] . ' = ' . $plan["id"] . "<br>";
								if ($plan["product"] == $membership['id']) {
									$id_plan = $plan["id"];
								}
							}


							// $session = \Stripe\Checkout\Session::create([
							// 	'payment_method_types' => ['card'],
							// 	'subscription_data' => [
							// 		'items' => [
							// 			['plan' => $id_plan]
							// 		],
							// 	],
							// 	'success_url' => 'http://localhost/ESGI/PA2020/nsa-services-web/dashboard.php?redirect=success&session_id={CHECKOUT_SESSION_ID}',
							// 	'cancel_url' => 'http://localhost/ESGI/PA2020/nsa-services-web/index.php?redirect=cancel_payment',
							// ]);

						?>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary" onclick="redirectToCheckout('<?= $id_plan ?>')">Payer l'abonnement</button>
			      </div>
			    </div>
			  </div>
			</div>



		<?php endforeach; ?>




	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script>


		var PUBLISHABLE_KEY = "pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B";


		var DOMAIN = http://nsaservices.local;


		// "http://localhost/ESGI/PA2020/nsa-services-web";

		var stripe = Stripe(PUBLISHABLE_KEY);

		// Handle any errors from Checkout
		var handleResult = function(result) {
			if (result.error) {
				var displayError = document.getElementById("error-message");
				displayError.textContent = result.error.message;
			}
		};

		// cette fonction permet de rediriger vers le site de stripe avec l'id du plan
		var redirectToCheckout = function(planId) {
			stripe
				.redirectToCheckout({
					items: [{ plan: planId, quantity: 1 }],
					successUrl:
						// "https://" +
						DOMAIN +
						"/pages_stripe/success.php?session_id={CHECKOUT_SESSION_ID}",
					// cancelUrl: "https://" + DOMAIN + "/canceled.html"
					cancelUrl: DOMAIN + "/pages_stripe/canceled.html"
				})
				.then(handleResult);
		};



		// stripe.redirectToCheckout({
		// 	// Make the id field from the Checkout Session creation API response
		// 	// available to this file, so you can provide it as parameter here
		// 	// instead of the {{CHECKOUT_SESSION_ID}} placeholder.
		// 	sessionId: '{{CHECKOUT_SESSION_ID}}'
		// }).then(function (result) {
		// 	// If `redirectToCheckout` fails due to a browser or network
		// 	// error, display the localized error message to your customer
		// 	// using `result.error.message`.
		// 	console.log(result.error.message);
		// });
	</script>


</body>
</html>
