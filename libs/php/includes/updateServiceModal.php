<div class="modal fade" id="modalUpdate<?php echo $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitle<?php echo $result['id']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle<?php echo $result['id']; ?>">Edit Service Infos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../libs/php/controllers/admin_updateServiceInfo.php" method="post">
          <div class="form-row">
            <input type="hidden" name="pid" value="<?php echo $result['id']; ?>">
            <div class="form-group col-md-6">
              <label for="inputCorpName">Nom du service</label>
              <input type="text" class="form-control" id="inputname" name="inputname" value="<?php echo $result['name']; ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="inputCorpId">Prix </label>
              <input type="text" class="form-control" id="inputLname" name="inputPrice" value="<?php echo $result['price']; ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputLname">Prix promo</label>
              <input type="text" class="form-control" id="inputDPrice" name="inputDPrice" value="<?php echo $result['discountPrice']; ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="rolesList">Job :</label>
              <select class="form-control" name="category" id="categoryList">
                <?php
                  $dq = $conn->query('SELECT * FROM category');
                  while($category = $dq->fetch()){
                ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              </select>
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
</div>
