<?php include ('libs/php/isConnected.php');
include('libs/php/db/db_connect.php');
include('libs/php/functions/translation.php');

if (isset($_GET['lang'])) {
	$langue = $_GET["lang"];
}else {
$langue = 0;
}

?>
<html>
	<head>
		<title>nsa</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="ressources/style/style.css">
	</head>
	<body>
		<?php include 'libs/php/mainHeader.php';
		if (isset($_GET['status']) && $_GET['status'] == 'deconnected') { ?>
			<div class="alert text-center alert-danger" role="alert">
				Vous etes deconnecter !
			</div>
		<?php }
		if (isset($_GET['error']) && $_GET['error'] == 'accessUnauthorized') { ?>
			<div class="alert text-center alert-danger" role="alert">
				Vous n'avez pas le droit d'accéder à cette page.
			</div>
		<?php } ?>
		<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
		    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
		    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
		  </ol>
		  <div class="carousel-inner">
		    <div class="carousel-item active">
		      <img src="ressources/img/premium-individuel-800x513.jpg" style="height: 920px;"  class="d-block w-100">
		      <div class="carousel-caption d-none d-md-block">
		        <h5><?php echo $aLecoute[$langue]; ?> </h5>
		      </div>
		    </div>
		    <div class="carousel-item">
		      <img src="ressources/img/nsa-services.png" style="height: 920px;" class="d-block w-100" alt="">
		      <div class="carousel-caption d-none d-md-block">
		      </div>
		    </div>
		    <div class="carousel-item">
		      <img src="ressources/img/premium-individuel-800x513.jpg" style="height: 920px;" class="d-block w-100" >
		      <div class="carousel-caption d-none d-md-block">
		      </div>
		    </div>
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
				<div id="sommeNous">
					<div class="col-md-6 quiSommeNous">
						<img class="aboutImg" src="ressources/img/premium-individuel-800x513.jpg" alt="">
					</div>
					<div class="col-md-6 quiSommeNous">
						<h3 id="h3qui"><?php echo $quiSommeNous[$langue]; ?></h3>
						<p id="quiSommeNousTexte"><?php echo $quiSommeNoustexte[$langue]; ?></p>
					</div>
				</div><br>
				<h1 style="text-align:center;"><?php echo $aboIndiv[$langue] ?></h2>
					<hr class="my-4">

				<div id="abon"class="scrollmenu">
					<?php
					$q = $conn->query('SELECT * FROM membership');
					while($result = $q->fetch()){
					 ?>
					<div class="col-md-4 mx-auto">
						<div class="jumbotron">
						  <h1 class="display-3" style="text-align: center;"><?php echo $result['name']?></h1>
							<hr class="my-4">
							<div>
								<p style="font-size: 22px; color: #00bcd4; text-align:center;"><b><?php echo $result['price']; ?> € TCC/AN </b></p>
							</div>
							<div>
								<p style="font-size: 22px; text-align:center;"><?php echo $result['description']; ?></p>
							</div>
							<div>
								<p style="font-size: 22px; text-align:center;"><?php echo $open[$langue] ?> <?php echo $result['openDays']; ?>j/7 <?php echo $from[$langue] ?> <?php echo $result['openHours']?>H <?php echo $to[$langue] ?> <?php echo $result['closeHours']; ?>H</p>
							</div>
							<div id="btnInteresser" class="mx-auto">
								<a style="margin-left: 25%;" type="button" class="btn btn-info" href="#">Je suis Interesse</a>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
				<?php include('libs/php/footer.php'); ?>
				<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
				<script>
				  var div = document.createElement('div');
				  div.className = 'fb-customerchat';
				  div.setAttribute('page_id', '105590107759642');
				  div.setAttribute('ref', '');
				  document.body.appendChild(div);
				  window.fbMessengerPlugins = window.fbMessengerPlugins || {
				    init: function () {
				      FB.init({
				        appId            : '1678638095724206',
				        autoLogAppEvents : true,
				        xfbml            : true,
				        version          : 'v3.3'
				      });
				    }, callable: []
				  };
				  window.fbAsyncInit = window.fbAsyncInit || function () {
				    window.fbMessengerPlugins.callable.forEach(function (item) { item(); });
				    window.fbMessengerPlugins.init();
				  };
				  setTimeout(function () {
				    (function (d, s, id) {
				      var js, fjs = d.getElementsByTagName(s)[0];
				      if (d.getElementById(id)) { return; }
				      js = d.createElement(s);
				      js.id = id;
				      js.src = "//connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
				      fjs.parentNode.insertBefore(js, fjs);
				    }(document, 'script', 'facebook-jssdk'));
				  }, 0);
				</script>
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>
