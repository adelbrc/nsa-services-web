<?php
$list = Partner::getAllPartners();
?>

<div class="dataContainer">
  <h3 class="text-center">Partners List</h3>
  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Corporation</th>
          <th scope="col">SIREN</th>
          <th scope="col">Firstname</th>
          <th scope="col">Lastname</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">City</th>
          <th scope="col">Edit</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($list as $key => $partner): ?>
          <tr>
            <th scope="row"><?php echo $partner->getPID(); ?></th>
            <td><?php echo $partner->getCorpName(); ?></td>
            <td><?php echo $partner->getCorpId(); ?></td>
            <td><?php echo $partner->getFirstname(); ?></td>
            <td><?php echo $partner->getLastname(); ?></td>
            <td><?php echo $partner->getEmail(); ?></td>
            <td><?php echo $partner->getPhoneNumber(); ?></td>
            <td><?php echo $partner->getCity(); ?></td>
            <td>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal<?php echo $partner->getPID(); ?>">
                Edit
              </button>
            </td>
          </tr>

          <!-- Modal -->
          <div class="modal fade" id="modal<?php echo $partner->getPID(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitle<?php echo $partner->getPID(); ?>" aria-hidden="true">
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
                        <label for="inputLname">Lastname</label>
                        <input type="text" class="form-control" id="inputLname" value="<?php echo $partner->getLastName(); ?>" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputFname">Firstname</label>
                        <input type="text" class="form-control" id="inputFname" value="<?php echo $partner->getFirstname(); ?>" disabled>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo $partner->getEmail(); ?>">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputPhone">Phone</label>
                        <input type="phone" class="form-control" id="inputPhone" name="phone" value="<?php echo $partner->getPhoneNumber(); ?>">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputAddr">Address</label>
                        <input type="text" class="form-control" id="inputAddr" name="addr" value="<?php echo $partner->getAddress(); ?>">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity" name="city" value="<?php echo $partner->getCity(); ?>">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputBegin">Disponibility Begin</label>
                        <input type="datetime" class="form-control" id="inputBegin" name="dispo_begin" value="<?php echo $partner->getDisponibilityBegin(); ?>">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputEnd">Disponibility End</label>
                        <input type="datetime" class="form-control" id="inputEnd" name="dispo_end" value="<?php echo $partner->getDisponibilityEnd(); ?>">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputPricing">Pricing</label>
                        <input type="text" class="form-control" id="inputPricing" name="pricing" value="<?php echo $partner->getPricing(); ?>">
                      </div>
                      <div class="form-group">
                        <label for="rolesList">Job :</label>
                        <select class="form-control" name="role" id="rolesList">
                          <option value="<?php echo $partner->getRoleId(); ?>"><?php echo $partner->getRoleById($partner->getRoleId()); ?></option>
                        </select>
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
          <!-- End Modal -->
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
