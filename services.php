<?php

require_once("libs/php/classes/User.php");
require_once("libs/php/classes/Service.php");
require_once('libs/stripe-php-master/init.php');
include("libs/php/isConnected.php");

// Init Stripe API KEY
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="ressources/style/style.css">
    <title>Home Services | Offers</title>
  </head>
  <body>
    <header>
      <?php include("libs/php/mainHeader.php"); ?>
    </header>
    <main>
      <section class="sizedSection">
        <div class="dataContainer">
          <h2 class="text-center">Rechercher des services</h2>
          <form class="text-center searchServicesForm" action="" method="post">
            <input class="customInput" type="text" name="search" placeholder="Garde d'enfants, plomberie, réparation informatique...">
            <input class="customInput" type="text" name="search_location" placeholder="Paris, Marseille...">
            <button class="searchServicesBtn" type="submit" name="button">Rechercher</button>
          </form>
        </div>
      </section>
      <section class="sizedSection">
        <h2 class="text-center">Nos services</h2>
        <div class="row">
          <?php include("libs/php/views/servicesCardsList.php"); ?>
        </div>
      </section>
    </main>
    <script src="https://js.stripe.com/v3/"></script>
    <script>


      var PUBLISHABLE_KEY = "pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B";

      var DOMAIN = http://nsaservices.local;

      var stripe = Stripe(PUBLISHABLE_KEY);

      // Handle any errors from Checkout
      var handleResult = function(result) {
        if (result.error) {
          var displayError = document.getElementById("error-message");
          displayError.textContent = result.error.message;
        }
      };

      // cette fonction permet de rediriger vers le site de stripe avec l'id du plan
      var redirectToCheckout = function(id_product) {
        stripe
          .redirectToCheckout({
            items: [{ product: id_product, quantity: 1 }],
            successUrl:
              // "https://" +
              DOMAIN +
              "/pages_stripe/success.html?session_id={CHECKOUT_SESSION_ID}",
            // cancelUrl: "https://" + DOMAIN + "/canceled.html"
            cancelUrl: DOMAIN + "/pages_stripe/canceled.html"
          })
          .then(handleResult);
      };

    </script>
  </body>
</html>
