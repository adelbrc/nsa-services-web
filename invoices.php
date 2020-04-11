<?php

require_once('libs/php/classes/User.php');
include('libs/php/isConnected.php');
include('libs/php/functions/translation.php');

if (isset($_GET['lang'])) {
	$langue = $_GET["lang"];
}else {
$langue = 0;
}
if (!isConnected()) {
    header("Location: login.php");
    exit;
}

$user = User::getUserByID($_SESSION["user"]["id"]);

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="ressources/style/style.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>Compte | Factures</title>
    </head>
    <body>
        <header>
          <?php include("libs/php/includes/userHeader.php"); ?>
        </header>
        <main>
            <div class="container-fluid">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2" id='user'>Factures</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                      <div class="btn-group mr-2">
                        <ul class="nav justify-content-center" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="membership-tab" data-toggle="tab" href="#membership" role="tab" aria-controls="membership" aria-selected="true"><button type="button" class="btn btn-sm btn-outline-primary">Abonnements</button></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="service-tab" data-toggle="tab" href="#service" role="tab" aria-controls="service" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Services</button></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
                <div class="tab-content" id="myProfileContent">
                    <div class="tab-pane fade show active" id="membership" role="tabpanel" aria-labelledby="membership">
                      <?php include("libs/php/views/userMembershipsInvoicesList.php"); ?>
                    </div>
                    <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service">
                      Service
                    </div>
                </div>
            </div>
        </main>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
