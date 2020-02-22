<?php

require_once('libs/stripe-php-master/init.php');
\Stripe\Stripe::setApiKey('sk_test_UDEhJY5WRNQMQUmjcA20BPne00XeEQBuUc');


// Creer un produit de type "Service" qui peut avoir differents plans forfaitaires
// [inserer create product]


// on veut avoir une reference vers l'id de notre produit qu'on manipule (CRUD)
$le_id_de_notre_produit;

$products = \Stripe\Product::all();

foreach ($products as $key => $product) {
	// echo $product["name"] . " : " . $product["id"] . "<br>";
	// affiche :
		// Abonnements : prod_GmIrmkZZUKLyI1
		// Monthly ... : prod_GmM6KiI39i8LEB

	// si le nom du produit est egal a notre product en question
	if ($product["name"] == "Abonnements") {
		$le_id_de_notre_produit = $product["id"]; 
		break;
	}
}



// Ajouter un nouveau plan forfaitaire de type Plan a un produit (de type Service) DEJA CREE
if (isset($_POST["createPlan"])) {
	// 1. On retrouve l'id du produit de type service
	// 2. On ajoute un nouveau plan a ce produit



	// 2
	$plan = \Stripe\Plan::create([
		'currency' => 'eur',
		'interval' => 'month',
		'product' => $le_id_de_notre_produit,
		'nickname' => "Nouvelle categorie d'abonnement",
		'amount' => 999 * 100,
	]);

	// $plan est l'objet retourne representant le plan tout fraichement ajouté
	// l'essentiel est contenu dans la clé "data"
	// var_dump($plan["data"]);

	echo "<span class='success'>Nouveau plan forfaitaire ajouté !</span>";
}












if (isset($_POST["updatePlan"])) {
	// 1. Supprimer ce plan via cet id
	// 2. Recreer un plan qu'on associe au Produit de type service (qui contient differents plans forfaitaires)
	// var_dump($_POST);

	// 1.
	$deleted_plan = \Stripe\Plan::retrieve($_POST["update_id"]);
	$deleted_plan->delete();


	// 2.
	$new_plan = \Stripe\Plan::create([
		'currency' => 'eur',
		'interval' => 'month',
		'product' => $le_id_de_notre_produit,
		'nickname' => $_POST['plan_name'],
		'amount' => $_POST['amount'] * 100,
		'metadata' => [
			'openDays' => $_POST['openDays'],
			'openHour' => $_POST['openHour'],
			'closeHour' => $_POST['closeHour'],
			'hoursQuota' => $_POST['hoursQuota']
			]
	]);

	echo "<span class='success'>Plan : " . $_POST['plan_name'] . " mis a jour !</span>";


}











// Pour supprimer un plan via son ID
if (isset($_POST["removePlan"])) {

	$plan = \Stripe\Plan::retrieve($_POST["plan_id"]);
	$plan->delete();

	echo "<span class='success'>Plan ". $_POST['plan_name'] . " supprimé !</span>";
}












// Pour ajouter un nouveau container de plans forfaitaires (un produit qui peut avoir different plans forfaitaires)
if (isset($_POST["createProduct"])) {
	\Stripe\Product::create([
		'name' => 'Monthly membership base fee',
		'type' => 'service',
	]);

	echo "<span class='success'>Nouveau Product de type service créé ! (Supprimez ce Product via le dashboard)</span>";
}



?>





<html>
	<head>
		<meta charset="utf-8">
		<style>
			.success {
				padding: 10px;
				background-color: lightgreen;
				color: white;
				text-align: center;
			}
		</style>
	</head>

	<body>
		<form action="" method="POST">
			<button name="createProduct" value="1" style="background-color: orange;">Create un Product</button>
			<button name="createPlan" value="1" style="background-color: lightgreen;">Create un Plan tarifaire générique dans le Product "Abonnements"</button>
		</form>

	
		<h3>Mettre à jour un plan</h3>
		<p>Voici les plans tarifaires actuels du <b>produit "Abonnements"</b> :</p>

		
		<div style="display: flex; justify-content: space-around; overflow-x: scroll; height: 100%;">

			<?php

			$plans = \Stripe\Plan::all();

			foreach ($plans as $key => $plan) {
				$metadata = $plans["data"][$key]["metadata"];
			?>
			
				<section>
				
					<form action="" method="POST">

						<b> Plan tarifaire (<?= $key + 1 ?>) : <?= $plans['data'][$key]['nickname'] ?></b><br>
						<input type="text" name="amount" value=" <?= $plans['data'][$key]['amount'] / 100  ?>"> € / mois <br>

						openDays : <input type="text" name="openDays" value="<?= $metadata["openDays"] ?>"><br>
						openHour : <input type="text" name="openHour" value="<?= $metadata["openHour"] ?>"><br>
						closeHour : <input type="text" name="closeHour" value="<?= $metadata["closeHour"] ?>"><br>
						hoursQuota : <input type="text" name="hoursQuota" value="<?= $metadata["hoursQuota"] ?>"><br>

						<input type="hidden" name="update_id" value="<?= $plans["data"][$key]["id"] ?>">
						<input type="hidden" name="plan_name" value="<?= $plans["data"][$key]["nickname"] ?>">

						<input type="submit" name="updatePlan" value="Mettre a jour <?= $plans['data'][$key]['nickname'] ?>">
					
					</form>

					<form action="" method="POST">
						<input type="hidden" name="plan_id" value="<?= $plans['data'][$key]['id'] ?>">
						<input type="hidden" name="plan_name" value="<?= $plans['data'][$key]['nickname'] ?>">
						<input type="submit" name="removePlan" value="Supprimer le plan <?= $plans['data'][$key]['nickname'] ?>"><br><br><br>
					</form>
			</section>

			<?php }	?>


		</div>

	</body>
</html>