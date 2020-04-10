<div class="tab-content" id="userTab">
  <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list">
    <div class="dataContainer">
      <h3 class="text-center">Categories/Roles List</h3>
      <?php if (isset($_GET['statusCat']) && $_GET['statusCat'] == 'field_blank') { ?>
        <div class="alert text-center alert-danger" role="alert">
          Tous les champs doivent être complétés !
        </div>
      <?php } ?>
      <div class="row">
        <?php include('includes/newCategoriesModal.php'); ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col"><?php echo $name[$langue]; ?></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php $q = $conn->query('SELECT * FROM category');
                    while($category = $q->fetch()){ ?>
                <tr>
                  <th scope="row"><?php echo $category['id']; ?></th>
                  <td><?php echo $category['name']; ?></td>
                  <td>
                    <button type="button" onclick="supprimerCategorie(<?php echo $category['id']; ?>)"  id="deleteSub" class="btn btn-danger">
                      <i class="fa fa-close"></i>
                    </button>
                  </td>
                </tr>
                <?php include("../libs/php/includes/updateServiceModal.php"); ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
