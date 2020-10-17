<form class="form-horizontal" id="form_customer">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="cus_code">Customer Code <span class="required">*</span></label>
					<input type="text" class="form-control" id="cus_code" name="cus_code">
					<small id="error_cus_code" class="form-text text-danger"></small>
				</div>
				<div class="form-group">
					<label for="cus_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="cus_name" name="cus_name" placeholder="Enter name">
					<small id="error_cus_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="cus_greeting">Greeting </label>
					<select class="form-control select2" id="cus_greeting" name="cus_greeting">
					</select>
				</div>
				<div class="form-group">
					<label for="cus_email">Email </label>
					<input type="text" class="form-control" id="cus_email" name="cus_email" placeholder="Enter email">
					<small id="error_cus_email" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="cus_phone">Phone <span class="required">*</span></label>
					<input type="text" class="form-control number" id="cus_phone" name="cus_phone" placeholder="Enter phone">
					<small id="error_cus_phone" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="cus_phone2">Phone 2 </label>
					<input type="text" class="form-control number" id="cus_phone2" name="cus_phone2">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="cus_province">Province <span class="required">*</span></label>
					<select class="form-control select2" id="cus_province" name="cus_province">
					</select>
					<small id="error_cus_province" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="cus_city">City <span class="required">*</span></label>
					<select class="form-control select2 is-invalid" id="cus_city" name="cus_city">
					</select>
					<small id="error_cus_city" class="form-text text-danger"></small>
				</div>
				<input type="hidden" class="form-control" id="hidden_city" name="hidden_city">
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="cus_address">Address <span class="required">*</span></label>
					<textarea class="form-control" id="cus_address" name="cus_address" rows="3"></textarea>
					<small id="error_cus_address" class="form-text text-danger"></small>
				</div>
			</div>	
			<div class="col-md-6">
				<div class="form-group">
					<label for="cus_sales">Sales </label>
					<select class="form-control select2" id="cus_sales" name="cus_sales">
					</select>
				</div>
			</div>
			<div class="col-md-6 cus_firstsale">
				<div class="form-group">
					<label for="cus_firstsale">First Sale </label>
					<input type="text" class="form-control" id="cus_firstsale" name="cus_firstsale">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="cus_desc">Comments </label>
					<textarea class="form-control" id="cus_desc" name="cus_desc" rows="3"></textarea>
				</div>
			</div>	
			<div class="col-md-12">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="cus_isactive">
					<label for="cus_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
