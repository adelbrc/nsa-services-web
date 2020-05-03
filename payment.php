<?php

include("libs/php/isConnected.php");
include('libs/php/functions/translation.php');

if (!isset($_GET['panier']) OR !isset($_GET['hiddenpanier'])) {
	header("Location: mes_services.php");
}

require_once("libs/php/classes/DBManager.php");
$conn = DBManager::getConn();

require_once('libs/stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');


if (isset($_GET['lang']))
	$langue = $_GET["lang"];
else
	$langue = 0;


// STRIPE 
if (isset($_GET['stripeToken'])) {
	$token = $_GET['stripeToken'];

	// // retrouver le token
	// $retrieveToken = \Stripe\Token::retrieve($token);

	// // 
	// var_dump($retrieveToken["card"]["id"]);
	// $card_id = $retrieveToken["card"]["id"];


	// $src = \Stripe\Source::create(
	// 	[
	// 		"type" => "ach_credit_transfer",
	// 		"currency" => "usd",
	// 		"owner" => [
	// 			"email" => $_SESSION["user"]["email"]
	// 		]
	// 	]
	// );
	
	// $cus_src = \Stripe\Customer::createSource(
	// 	$_SESSION["user"]["cus_id"],
	// 	[
	// 		'source' => $src["id"],
	// 	]
	// );


	// \Stripe\Customer::update(
	// 	$_SESSION["user"]["cus_id"],
	// 	[
	// 		'default_source' => $src
	// 	]
	// );

	
	$charge = \Stripe\Charge::create([
		'amount' => $_GET['total'] * 100,
		'currency' => 'eur',

		// 'customer' => $_SESSION['user']['cus_id'],
		'description' => 'Commande de service sans abonnement',
		'source' => $token,
	]);

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://js.stripe.com/v3/"></script>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="ressources/style/style.css">

		<title>Home Services | Payment</title>

	</head>
	<body>
		<header>
			<?php include('libs/php/includes/userHeader.php'); ?>

		</header>

		<main>
	
			<section class="sizedSection">
				<div class="dataContainer">
					<div class="row" id="error-message">
					</div>
			

					<!-- <h2 class="text-center"><?php echo $chercherService[$langue]; ?></h2> -->
					<h2 class="text-center">Payer sa commande de <span id="total_text"></span> €</h2>
					
					<form action="" method="GET" id="payment-form">
						<div class="form-row">
							<label for="card-element">
								Veuillez insérer vos informations
							</label>

							<div id="card-element">
								A Stripe Element will be inserted here.
							</div>

							<div id="card-errors" role="alert"></div>
						</div>

						<input type="hidden" id="hiddenpanier" name="hiddenpanier">
						<input type="hidden" id="total" name="total">

						<button class="btn btn-success">Payer</button>
					</form>

				</div>
			</section>


		</main>


		<script src="ressources/js/script.js"></script>

		<script>

			// stripe
			var stripe = Stripe('pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B');
			var elements = stripe.elements();


			var style = {
				base: {
					// Add your base input styles here. For example:
					fontSize: '16px',
					color: '#32325d',
				},
			};

			// Create an instance of the card Element.
			var card = elements.create('card', {style: style});

			// Add an instance of the card Element into the `card-element` <div>.
			card.mount('#card-element');

			// Create a token or display an error when the form is submitted.
			var form = document.getElementById('payment-form');
			form.addEventListener('submit', function(event) {
				event.preventDefault();

				stripe.createToken(card).then(function(result) {
					if (result.error) {
						// Inform the customer that there was an error.
						var errorElement = document.getElementById('card-errors');
						errorElement.textContent = result.error.message;
					} else {
						// Send the token to your server.
						stripeTokenHandler(result.token);
					}
				});
			});
			

			function stripeTokenHandler(token) {
				// Insert the token ID into the form so it gets submitted to the server
				var form = document.getElementById('payment-form');
				var hiddenInput = document.createElement('input');
				hiddenInput.setAttribute('type', 'hidden');
				hiddenInput.setAttribute('name', 'stripeToken');
				hiddenInput.setAttribute('value', token.id);
				form.appendChild(hiddenInput);

				// Submit the form
				form.submit();
			}












			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			var panier = JSON.parse(urlParams.get('panier'));

			if (panier) {
				document.getElementById("total_text").innerText = panier[panier.length-1];
				console.log(panier);

				document.getElementById("hiddenpanier").value = JSON.stringify(panier);
				document.getElementById("total").value = panier[panier.length-1];
			}

			var hiddenpanier = JSON.parse(urlParams.get('hiddenpanier'));
			if (hiddenpanier) {
				console.log(hiddenpanier);

				for (var i = 0; i < hiddenpanier.length - 1; i++) {
					hiddenpanier[i].special_status = 1;
					doAjax('libs/php/controllers/ajax_mirrors.php', 'commandeService', JSON.stringify(hiddenpanier[i]));
				}
			}


		</script>
	</body>
</html>
