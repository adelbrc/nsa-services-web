<?php if (isset($_GET["error"]) && $_GET["error"] == "corp_name_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid corporation name !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "corp_id_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid corporation ID !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "email_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid email format !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "email_taken"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error :</strong> This email is already in our database.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "phone_number_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid phone number !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "phone_number_length"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error :</strong> This phone number is too long.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "address_length"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error :</strong> This address is too long.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "city_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid city format !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "city_length"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error :</strong> This city's name is too long.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "date_begin_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid date format !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "date_end_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid date format !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "pricing_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid pricing format !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["error"]) && $_GET["error"] == "role_format"): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Invalid role format !</strong> Try something else.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($_GET["update"]) && $_GET["update"] == "success"): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success !</strong> The partner's informations have been correctly updated.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>
