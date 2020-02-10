<div class="profileCard">
  <h1 class="text-center">Informations</h1>
  <form action="libs/php/controllers/updateUserInfos.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf-token" value="">
    <img class="profilePicture" src="<?php echo $user->getProfilePic(); ?>" alt="">
    <div class="form-group">
      <input type="file" style="display:block;margin:auto;margin-bottom:60px" name="profile_pic" />
    </div>
    <div class="form-row">
      <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <label for="emailID">Adresse Email</label>
        <input type="email" class="form-control" id="emailID" name="email" aria-describedby="emailHelp" value="<?php echo $user->getEmail(); ?>">
      </div>
      <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <label for="passID">Nouveau mot de passe</label>
        <input type="password" class="form-control" id="passID" name="pass" placeholder="Saisir le nouveau mot de passe">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <label for="phoneID">Phone</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="phone">+33</span>
          </div>
          <input type="text" class="form-control" id="phoneID" name="phone" value="<?php echo $user->getPhoneNumber(); ?>" aria-label="Phone" aria-describedby="phone">
        </div>
      </div>
      <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <label for="addrID">Address</label>
        <input class="form-control" id="addrID" type="text" name="address" value="<?php echo $user->getAddress(); ?>">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <label for="cityID">City</label>
        <input class="form-control" id="cityID" type="text" name="city" value="<?php echo $user->getCity(); ?>">
      </div>
    </div>
    <div class="form-group">
      <button type="submit" name="submit" class="btn btn-success">Update</button>
    </div>
  </form>
</div>
