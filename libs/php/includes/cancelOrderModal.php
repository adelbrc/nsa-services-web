<div class="modal fade" id="modalCancel<?php echo $order->getOrderId(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitle<?php echo $order->getOrderId(); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle<?php echo $order->getOrderId(); ?>">Cancel Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Do you really want to cancel this order ?</p>
        <p><?php echo "Order ID: " . $order->getOrderId(); ?></p>
        <p><?php echo "Customer ID: " . $order->getCustomerId(); ?></p>
        <p><?php echo "Service ID: " . $order->getServiceId(); ?></p>
        <p><?php echo "Date: " . $order->getOrderDate(); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a type="button" href="../libs/php/controllers/cancelOrder.php?oid=<?php echo $order->getOrderId(); ?>" class="btn btn-danger">Cancel</a>
      </div>
    </div>
  </div>
</div>
