<form class="form-horizontal" id="form_category">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="cat_sk">Search Key <span class="required">*</span></label>
					<input type="text" class="form-control" id="cat_sk" name="cat_sk">
					<small id="error_cat_sk" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="cat_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Enter name category">
					<small id="error_cat_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="cat_desc">Description</label>
					<textarea class="form-control" id="cat_desc" name="cat_desc" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="cat_isactive">
					<label for="cat_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
