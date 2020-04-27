<?php

$sql = "SELECT * FROM invoice WHERE customer_id = :uid and membership_id != ''";
$req = $GLOBALS["conn"]->prepare($sql);
$req->execute(array("uid" => $user->getUID()));

while ($row = $req->fetch()) {

	$row["file_path"] = str_replace("/var/www/nsa-services-web/", "", $row["file_path"]);
?>

		<div class="container w-50 col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<p><?php echo "<b>Facture</b> : " . $row["invoice_id"]; ?></p>
			<p><?php echo "<b>Date</b> : " . $row["date_issue"]; ?></p>
			<p><?php echo "<b>Montant</b> : " . $row["amount_paid"] . "€"; ?></p>

			<div class="float-right">
				<a class="btn btn-success" href="<?php echo $row["file_path"]; ?>">Télécharger</a>
			</div>
		</div>


<?php } ?>
