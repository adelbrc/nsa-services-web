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
    <link rel="stylesheet" type="text/css" href="../ressources/style/bootstrap.min.css">

  </head>
  <body>
<?php include('../libs/php/mainHeader.php'); ?>
  </body>
</html>
