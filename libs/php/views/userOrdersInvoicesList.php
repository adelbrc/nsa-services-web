<?php

// la condition c'est select les abonnements de X utilisateur où la colonne membership id contient quelque chose,
// parce que si elle est vide ca veut dire que la row c'est une facture de service, et comme un service n'a pas d'id de membership,
// on le met vide

$sql = "SELECT * FROM invoice WHERE customer_id = :uid AND service_id != '' ORDER BY invoice_id DESC";

$req = $GLOBALS["conn"]->prepare($sql);
$req->execute(array("uid" => $user->getUID()));

while ($row = $req->fetch()) {

	$row["file_path"] = str_replace("/var/www/nsa-services-web/", "", $row["file_path"]);
?>

<div class="dataContainer">
	<div class="row d-flex flex-wrap">
		<div class="container w-50 col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<p><?php echo "<b>Facture</b> : " . $row["invoice_id"]; ?></p>
			<p><?php $thedate = new DateTime($row["date_issue"]); echo "<b>Date</b> : " . $thedate->format("d-m-Y H:i:s"); ?></p>
			<p><?php echo "<b>Montant</b> : " . $row["amount_paid"] . "€"; ?></p>

			<div class="float-right">
				<a class="btn btn-success" href="<?php echo $row["file_path"]; ?>">Télécharger</a>
			</div>
		</div>
	</div>
</div>


<?php } ?>
