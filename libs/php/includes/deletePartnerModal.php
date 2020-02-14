<div class="modal fade" id="modalDelete<?php echo $partner->getPID(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitle<?php echo $partner->getPID(); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle<?php echo $partner->getPID(); ?>">Delete Partner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete the partner ?</p>
        <p><?php echo "UID: " . $partner->getPID(); ?></p>
        <p><?php echo "Lastname: " . $partner->getLastName(); ?></p>
        <p><?php echo "Firstname: " . $partner->getFirstname(); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a type="button" href="../libs/php/controllers/deletePartner.php?pid=<?php echo $partner->getPID(); ?>" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
