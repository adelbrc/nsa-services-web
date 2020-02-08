<?php
if (isset($_POST['formconnexion'])) {
  if(!empty($_POST['mail'])  AND !empty($_POST['passwd']) ){

    include ('db/db_connect.php');
    $email = htmlspecialchars($_POST['mail']);
    $password = htmlspecialchars($_POST['passwd']);
    $password = hash('sha256', $password);

  	$loginQuery = $conn->prepare("SELECT * FROM customer WHERE email = ? AND password = ?");

  	$res = $loginQuery->execute([$email, $password]);

  	$rows = $loginQuery->rowCount();

  	if ($rows) {
  		$user = $loginQuery->fetch();
  		session_start();
  		$_SESSION['user'] = $user;
      if ($_SESSION['user']['rank'] == 0) {
        header('Location: ../../dashboard.php?connectedAs=user');
      }else {
        header('Location: ../../login.php?error=wrongpass');
      }
    }
  }
}


 ?>
