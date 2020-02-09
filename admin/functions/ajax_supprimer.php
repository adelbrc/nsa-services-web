<?php
include('../../libs/php/db/db_connect.php');
if (isset($_GET['user_id']) && !empty($_GET['user_id']) ) {
  $requeteSupprime =$conn->prepare('DELETE FROM user WHERE id = ?');
  $requeteSupprime ->execute(array(
    $_GET['user_id'],
  ));
  exit;
}
if (isset($_GET['abonnement_id']) && !empty($_GET['abonnement_id']) ) {
  $requeteSupprime =$conn->prepare('DELETE FROM membership WHERE id = ?');
  $requeteSupprime ->execute(array(
    $_GET['abonnement_id'],
  ));
  exit;
}


 ?>
