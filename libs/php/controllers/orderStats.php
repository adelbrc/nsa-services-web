<?php

require_once("../classes/User.php");
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

$sql = "SELECT date(order_date), count(*) FROM orders GROUP BY date(order_date) ORDER BY date(order_date) DESC";
$req = $GLOBALS["conn"]->prepare($sql);
$req->execute();

$data = [];

while ($row = $req->fetch()) {
    $data[] = array("order_date" => $row["date(order_date)"], "nb" => $row["count(*)"]);
}

echo json_encode($data);

?>
