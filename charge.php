<?php

require_once('libs/stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

// `source` is obtained with Stripe.js; see https://stripe.com/docs/payments/accept-a-payment-charges#web-create-token

// on recupere le moyen de paiement par defaut du customer


// echo "Création de la carte...<br>";
// \Stripe\Customer::createSource(
// 	'cus_HD8JdOojODkQNi',
// 	['source' => 'tok_amex']
// );

// $mycard = \Stripe\Customer::allSources(
// 	'cus_HD8JdOojODkQNi',
// 	['object' => 'card', 'limit' => 3]
// );

// // var_dump($cards["data"]);
// // var_dump($mycard["data"][0]);
// var_dump($mycard["data"][0]["id"]);

// \Stripe\Charge::create([
// 	'amount' => 2000,
// 	'currency' => 'eur',

// 	'customer' => 'cus_HD8JdOojODkQNi',
// 	'source' => $mycard["data"][0]["id"],
	
// 	'description' => 'Paiement test',
// ]);







// TUTO
// Token is created using Stripe Checkout or Elements!
// Get the payment token ID submitted by the form:

if (isset($_GET['stripeToken'])) {
	$token = $_GET['stripeToken'];
	
	$charge = \Stripe\Charge::create([
		'amount' => 2000,
		'currency' => 'usd',
		'description' => 'Example charge',
		'source' => $token,
	]);
	
	var_dump($charge);
	echo "OK";
}




?>

<!DOCTYPE html>
<html>
<head>
	<script src="https://js.stripe.com/v3/"></script>
	<title></title>
	<style>
		#payment-form {
			background-color: #eee;
			padding: 10px;
			border-radius: 3px;
			width: 400px;
			margin: 100px auto;
		}

		#payment-form div label {
			padding-bottom: 10px;
		}

		#payment-form div {
			margin: 10px 0px;
		}
	
		#card-element {
			background-color: lightblue;
			padding: 10px;
			border-radius: 3px;
		}

		#card-errors {
			color: red;
			padding: 10px;
			border-radius: 3px;
		}


	</style>
</head>
<body>


	<form action="" method="get" id="payment-form">
		<div class="form-row">
			<label for="card-element">
				Credit or debit card
			</label>

			<div id="card-element">
				<!-- A Stripe Element will be inserted here. -->
			</div>

			<!-- Used to display Element errors. -->
			<div id="card-errors" role="alert"></div>
		</div>

		<button>Submit Payment</button>
	</form>



	<script>
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



	</script>

</body>
</html>