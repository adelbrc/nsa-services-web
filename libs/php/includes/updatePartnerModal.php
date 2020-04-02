<div class="modal fade" id="modalUpdate<?php echo $partner->getPID(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitle<?php echo $partner->getPID(); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle<?php echo $partner->getPID(); ?>">Edit Partner Infos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../libs/php/controllers/updatePartnerInfos.php" method="post">
          <div class="form-row">
            <input type="hidden" name="pid" value="<?php echo $partner->getPID(); ?>">
            <div class="form-group col-md-6">
              <label for="inputCorpName">Corporation</label>
              <input type="text" class="form-control" id="inputCorpName" name="corp_name" value="<?php echo $partner->getCorpName(); ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="inputCorpId">SIREN</label>
              <input type="text" class="form-control" id="inputCorpId" name="corp_id" value="<?php echo $partner->getCorpId(); ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputLname"><?php echo $Nom[$langue]; ?></label>
              <input type="text" class="form-control" id="inputLname" value="<?php echo $partner->getLastName(); ?>" disabled>
            </div>
            <div class="form-group col-md-6">
              <label for="inputFname"><?php echo $prestataire[$langue]; ?></label>
              <input type="text" class="form-control" id="inputFname" value="<?php echo $partner->getFirstname(); ?>" disabled>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail">Email</label>
              <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo $partner->getEmail(); ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPhone"><?php echo $telNumber[$langue]; ?></label>
              <input type="phone" class="form-control" id="inputPhone" name="phone" value="<?php echo $partner->getPhoneNumber(); ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputAddr"><?php echo $address[$langue]; ?></label>
              <input type="text" class="form-control" id="inputAddr" name="addr" value="<?php echo $partner->getAddress(); ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="inputCity"><?php echo $Ville[$langue]; ?></label>
              <input type="text" class="form-control" id="inputCity" name="city" value="<?php echo $partner->getCity(); ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputBegin"><?php echo $disponibleDebut[$langue]; ?></label>
              <input type="datetime" class="form-control" id="inputBegin" name="dispo_begin" value="<?php echo $partner->getDisponibilityBegin(); ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="inputEnd"><?php echo $disponibleFin[$langue]; ?></label>
              <input type="datetime" class="form-control" id="inputEnd" name="dispo_end" value="<?php echo $partner->getDisponibilityEnd(); ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputPricing"><?php echo $prix[$langue]; ?></label>
              <input type="text" class="form-control" id="inputPricing" name="pricing" value="<?php echo $partner->getPricing(); ?>">
            </div>
            <div class="form-group">
              <label for="rolesList">Job :</label>
              <select class="form-control" name="role" id="rolesList">
                <option value="<?php echo $partner->getRoleId(); ?>" selected><?php echo $partner->getRoleById($partner->getRoleId()); ?></option>
                <?php foreach ($roles as $key => $role): ?>
                  <option value="<?php echo $role["id"]; ?>"><?php echo $role["name"]; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-success" value="Save">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $close[$langue]; ?></button>
      </div>
    </div>
  </div>
</div>
