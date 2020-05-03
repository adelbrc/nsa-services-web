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
		<title><?php echo $inscription[$langue]; ?></title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="ressources/style/style.css">
	</head>
	<body>
		<?php include('libs/php/mainHeader.php'); ?>
		<div class=" border jumbotron col-md-8 mx-auto" id="jumboLogin" style="margin-top: 75px;">
			<h1 class="display-5" style="text-align: center;"><?php echo $inscription[$langue]; ?></h1>
			<br>
			<div class="form-group col-md-12">
								<?php if (isset($_GET['signup']) && $_GET['signup'] == "passerror") {
									echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . $passerror[$langue]. '</div>';
								}
								if (isset($_GET['signup']) && $_GET['signup'] == "pseudolength") {
									echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . $pseudolength[$langue]. '</div>';
								}
								if (isset($_GET['signup']) && $_GET['signup'] == "lastname_length") {
									echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . $lastnameLength[$langue] . '</div>';
								}
								if (isset($_GET['signup']) && $_GET['signup'] == "field_blank") {
									echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . $field_blank[$langue]. '</div>';
								}
								if (isset($_GET['signup']) && $_GET['signup'] == "name_length") {
									echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . $name_length[$langue]. '</div>';
								}
								if (isset($_GET['signup']) && $_GET['signup'] == "invalid_email") {
									echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . $invalid_email[$langue] . '</div>';
								}
								if (isset($_GET['error']) && $_GET['error'] == "email_exist") {
									echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . $email_exist[$langue]. '</div>';     //captcha
								}
								?>
							</div>
			<form class="formSignup" action="libs/php/inscription.php" method="post">
				<div class="form-group">
					<label for="exampleInputEmail1"><?php echo $Nom[$langue]; ?></label>
					<input type="text" class="form-control" id="exampleInputNom" aria-describedby="NomHelp" placeholder="<?php echo $saisir[$langue] .' '. $Nom[$langue]; ?>" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1"><?php echo $Prenom[$langue]; ?></label>
					<input type="text" class="form-control" id="exampleInputprenom" aria-describedby="prenomHelp" placeholder="<?php echo $saisir[$langue] .' '. $Prenom[$langue]; ?>" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1"><?php echo $address[$langue]; ?></label>
					<input type="text" class="form-control" id="exampleInputadress" aria-describedby="adressHelp" placeholder="<?php echo $saisir[$langue] .' '. $address[$langue]; ?>" name="adress" value="<?php if(isset($adress)) { echo $adress; } ?>">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1"><?php echo $Ville[$langue]; ?></label>
					<input type="text" class="form-control" id="exampleInputville" aria-describedby="villeHelp" placeholder="<?php echo $saisir[$langue] .' '. $Ville[$langue]; ?>" name="ville" value="<?php if(isset($ville)) { echo $ville; } ?>">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1"><?php echo $telNumber[$langue]; ?></label>
					<input type="text" class="form-control" id="exampleInputNum" aria-describedby="NumHelp" placeholder="<?php echo $saisir[$langue] .' '. $telNumber[$langue]; ?>" name="num" value="<?php if(isset($num)) { echo $num; } ?>">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Email</label>
					<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $saisir[$langue] .' Email'; ?>" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>">
				</div>
				<div class="form-group">
					<label for="passwd"><?php echo $passwd[$langue]; ?></label>
					<input type="password" class="form-control" id="passwd" aria-describedby="passwdHelp" placeholder="<?php echo $saisir[$langue] .' '. $passwd[$langue]; ?>" name="passwd">
				</div>
				<div class="form-group">
					<label for="passwd"><?php echo $confimPasswd[$langue]; ?></label>
					<input type="password" class="form-control" id="passwd" aria-describedby="passwdHelp" placeholder="<?php echo $reSaisir[$langue] .' '. $passwd[$langue]; ?>" name="passwd2">
				</div>
				<button type="submit" name="forminscription" class="btn btn-primary"><?php echo $sInscrire[$langue]; ?></button>
			</form>
		</div>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>
