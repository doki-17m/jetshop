<form class="form-horizontal" id="form_product">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_code">Code Product</label>
					<input type="text" class="form-control" id="pro_code" name="pro_code" placeholder="Enter code product">
				</div>
				<div class="form-group">
					<label for="pro_name">Brand Product</label>
					<div class="input-group">
						<input type="text" class="form-control" id="pro_name" name="pro_name" placeholder="Enter merk product">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-tshirt"></i></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Image Product</label>
					<div id="form-upload-result">
						<!-- <label class="form-result col-md-6">
							<button type="button" class="close-img" id="btn_delimg" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<img class="img1"src="<?= base_url('assets/cust/images/download.jpg') ?>"/>
						</label> -->
						<label class="form-result col-md-6">
							<button type="button" class="close-img" id="btn_delimg" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</label>

					</div>
					<div id="form-upload">
						<label class="form-uploadfoto col-md-6">
							<input type="file" id="pro_image" name="pro_image"></input>
							<img class="img2" src="<?= base_url('assets/dist/img/cameraroll.png') ?>" />
						</label>
						<small class="form-upload-text text-muted">
							Tipe file (JPG, PNG), Maksimal ukuran file adalah <strong> 1Mb</strong>
						</small>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="pro_desc">Description</label>
					<textarea class="form-control" id="pro_desc" name="pro_desc" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_catg">Product Category</label>
					<select class="form-control select2" style="width: 100%;" id="pro_catg" name="pro_catg">
						<option selected="selected" value="1">Baju</option>
						<option value="2">Lain-Lain</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_weight">Weight (gram)</label>
					<div class="input-group">
						<input type="number" class="form-control" id="pro_weight" name="pro_weight">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
						</div>
					</div>
					<small class="form-text text-muted">
						Satuan <strong>gram</strong>, berat 1 kg: <strong>1000 gram</strong>
					</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_minorder">Minimum Order</label>
					<input type="number" class="form-control" id="pro_minorder" name="pro_minorder" placeholder="Enter minimal order">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_uom">UOM</label>
					<select class="form-control select2" style="width: 100%;" id="pro_uom" name="pro_uom">
						<option selected="selected" value="pcs">Pcs</option>
						<option value="pk">Pack</option>
						<option value="ea">Each</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_purchidr">Purchase</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">IDR</span>
						</div>
						<input type="number" class="form-control" id="pro_purchidr" name="pro_purchidr">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_slsidr">Sales</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">IDR</span>
						</div>
						<input type="number" class="form-control" id="pro_slsidr" name="pro_slsidr">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="pro_isactive">
					<label for="pro_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
