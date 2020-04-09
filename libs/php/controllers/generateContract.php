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

if ($user->getRank() != 3) {
    header("Location: ../../../index.php");
    exit;
}

// Vérification des données
$partner_id = checkInput($_POST["pid"]);
$begin = checkInput($_POST["begin"]);
$end = checkInput($_POST["end"]);
$clauses = checkInput($_POST["clauses"]);

if (!isset($partner_id) || empty($partner_id)) {
    header("Location: ../../../admin/partners_management.php?error=partner_id");
    exit;
}

if (!isset($begin) || empty($begin)) {
    header("Location: ../../../admin/partners_management.php?error=beginning_date");
    exit;
}

if (!isset($clauses) || empty($clauses)) {
    header("Location: ../../../admin/partners_management.php?error=missing_clauses");
    exit;
}



Partner::generateContract($partner_id, $begin, $end, $clauses);

?>
