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
      <a class="nav-link" href="login.php">Connexion</a>
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
      <a class="nav-link" href="/libs/php/deconnexion.php">Deconnexion</a>
    </li>
  <?php } ?>

  </ul>
</header>
