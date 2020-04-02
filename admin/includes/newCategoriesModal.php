<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoryModal">
  <?php echo $creenvlleCategorie[$langue]; ?>
</button>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"><?php echo $nvlleCategorie[$langue]; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../libs/php/controllers/newCategory.php" method="post">
          <div class="form-row">
            <input type="hidden" name="pid" value="">
            <div class="form-group col-md-6 mx-auto">
              <label for="inputName"><?php echo $name[$langue]; ?></label>
              <input type="text" class="form-control" id="inputName" name="category_name" >
            </div>
            <div class="form-group col-md-6 mx-auto">
              <label for="inputReduc"><?php echo $nbAvantReduc[$langue]; ?></label>
              <input type="number" class="form-control" id="inputReduc" name="inputReduc" >
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
