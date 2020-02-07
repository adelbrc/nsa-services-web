<?php
if(isset($_POST['formNewSub'])){
  if(!empty($_POST['nom'])  AND !empty($_POST['tarif'])  AND !empty($_POST['NbJrs'])  AND !empty($_POST['OpenHour']) AND !empty($_POST['CloseHour']) ){

    $nom = htmlspecialchars($_POST['nom']);
    $tarif = htmlspecialchars($_POST['tarif']);
    $NbJrs = htmlspecialchars($_POST['NbJrs']);
    $OpenHour = htmlspecialchars($_POST['OpenHour']);
    $CloseHour = htmlspecialchars($_POST['CloseHour']);

    include('../libs/php/db/db_connect.php');
    $insertRole = $conn->prepare("INSERT INTO membership(name, price, openDays, openHours, closeHours) VALUES(?, ?, ?, ?, ?)");
		$insertRole->execute(array($nom, $tarif, $NbJrs, $OpenHour, $CloseHour));
    header('location:subscription.php?status=ajoutNewSub');
  }else{
    header('location:dashboard.php?error=fieldblanks');
  }
}
 ?>
