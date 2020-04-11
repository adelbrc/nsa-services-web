<nav class="col-md-2 d-none d-md-block bg-primary sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="fa fa-dashboard"></i>
          Dashboard <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="displayUsers.php">
          <i class="fa fa-address-book"></i>
          <?php echo $utilisateurs[$langue]; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="subscription.php">
          <i class="fa fa-address-card"></i>
          <?php echo $abonnement[$langue]; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="partners_management.php">
          <i class="fa fa-briefcase"></i>
          <?php echo $partenaires[$langue]; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="services_management.php">
          <i class="fa fa-folder"></i>
          Services
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="devis_management.php">
          <i class="fa fa-usd" aria-hidden="true"></i>
          Devis
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="orders_management.php">
          <i class="fa fa-eur"></i>
          <?php echo $commande[$langue]; ?>
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1">
      <span><?php echo $report[$langue]; ?></span>
      <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          <?php echo $cemois[$langue]; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          <?php echo $trimeste[$langue]; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          <?php echo $cetteAnnee[$langue]; ?>
        </a>
      </li>
    </ul>
  </div>
</nav>
