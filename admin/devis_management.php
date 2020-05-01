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

if (isset($_POST['buttonAnswerDeviss'])) {
	if (isset($_POST['price']) AND isset($_POST['answer']) AND !empty($_POST['answer']) AND !empty($_POST['price'])) {
		date_default_timezone_set('Europe/Paris');
		$date = date('y-m-d h:i:s');
		$price = htmlspecialchars($_POST['price']);
		$answer = htmlspecialchars($_POST['answer']);
		$idDevis = $_POST['idDevis'];
		$queryInsertDevis = $conn->prepare("UPDATE devis SET devis_cost =?, answer=?, answer_date = ?, status = 'Valide' WHERE devis_id = ?");
		$queryInsertDevis->execute(
			array(
				$price,
				$answer,
				$date,
				$idDevis
			));
	}else {
		echo 'ERROR';
	}
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
									<li class="nav-item">
										<a class="nav-link active button_export" role="button" href="functions/exportOrders.php">Export</a>
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
							<div class="dataContainer" id="rowRole">
								<h3 class="text-center">Orders List</h3>
								<div class="row">
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th scope="col">Titre</th>
													<th scope="col">Date demande</th>
													<th scope="col">Prix</th>
													<th scope="col">Status</th>
													<th scope="col">Réponse</th>
													<th scope="col">Rejeter</th>
												</tr>
											</thead>
											<tbody>

												<?php
													$queryGetDevis = $conn->prepare("SELECT * FROM devis");
													$queryGetDevis->execute([]);

													foreach ($queryGetDevis->fetchAll() as $devisArray):
														$thedate = new DateTime($devisArray["ordered_date"]);
													 ?>
														<tr>
															<td><?= $devisArray["title"] ?></td>
															<td><?= "Le " . $thedate->format('d/m/Y à H:i:s') ?></td>
															<td><?= !$devisArray["devis_cost"] ? "/" : $devisArray["devis_cost"];  ?></td>
															<td><?= $devisArray["status"] == "En attente" ? "<i class='fa fa-hourglass-half' aria-hidden='true'></i>":
															($devisArray["status"] == "Valide" ? "<i class='fa fa-check' aria-hidden='true'></i>" : "<i class='fa fa-times' aria-hidden='true'></i>")
															?>
															</td>
															<!-- <td><?= $devisArray["answer"] ?></td> -->
															<td>
																<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_devis_<?= $devisArray['devis_id'] ?>">Voir plus</button>
															</td>
															<td>
																<button type="button" id="deleteSub" onclick="supprimer(<?= $devisArray["devis_id"] ?>)" class="close" aria-label="Close" href="#">
																	<span aria-hidden="true">&times;</span>
																</button>
															</td>
															<!-- Modal -->
															<div class="modal fade" id="modal_devis_<?= $devisArray['devis_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog" role="document">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title">Devis n°<?= $devisArray["devis_id"] ?></h5>
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																			</button>
																		</div>
																		<div class="modal-body">
																			<h5>Service demandé</h5>
																			<p><?= $devisArray["title"] ?></p>

																			<h5>Adresse du devis : </h5>
																			<p><?= !$devisArray["address"] ? "/" : $devisArray["address"];  ?></p>
																			<h5>Date de la prestation : </h5>
																			<?php
																				$queryGetDateDevis = $conn->prepare("SELECT * FROM devis_session WHERE devis_id_fk = ?");
																				$queryGetDateDevis->execute([$devisArray["devis_id"]]);
																				foreach ($queryGetDateDevis->fetchAll() as $devisSession):
																			?>
																			<p><?php $thedate2 = new DateTime($devisSession['devis_day']); echo $thedate2->format('d/m/Y'); ?></p>

																			<h5>Heure</h5>
																			<p><?= $devisSession['devis_begin_time']; ?></p>
																			<?php endforeach; ?>
																			<h5>Description du client</h5>
																			<p><?= $devisArray["description"] ?></p>

																			<h3>Chiffrage</h3>
																			<form class="formAnswerDevis"  method="post">
																				<h5>Prix €</h5>
																				<input type="number" name="price">
																				<input type="text" name="idDevis" value="<?= $devisArray["devis_id"] ?>" hidden>
																				<h5>Description </h5>
																				<textarea name="answer" rows="8" cols="50"></textarea><br>
																				<button type="submit" name="buttonAnswerDeviss" class="btn btn-primary">Soumettre</button>

																			</form>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																			<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
																		</div>
																	</div>
																</div>
															</div>
														</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="interventions" role="tabpanel" aria-labelledby="interventions">
							<?php include("../libs/php/views/interventionsList.php"); ?>
						</div>
					</div>
				</main>
			</div>
		</div>
		<script>
		function supprimer(id_devis) {

			let xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					// console.log(xhttp.responseText);
					// alert('Abonnement bien supprimé !');
					document.getElementById("rowRole").innerHTML += "<div class=\"alert alert-success col-md-12\" role=\"alert\" style=\"margin-top: 20px; text-align: center;\">Devis Rejeter</div>";
					// on supprime graphiquement l'abonnement voulu
					//elem.parentNode.parentNode.parentNode.removeChild(elem.parentNode.parentNode);
				}
			};

			xhttp.open('GET', 'functions/ajax_supprimer.php?id_devis=' + id_devis);
			xhttp.send();
			}
		</script>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
		integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>
