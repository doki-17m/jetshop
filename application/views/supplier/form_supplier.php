<form class="form-horizontal" id="form_supplier">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="sup_code">Supplier Code <span class="required">*</span></label>
					<input type="text" class="form-control" id="sup_code" name="sup_code">
					<small id="error_sup_code" class="form-text text-danger"></small>
				</div>
				<div class="form-group">
					<label for="sup_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="sup_name" name="sup_name" placeholder="Enter name">
					<small id="error_sup_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="sup_greeting">Greeting </label>
					<select class="form-control select2" id="sup_greeting" name="sup_greeting">
					</select>
				</div>
				<div class="form-group">
					<label for="sup_email">Email </label>
					<input type="text" class="form-control" id="sup_email" name="sup_email" placeholder="Enter email">
					<small id="error_sup_email" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="sup_phone">Phone <span class="required">*</span></label>
					<input type="text" class="form-control number" id="sup_phone" name="sup_phone" placeholder="Enter phone">
					<small id="error_sup_phone" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="sup_phone2">Phone 2 </label>
					<input type="text" class="form-control number" id="sup_phone2" name="sup_phone2">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="sup_address">Address <span class="required">*</span></label>
					<textarea class="form-control" id="sup_address" name="sup_address" rows="3"></textarea>
					<small id="error_sup_address" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="sup_desc">Comments </label>
					<textarea class="form-control" id="sup_desc" name="sup_desc" rows="3"></textarea>
				</div>
			</div>	
			<div class="col-md-12">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="sup_isactive">
					<label for="sup_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
