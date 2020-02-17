<?php
include('../db/db_connect.php');

  $req = $conn->prepare('UPDATE user SET firstname = ?, lastname = ?,phone_number = ? WHERE id= ?');

  $req->execute(array(
    $_POST['inputFname'],
    $_POST['inputLname'],
    $_POST['inputNum'],
    $_POST['pid']
  ));
  header('location: ../../../admin/displayUsers.php?status=worked');

  ?>
