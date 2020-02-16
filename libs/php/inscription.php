<?php
session_start();
if (isset($_POST['forminscription'])) {

  $nom = htmlspecialchars($_POST['nom']);
  $prenom = htmlspecialchars($_POST['prenom']);
  $mail = htmlspecialchars($_POST['mail']);
  $passwd = htmlspecialchars($_POST['passwd']);
  $passwd2 = htmlspecialchars($_POST['passwd2']);
  $adress = htmlspecialchars($_POST['adress']);
  $num = htmlspecialchars($_POST['num']);
  $ville = htmlspecialchars($_POST['ville']);

  if (!empty($_POST['nom']) AND !empty($_POST['prenom'])AND !empty($_POST['ville']) AND !empty($_POST['mail']) AND !empty($_POST['num']) AND !empty($_POST['passwd']) AND !empty($_POST['passwd2']) AND !empty($_POST['adress'])) {

  	$nomlenght = strlen($nom);
  	$prenomlength = strlen($prenom);
  	$adresslength = strlen($adress);

  	if ($nomlenght <= 45) {
  	  if ($adresslength <=45) {
  		    if ($prenomlength <= 45) {



  			if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
  			  if ($passwd == $passwd2) {
    				include('classes/User.php');

            $user = User::loadUser($mail);

            if ($user != NULL) {
              header('Location: ../../signup.php?error=email_exist');
              exit;
            }
				    $password = hash('sha256', $passwd);
            User::signup($prenom, $nom, $mail, $password, $num, $adress, $ville);


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
