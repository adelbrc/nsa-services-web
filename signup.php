<?php include ('libs/php/isConnected.php'); ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
  </head>
  <body>
    <?php include('libs/php/mainHeader.php'); ?>
    <div class=" border jumbotron col-md-8 mx-auto" id="jumboLogin" style="margin-top: 75px;">
      <h1 class="display-5" style="text-align: center;">Inscription</h1>
      <br>
      <div class="form-group col-md-12">
                <?php if (isset($_GET['signup']) && $_GET['signup'] == "passerror") {
                  echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Vos mot de passe ne correspondent pas !'. '</div>';
                }
                if (isset($_GET['signup']) && $_GET['signup'] == "pseudolength") {
                  echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Votre pseudo ne peut pas dépasser 15 caracteres !'. '</div>';
                }
                if (isset($_GET['signup']) && $_GET['signup'] == "lastname_length") {
                  echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Votre nom ne peut pas dépasser 15 caracteres !'. '</div>';
                }
                if (isset($_GET['signup']) && $_GET['signup'] == "field_blank") {
                  echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Tout les champs doivent être compléter !'. '</div>';
                }
                if (isset($_GET['signup']) && $_GET['signup'] == "name_length") {
                  echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Votre prénom ne peut pas dépasser 15 caracteres !'. '</div>';
                }
                if (isset($_GET['signup']) && $_GET['signup'] == "invalid_email") {
                  echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Votre adresse mail n\'est pas valide ! '. '</div>';
                }
                if (isset($_GET['error']) && $_GET['error'] == "email_exist") {
                  echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Email déja existant'. '</div>';     //captcha
                }
                ?>
              </div>
      <form class="formSignup" action="libs/php/inscription.php" method="post">
        <div class="form-group">
          <label for="exampleInputEmail1">Nom</label>
          <input type="text" class="form-control" id="exampleInputNom" aria-describedby="NomHelp" placeholder="Saisir votre nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Prenom</label>
          <input type="text" class="form-control" id="exampleInputprenom" aria-describedby="prenomHelp" placeholder="Saisir votre prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Adresse Postal</label>
          <input type="text" class="form-control" id="exampleInputadress" aria-describedby="adressHelp" placeholder="Saisir votre adresse" name="adress" value="<?php if(isset($adress)) { echo $adress; } ?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Ville</label>
          <input type="text" class="form-control" id="exampleInputville" aria-describedby="villeHelp" placeholder="Saisir votre ville" name="ville" value="<?php if(isset($ville)) { echo $ville; } ?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Numero de telephone</label>
          <input type="text" class="form-control" id="exampleInputNum" aria-describedby="NumHelp" placeholder="Saisir votre numero de telephone" name="num" value="<?php if(isset($num)) { echo $num; } ?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Adresse Email</label>
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Saisir l'email" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>">
        </div>
        <div class="form-group">
          <label for="passwd">Mot de passe</label>
          <input type="password" class="form-control" id="passwd" aria-describedby="passwdHelp" placeholder="Saisir le mot de passe" name="passwd">
        </div>
        <div class="form-group">
          <label for="passwd">Retapper votre mot de passe</label>
          <input type="password" class="form-control" id="passwd" aria-describedby="passwdHelp" placeholder="Resaisir le mot de passe" name="passwd2">
        </div>
        <button type="submit" name="forminscription" class="btn btn-primary">Se connecter</button>
      </form>
    </div>
  </body>
</html>
