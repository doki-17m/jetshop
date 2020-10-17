<form class="form-horizontal" id="form_courier">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="cou_code">Courier Code <span class="required">*</span></label>
					<input type="text" class="form-control" id="cou_code" name="cou_code">
					<small id="error_cou_code" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="cou_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="cou_name" name="cou_name" placeholder="Enter name courier">
					<small id="error_cou_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="cou_desc">Description</label>
					<textarea class="form-control" id="cou_desc" name="cou_desc" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="cou_isactive">
					<label for="cou_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
