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

$pid = checkInput($_GET["pid"]);

if(!isset($pid) || empty($pid)){
  header("Location: ../../../admin/partners_management.php?error=dont_try_this");
  exit;
}

if (!preg_match("#[1-9]#", $pid)) {
  header("Location: ../../../admin/partners_management.php?error=dont_even_try_this");
  exit;
}

// Check if partner exists
$partner = Partner::getPartnerById($pid);

if (is_null($partner)) {
  header("Location: ../../../admin/partners_management.php?error=pid");
  exit;
}

$partner->delete();
header("Location: ../../../admin/partners_management.php?del=success");
exit;
?>
