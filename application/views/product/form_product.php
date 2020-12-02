<form class="form-horizontal" id="form_product">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_code">Code Product <span class="required">*</span></label>
					<input type="text" class="form-control" id="pro_code" name="pro_code" placeholder="Enter code product">
					<small id="error_pro_code" class="form-text text-danger"></small>
				</div>
				<div class="form-group">
					<label for="pro_name">Brand Product <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" id="pro_name" name="pro_name" placeholder="Enter merk product">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-tshirt"></i></span>
						</div>
					</div>
					<small id="error_pro_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Image Product</label>
					<div id="form-upload-result">
						<label class="form-result col-md-6">
							<button type="button" class="close-img" id="btn_delimg" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</label>
					</div>
					<div id="form-upload">
						<label class="form-upload-foto col-md-6">
							<input type="file" id="pro_image" name="pro_image" accept="image/jpeg, image/png"></input>
							<img class="img-upload" src="<?= base_url('assets/dist/img/cameraroll.png') ?>" />
						</label>
						<small class="form-upload-text text-muted">
							Tipe file (JPG, PNG), Maksimal ukuran file adalah <strong> 5 Mb</strong>
						</small>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_desc">Description</label>
					<textarea class="form-control" id="pro_desc" name="pro_desc" rows="2"></textarea>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group customcheck">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input active" id="pro_isactive">
						<label for="pro_isactive" class="custom-control-label">Active</label>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group customcheck">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input obral" id="pro_isobral">
						<label for="pro_isobral" class="custom-control-label">Obral</label>
					</div>
				</div>
			</div>
			<div class="col-md-6" id="group_pro_qty">
				<div class="form-group">
					<label for="pro_qty">Quantity <span class="required">*</span></label>
					<input type="text" class="form-control number" id="pro_qty" name="pro_qty">
					<small id="error_pro_qty" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_uom">UOM</label>
					<select class="form-control select2" id="pro_uom" name="pro_uom"></select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_catg">Product Category <span class="required">*</span></label>
					<select class="form-control select2" id="pro_catg" name="pro_catg"></select>
					<small id="error_pro_catg" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6" id="group_pro_minorder">
				<div class="form-group">
					<label for="pro_minorder">Minimum Order</label>
					<input type="number" class="form-control number" id="pro_minorder" name="pro_minorder" value="1" placeholder="Enter minimal order">
					<small id="error_pro_minorder" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_weight">Weight (gram) <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control number" id="pro_weight" name="pro_weight">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
						</div>
					</div>
					<small id="msg_pro_weight" class="form-text text-muted">
						Satuan <strong>gram</strong>, berat 1 kg: <strong>1000 gram</strong>
					</small>
					<small id="error_pro_weight" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_purchidr">Purchase <span class="required">*</span></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">IDR</span>
						</div>
						<input type="text" class="form-control rupiah" id="pro_purchidr" name="pro_purchidr">
					</div>
					<small id="error_pro_purchidr" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_slsidr">Sales <span class="required">*</span></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">IDR</span>
						</div>
						<input type="text" class="form-control rupiah" id="pro_slsidr" name="pro_slsidr">
					</div>
					<small id="error_pro_slsidr" class="form-text text-danger"></small>
				</div>
			</div>
		</div>
	</div>
</form>