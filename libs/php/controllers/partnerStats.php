<?php

require_once("../classes/User.php");
require_once("../classes/Partner.php");
include("../isConnected.php");
include("../functions/checkInput.php");
include("../functions/tokenize.php");

if (!isConnected()) {
  header("Location: ../../../index.php");
  exit;
}

$user = User::getUserByID($_SESSION["user"]["id"]);

if($user->getRank() != 3) {
    header("Location: ../../../index.php");
    exit;
}

$sql = "SELECT date(signup_date), count(*) FROM user GROUP BY date(signup_date) ORDER BY date(signup_date) DESC";
$req = $GLOBALS["conn"]->prepare($sql);
$req->execute();

$data = [];

while ($row = $req->fetch()) {
    $data[] = array("signup_date" => $row["date(signup_date)"], "nb" => $row["count(*)"]);
}

echo json_encode($data);

?>
