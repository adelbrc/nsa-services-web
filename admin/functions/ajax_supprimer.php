<?php
include('../../libs/php/db/db_connect.php');
if (isset($_GET['user_id']) && !empty($_GET['user_id']) ) {
  $requeteSupprime =$conn->prepare('DELETE FROM user WHERE id = ?');
  $requeteSupprime ->execute(array(
    $_GET['user_id'],
  ));
  exit;
}
if (isset($_GET['service_id']) && !empty($_GET['service_id']) ) {
  $requeteSupprime =$conn->prepare('DELETE FROM service WHERE id = ?');
  $requeteSupprime ->execute(array(
    $_GET['service_id'],
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
if (isset($_GET['category_id']) && !empty($_GET['category_id']) ) {
  $requeteSupprime =$conn->prepare('DELETE FROM category WHERE id = ?');
  $requeteSupprime ->execute(array(
    $_GET['category_id'],
  ));
  exit;
}

 ?>
