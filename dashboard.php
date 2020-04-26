<?php include ('libs/php/isConnected.php');
if (!isConnected()) {
	header('location: index.php?error=accessUnauthorized');
}
include('libs/php/functions/translation.php');

if (isset($_GET['lang'])) {
	$langue = $_GET["lang"];
}else {
	$langue = 0;
}

// \Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

// $session = \Stripe\Checkout\Session::create([
//   'payment_method_types' => ['card'],
//   'mode' => 'setup',
//   'customer' => 'cus_FOsk5sbh3ZQpAU',
//   'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
//   'cancel_url' => 'https://example.com/cancel',
// ]);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Dashboard</title>

	<!-- Stripe -->
	<!-- <link rel="stylesheet" type="text/css" href="./ressources/css/global.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="./ressources/css/normalize.css"> -->
	<script src="https://js.stripe.com/v3/"></script>
	<!-- Fin Stripe -->

	<!-- My styles -->
	<link rel="stylesheet" type="text/css" href="./ressources/style/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./ressources/style/user.css">
	<!-- Fin My styles -->

</head>
<body>
	<?php
		include('libs/php/db/db_connect.php');
		include('libs/php/includes/userHeader.php');
	?>
	<div>
		<h2 style="text-align: center; font-size: 50px; padding-top: 50px"><?php echo $decouvrirAbon[$langue]; ?></h2>
	</div>

	<hr class="my-4">

	<div class="alert alert-success alert-dismissible fade show w-50 mx-auto" style="display: none; position: fixed; top: 20px; right:25%; z-index: 10" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès !</strong> <?php echo $resiliationOk[$langue]; ?>
	</div>





	<div class="container d-flex justify-content-around" id="abonnements">

	<?php

		require_once('libs/stripe-php-master/init.php');
		\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');

		// on recupere et affiche tous les abonnements
		$queryMemberships = $conn->query("SELECT * FROM membership");
		$queryMemberships->execute();
		$memberships = $queryMemberships->fetchAll();
		foreach ($memberships as $membership):
	?>

			<div class="card text-center" style="width: 18rem;">
				<img class="card-img-top" src="https://via.placeholder.com/300x150.png" alt="Card image cap">
				<div class="card-body">
				<h5 class="card-title"><?= $membership["name"] ?></h5>
				<p class="card-text"><?= $membership["description"] ?></p>
				</div>
				<ul class="list-group list-group-flush">
				<li class="list-group-item"><?= $membership["price"] ?> €</li>
				<li class="list-group-item"><?= $membership["timeQuota"] ?> <?php echo $heureMois[$langue]; ?></li>
				<li class="list-group-item"><?php echo $disponibilite[$langue]; ?> <?= $membership["openDays"] ?>j / 7j</li>
				<li class="list-group-item"><?php echo $from[$langue]; ?> <?= $membership["openHours"] ?> h <?php echo $to[$langue]; ?> <?= $membership["closeHours"] ?> h</li>
				<li class="list-group-item"><?php echo $engagement[$langue]; ?> <?= $membership["duration"] ?> mois</li>
				</ul>

				<div class="card-body">

					<?php
						// On va verifier ici que l'utilisateur n'est pas deja abonné a un abonnement
						// s'il est abonné, on bloque le bouton de suscription
						// on fait ca en php parce que c'est non modifiable si le mec tente de faire un "Inspecter lelement"

						// on selectionne user_id mais on pourrait selectionner n'importe quelle colonne,
						// c'est juste pour voir si on a une ligne de retournée
						$queryUserHasSubscription = $conn->prepare("SELECT membership_id FROM memberships_history WHERE user_id = ? AND status = 'active'");
						$queryUserHasSubscription->execute([$_SESSION["user"]["id"]]);
						$result = $queryUserHasSubscription->fetch();

						if ($queryUserHasSubscription->rowCount()) {

							if ($result["membership_id"] == $membership["id"]) {
								echo "<button class=\"btn btn-success\">Mon abonnement actuel</button>";
								echo "<button class=\"btn btn-danger\" data-user-id=\"" . $_SESSION['user']['id'] . "\" data-membership-id=\"" . $membership['id'] . "\" id=\"resilier_sub\">Résilier</button>";
							} else {
								echo "<button class=\"btn btn-secondary\">Un abonnement a déjà été choisi</button>";
							}
						} else {
							echo "<a href=\"./#\" class=\"btn btn-primary\" id=\"" . $membership['id'] . "\" data-toggle=\"modal\" data-target=\"#paymentModal" . $membership['id'] ."\">Je choisis " . $membership['name'] . "</a>";
						}
					?>

				</div>

			</div>

			<!-- Modal -->
			<div class="modal fade" id="paymentModal<?= $membership['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="paymentModalLabel"><?php echo $sabonnerA[$langue]; ?> <?= $membership['name'] ?> ?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?php echo $attendPlus[$langue]; ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $close[$langue]; ?></button>
						<button type="button" class="btn btn-primary" onclick="redirectToCheckout('<?= $membership["id_plan"] ?>')"><?php echo $passerPaiement[$langue]; ?></button>
					</div>
				</div>
				</div>
			</div>



		<?php endforeach; ?>

	</div>


	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<!-- le js ci-dessous (script.js) contient doAjax() -->
	<script src="ressources/js/script.js"></script>



	<script>





		var btn_resililer = document.getElementById("resilier_sub");
		if (btn_resililer != null) {

			btn_resililer.addEventListener("click", function() {
				var user_id = btn_resililer.getAttribute("data-user-id");
				var membership_id = btn_resililer.getAttribute("data-membership-id");
				doAjax("libs/php/controllers/ajax_mirrors.php", "resilier", JSON.stringify({"user_id": user_id, "membership_id": membership_id}));
			});
		}

		var PUBLISHABLE_KEY = "pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B";


		// var DOMAIN = "http://nsaservices.local";
		var DOMAIN = "http://localhost/nsa-services-web";

		var stripe = Stripe(PUBLISHABLE_KEY);

		// Handle any errors from Checkout
		var handleResult = function(result) {
			if (result.error) {
				var displayError = document.getElementById("error-message");
				displayError.textContent = result.error.message;
			}
		};

		// cette fonction permet de rediriger vers le site de stripe avec l'id du plan
		var redirectToCheckout = function(planId) {
			stripe.redirectToCheckout({
					items: [{ plan: planId, quantity: 1 }],
					successUrl:DOMAIN + "/success.php?session_id={CHECKOUT_SESSION_ID}",
					cancelUrl: DOMAIN + "/dashboard.php?session_id={CHECKOUT_SESSION_ID}",
					customerEmail: "<?= $_SESSION["user"]["email"] ?>"
					// payment_method: {card: cardElement}


				})
				.then(handleResult);
		};


	</script>


</body>
</html>
