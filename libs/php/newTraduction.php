<?php
require_once('db/db_connect.php');

if (isset($_POST['formTraduction'])) {
  if (isset($_POST['langue']) AND !empty($_POST['langue'])) {
    $queryMyTraduction = $conn->prepare("INSERT INTO traduction(name_traduction) VALUES (?)");
    $queryMyTraduction->execute([$_POST['langue']]);
    header('Location: ../../index.php?status=traduction_request_done');
  }else {
    header('Location: ../../index.php?error=field_blank');
  }
}
 ?>
