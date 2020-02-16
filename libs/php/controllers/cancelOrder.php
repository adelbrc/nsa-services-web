<?php

require_once("../classes/User.php");
require_once("../classes/Order.php");
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

$oid = checkInput($_GET["oid"]);

if(!isset($oid) || empty($oid)){
  header("Location: ../../../admin/orders_management.php?error=dont_try_this");
  exit;
}

if (!preg_match("#[1-9]#", $oid)) {
  header("Location: ../../../admin/orders_management.php?error=dont_even_try_this");
  exit;
}

// Check if order exists
$order = Order::getOrderByID($oid);

if (is_null($order)) {
  header("Location: ../../../admin/orders_management.php?error=oid");
  exit;
}

if ($order->cancel()) {
  header("Location: ../../../admin/orders_management.php?c=success");
  exit;
}else {
  header("Location: ../../../admin/orders_management.php?c=already_canceled");
  exit;
}

?>
