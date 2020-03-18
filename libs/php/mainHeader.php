<header>
  <ul class="nav justify-content-end">
    <li class="nav-item">
      <a class="nav-link active" href="index.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="services.php">Services</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Tarif</a>
    </li>
    <?php if(!isConnected()){ ?>
    <li class="nav-item">
      <a class="nav-link" href="login.php"><?php echo $connexion[$langue]; ?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="signup.php">Inscription</a>
    </li>
  <?php }
  if (isConnected()) { ?>
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="libs/php/deconnexion.php">Deconnexion</a>
    </li>
  <?php } ?>
  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Langue
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="?lang=0"><img src="https://img.icons8.com/color/64/000000/france.png"/></a>
          <a class="dropdown-item" href="?lang=1"><img src="https://img.icons8.com/color/64/000000/usa.png"/></a>
          <!-- <a class="dropdown-item" href="index.php?langue=0">Something else here</a> -->
        </div>
      </li>
  </ul>
</header>
