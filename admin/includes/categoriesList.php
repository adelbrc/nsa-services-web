<div class="tab-content" id="userTab">
  <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list">
    <div class="dataContainer">
      <h3 class="text-center">Categories List</h3>
      <div class="row">
        <?php include('includes/newCategoriesModal.php'); ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php $q = $conn->query('SELECT * FROM category');
                    while($result = $q->fetch()){ ?>
                <tr>
                  <th scope="row"><?php echo $result['id']; ?></th>
                  <td><?php echo $result['name']; ?></td>
                  <td>
                    <button type="button" onclick="supprimerCategorie(<?php echo $result['id']; ?>)"  id="deleteSub" class="btn btn-danger">
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
