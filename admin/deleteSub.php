<?php
include('../libs/php/db/db_connect.php');

$deleteSubs = $conn->prepare("INSERT INTO membership(name, price, openDays, openHours, closeHours) VALUES(?, ?, ?, ?, ?)");
$deleteSubs->execute(array($nom, $tarif, $NbJrs, $OpenHour, $CloseHour));
 ?>
