<?php
include ('../libs/php/isConnected.php');
if ($_SESSION['user']['rank'] !=3) {
  header('location: ../index.php?error=accessUnauthorized');
}
include ('../libs/php/db/db_connect.php');
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../ressources/style/admin.css">
    <link rel="stylesheet" href="../ressources/style/sidebar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
  <body>
    <header>
    <?php include('includes/headerNavigation.php'); ?>
  </header>
    <div class="container-fluid">
      <div class="row">
        <?php include('includes/sidebar.php'); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class=" border jumbotron col-md-12" id="jumboRole" style="margin-top: 75px;">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'ajoutNewRole') { ?>
              <div class="alert text-center alert-success" role="alert">
                Vous venez de créer une nouvelle foncion !
              </div>
            <?php } ?>
            <h1 class="display-5" style="text-align: center;">Role</h1>
            <br>
            <?php include('createRoleBtn.php'); ?>
          </div>
        </main>
      </div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</html>
