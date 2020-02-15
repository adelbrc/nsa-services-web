<?php
$list = Order::getAllOrders();
?>

<div class="dataContainer">
  <h3 class="text-center">Orders List</h3>
  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Customer ID</th>
          <th scope="col">Order Date</th>
          <th scope="col">Quantity</th>
          <th scope="col">Service ID</th>
          <th scope="col">Payment Status</th>
          <th scope="col">Reservation Date</th>
          <th scope="col">Order Status</th>
          <th scope="col">Cancel</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($list as $key => $order): ?>
          <tr>
            <th scope="row"><?php echo $order->getOrderId(); ?></th>
            <td><?php echo $order->getCustomerId(); ?></td>
            <td><?php echo $order->getOrderDate(); ?></td>
            <td><?php echo $order->getNbHours(); ?></td>
            <td><?php echo $order->getServiceId(); ?></td>
            <td><?php echo $order->getPaymentStatus(); ?></td>
            <td><?php echo $order->getReservationDate(); ?></td>
            <td><?php echo $order->getOrderStatus(); ?></td>
            <td>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalCancel<?php echo $order->getOrderId(); ?>">
                <i class="fa fa-close"></i>
              </button>
            </td>
          </tr>
          <!-- Modale Delete Partner -->
          <?php include("../libs/php/includes/cancelOrderModal.php"); ?>
          <!-- End Modal -->
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
