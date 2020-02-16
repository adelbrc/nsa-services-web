<?php $list = Service::getAllServices(); ?>
<?php foreach ($list as $key => $service): ?>
  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
    <div class="card serviceCard" style="width: 18rem;">
      <img src="ressources/img/nsa-services.png" style="width:100px;height:100px;margin:auto" alt="...">
      <div class="card-body">
        <h5 class="card-title"><?php echo $service->getName(); ?></h5>
        <p class="card-text"><?php echo $service ->getDescription(); ?></p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><?php echo "Prix: " . $service->getPrice() . "€/h"; ?></li>
        <li class="list-group-item"><?php echo "Categorie: " . $service->getServiceCategory(); ?></li>
      </ul>
      <div class="card-body">
        <a href="#" class="card-link">Commander</a>
        <a href="#" class="card-link">Réserver</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
