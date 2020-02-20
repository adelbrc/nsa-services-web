<?php
$interventions = Intervention::getAllInterventions();
?>
<div class="dataContainer">
  <h3 class="text-center">Interventions History</h3>
  <div class="row">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Partner ID</th>
            <th scope="col">Order ID</th>
            <th scope="col">Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($interventions as $key => $intervention): ?>
            <tr>
              <th scope="row"><?php echo $intervention->getID(); ?></th>
              <td><?php echo $intervention->getPID(); ?></td>
              <td><?php echo $intervention->getOID(); ?></td>
              <td><?php echo $intervention->getInterventionDate(); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
