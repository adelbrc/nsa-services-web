<?php
  if(!empty($_POST['category_name'])){

    $name = htmlspecialchars($_POST['category_name']);

    include('../db/db_connect.php');
    $insertRole = $conn->prepare("INSERT INTO category(name) VALUES(?)");

				$insertRole->execute(array($name));

        header('location: ../../../admin/services_management.php?status=ajoutNewCategory');
  }

?>
