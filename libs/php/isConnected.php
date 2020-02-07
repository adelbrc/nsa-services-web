<?php
session_start();

// Fonction pour vérifier si l'utilisateur est connecté ou pas
function isConnected(){
  if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $connected = true;
  }else{
    $connected = false;
  }
  return $connected;
}


?>
