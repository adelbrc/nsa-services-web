<?php

require_once('../libs/stripe-php-master/init.php');

\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

$session = \Stripe\Checkout\Session::retrieve(
  'cs_test_jTb5MATSrfPcsItxS0vZXkAJqfMNBTducVWOq5nBveSj11KqPdkC8sAn'
);

echo "le client : " . $session["customer"] . " <br>a souscrit a l'abonnement : " . $session["display_items"][0]["plan"]["id"] . " <br>avec le session id suivant " . $session["id"] . " ; <br>voici l'id de la souscription : " . $session["subscription"];

// var_dump($session);

?>