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

    $newService = \Stripe\Product::create([
      'type' => 'good',
      'name' => $name
    ]);


    $sku1 = \Stripe\SKU::create([
    'currency' => 'usd',
    'inventory' => [
        'type' => 'finite',
        'quantity' => 500,
    ],
    'price' => $price,
    'product' => $newService["id"]
    ]);
    echo $newService['id'];
    echo $price;

    include('../db/db_connect.php');
    $insertRole = $conn->prepare("INSERT INTO service(name, price, discountPrice, category_id, description ) VALUES(?, ?, ?, ?, ?)");

				$insertRole->execute(array($name, $price, $discountPrice, $category, $description));

        header('location: ../../../admin/services_management.php?status=ajoutNewRole');
  }else{
    header('location: ../../../admin/services_management.php?status=field_blank');
  }

?>
