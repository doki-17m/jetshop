<form class="form-horizontal" id="form_greeting">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="gre_sk">Search Key <span class="required">*</span></label>
					<input type="text" class="form-control" id="gre_sk" name="gre_sk">
					<small id="error_gre_sk" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="gre_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="gre_name" name="gre_name" placeholder="Enter name greeting">
					<small id="error_gre_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="gre_desc">Description</label>
					<textarea class="form-control" id="gre_desc" name="gre_desc" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="gre_isactive">
					<label for="gre_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
