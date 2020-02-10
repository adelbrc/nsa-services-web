<?php
include ('../libs/php/isConnected.php');
if ($_SESSION['user']['rank'] !=3) {
  header('location: ../index.php?error=accessUnauthorized');
}
include ('../libs/php/db/db_connect.php');


if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $supprimer = (int) $_GET['id'];
    $req = $conn->prepare('DELETE FROM membership WHERE idAbonnement = ?');
    $req->execute(array($supprimer));
 }
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Gestion des abonnements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../ressources/style/admin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <header>
    <?php include('includes/headerNavigation.php'); ?>
    </header>
    <div class="container-fluid">
      <div class="row">
        <?php include('includes/sidebar.php'); ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class=" border jumbotron col-md-12" id="jumboRole" style="margin-top: 75px;">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'ajoutNewSub') {
              echo '<div class="alert alert-success col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Vous venez d\'ajouter un nouvelle abonnement' . '</div>';
            }
            if (isset($_GET['status']) && $_GET['status'] == 'worked') {
              echo '<div class="alert alert-success col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Vous venez de modifier les informations d\'un abonnement' . '</div>';
            }
            if (isset($_GET['error']) && $_GET['error'] == 'fieldblanks') {
              echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Vous devez remplir tout les champs !' . '</div>';
            } ?>
            <h1 class="display-5" style="text-align: center;">Abonnements</h1>
            <?php include('createSubscriptionBtn.php');?>
            <br>
            <?php
            if (isset($_GET['status']) && $_GET['status'] == "ajoutNewRole") {
              echo '<div class="alert alert-success col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Vous venez d\'ajouter une nouvelle fonction' . '</div>';
            } ?>
            <br>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">nom</th>
                  <th scope="col">Prix</th>
                  <th scope="col">Nb d'heure compris</th>
                  <th scope="col">Nb de jours ouverts</th>
                  <th scope="col">Heure open/close</th>
                  <th scope="col">Durée</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $q = $conn->query('SELECT * FROM membership');
                  while($result = $q->fetch()){
                ?>
                <tr>
                  <th scope="row"><?php echo $result['id']; ?></th>
                  <td><?php echo $result['name']; ?></td>
                  <td><?php echo $result['price'] . '€ TTC/an'; ?></td>
                  <td><?php echo $result['timeQuota']. ' €'; ?></td>
                  <td><?php echo $result['openDays']. 'j/7'; ?></td>
                  <td><?php echo $result['openHours']. 'h - '. $result['closeHours'] . 'h'; ?></td>
                  <td><?php echo $result['duration'] . 'mois'; ?></td>
                  <td><button type="button" id="deleteSub" onclick="supprimer(<?php echo $result['id']; ?>)"  class="close" aria-label="Close" href="#"><span aria-hidden="true">&times;</span></button></td>
                  <td><a href="modifySubscription.php?id=<?php echo $result['id']; ?>"><i class="fa fa-search-plus"></i></a></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
        </main>
      </div>
    </div>
  </body>
  <script>
  function supprimer(abonnement_id) {
    let xhttp = new XMLHttpRequest();

     xhttp.onreadystatechange = function() {
       if (xhttp.readyState == 4 && xhttp.status == 200) {
         console.log(xhttp.responseText);
             alert('Utilisateur bien supprimé !');
           }
     }
     xhttp.open('GET', 'functions/ajax_supprimer.php?abonnement_id=' + abonnement_id);
     xhttp.send();
   }
  </script>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</html>
