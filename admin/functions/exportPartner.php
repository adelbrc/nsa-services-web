<?php
include('../../libs/php/db/db_connect.php');
header('content-Type: text/csv');
header('accept-charset: utf-8');
header('content-disposition: attachement; filename="export_user.csv"'); //Permet de modifier le type du fichier en *csv

$req = $conn->prepare('SELECT * FROM partner ');
$req->execute();
$data=$req->fetchAll();
 ?>"id";"Societe";"nom de famille";"Prenom";"email";"Telephone";"Ville"; "Dispo du";"Au";<?php

 foreach ($data as $d) {
   echo "\n".'"'. $d['partner_id'].'";"'.$d['corporation_name'].'";"'.$d['lastname'].'";"'.$d['firstname'].'";"'.$d['email'].'";"'. $d['phone'].'";"'.$d['city'].'";"'
   .$d['disponibility_begin'].'";"'.$d['disponibility_end'] .'"';
   }
?>
