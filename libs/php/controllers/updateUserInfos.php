<?php

require_once("../classes/User.php");
include("../isConnected.php");
include("../functions/checkInput.php");
include("../functions/tokenize.php");

if (!isConnected()) {
  header("Location: ../../../index.php");
  exit;
}

$user = User::getUserByID($_SESSION["user"]["id"]);

$email = checkInput($_POST["email"]);
$phone = checkInput($_POST["phone"]);
$address = checkInput($_POST["address"]);
$city = checkInput($_POST["city"]);

// -------------------------------
// Gestion et traitements de la photo de la profile pic

if (isset($_FILES["profile_pic"]) && !empty($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] == 0) {

  $uploadCode = 1;
  $uploadHash = tokenize(20);

  // Création des chemins et lieux de dépot des photos
  $file_name = $_FILES["profile_pic"]["name"];
  $arr = explode(".", $file_name);
  $file_ext = strtolower(end($arr));
  $file_destination = "../../../ressources/img/profile_pics/" . $user->getUID() . "-" . date("Y-m-d-H-i-s") . "-" . $uploadHash . "." . $file_ext;

  // Check si c'est bien une image
  if (getimagesize($_FILES["profile_pic"]["tmp_name"]) !== false) {
    $uploadCode = 1;
  }else {
    $uploadCode = 0;
  }

  // Vérifier si le fichier existe déjà
  if (file_exists($file_destination)) {

    $uploadCode = 0;
    header('Location: ../../../profile.php?error=profile_pic_exists');
    exit;

  }

  // // Vérifier le format du fichier et extension
  if ($file_ext != "png" && $file_ext != "jpg" && $file_ext != "jpeg" && $file_ext != "gif") {
    header("Location: ../../../profile.php?error=extension");
    exit;
  }

  if ($_FILES["profile_pic"]["type"] != "image/png" && $_FILES["profile_pic"]["type"] != "image/jpg" && $_FILES["profile_pic"]["type"] != "image/jpeg" &&
  $_FILES["profile_pic"]["type"] != "image/gif") {
    $uploadCode = 0;
  }

  // Vérification de la taille du fichier
  $maxsize = 512000; // 512 KB

  if (($_FILES['profile_pic']['size'] > $maxsize)) {

    $uploadCode = 0;
    header('Location: ../../../profile.php?error=file_size');
    exit;

  }

  if ($uploadCode == 1) {

    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $file_destination);
    $profile_pic = $file_destination;

  }else {

    header("Location: ../../../profile.php?error=err");
    exit;

  }
}else {

  $profile_pic = $user->getProfilePic();
}

// ----------------------------------------
// Gestion de l'email

if (isset($email) && !empty($email)) {

  // Format de l'email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header('Location: ../../../profile.php?error=email_format');
    exit;
  }

  // Check si Email déjà utilisé
  $q = "SELECT email FROM user WHERE email = ? AND NOT email = ?";
  $req = $GLOBALS["conn"]->prepare($q);
  $req->execute(array($email, $user->getEmail()));

  $answers = [];

  while ($row = $req->fetch()) {
    $answers[] = $row;
  }

  if (count($answers) != 0) {
    header('Location: ../../../profile.php?error=email_taken');
    exit;
  }

}else {
  $email = $user->getEmail();
}



// --------------------------------
// Gestion du mot de passe
if (isset($_POST["pass"]) && !empty($_POST["pass"])) {
  $pwd = hash("sha256", $_POST['pass']);
}else {
  $pwd = $user->getPassword();
}


// ---------------------------------
//  Gestion du téléphone
if (isset($phone) && !empty($phone)) {

  // Format du numéro (French)
  $phone_pattern = "/^(0)[1-9](\d{2}){4}$/";

  if (!preg_match($phone_pattern, $phone)) {
    header("Location: ../../../profile.php?error=phone_number_format");
    exit;
  }

  // Longueur du numéro
  if (strlen($phone) != 10) {
    header("Location: ../../../profile.php?error=phone_number_length");
    exit;
  }

  // Check si numéro tel déjà utilisé
  $q = "SELECT phone_number FROM user WHERE phone_number = ? AND NOT phone_number = ?";
  $req = $GLOBALS["conn"]->prepare($q);
  $req->execute(array($phone, $user->getPhoneNumber()));

  $answers = [];

  while ($row = $req->fetch()) {
    $answers[] = $row;
  }

  if (count($answers) != 0) {
    header('Location: ../../../profile.php?error=phone_number_taken');
    exit;
  }

}else {
  $phone = $user->getPhoneNumber();
}


// ----------------------------------
//  Gestion de l'adresse
if (isset($address) && !empty($address)) {

  // Longueur de l'addresse
  if (strlen($address) > 150) {
    header("Location: ../../../profile.php?error=address_length");
    exit;
  }
}else {
  $address = $user->getAddress();
}


// ----------------------------------
//  Gestion de la ville
if (isset($city) && !empty($city)) {

  // Format de la ville
  if (!preg_match("#[a-zA-Z]#", $city)) {
    header("Location: ../../../profile.php?error=city_format");
    exit;
  }

  // Longueur
  if (strlen($city) > 45) {
    header("Location: ../../../profile.php?error=city_length");
    exit;
  }
}else {
  $city = $user->getCity();
}

// --------------------------------------
// Update user infos
$user->updateUserInfos($email, $pwd, $profile_pic, $phone, $address, $city);

// A rajouter : mettre à jour la variable globale $_SESSION avec les nouvelles infos de l'user

header("Location: ../../../profile.php?submit=success");
exit;


?>
