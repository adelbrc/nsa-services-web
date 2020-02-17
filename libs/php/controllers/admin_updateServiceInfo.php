<?php
include('../db/db_connect.php');

  $req = $conn->prepare('UPDATE service SET name = ?, price = ?,discountPrice = ?, category_id = ? WHERE id= ?');

  $req->execute(array(
    $_POST['inputname'],
    $_POST['inputPrice'],
    $_POST['inputDPrice'],
    $_POST['category'],
    $_POST['pid']
  ));
  header('location: ../../../admin/services_management.php?status=worked');

  ?>
