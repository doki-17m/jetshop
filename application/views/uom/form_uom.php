<form class="form-horizontal" id="form_uom">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="uom_code">UOM Code <span class="required">*</span></label>
					<input type="text" class="form-control" id="uom_code" name="uom_code">
					<small id="error_uom_code" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="uom_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="uom_name" name="uom_name" placeholder="Enter name uom">
					<small id="error_uom_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="uom_desc">Description</label>
					<textarea class="form-control" id="uom_desc" name="uom_desc" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="uom_isactive">
					<label for="uom_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
