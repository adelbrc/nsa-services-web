<!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
  Nouvelle fonction
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="formRole" action="libs/php/newRole.php" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Nom</label>
            <input type="text" class="form-control" id="exampleInputNom" aria-describedby="NomHelp" placeholder="Saisir votre nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Tarif plein</label>
            <input type="number" class="form-control" id="exampleInputtarifP" aria-describedby="tarifPHelp" placeholder="Saisir le prix" name="tarifPlein" value="<?php if(isset($tarifP)) { echo $tarifP; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">nombre d'unité pour remise</label>
            <input type="number" class="form-control" id="exampleInputNbRemise" aria-describedby="NbRemiseHelp" placeholder="Saisir le nombre d'unité pour remise" name="NbRemise" value="<?php if(isset($NbRemise)) { echo $NbRemise; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Tarif remisé</label>
            <input type="number" class="form-control" id="exampleInputtarifR" aria-describedby="tarifRHelp" placeholder="Saisir le prix remisé" name="tarifRemise" value="<?php if(isset($tarifR)) { echo $tarifR; } ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="formNewRole" class="btn btn-primary">Valider</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
