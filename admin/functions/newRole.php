<?php
if(isset($_POST['formNewRole'])){
  if(!empty($_POST['nom']) AND !empty($_POST['NbRemise'])){
    $nom = htmlspecialchars($_POST['nom']);
    $NbRemise = htmlspecialchars($_POST['NbRemise']);

    include('../../libs/php/db/db_connect.php');
    $insertRole = $conn->prepare("INSERT INTO role(name, nbForDiscount ) VALUES(?, ?)");

				$insertRole->execute(array($nom, $NbRemise));

        header('location: ../services_management.php?status=ajoutNewRole');
  }
}
 ?>
