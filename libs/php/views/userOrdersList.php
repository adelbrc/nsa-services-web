<?php
$list = Order::getUserOrders($user->getUID());
?>

<div class="dataContainer">
  <h3 class="text-center">Orders History</h3>
  <div class="row">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Order Date</th>
            <th scope="col">Quantity</th>
            <th scope="col">Service ID</th>
            <th scope="col">Payment Status</th>
            <th scope="col">Reservation Date</th>
            <th scope="col">Order Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($list as $key => $order): ?>
            <tr>
              <th scope="row"><?php echo $order->getOrderId(); ?></th>
              <td><?php echo $order->getOrderDate(); ?></td>
              <td><?php echo $order->getNbHours() . "h"; ?></td>
              <td><?php echo $order->getServiceId(); ?></td>
              <td><?php echo $order->getPaymentStatus(); ?></td>
              <td><?php echo $order->getReservationDate(); ?></td>
              <td>
                <?php if ($order->getOrderStatus() == 0): ?>
                  <?php echo "Pending"; ?>
                <?php endif; ?>
                <?php if ($order->getOrderStatus() == 1): ?>
                  <?php echo "Confirmed"; ?>
                <?php endif; ?>
                <?php if ($order->getOrderStatus() == 2): ?>
                  <?php echo "Canceled"; ?>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
