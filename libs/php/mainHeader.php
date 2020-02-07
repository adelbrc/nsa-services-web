<header>
  <ul class="nav justify-content-end">
    <li class="nav-item">
      <a class="nav-link active" href="#">Nos services</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="#">Tarif</a>
    </li>
    <?php if(!isConnected()){ ?>
    <li class="nav-item">
      <a class="nav-link active" href="login.php">Connexion</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="signup.php">Inscription</a>
    </li>
  <?php }
  if (isConnected()) { ?>
    <li class="nav-item">
      <a class="nav-link active" href="/NSA-Services/Web/libs/php/Deconnexion.php">Deconnexion</a>
    </li>
  <?php } ?>

  </ul>
</header>
