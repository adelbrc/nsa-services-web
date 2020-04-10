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

    <meta charset="utf-8">
    <link rel="stylesheet" href="../ressources/style/style.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/../libs/font-awesome/4.7.0/css/font-awesome.min.css">

  	<!-- Fin My styles -->
  </head>
  <?php include('../libs/php/includes/partnerHeader.php');
  include('../libs/php/db/db_connect.php');
  ?>
  <body>
    <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
      <h3 class="text-center">Bienvenu <?php echo $_SESSION['user']['corporation_name'] ?></h3>
      <hr>
      <div class="tab-content" id="userTab">
      <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list">
          <div class="table-responsive">
            <div class="dataContainer">
              <h3 class="text-center">Mon espace partenaire</h3>
              <div class="row">
                <div class="table-responsive">

                  <!-- <canvas id="myChart" style="width:200px"></canvas> -->
                  <div id="container" class="d-flex justify-content-center" style="display: flex;">
                    <div class="containerd" style="display: flex; background-color :green;">
                      <div class="">
                        <i class="fa fa-bell" aria-hidden="true" style="font-size:55px; margin-right:15px"></i>
                      </div>
                      <div class="">
                        <?php
                        $queryCountService = $conn->prepare("SELECT COUNT(*) FROM order_session WHERE partner_id = ? ");
                        $queryCountService->execute([$_SESSION['user']['partner_id']]);
                        $res = $queryCountService->fetch();
                        ?>
                        <b><?php echo $res[0]; ?></b><p>Services effectue</p>
                      </div>

                    </div>

                    <div class="containerd" style="display: flex; background-color :orange;">
                      <div class="">
                        <i class="fa fa-usd" aria-hidden="true" style="font-size:55px; margin-right:15px"></i>

                      </div>
                      <div class="">
                        <?php
                        $queryCountService = $conn->prepare("SELECT * FROM partner WHERE partner_id = ? ");
                        $queryCountService->execute([$_SESSION['user']['partner_id']]);
                        $ress = $queryCountService->fetch();

                          $ca = $res[0]*$ress[12];
                         echo $ca." €";?><p>Chiffre d'affaire</p>
                      </div>

                    </div>
                </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
      </div>

    </main>
    <!-- <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',

        // The data for our dataset
        data: {
              labels: ['Nb de services effectue'],
              datasets: [{

              <?php
              // $queryCountService = $conn->prepare("SELECT COUNT(*) FROM order_session WHERE partner_id = ? ");
            	// $queryCountService->execute([$_SESSION['user']['partner_id']]);
            	// $res = $queryCountService->fetch();
              ?>
                data: [<?php //echo $res[0] ?>, 96],
                backgroundColor: [
                  'rgb(0,0,255)',
                  'rgb(105,105,105)',
                ],

                borderColor: 'rgb(255,255,255)',
            }]
        },

        // Configuration options go here
        options: {}
    });
    </script> -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/../libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
  </body>
</html>
