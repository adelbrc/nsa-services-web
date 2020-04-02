<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Creer Nouveau service
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="modalTitle">Service</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		<!-- avant que je modifie \|/ -->
		<!-- <form action="../../libs/php/controllers/newService.php" method="post"> -->
		<form action="../libs/php/controllers/newService.php" method="post">
		  <div class="form-row">
			<input type="hidden" name="pid" value="">
			<div class="form-group col-md-6">
			  <label for="inputName"><?php echo $nomService[$langue]; ?></label>
			  <input type="text" class="form-control" id="inputName" name="service_name" >
			</div>
			<div class="form-group col-md-6">
			  <label for="inputPrice"><?php echo $prix[$langue]; ?></label>
			  <input type="number" class="form-control" id="inputPrice" name="service_price">
			</div>
		  </div>
		  <div class="form-row">
			<div class="form-group col-md-6">
			  <label for="inputDiscountPrice"><?php echo $prixReduit[$langue]; ?></label>
			  <input type="number" class="form-control" id="inputDiscountPrice" name="inputDiscountPrice">
			</div>
			<div class="form-group col-md-6">
			  <div class="form-group">
				<label for="service_category"><?php echo $categorie[$langue]; ?></label>
				<select class="form-control" name="category" id="categoryList">
				  <?php $q = $conn->query('SELECT * FROM category');
						while($category = $q->fetch()){ ?>
				  <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
				<?php } ?>
				</select>
			  </div>
			</div>
		  </div>
		  <div class="form-row">
			<div class="form-group col-md-6">
			  <label for="inputDescription">Description</label>
			  <input type="text" class="form-control" id="inputDescription">
			</div>
		  </div>
		  <div class="form-group">
			<input type="submit" class="btn btn-success" value="Save">
		  </div>
		</form>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $close[$langue]; ?></button>
	  </div>
	</div>
  </div>
</div>
