<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="index.php">
		<img src="ressources/img/nsa-services.png" width="80" height="80" alt="nsa-services-logo">
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="dashboard.php">Dashboard</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="services.php">Services</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Account
				</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="profile.php">Profile</a>
				<a class="dropdown-item" href="orders.php">Orders</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Interventions</a>
			</div>
			</li>
			<?php if ($_SESSION["user"]["rank"] == "3"): ?>
				<li class="nav-item">
					<a class="nav-link" href="admin/dashboard.php">Admin Panel</a>
				</li>
			<?php endif; ?>
			<li class="nav-item">
				<a class="nav-link" href="libs/php/deconnexion.php">Logout</a>
			</li>

			<li class="nav-item">
			</li>
		</ul>


		<?php
			// on check que l'abonnement du mec arrive a echeance 1 semaine avant

			$queryUserSubDate = $conn->prepare("SELECT ending FROM memberships_history WHERE user_id = ? AND status = \"active\"");
			$queryUserSubDate->execute([$_SESSION["user"]["id"]]);
			$res = $queryUserSubDate->fetch();

			$aujourdhui = date_create_from_format('Y-m-d', date("Y-m-d"));

			$date_fin = date_create($res["ending"]);
			$date_alert = date_sub($date_fin, date_interval_create_from_date_string("7 days"));

			$aujourdhui = date_add($aujourdhui, date_interval_create_from_date_string("24 days"));

			$diff = date_diff(
				$aujourdhui,
				// je rajoute 1 jour parce que la comparaison date_diff() prend pas le dernier jour de validite
				date_add(date_create($res["ending"]), date_interval_create_from_date_string("1 day"))
				// date_create($res["ending"])
			);

			if ($aujourdhui >= $date_alert) { ?>
				<div class="alert alert-danger m-0 mr-3" role="alert">
				Votre abonnement expire dans <?= $diff->format("%a jour(s)") ?>
				</div>
			<?php
			}

			// echo $aujourdhui->format("d/m/Y");

			?>



		<?php //endif; ?>
	
		<form class="form-inline my-2 my-lg-0">
			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
			<button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
		</form>
	</div>
</nav>
