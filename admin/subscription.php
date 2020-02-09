<?php
include ('../libs/php/isConnected.php');

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
    <link rel="stylesheet" type="text/css" href="../ressources/style/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../ressources/style/dashHeader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../ressources/style/admin.css">


  </head>
  <body>
    <?php include('../libs/php/mainHeader.php'); ?>
    <div class="container-fluid">
      <div class="row">
        <?php include('dashHeader.php');?>
        <?php
        if (isset($_GET['status']) && $_GET['status'] == 'ajoutNewSub') {
          echo '<div class="alert alert-success col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Vous venez d\'ajouter un nouvelle abonnement' . '</div>';
        }
        if (isset($_GET['error']) && $_GET['error'] == 'fieldblanks') {
          echo '<div class="alert alert-danger col-md-12" role="alert" style="margin-top: 20px; text-align: center;">' . 'Vous devez remplir tout les champs !' . '</div>';
        } ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <?php include('createSubscriptionBtn.php');?>
          <div class=" border jumbotron col-md-12" id="jumboRole" style="margin-top: 75px;">
            <h1 class="display-5" style="text-align: center;">Abonnements</h1>
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
                  <td><a type="button" id="deleteSub" class="close" aria-label="Close" href="#"><span aria-hidden="true">&times;</span></a></td>
                </tr>
                            <?php } ?>
              </tbody>
            </table>

          </div>
        </main>
      </div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

</html>
