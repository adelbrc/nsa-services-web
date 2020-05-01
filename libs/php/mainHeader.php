<header>
	<ul class="nav justify-content-end">
		<li class="nav-item">
			<a class="nav-link active" href="index.php">Home</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#abonTitle">Tarifs</a>
		</li>
		<?php if(!isConnected()){ ?>
		<li class="nav-item">
			<a class="nav-link" href="login.php"><?php echo $connexion[$langue]; ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="signup.php"><?php echo $inscription[$langue]; ?></a>
		</li>
	<?php }
	if (isConnected()) { ?>
		<li class="nav-item">
			<a class="nav-link" href="dashboard.php">Dashboard</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="libs/php/deconnexion.php"><?php echo $deconnexion[$langue]; ?></a>
		</li>
	<?php } ?>
	<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php echo $langues[$langue]; ?>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="?lang=0"><img src="https://img.icons8.com/color/64/000000/france.png"/></a>
					<a class="dropdown-item" href="?lang=1"><img src="https://img.icons8.com/color/64/000000/usa.png"/></a>
					<!-- <a class="dropdown-item" href="index.php?langue=0">Something else here</a> -->
				</div>
			</li>
	</ul>
</header>
