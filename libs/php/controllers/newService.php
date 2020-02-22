<?php
  if(!empty($_POST['service_name']) AND !empty($_POST['service_price']) AND !empty($_POST['inputDiscountPrice']) AND !empty($_POST['category'])){

    $name = htmlspecialchars($_POST['service_name']);
    $discountPrice = htmlspecialchars($_POST['inputDiscountPrice']);
    $price = htmlspecialchars($_POST['service_price']);
    $category = htmlspecialchars($_POST['category']);
    $description = htmlspecialchars($_POST['inputDescription']);

    include('../db/db_connect.php');
    $insertRole = $conn->prepare("INSERT INTO service(name, price, discountPrice, category_id, description ) VALUES(?, ?, ?, ?, ?)");

				$insertRole->execute(array($name, $price, $discountPrice, $category, $description));

        header('location: ../../../admin/services_management.php?status=ajoutNewRole');
  }else{
    header('location: ../../../admin/services_management.php?status=field_blank');
  }

?>
