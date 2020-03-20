<?php
include('../../libs/php/db/db_connect.php');
header('content-Type: text/csv');
header('accept-charset: utf-8');
header('content-disposition: attachement; filename="export_user.csv"'); //Permet de modifier le type du fichier en *csv

$req = $conn->prepare('SELECT * FROM service ');
$req->execute();
$data=$req->fetchAll();
 ?>"id";"nom";"Prix";"Prix reduit";<?php

 foreach ($data as $d) {
   echo "\n".'"'. $d['id'].'";"'.$d['name'].'";"'.$d['price'].'";"'.$d['discountPrice'].'"';
   }
?>
