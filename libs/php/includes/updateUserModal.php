<div class="modal fade" id="modalUpdate<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitle<?php echo $result['id']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle<?php echo $result['id']; ?>">Edit Partner Infos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../libs/php/controllers/admin_updateUserInfo.php" method="post">
          <div class="form-row">
            <input type="hidden" name="pid" value="<?php echo $result['id']; ?>">
            <div class="form-group col-md-6">
              <label for="inputCorpName">Prenom</label>
              <input type="text" class="form-control" id="inputFname" name="inputFname" value="<?php echo $result['firstname']; ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="inputCorpId">Nom de famille</label>
              <input type="text" class="form-control" id="inputLname" name="inputLname" value="<?php echo $result['lastname']; ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputLname">Email</label>
              <input type="text" class="form-control" id="inputEmail" value="<?php echo $result['email']; ?>" disabled>
            </div>
            <div class="form-group col-md-6">
              <label for="inputFname">Numéro de téléphone</label>
              <input type="text" class="form-control" id="inputNum" name="inputNum" value="<?php echo $result['phone_number']; ?>">
            </div>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-success" value="Save">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
