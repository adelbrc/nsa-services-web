<?php include ('../libs/php/isConnected.php');
if (!isConnected()) {
  header('location: ../index.php?error=accessUnauthorized');
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Collaborateur</title>
    <!-- My styles -->
  	<link rel="stylesheet" type="text/css" href="../ressources/style/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="./ressources/style/user.css">
  	<!-- Fin My styles -->
  </head>
  <body>
<?php include('../libs/php/includes/partnerHeader.php');
include('../libs/php/db/db_connect.php');
?>
  </body>
</html>
