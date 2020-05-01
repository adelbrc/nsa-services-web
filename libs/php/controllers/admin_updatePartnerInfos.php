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

if ($user->getRank() != 3) {
    header("Location: ../../../index.php");
    exit;
}

$partner_id = checkInput($_POST["pid"]);
$partner = Partner::getPartnerById($partner_id);

$corp_name = checkInput($_POST["corp_name"]);
$corp_id = checkInput($_POST["corp_id"]);
$email = checkInput($_POST["email"]);
$phone = checkInput($_POST["phone"]);
$address = checkInput($_POST["addr"]);
$city = checkInput($_POST["city"]);
$dispo_begin = checkInput($_POST["dispo_begin"]);
$dispo_end = checkInput($_POST["dispo_end"]);
$pricing = checkInput($_POST["pricing"]);
$role = checkInput($_POST["role"]);

$partner = Partner::getPartnerById($partner_id);

// ---------------

if (!isset($corp_name) || empty($corp_name)) {
    $corp_name = $partner->getCorp();
}

if (!isset($corp_id) || empty($corp_id)) {
    $corp_id = $partner->getCorpId();
}

// ---------------
// Email
if (isset($email) && !empty($email)) {

  // Format de l'email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header('Location: ../../../admin/partners_management.php?error=email_format');
    exit;
  }

  // Check si Email déjà utilisé
  $q = "SELECT email FROM partner WHERE email = ? AND NOT email = ?";
  $req = $GLOBALS["conn"]->prepare($q);
  $req->execute(array($email, $partner->getEmail()));

  $answers = [];

  while ($row = $req->fetch()) {
    $answers[] = $row;
  }

  if (count($answers) != 0) {
    header('Location: ../../../admin/partners_management.php?error=email_taken');
    exit;
  }

}else {
  $email = $partner->getEmail();
}

// ---------------------------------
//  Gestion du téléphone
if (isset($phone) && !empty($phone)) {

  // Format du numéro (French)
  $phone_pattern = "/^(0)[1-9](\d{2}){4}$/";

  if (!preg_match($phone_pattern, $phone)) {
    header("Location: ../../../admin/partners_management.php?error=phone_number_format");
    exit;
  }

  // Longueur du numéro
  if (strlen($phone) != 10) {
    header("Location: ../../../admin/partners_management.php?error=phone_number_length");
    exit;
  }

}else {
  $phone = $partner->getPhoneNumber();
}


// ----------------------------------
//  Gestion de l'adresse
if (isset($address) && !empty($address)) {

  // Longueur de l'addresse
  if (strlen($address) > 150) {
    header("Location: ../../../admin/partners_management.php?error=address_length");
    exit;
  }
}else {
  $address = $partner->getAddress();
}


// ----------------------------------
//  Gestion de la ville
if (isset($city) && !empty($city)) {

  // Format de la ville
  if (!preg_match("#[a-zA-Z]#", $city)) {
    header("Location: ../../../admin/partners_management.php?error=city_format");
    exit;
  }

  // Longueur
  if (strlen($city) > 45) {
    header("Location: ../../../admin/partners_management.php?error=city_length");
    exit;
  }

}else {
  $city = $partner->getCity();
}


// ------------------------
// Gestion des dates
if (isset($dispo_begin) && !empty($dispo_begin)) {

  // $dispo_beg = date_parse($dispo_begin);
  //
  // if (!checkdate($dispo_beg["month"], $dispo_beg["day"], $dispo_beg["year"])) {
  //   header("Location: ../../../admin/partners_management.php?error=date_begin_format");
  //   exit;
  // }

}else {
  $dispo_begin = $partner->getDisponibilityBegin();
}

if (isset($dispo_end) && !empty($dispo_end)) {

  // $dispo_e = date_parse($dispo_end);
  //
  // if (!checkdate($dispo_e["month"], $dispo_e["day"], $dispo_e["year"])) {
  //   header("Location: ../../../admin/partners_management.php?error=date_end_format");
  //   exit;
  // }

}else {
  $dispo_end = $partner->getDisponibilityEnd();
}

// -----------------------
// Gestion Tarif
if (isset($pricing) && !empty($pricing)) {

  if (!filter_var($pricing, FILTER_VALIDATE_FLOAT)) {
    header("Location: ../../../admin/partners_management.php?error=pricing_format");
    exit;
  }

}else {
  $pricing = $partner->getPricing();
}


// ---------------------
// Mise à jour des infos
$partner->setCorpName($corp_name);
$partner->setCorpId($corp_id);
$partner->setEmail($email);
$partner->setPhoneNumber($phone);
$partner->setAddress($address);
$partner->setCity($city);
$partner->setDisponibilityBegin($dispo_begin);
$partner->setDisponibilityEnd($dispo_end);
$partner->setPricing($pricing);

include("../db/db_connect.php");

$sql = "UPDATE partner SET corporation_name = :corpname, corporation_id = :corpid, address = :addr, city = :ct, email = :mail, phone = :phonenumb, pricing = :prix,
disponibility_begin = :dispobeg, disponibility_end = :dispoend WHERE partner_id = :pid";
$req = $conn->prepare($sql);
$req->execute(array(
    "corpname" => $partner->getCorpName(),
    "corpid" => $partner->getCorpId(),
    "addr" => $partner->getAddress(),
    "ct" => $partner->getCity(),
    "mail" => $partner->getEmail(),
    "phonenumb" => $partner->getPhoneNumber(),
    "prix" => $partner->getPricing(),
    "dispobeg" => $partner->getDisponibilityBegin(),
    "dispoend" => $partner->getDisponibilityEnd(),
    "pid" => $partner->getPID(),
));

header("Location: ../../../admin/partners_management.php?update=success");
exit;
?>
