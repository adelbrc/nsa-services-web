<?php

include ('../libs/php/isConnected.php');
if (!isConnected()) {
	header('location: ../index.php?error=accessUnauthorized');
}

require_once('../libs/php/classes/Partner.php');

$partnerId = Partner::getPartnerById($_SESSION["user"]["partner_id"]);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<title>Collaborateur</title>
		<!-- My styles -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="../ressources/style/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Fin My styles -->
	</head>
	<?php
	include('../libs/php/includes/partnerHeader.php');
	include('../libs/php/db/db_connect.php');
	?>
	<main>
		<main>
				<div class="container-fluid">
						<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
								<h1 class="h2" id='user'>Profile</h1>
								<div class="btn-toolbar mb-2 mb-md-0">
									<div class="btn-group mr-2">
										<ul class="nav justify-content-center" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="infos-tab" data-toggle="tab" href="#infos" role="tab" aria-controls="infos" aria-selected="true"><button type="button" class="btn btn-sm btn-outline-primary">Informations</button></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Settings</button></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="<?php echo $partnerId->getContract(); ?>"><button type="button" class="btn btn-sm btn-outline-primary">Contrat</button></a>
											</li>
										</ul>
									</div>
								</div>
						</div>
						<div class="form-group col-md-12">
											<?php if (isset($_GET['error']) && $_GET['error'] == "email_format") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Votre mail est au mauvais format'. '</div>';
											}
											if (isset($_GET['error']) && $_GET['error'] == "email_taken") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Le mail est déja pris'. '</div>';
											}
											if (isset($_GET['error']) && $_GET['error'] == "phone_number_format") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Le numéros de téléphone doit avoir que des chiffres !' . '</div>';
											}
											if (isset($_GET['error']) && $_GET['error'] == "phone_number_length") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Le numéros doit avoir 10 chiffres !'. '</div>';
											}
											if (isset($_GET['error']) && $_GET['error'] == "address_length") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'L\'adress ne doit pas dépasser 50 caractere !'. '</div>';
											}
											if (isset($_GET['error']) && $_GET['error'] == "city_format") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'La ville ne peut avoir que des lettres !' . '</div>';
											}
											if (isset($_GET['error']) && $_GET['error'] == "city_length") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'La ville ne peut pas dépasser 150 caracteres !'. '</div>';     //captcha
											}
											if (isset($_GET['error']) && $_GET['error'] == "date_begin_format") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Date de début'. '</div>';     //captcha
											}
											if (isset($_GET['error']) && $_GET['error'] == "date_end_format") {
												echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Date de fin'. '</div>';     //captcha
											}
											if (isset($_GET['update']) && $_GET['update'] == "success") {
												echo '<div class="alert alert-success col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Les informations ont bien été modifié !'. '</div>';     //captcha
											}
											?>
										</div>
						<div class="tab-content" id="myProfileContent">
								<div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings">
									<div class="dataContainer">
										<h1 class="text-center">Informations</h1>
										<form action="../libs/php/controllers/updatePartnerInfos.php" method="post" enctype="multipart/form-data">
											<input type="hidden" name="csrf-token" value="">
											<div class="form-group">
												<input type="file" style="display:block;margin:auto;margin-bottom:60px" name="profile_pic" />
											</div>
											<div class="form-row">
												<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
													<label for="emailID">Adresse Email</label>
													<input type="email" class="form-control" id="emailID" name="email" aria-describedby="emailHelp" value="<?php echo $partnerId->getEmail(); ?>">
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
													<label for="passID">Nouveau mot de passe</label>
													<input type="password" class="form-control" id="passID" name="pass" placeholder="Saisir le nouveau mot de passe">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
													<label for="phoneID">Phone</label>
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="phone">+33</span>
														</div>
														<input type="text" class="form-control" id="phoneID" name="phone" value="<?php echo $partnerId->getPhoneNumber(); ?>" aria-label="Phone" aria-describedby="phone">
													</div>
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
													<label for="addrID">Address</label>
													<input class="form-control" id="addrID" type="text" name="address" value="<?php echo $partnerId->getAddress(); ?>">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
													<label for="cityID">City</label>
													<input class="form-control" id="cityID" type="text" name="city" value="<?php echo $partnerId->getCity(); ?>">
												</div>
											</div>
											<div class="form-group">
												<button type="submit" name="submit" class="btn btn-success">Update</button>
											</div>
										</form>
									</div>
								</div>
						</div>
						<div class="tab-content" id="myProfileContent">
								<div class="tab-pane fade show active" id="infos" role="tabpanel" aria-labelledby="infos">
									<div class="dataContainer">
										<div class="row">
											<div class="col-6">
												<p class="text-center">Nom de societe : <?php echo  $partnerId->getCorpName();?></p>
											</div>
											<div class="col-6">
												<p class="text-center">Email : <?php echo $partnerId->getEmail(); ?></p>
											</div>
										</div>
										<div class="row">
											<div class="col-6">
												<p class="text-center">Prénom : <?php echo $partnerId->getFirstname(); ?></p>
											</div>
											<div class="col-6">
												<p class="text-center">Nom de famille : <?php echo $partnerId->getLastname(); ?></p>
											</div>
										</div>
										<div class="row">
											<div class="col-6">
												<p class="text-center">Adresse : <?php echo $partnerId->getAddress(); ?></p>
											</div>
											<div class="col-6">
												<p class="text-center">Ville : <?php echo $partnerId->getCity(); ?></p>
											</div>
										</div>
										<div class="row">
											<div class="col-6">
												<p class="text-center">Télephone : <?php echo $partnerId->getPhoneNumber(); ?></p>
											</div>
											<div class="col-6">
												<p class="text-center">Tarif /h : <?php echo $partnerId->getPricing(); ?></p>
											</div>
										</div>
									</div>
								</div>
								<!-- <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings">
									<?php //include("../libs/php/views/userSettingsForm.php"); ?>

								</div> -->
						</div>
				</div>
		</main>
	</main>



	<body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	</body>
</html>
