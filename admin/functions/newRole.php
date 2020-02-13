<?php
if(isset($_POST['formNewRole'])){
  if(!empty($_POST['nom'])  AND !empty($_POST['tarifPlein'])  AND !empty($_POST['NbRemise'])  AND !empty($_POST['tarifRemise']) ){
    $nom = htmlspecialchars($_POST['nom']);
    $tarifP = htmlspecialchars($_POST['tarifPlein']);
    $NbRemise = htmlspecialchars($_POST['NbRemise']);
    $tarifR = htmlspecialchars($_POST['tarifRemise']);

    include('db/db_connect.php');
    $insertRole = $conn->prepare("INSERT INTO role(name, price, discountPrice, nbHoursForDiscount) VALUES(?, ?, ?, ?)");

				$insertRole->execute(array($nom, $tarifP, $tarifR, $NbRemise));

        header('location:../../dashboard.php?status=ajoutNewRole');
  }
}
 ?>
