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

$user = Partner::getPartnerByID($_SESSION["user"]["partner_id"]);

$partner_id = $_SESSION["user"]["partner_id"];
//$corp_name = checkInput($_POST["corp_name"]);
//$corp_id = checkInput($_POST["corp_id"]);
$email = checkInput($_POST["email"]);
$phone = checkInput($_POST["phone"]);
$address = checkInput($_POST["address"]);
$city = checkInput($_POST["city"]);
//$dispo_begin = checkInput($_POST["dispo_begin"]);
//$dispo_end = checkInput($_POST["dispo_end"]);
//$pricing = checkInput($_POST["pricing"]);
//$role = checkInput($_POST["role"]);

$partner = Partner::getPartnerById($partner_id);

// ---------------

// ---------------
// Email
if (isset($email) && !empty($email)) {

  // Format de l'email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header('Location: ../../../collaborateur/profile.php?error=email_format');
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
    header('Location: ../../../collaborateur/profile.php?error=email_taken');
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
    header("Location: ../../../collaborateur/profile.php?error=phone_number_format");
    exit;
  }

  // Longueur du numéro
  if (strlen($phone) != 10) {
    header("Location: ../../../collaborateur/profile.php?error=phone_number_length");
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
    header("Location: ../../../collaborateur/profile.php?error=address_length");
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
    header("Location: ../../../collaborateur/profile.php?error=city_format");
    exit;
  }

  // Longueur
  if (strlen($city) > 45) {
    header("Location: ../../../collaborateur/profile.php?error=city_length");
    exit;
  }

}else {
  $city = $partner->getCity();
}


// ------------------------
// Gestion des dates
if (isset($dispo_begin) && !empty($dispo_begin)) {

  $dispo_beg = date_parse($dispo_begin);

  if (!checkdate($dispo_beg["month"], $dispo_beg["day"], $dispo_beg["year"])) {
    header("Location: ../../../collaborateur/profile.php?error=date_begin_format");
    exit;
  }

}else {
  $dispo_begin = $partner->getDisponibilityBegin();
}

if (isset($dispo_end) && !empty($dispo_end)) {

  $dispo_e = date_parse($dispo_end);

  if (!checkdate($dispo_e["month"], $dispo_e["day"], $dispo_e["year"])) {
    header("Location: ../../../collaborateur/profile.php?error=date_end_format");
    exit;
  }

}else {
  $dispo_end = $partner->getDisponibilityEnd();
}

// -----------------------
// Gestion Tarif
if (isset($pricing) && !empty($pricing)) {

  if (!filter_var($pricing, FILTER_VALIDATE_FLOAT)) {
    header("Location: ../../../collaborateur/profile.php?error=pricing_format");
    exit;
  }

}else {
  $pricing = $partner->getPricing();
}

// ---------------------
// Mise à jour des infos
$partner->updatePartnerInfos($_SESSION["user"]["partner_id"], $address, $city, $email, $phone);
header("Location: ../../../collaborateur/profile.php?update=success");
exit;
?>
