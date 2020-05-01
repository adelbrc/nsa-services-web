<?php
require_once("../libs/php/classes/User.php");
require_once("../libs/php/classes/Partner.php");
require_once("../libs/php/classes/Order.php");
require_once("../libs/php/classes/Intervention.php");
include("../libs/php/isConnected.php");
include('../libs/php/functions/translation.php');

if (isset($_GET['lang'])) {
	$langue = $_GET["lang"];
}else {
	$langue = 0;
}


if (!isConnected()) {
	header("Location: ../login.php");
    exit;
}

$user = User::getUserByID($_SESSION["user"]["id"]);

if ($user->getRank() != "3") {
	header("Location: ../index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="../ressources/style/sidebar.css">
		<link rel="stylesheet" href="../ressources/style/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Home Services | <?php echo $gestionCommande[$langue]; ?></title>
	</head>
	<body>
      <header>
  		<?php include('includes/headerNavigation.php'); ?>
      </header>
      <div class="container-fluid">
  		<div class="row">
    		  <?php include('includes/sidebar.php'); ?>
              <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        			  <h1 class="h2" id='user'><?php echo $gestionCommande[$langue]; ?></h1>
                      <div class="btn-toolbar mb-2 mb-md-0">
          				<div class="btn-group mr-2">
            				  <ul class="nav justify-content-center" role="tablist">
              					<li class="nav-item"><a class="nav-link active button_export" role="button" href="functions/exportOrders.php">Export</a></li>
              					<li class="nav-item">
              						<a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Commandes</button></a>
              					</li>
              					<li class="nav-item">
                                    <a class="nav-link" id="interventions-tab" data-toggle="tab" href="#interventions" role="tab" aria-controls="interventions" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Interventions</button></a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                  </div>
      			<div class="tab-content" id="partnersTab">
                    <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list">
                      <?php include("../libs/php/alerts/cancelOrderAlerts.php"); ?>
                      <?php include("../libs/php/views/ordersList.php"); ?>
                    </div>
                    <div class="tab-pane fade" id="interventions" role="tabpanel" aria-labelledby="interventions">
                      <?php include("../libs/php/views/interventionsList.php"); ?>
                    </div>
                  </div>
              </main>
          </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
      integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
