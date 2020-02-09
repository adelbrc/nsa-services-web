<?php
include('../../libs/php/db/db_connect.php');
if (isset($_GET['user_id']) && !empty($_GET['user_id']) ) {
  $requeteSupprime =$conn->prepare('DELETE FROM user WHERE id = ?');
  $requeteSupprime ->execute(array(
    $_GET['user_id'],
  ));
}
 ?>
