<form class="form-horizontal" id="form_job">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="job_sk">Search Key <span class="required">*</span></label>
					<input type="text" class="form-control" id="job_sk" name="job_sk">
					<small id="error_job_sk" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="job_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="job_name" name="job_name" placeholder="Enter name job">
					<small id="error_job_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="job_desc">Description</label>
					<textarea class="form-control" id="job_desc" name="job_desc" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="job_isactive">
					<label for="job_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
