<?php include ('libs/php/isConnected.php');
if (!isConnected()) {
  header('location: index.php?error=accessUnauthorized');
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>dashboard</title>
    <link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="ressources/style/login.css">


  </head>
  <body>
    <?php include('libs/php/includes/userHeader.php');
    include('libs/php/db/db_connect.php');
    if($_SESSION['user']['rank'] == 2){
      include('libs/php/createRoleBtn.php');
    ?>

    <div class=" border jumbotron col-md-4" id="jumboRole" style="margin-top: 75px;">
      <h1 class="display-5" style="text-align: center;">Role</h1>
      <?php
      if (isset($_GET['status']) && $_GET['status'] == "ajoutNewRole") {
        echo '<div class="alert alert-success col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Vous venez d\'ajouter une nouvelle fonction' . '</div>';
      } ?>
      <br>
      <?php
        $q = $conn->query('SELECT * FROM role');
        while($result = $q->fetch()){
          echo '<table  border=4 cellspacing=4 cellpadding=4><tr><td><b>Fonction : </b>'.$result['name'] .'</td><td><b>Prix TTC : </b>'.$result['price'].'€'. '</td><td><b>Nb avant remise : </b>'.$result['nbHoursForDiscount'] .'</td></tr></table>';
        }
      }
      ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
