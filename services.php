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
                <form class="text-center searchServicesForm">
                  <div class="form-row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                      <input class="customInput" autocomplete="off" type="search" placeholder="Garde d'enfants, plomberie, réparation informatique..." onkeyup="showResult(this.value)">
                      <div id="serviceSearch">

                      </div>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                      <input class="customInput" type="search" name="search_location" placeholder="Paris, Marseille...">
                    </div>
                  </div>
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

        <!-- JS -->
        <script src="libs/ajax/searchServices.js" charset="utf-8"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script src="libs/js/checkout.js" charset="utf-8"></script>
  </body>
</html>
