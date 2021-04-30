<form class="form-horizontal" id="form_brand">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="bra_sk">Search Key <span class="required">*</span></label>
					<input type="text" class="form-control text-lowercase" id="bra_sk" name="bra_sk">
					<small id="error_bra_sk" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="bra_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control text-capitalize" id="bra_name" name="bra_name" placeholder="Enter name bra">
					<small id="error_bra_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="bra_desc">Description</label>
					<textarea class="form-control" id="bra_desc" name="bra_desc" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="bra_isactive">
					<label for="bra_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
