<!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
  <?php echo $creeAbonnement[$langue]; ?>
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="formSub" action="newsubscription.php" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $Nom[$langue]; ?></label>
            <input type="text" class="form-control" id="exampleInputNom" aria-describedby="NomHelp" placeholder="<?php echo $saisir[$langue].' '.$Nom[$langue]; ?>" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Tarif</label>
            <input type="number" class="form-control" id="exampleInputtarif" aria-describedby="tarifHelp" placeholder="<?php echo $saisir[$langue]; ?> tarif" name="tarif" value="<?php if(isset($tarif)) { echo $tarif; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $nbHeureCompris[$langue]; ?></label>
            <input type="number" class="form-control" id="exampleInputtimeQuotas" aria-describedby="ClosetimeQuotas" placeholder="<?php echo $saisir[$langue].' '.$nbHeureCompris[$langue]; ?>" name="timeQuotas" value="<?php if(isset($timeQuotas)) { echo $timeQuotas; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $nbJourCompris[$langue]; ?></label>
            <input type="number" class="form-control" id="exampleInputNbJrs" aria-describedby="NbJrsHelp" placeholder="<?php echo $saisir[$langue].' '.$nbJourCompris[$langue]; ?>" name="NbJrs" value="<?php if(isset($NbJrs)) { echo $NbJrs; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $heureOuverture[$langue]; ?></label>
            <input type="number" class="form-control" id="exampleInputOpenHour" aria-describedby="OpenHourHelp" placeholder="<?php echo $saisir[$langue].' '.$heureOuverture[$langue]; ?>" name="OpenHour" value="<?php if(isset($OpenHour)) { echo $OpenHour; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $heureFermeture[$langue]; ?></label>
            <input type="number" class="form-control" id="exampleInputCloseHour" aria-describedby="CloseHourHelp" placeholder="<?php echo $saisir[$langue].' '.$heureFermeture[$langue]; ?>" name="CloseHour" value="<?php if(isset($CloseHour)) { echo $CloseHour; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $duree[$langue]; ?></label>
            <input type="number" class="form-control" id="exampleInputduration" aria-describedby="Closeduration" placeholder="Saisir" name="duration" value="<?php if(isset($duration)) { echo $duration; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <input type="text" class="form-control" id="exampleInputDescription" aria-describedby="CloseDescription" placeholder="Saisir une description" name="Description" value="<?php if(isset($Description)) { echo $Description; } ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="formNewSub" class="btn btn-primary">Valider</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
