<?php

require_once("../classes/User.php");
require_once("../classes/Partner.php");
include("../isConnected.php");
include("../functions/checkInput.php");

if (!isConnected()) {
  header("Location: ../../../index.php");
  exit;
}

$user = User::getUserByID($_SESSION["user"]["id"]);

if($user->getRank() != 3) {
    header("Location: ../../../index.php");
    exit;
}

$sql = "SELECT date(add_date), count(*) FROM partner GROUP BY date(add_date) ORDER BY date(add_date) DESC";
$req = $GLOBALS["conn"]->prepare($sql);
$req->execute();

$data = [];

while ($row = $req->fetch()) {
    $data[] = array("add_date" => $row["date(add_date)"], "nb" => $row["count(*)"]);
}

echo json_encode($data);

?>
