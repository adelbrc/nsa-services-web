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
										<a class="nav-link active button_export" role="button" href="functions/exportPartner.php">Export</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="stats-tab" data-toggle="tab" href="#stats" role="tab" aria-controls="stats" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Stats</button></a>
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
							<?php include("../libs/php/views/partnerProfile.php"); ?>
						</div>
					</div>


					<div class="tab-content" id="partnersTab">
						<div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list">
							
							<div class="dataContainer">
								<h3 class="text-center">Doublons</h3>
								<p style="color: red"><b>Sélectionnez celui que vous souhaitez conserver</b></p>
								<p id="handle_status" style="color: green"></p>
								<div class="row">




							<!-- <div class="container bg-secondary border duplicate-box">
										<div class="container d-flex align-items-center justify-content-between">
										<p>#ID</p>
										<p>Nom</p>
										<p>Prenom</p>
										<p>Choix</p>
									</div>
								</div> -->


								<?php

								$queryDuplicates = $conn->query("SELECT email, COUNT(*) occurrences FROM partner GROUP BY email HAVING COUNT(*) > 1;");
								$res = $queryDuplicates->fetchAll();

								// var_dump($res);

								foreach($res as $dup): ?>

									<!-- UNIT -->
									<div class="container border duplicate-box">



									<?php
										
										$queryDup = $conn->prepare("SELECT * FROM partner WHERE email = ?");
										$queryDup->execute([$dup["email"]]);
										
										$random = random_int(100, 999);
										while (($dup_unit = $queryDup->fetch())): ?>
											<div class="container d-flex align-items-center justify-content-between">
												<p><?= $dup_unit["add_date"] ?></p>
												<p><?= $dup_unit["partner_id"] ?></p>
												<p><?= $dup_unit["lastname"] ?></p>
												<p><?= $dup_unit["email"] ?></p>
												<input type="checkbox" style="width: 20px;height: 20px;" data-partner-id="<?= $dup_unit["partner_id"] ?>" class="cb_doublon checkbox_<?= $random . substr($dup["email"], 0, 2) ?>" data-cb-id="checkbox_<?= $random . substr($dup["email"], 0, 2) ?>" onclick="selectDoublon(this)">
											</div>
										<?php endwhile; ?>

										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_<?php echo $random . substr($dup["email"], 0, 2) ?>">
											Voir comparaison
										</button>

										<button type="button" class="btn btn-success" onclick="validate_doublon('<?= $random . substr($dup["email"], 0, 2) ?>', '<?= $dup["email"] ?>')">
											Valider
										</button>
										<p id="error_<?= $random . substr($dup["email"], 0, 2) ?>"></p>

										<!-- Modal -->
										<div class="modal fade" id="modal_<?php echo $random . substr($dup["email"], 0, 2) ?>" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content" style="width: 700px">
													<div class="modal-header">
														<h5 class="modal-title">Modal </h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body container-fluid d-flex justify-content-between">

														<?php

														$queryDupModal = $conn->prepare("SELECT * FROM partner WHERE email = ?");
														$queryDupModal->execute([$dup["email"]]); 
														$resDupModal = $queryDupModal->fetchAll();

														foreach ($resDupModal as $resModal): ?>

															<div class="" style="flex: 1">
																<p>Partner n° <?= $resModal["partner_id"] ?></p>
																<p><b>Inséré le : </b><?= $resModal["add_date"] ?></p>
																<p><?= $resModal["firstname"] . " " . $resModal["lastname"] ?></p>
																<p><b>Email : </b><?= $resModal["email"] ?></p>
																<p><b>Phone : </b><?= $resModal["phone"] ?></p>
																<p><b>Entreprise : </b><?= $resModal["corporation_name"] ?></p>
																<p><b>Adresse : </b><?= $resModal["address"] ?></p>
																<p><?= $resModal["city"] ?></p>
																<p><b>Disponible de : </b><?= $resModal["disponibility_begin"] ?></p>
																<p><b>au : </b><?= $resModal["disponibility_end"] ?></p>
																<img src="<?= $resModal["qrcode"] ?>" alt="" width="100" height="100" />
																<p></p>
															</div>


														<?php endforeach; ?>

													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach; ?>

							</div>
						</div>
					</div>


				</main>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

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
