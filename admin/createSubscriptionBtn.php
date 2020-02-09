<!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
  new abonnement
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
        <form class="formSub" action="newsubscription.php" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Nom</label>
            <input type="text" class="form-control" id="exampleInputNom" aria-describedby="NomHelp" placeholder="Saisir votre nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Tarif</label>
            <input type="number" class="form-control" id="exampleInputtarif" aria-describedby="tarifHelp" placeholder="Saisir le prix" name="tarif" value="<?php if(isset($tarif)) { echo $tarif; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">nombre de service compris (en heure)</label>
            <input type="number" class="form-control" id="exampleInputtimeQuotas" aria-describedby="ClosetimeQuotas" placeholder="Saisir le prix" name="timeQuotas" value="<?php if(isset($timeQuotas)) { echo $timeQuotas; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">nombre de jours ouvert (/7j)</label>
            <input type="number" class="form-control" id="exampleInputNbJrs" aria-describedby="NbJrsHelp" placeholder="Saisir le nombre de jours ouvert" name="NbJrs" value="<?php if(isset($NbJrs)) { echo $NbJrs; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Heure ouverture</label>
            <input type="number" class="form-control" id="exampleInputOpenHour" aria-describedby="OpenHourHelp" placeholder="Saisir l'heure d'ouverture" name="OpenHour" value="<?php if(isset($OpenHour)) { echo $OpenHour; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Heure fermeture</label>
            <input type="number" class="form-control" id="exampleInputCloseHour" aria-describedby="CloseHourHelp" placeholder="Saisir l'heure de fermeture" name="CloseHour" value="<?php if(isset($CloseHour)) { echo $CloseHour; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Durée de l'abonnement (en mois)</label>
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
