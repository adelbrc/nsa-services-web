<?php

require_once('libs/stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');


// creation d'un service de type babysitting

// $res = \Stripe\Plan::create([
// 	'amount' => 1500,
// 	'currency' => 'eur',
// 	'nickname' => "thisisit",
// 	'interval' => 'week',
// 	'product' => "prod_GpCXWFLVjr3PXh",

// 	'interval_count' => '1',
// 	'usage_type' => 'metered',
// 	'billing_scheme' => "per_unit",
// 	'aggregate_usage' => "sum"

// ]);


// commande d'unité de babysitting

// $customers = \Stripe\Customer::all(['email' => "narek@ok.com"]);



	// babysitting
// $plan_ = "plan_H3gDiUCmHpTw4V";

// 	// anglais
// // $plan_ = "plan_H3RcKDN3MIT23E";


// // on verifie si l'USER A DEJA un ABONNEMENT ACTIF a ce SERVICE
// $abonnement_a_ce_service_data = \Stripe\Subscription::all([
// 	'customer' => "cus_H47YJ8qFDX2Esf",
// 	'plan' => $plan_,
// ]);

// $a_t_il_un_abonnement_a_ce_service = count($abonnement_a_ce_service_data["data"]);

// // echo $a_t_il_un_abonnement_a_ce_service;


// if ($a_t_il_un_abonnement_a_ce_service == 0) {
// 	// il n'a pas d'abonnement a ce service, il faut lui en creer un

// 	echo "on lui cree un abonnement";

// 	// // CREER UNE SUBSCRIPTION
// 	$sub_data = \Stripe\Subscription::create([
// 		// 'customer' => $booking->stripe_cus_id,
// 		'customer' => "cus_H47YJ8qFDX2Esf",
// 		'items' => [
// 			["plan" => $plan_]
// 		],
// 	]);
// } else {
// 	echo "il a deja un abonnement a ce service, on le selectionne juste";
// 	$sub_data = $abonnement_a_ce_service_data["data"][0];
// }

// // var_dump($sub_data);
// // var_dump(get_object_vars($))

// $sub_ = $sub_data["id"]; // sub_...


// $si_ = $sub_data["items"]["data"][0]["id"]; // si_...

// // for (pour chaque session, creer un usage record)
// $a = \Stripe\SubscriptionItem::createUsageRecord(
// 	$si_,
// 	[
// 		'quantity' => 3,
// 		'timestamp' => strtotime("now"),
// 		'action' => 'increment',
// 	]
// );


// echo "<br>3 Enregistrements ajoutés !";

// // recuperer l'id de la subscription : 
// echo $s["id"];

// echo $create_sub["id"];
// var_dump($create_sub);



// var_dump($a);
// var_dump($a["data"]);


// FACTURING
// $factures_a_venir = \Stripe\Invoice::upcoming(["customer" => "cus_H47YJ8qFDX2Esf"]);
// var_dump($factures_a_venir);


// $a = \Stripe\Invoice::all(['limit' => 3, 'customer' => 'cus_H47YJ8qFDX2Esf']);
// var_dump($a["data"]);


// $lines = $factures_a_venir->lines->all()["data"];
// var_dump($lines);

// echo $lines[0]["invoice"];
// echo $lines[0]["quantity"] * $lines[0]["amount"] / 1000;

// $invoice = \Stripe\Invoice:retrieve(
// 		''
// );

// $invoice->pay();


// $a = \Stripe\Invoice::create([
//   'customer' => 'cus_H47YJ8qFDX2Esf',
// ]);
// var_dump($a);

// $a = \Stripe\Invoice::create([
//   'customer' => 'cus_H47YJ8qFDX2Esf',
// ]);


// var_dump($a);


if (0) {
	$a = \Stripe\InvoiceItem::create([
		'customer' => 'cus_HAFAOdaTgPy3k4',
		'amount' => 4000,
		'currency' => 'EUR',
		'description' => 'Paiement test',
	]);


	$b = \Stripe\Invoice::create([
	  'customer' => 'cus_HAFAOdaTgPy3k4',
	  // 'auto_advance' => true, /* auto-finalize this draft after ~1 hour */
	  'auto_advance' => false, /* auto-finalize this draft after ~1 hour */
	]);

	$invoice = \Stripe\Invoice::retrieve($b["id"]);
	$invoice->finalizeInvoice();
	$c = $invoice->pay();
	var_dump($c);
}

// $queryInsertInvoice = $conn->query("INSERT INTO invoices (stripe_id, customer_id, amount_paid, date_issue) VALUES (?, ?, ?, ?)");
// $queryInsertInvoice->execute([]);


// $intent = \Stripe\PaymentIntent::create([
//   'amount' => 1099,
//   'currency' => 'usd',
//   // Verify your integration in this guide by including this parameter
//   'metadata' => ['integration_check' => 'accept_a_payment'],
// ]);


// ===== TEST ANNULATION ======
// $subscription = \Stripe\Subscription::update(
// 	'sub_HAIUSZNbeCGlu9',
// 	["cancel_at_period_end" => true]
// );

// var_dump($subscription);
// ===== [OK] =====



// ===== TEST UPCOMING INVOICE ======
// var_dump(\Stripe\Invoice::upcoming(["customer" => "cus_HAFAOdaTgPy3k4"]));
// ===== [OK] =====

// ===== TEST ATTACH PaymentMethod ======
$mainPm = \Stripe\PaymentMethod::all([
  'customer' => 'cus_HAakMCVY3mAevo',
  'type' => 'card',
]);


$payment_method = \Stripe\PaymentMethod::retrieve(
	$mainPm["data"][0]["id"]
);

$payment_method->attach([
	'customer' => 'cus_HAajMXFCRiZJyp',
]);


// ===== [OK] =====




?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		/**
		 * The CSS shown here will not be introduced in the Quickstart guide, but shows
		 * how you can use CSS to style your Element's container.
		 */
		.StripeElement {
		  box-sizing: border-box;

		  height: 40px;

		  padding: 10px 12px;

		  border: 1px solid transparent;
		  border-radius: 4px;
		  background-color: white;

		  box-shadow: 0 1px 3px 0 #e6ebf1;
		  -webkit-transition: box-shadow 150ms ease;
		  transition: box-shadow 150ms ease;
		}

		.StripeElement--focus {
		  box-shadow: 0 1px 3px 0 #cfd7df;
		}

		.StripeElement--invalid {
		  border-color: #fa755a;
		}

		.StripeElement--webkit-autofill {
		  background-color: #fefde5 !important;
		}
	</style>
</head>
<body>







<!-- <form id="payment-form" style="width: 500px;margin: 200px auto"> -->
  <!-- <div id="card-element"> -->
    <!-- Elements will create input elements here -->
  <!-- </div> -->

  <!-- We'll put the error messages in this element -->
<!--   <div id="card-errors" role="alert"></div>

  <button id="submit">Pay</button>
</form>
	<script src="https://js.stripe.com/v3/"></script>
	<script>
		var stripe = Stripe('pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B');
		var elements = stripe.elements();
		var style = {
		  base: {
		    color: "#32325d",
		  }
		};

		var card = elements.create("card", { style: style });
		card.mount("#card-element");

		card.addEventListener('change', function(event) {
		  var displayError = document.getElementById('card-errors');
		  if (event.error) {
		    displayError.textContent = event.error.message;
		  } else {
		    displayError.textContent = '';
		  }
		});




		var form = document.getElementById('payment-form');

		form.addEventListener('submit', function(ev) {
		  ev.preventDefault();
		  stripe.confirmCardPayment(clientSecret, {
		    payment_method: {
		      card: card,
		      billing_details: {
		        name: 'Jenny Rosen'
		      }
		    }
		  }).then(function(result) {
		    if (result.error) {
		      // Show error to your customer (e.g., insufficient funds)
		      console.log(result.error.message);
		    } else {
		      // The payment has been processed!
		      if (result.paymentIntent.status === 'succeeded') {
		        // Show a success message to your customer
		        // There's a risk of the customer closing the window before callback
		        // execution. Set up a webhook or plugin to listen for the
		        // payment_intent.succeeded event that handles any business critical
		        // post-payment actions.
		      }
		    }
		  });
		});
	</script> -->

</body>
</html>



