<?php
include('../../libs/php/db/db_connect.php');
header('content-Type: text/csv');
header('accept-charset: utf-8');
header('content-disposition: attachement; filename="export_order.csv"'); //Permet de modifier le type du fichier en *csv

$req = $conn->prepare('SELECT * FROM nsaservices_db.order ');
$req->execute();
$data=$req->fetchAll();
 ?>"id";"date de commande";"Nb Heures";<?php

 foreach ($data as $d) {
   echo "\n".'"'. $d['order_id'].'";"'.$d['order_date'].'";"'.$d['nbHours'].'"';
   }
?>
