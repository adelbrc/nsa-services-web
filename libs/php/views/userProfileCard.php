<div class="dataContainer">
  <div class="row">
    <img class="profilePicture" src="<?php echo str_replace("../../../", "", $user->getProfilePic()); ?>">
  </div>
  <div class="row">
    <div class="col-6">
      <p class="text-center">Nom : <?php echo $user->getLastname(); ?></p>
    </div>
    <div class="col-6">
      <p class="text-center">Prénom : <?php echo $user->getFirstname(); ?></p>
    </div>
  </div>
</div>
