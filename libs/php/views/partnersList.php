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
          <th scope="col">Delete</th>
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
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUpdate<?php echo $partner->getPID(); ?>">
                <i class="fa fa-cog"></i>
              </button>
            </td>
            <td>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete<?php echo $partner->getPID(); ?>">
                <i class="fa fa-close"></i>
              </button>
            </td>
          </tr>

          <!-- Modal Update Partner -->
          <?php include("../libs/php/includes/updatePartnerModal.php"); ?>
          <!-- End Modal -->

          <!-- Modale Delete Partner -->
          <?php include("../libs/php/includes/deletePartnerModal.php"); ?>
          <!-- End Modal -->
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
