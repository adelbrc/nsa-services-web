<?php
session_start();
if (isset($_POST['forminscription'])) {

  $nom = htmlspecialchars($_POST['nom']);
  $prenom = htmlspecialchars($_POST['prenom']);
  $mail = htmlspecialchars($_POST['mail']);
  $passwd = htmlspecialchars($_POST['passwd']);
  $passwd2 = htmlspecialchars($_POST['passwd2']);
  $adress = htmlspecialchars($_POST['adress']);

  if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail']) AND !empty($_POST['passwd']) AND !empty($_POST['passwd2']) AND !empty($_POST['adress'])) {

	$nomlenght = strlen($nom);
	$prenomlength = strlen($prenom);
	$adresslength = strlen($adress);

	if ($nomlenght <= 45) {
	  if ($adresslength <=45) {
		    if ($prenomlength <= 45) {



			if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			  if ($passwd == $passwd2) {
				include('db/db_connect.php');

        $loginQuery = $conn->prepare("SELECT * FROM user WHERE email = ?");

        $res = $loginQuery->execute([$mail]);

        $rows = $loginQuery->rowCount();

        if ($rows) {
          $user = $loginQuery->fetch();
          header('Location: ../../signup.php?error=email_exist');
          exit;
        }
				$insertmbr = $conn->prepare("INSERT INTO user(lastname, firstname, email, password, address, Role_name) VALUES(?, ?, ?, ?, ?, 'Client')");

				$password = hash('sha256', $passwd);


				$insertmbr->execute(array($nom, $prenom, $mail, $password, $adress));

				$lastId = $conn->lastInsertId();

				header('Location: ../../login.php?inscription=success');
			  }
			  else {
        header('Location:../../signup.php?signup=passerror');
        exit;
			  }
			}
			else {
        header('Location:../../signup.php?signup=invalid_email');
        exit;
			}
		}
		else {
      header('Location:../../signup.php?signup=name_length');
      exit;
		}
	  }
	  else {
    header('Location:../../signup.php?signup=adresslength');
    exit;
    }
	}
	else {
    header('Location:../../signup.php?signup=lastname_length');
    exit;
	}
  }
  else {
  header('Location:../../signup.php?signup=field_blank');
  exit;

  }
}
 ?>
