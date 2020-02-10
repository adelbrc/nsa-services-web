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
    <link rel="stylesheet" type="text/css" href="ressources/style/user.css">


  </head>
  <body>
    <?php include('libs/php/includes/userHeader.php');
    include('libs/php/db/db_connect.php');
    ?>
    <div>
      <h2 style="text-align: center; font-size: 50px; padding-top: 50px">Découvrez nos services</h2>
    </div>
    <hr class="my-4">

    <div id="role"class="scrollmenu">
      <?php
      $q = $conn->query('SELECT * FROM role');
      while($result = $q->fetch()){
       ?>
      <div class="col-md-3 mx-auto">
        <div class="jumbotron">
          <h1 class="display-5" style="text-align: center;"><?php echo $result['name']?></h1>
          <hr class="my-4">
          <div id="btnInteresser" class="mx-auto">
            <a style="margin-left: 30%;" type="button" class="btn btn-info" href="#">Réserver</a>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
