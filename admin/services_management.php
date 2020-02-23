<?php
include ('../libs/php/isConnected.php');
if ($_SESSION['user']['rank'] !=3) {
  header('location: ../index.php?error=accessUnauthorized');
}
include ('../libs/php/db/db_connect.php');
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../ressources/style/sidebar.css">
    <link rel="stylesheet" href="../ressources/style/style.css">
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
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2" id='user'>Services Management</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <ul class="nav justify-content-center" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true"><button type="button" class="btn btn-sm btn-outline-primary">List</button></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="stats-tab" data-toggle="tab" href="#stats" role="tab" aria-controls="stats" aria-selected="false"><button type="button" class="btn btn-sm btn-outline-primary">Stats</button></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="tab-content" id="userTab">
            <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list">
              <div class="dataContainer">
                <h3 class="text-center">Services List</h3>
                <?php if (isset($_GET['status']) && $_GET['status'] == 'field_blank') { ?>
                  <div class="alert text-center alert-danger" role="alert">
                    Tous les champs doivent être complétés !
                  </div>
                <?php } ?>
                <div class="row">
                  <?php include('includes/newServicesModal.php'); ?>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col">Discount Price</th>
                          <th scope="col">Category</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $q = $conn->query('SELECT * FROM service');
                              while($result = $q->fetch()){ ?>
                          <tr>
                            <th scope="row"><?php echo $result['id']; ?></th>
                            <td><?php echo $result['name']; ?></td>
                            <td><?php echo $result['price']; ?></td>
                            <td><?php echo $result['discountPrice']; ?></td>
                            <?php
                            $dq = $conn->prepare('SELECT name FROM category WHERE id = ?');
                            $rdes = $dq->execute([$result['category_id']]);
                            $cate = $dq->fetch();
                             ?>
                            <td><?php echo $cate['name']; ?></td>
                            <td>
                              <!-- Button trigger modal -->
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUpdate<?php echo $result['id']; ?>">
                                <i class="fa fa-cog"></i>
                              </button>
                            </td>
                            <td>
                              <button type="button" onclick="supprimer(<?php echo $result['id']; ?>)"  id="deleteSub" class="btn btn-danger">
                                <i class="fa fa-close"></i>
                              </button>
                            </td>
                          </tr>
                          <?php include("../libs/php/includes/updateServiceModal.php"); ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Affichage de toutes les categories -->
          <?php include('includes/categoriesList.php'); ?>
        </main>
      </div>
    </div>
  </body>
  <script>
  function supprimer(service_id) {
    let xhttp = new XMLHttpRequest();

     xhttp.onreadystatechange = function() {
       if (xhttp.readyState == 4 && xhttp.status == 200) {
         console.log(xhttp.responseText);
             alert('Utilisateur bien supprimé !');
           }
     }
     xhttp.open('GET', 'functions/ajax_supprimer.php?service_id=' + service_id);
     xhttp.send();
   }
   function supprimerCategorie(category_id) {
     let xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          console.log(xhttp.responseText);
              alert('Utilisateur bien supprimé !');
            }
      }
      xhttp.open('GET', 'functions/ajax_supprimer.php?category_id=' + category_id);
      xhttp.send();
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</html>
