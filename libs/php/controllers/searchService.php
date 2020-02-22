<?php

require_once("../classes/User.php");
require_once("../classes/Service.php");
include("../isConnected.php");
include("../functions/checkInput.php");

if (!isConnected()) {
  header("Location: ../../../index.php");
  exit;
}

$userInput = checkInput($_GET["q"]);

// Checking user input
if (!isset($userInput) || empty($userInput)) {
  header("Location: ../../../services.php?error=empty_input");
  exit;
}

if (!preg_match("#[a-zA-Z]#", $userInput)) {
  header("Location: ../../../services.php?error=search_format");
  exit;
}

$result = Service::searchService($userInput);

foreach ($result as $key => $service) {
  echo $service->getName();
}




?>
