<!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" style="margin-left: 30%;">
  Réserver
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $result['name']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="formResa" action="../newReservation.php" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Nombre d'heure</label>
            <input type="number" class="form-control" id="exampleInputnbHours" aria-describedby="nbHoursHelp" placeholder="Nombre d'heure" name="nbHours" value="<?php if(isset($nbHours)) { echo $nbHours; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Date de réservation</label>
            <input type="date" class="form-control" id="exampleInputdateResa" aria-describedby="dateResaHelp" placeholder="date" name="dateResa" value="<?php if(isset($dateResa)) { echo $dateResa; } ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <input type="text" style="height: 100px;" class="form-control" id="exampleInputDescription" aria-describedby="CloseDescription" name="Description" value="<?php if(isset($Description)) { echo $Description; } ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="formNewSub" class="btn btn-primary">Confirmer la réservation</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
