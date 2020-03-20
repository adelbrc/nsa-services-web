<?php
include('../../libs/php/db/db_connect.php');
header('content-Type: text/csv');
header('accept-charset: utf-8');
header('content-disposition: attachement; filename="export_user.csv"'); //Permet de modifier le type du fichier en *csv

$req = $conn->prepare('SELECT * FROM user ');
$req->execute();
$data=$req->fetchAll();
 ?>"id";"nom de famille";"Prenom";"email";"Telephone";"Ville";<?php

 foreach ($data as $d) {
   echo "\n".'"'. $d['id'].'";"'.$d['lastname'].'";"'.$d['firstname'].'";"'.$d['email'].'";"'. $d['phone_number'].'";"'.$d['city'] .'"';
   }
?>
