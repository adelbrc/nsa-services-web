<?php include ('libs/php/isConnected.php'); ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
    <link rel="stylesheet" href="ressources/style/login.css">
    <title>Connexion</title>
  </head>
  <body> 
    <?php include('libs/php/mainHeader.php'); ?>

    <div class=" border jumbotron col-md-8 mx-auto" id="jumboLogin" style="margin-top: 75px;">
      <h1 class="display-5" style="text-align: center;">Connexion</h1>
      <?php if (isset($_GET['error']) && $_GET['error'] == 'wrongpass') { ?>
        <div class="alert text-center alert-danger" role="alert">
          Mauvais mot de passe
        </div>    <?php  } ?>
        <?php if (isset($_GET['inscription']) && $_GET['inscription'] == 'success') { ?>
          <div class="alert text-center alert-success" role="alert">
            Vous pouvez désormais vous connecter
          </div>    <?php  } ?>
      <br>
      <form class="formLogin" action="libs/php/connexion.php" method="post">
        <div class="form-group">
          <label for="exampleInputEmail1">Adresse Email</label>
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Saisir l'email" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>">
        </div>
        <div class="form-group">
          <label for="passwd">Mot de passe</label>
          <input type="password" class="form-control" id="passwd" aria-describedby="passwdHelp" placeholder="Saisir lemot de passe" name="passwd">
        </div>
        <button type="submit" name="formconnexion" class="btn btn-primary">Se connecter</button>
            <a href="signup.php"><p>Pas encore inscrit ? Rejoingnez-nous !</p></a>
      </form>
    </div>
  </body>
</html>
