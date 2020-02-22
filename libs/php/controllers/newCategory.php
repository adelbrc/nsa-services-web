<?php
  if(!empty($_POST['category_name'])){

    $name = htmlspecialchars($_POST['category_name']);
    $reduc = htmlspecialchars($_POST['inputReduc']);

    include('../db/db_connect.php');
    $insertCategory = $conn->prepare("INSERT INTO category(name) VALUES(?)");

		$insertCategory->execute(array($name));

    $insertRole = $conn->prepare("INSERT INTO role(name, nbForDiscount) VALUES(?, ?)");

    $insertRole->execute(array($name, $reduc));

        header('location: ../../../admin/services_management.php?status=ajoutNewCategory');
  }

?>
