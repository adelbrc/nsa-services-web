<?php
  if(!empty($_POST['service_name']) AND !empty($_POST['service_price']) AND !empty($_POST['inputDiscountPrice']) AND !empty($_POST['category'])){

    $name = htmlspecialchars($_POST['service_name']);
    $discountPrice = htmlspecialchars($_POST['inputDiscountPrice']);
    $price = htmlspecialchars($_POST['service_price']);
    $category = htmlspecialchars($_POST['category']);
    $description = htmlspecialchars($_POST['inputDescription']);


    // on va l'inserer (1) dans stripe puis (2) en bdd
    // comme ca on peut recuperer le id_plan genere par stripe pour le mettre en bdd

    // (1) Insert dans stripe
    require_once('../../stripe-php-master/init.php');
    \Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

    // on stock cette requete parce qu'elle renvoie les infos du plan créé (comme l'id qu'on va stocker en bdd)
  	$newPlan = \Stripe\Plan::create([
  	'currency' => 'eur',
  	'amount' => $price * 100,
  	'interval' => 'month',
  	'product' => 'prod_GpCXWFLVjr3PXh', // l'id du produit qui contient les differents plans tarifaires
  	'nickname' => $name,
  	'metadata' => [
  		'description' => $description,
  		]
  	]);
  	echo "Nouveau plan ajouté dans stripe<br>";



    include('../db/db_connect.php');
    $insertRole = $conn->prepare("INSERT INTO service(name, price, discountPrice, category_id, description ) VALUES(?, ?, ?, ?, ?)");

				$insertRole->execute(array($name, $price, $discountPrice, $category, $description));

        header('location: ../../../admin/services_management.php?status=ajoutNewRole');
  }else{
    header('location: ../../../admin/services_management.php?status=field_blank');
  }

?>
