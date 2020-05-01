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
		<title>NSA Home Services</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="ressources/style/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="ressources/style/style.css">
	</head>
	<body>
		<?php include 'libs/php/mainHeader.php';
		if (isset($_GET['status']) && $_GET['status'] == 'deconnected') { ?>
			<div class="alert text-center alert-danger" role="alert">
				Vous vous êtes déconnecté !
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
						<!-- <img src="ressources/img/background1.jpg" id="bg1" class="carousel-background d-block w-100"> -->
						<div id="bg1" class="carousel-background d-block w-100">
							<div class="carousel-caption d-none d-md-block">
								<h1><?php echo $aLecoute[$langue]; ?></h1>
								<a href="signup.php">
									<button class="btn btn-success">Démarrer ma vie de luxe</button>
								</a>
							</div>
						</div>

					</div>
					<div class="carousel-item">
						<img src="ressources/img/background2.jpg" id="bg2" class="carousel-background d-block w-100">
						<div class="carousel-caption d-none d-md-block">
						<!-- <h1><?php echo $aLecoute[$langue]; ?></h1> -->
							<h1>Exigez l'excellence</h1>
						</div>

					</div>

					<div class="carousel-item">
						<img src="ressources/img/background3.jpg" id="bg3" class="carousel-background d-block w-100">
						<div class="carousel-caption d-none d-md-block">
						<!-- <h1><?php echo $aLecoute[$langue]; ?></h1> -->
							<h1>Libérez-vous</h1>
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
			</div>


				<div id="sommeNous">
					<div class="col-md-6 quiSommeNous">
						<img class="aboutImg" src="ressources/img/premium-individuel-800x513.jpg">
					</div>
					<div class="col-md-6 quiSommeNous">
						<h3 class="h3qui"><?php echo $quiSommeNous[$langue]; ?></h3>
						<p id="quiSommeNousTexte"><?php echo $quiSommeNoustexte[$langue]; ?></p>
					</div>
				</div>
				<div id="canvas">

				</div>
				<br>

				<h1 id="abonTitle" class="h3qui" style="text-align:center;"><?php echo $aboIndiv[$langue] ?></h1>

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
				<script type="module">

												import * as THREE from './libs/js/webGL/build/three.module.js';
												//import Stats from './libs/js/webGL/jsm/libs/stats.module.js';
												import { GUI } from './libs/js/webGL/jsm/libs/dat.gui.module.js';
												import { FBXLoader } from './libs/js/webGL/jsm/loaders/FBXLoader.js';
												import { OrbitControls } from './libs/js/webGL/jsm/controls/OrbitControls.js';

												var container, controls;
												var camera, scene, renderer, light;

												var clock = new THREE.Clock();

												var mixer;

												init();
												animate();

												function init() {
													container = document.createElement( 'div' );
													var canvas = document.getElementById( 'canvas' );
													canvas.appendChild( container );
													camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 15000 );
													camera.position.set( 50, 300, 220 );

													scene = new THREE.Scene();
													scene.background = new THREE.Color( 0x000000 );
													// scene.fog = new THREE.Fog( 0xa0a0a0, 200, 1000 );

													light = new THREE.HemisphereLight( 0xffffff, 0x444444 );
													light.position.set( 0, 200, 0 );
													scene.add( light );

													light = new THREE.DirectionalLight( 0xffffff );
													light.position.set( 0, 200, 100 );
													light.castShadow = true;
													light.shadow.camera.top = 180;
													light.shadow.camera.bottom = - 100;
													light.shadow.camera.left = - 120;
													light.shadow.camera.right = 120;
													scene.add( light );

													// scene.add( new CameraHelper( light.shadow.camera ) );

													// ground
													var mesh = new THREE.Mesh( new THREE.PlaneBufferGeometry( 2000, 2000 ), new THREE.MeshPhongMaterial( { color: 0x000000, depthWrite: false } ) );
													mesh.rotation.x = - Math.PI / 2;
													mesh.receiveShadow = true;
													scene.add( mesh );

													var grid = new THREE.GridHelper( 2000, 20, 0x000000, 0x000000 );
													grid.material.opacity = 0.2;
													grid.material.transparent = true;
													scene.add( grid );

													// model
													var loader = new FBXLoader();
													loader.load( 'libs/js/webGL/3Dobjects/plombier/Dropping.fbx', function ( plombier ) {

													mixer = new THREE.AnimationMixer( plombier );

													var action = mixer.clipAction( plombier.animations[ 0 ] );
													action.play();

													plombier.traverse( function ( child ) {

														if ( child.isMesh ) {

															child.castShadow = true;
															child.receiveShadow = true;

														}

													} );
																plombier.rotation.y = 2.3;
															plombier.position.z = -205;
															plombier.position.x = 85;
													plombier.rotation.y = 4.5;

													scene.add( plombier );

													} );
															// Kitchen
															var loader = new FBXLoader();
															loader.load( 'libs/js/webGL/3Dobjects/kitchen2/source/test9.fbx', function ( cuisine ) {

																	cuisine.traverse( function ( child ) {

																		if ( child.isMesh ) {

																			child.castShadow = true;
																			child.receiveShadow = true;

																		}
																} );
														cuisine.position.x = 300;
														cuisine.position.z = 700;
														cuisine.position.y = 10;
														cuisine.rotation.y = 1.6;

														cuisine.scale.set(90,90,90);
														scene.add( cuisine );

															} );

													renderer = new THREE.WebGLRenderer( { antialias: true } );
													renderer.setPixelRatio( window.devicePixelRatio );
													renderer.setSize( window.innerWidth, window.innerHeight );
													renderer.shadowMap.enabled = true;
													container.appendChild( renderer.domElement );

													controls = new OrbitControls( camera, renderer.domElement );
													controls.target.set( 0, 150, -150 );
													controls.update();

													window.addEventListener( 'resize', onWindowResize, false );
												}

												function onWindowResize() {

													camera.aspect = window.innerWidth / window.innerHeight;
													camera.updateProjectionMatrix();

													renderer.setSize( window.innerWidth, window.innerHeight );

												}

												//

												function animate() {

													requestAnimationFrame( animate );

													var delta = clock.getDelta();

													if ( mixer ) mixer.update( delta );

													renderer.render( scene, camera );


												}

											</script>
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>
