<?php
require_once("../libs/php/classes/User.php");
require_once("../libs/php/classes/Partner.php");
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
		<title>Home Services | <?php echo $gestionPartner[$langue]; ?></title>
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
						<h1 class="h2" id='user'><?php echo $gestionPartner[$langue]; ?></h1>
						<div class="btn-toolbar mb-2 mb-md-0">
							<div class="btn-group mr-2">
								<ul class="nav justify-content-center" role="tablist">
									<li class="nav-item">
										<a class="nav-link button_export" role="button" href="functions/exportPartner.php">Export</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">List</button></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="stats-tab" data-toggle="tab" href="#stats" role="tab" aria-controls="stats" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Stats</button></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="doublons-tab" data-toggle="tab" href="#doublons" role="tab" aria-controls="doublons" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Doublons</button></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="tab-content" id="partnersTab">
						<div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list">
							<?php include("../libs/php/alerts/updatePartnerAlerts.php"); ?>
							<?php include("../libs/php/views/partnersList.php"); ?>
						</div>
						<div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats">
							<?php include("../libs/php/views/partnerStats.php"); ?>
						</div>
						<div class="tab-pane fade" id="doublons" role="tabpanel" aria-labelledby="doublons">
							<?php include("../libs/php/views/partnersDoublons.php"); ?>
						</div>
					</div>

				</main>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
		<script src="../libs/js/partnerStatsChart.js"></script>
		<script src="../ressources/js/script.js"></script>

		<script>

			function selectDoublon(checkbox) {
				var classe = checkbox.getAttribute("data-cb-id");
				var checkboxes = document.getElementsByClassName(classe);
				for (c of checkboxes) {
					if (c != checkbox)
						c.checked = false;
				}

				// on coupe la partie "checkbox_" de checkbox_321john
				// pour n'avoir que le 321john
				classe = classe.substring(9);

				if (document.querySelector("#error_"+classe).innerHTML)
					document.querySelector("#error_"+classe).innerHTML = "";
			}

			function validate_doublon(cb_id, email) {

				if (document.querySelector(".checkbox_"+cb_id+":checked") == null) {
					document.querySelector("#error_"+cb_id).innerHTML = "Veuillez sélectionner un partenaire à garder";
					return;
				}

				var the_checkbox = document.querySelector(".checkbox_"+cb_id+":checked");
				var son_id = the_checkbox.getAttribute("data-partner-id");
				// le return de doAjax fonctionne pas, on suppose que ca fonctionne
				doAjax("../libs/php/controllers/ajax_mirrors.php", "doublon", JSON.stringify({"id": son_id, "email": email}));

				the_checkbox.parentNode.parentNode.parentNode.removeChild(the_checkbox.parentNode.parentNode);
				document.getElementById("handle_status").innerHTML = "Doublons supprimés avec succès";
			}


		</script>
	</body>
</html>
