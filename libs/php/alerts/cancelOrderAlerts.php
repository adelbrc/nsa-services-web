<?php if (isset($_GET["error"]) && $_GET["error"] == "dont_try_this"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Stop !</strong> You should not try this.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "dont_even_try_this"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Stop !</strong> We are watching you.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "oid"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid Order ID!</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "already_canceled"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error :</strong> This order has already been canceled.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["c"]) && $_GET["c"] == "success"): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success !</strong> This order has been canceled.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>
