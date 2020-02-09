<?php

session_start();

require_once("libs/php/classes/User.php");

$user = User::loadUser($_SESSION["user"]["email"]);

print_r($user);

?>
