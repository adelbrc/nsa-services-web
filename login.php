<?php include ('libs/php/isConnected.php');
include('libs/php/functions/translation.php');
if (isset($_GET['lang'])) {
	$langue = $_GET["lang"];
}else {
$langue = 0;
}
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="ressources/style/style.css">
    <title><?php echo $connexion[$langue]; ?></title>
  </head>
  <body>
    <?php include('libs/php/mainHeader.php'); ?>

    <div class=" border jumbotron col-md-8 mx-auto" id="jumboLogin" style="margin-top: 75px;">
      <h1 class="display-5" style="text-align: center;"><?php echo $connexion[$langue]; ?></h1>
      <?php if (isset($_GET['error']) && $_GET['error'] == 'wrongpass') { ?>
        <div class="alert text-center alert-danger" role="alert">
          <?php echo $wrongpass[$langue]; ?>
        </div>    <?php  } ?>
        <?php if (isset($_GET['inscription']) && $_GET['inscription'] == 'success') { ?>
          <div class="alert text-center alert-success" role="alert">
            <?php echo $rediInscri[$langue]; ?>
          </div>    <?php  } ?>
      <br>
      <form class="formLogin" action="libs/php/connexion.php" method="post">
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $saisir[$langue] .' Email'; ?>" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>">
        </div>
        <div class="form-group">
          <label for="passwd"><?php echo $passwd[$langue]; ?></label>
          <input type="password" class="form-control" id="passwd" aria-describedby="passwdHelp" placeholder="<?php echo $saisir[$langue] .' '. $passwd[$langue]; ?>" name="passwd">
        </div>
        <button type="submit" name="formconnexion" class="btn btn-primary"><?php echo $seConnecter[$langue]; ?></button>
            <a href="signup.php"><p><?php echo $pasEncoreInscrit[$langue]; ?></p></a>
      </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  </body>
</html>
