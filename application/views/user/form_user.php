<form class="form-horizontal" id="form_user">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_username">Username <span class="required">*</span></label>
					<input type="text" class="form-control" id="usr_username" name="usr_username">
					<small id="error_usr_username" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_greeting">Greeting </label>
					<select class="form-control select2" id="usr_greeting" name="usr_greeting">
					</select>
				</div>
			</div>			
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="usr_name" name="usr_name" placeholder="Enter name">
					<small id="error_usr_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group customcheck">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input active" id="usr_isactive">
						<label for="usr_isactive" class="custom-control-label">Active</label>
					</div>
				</div>			
			</div>
			<div class="col-md-2">
				<div class="form-group customcheck">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input salesrep" id="usr_issalesrep">
						<label for="usr_issalesrep" class="custom-control-label">Sales</label>
					</div>
				</div>			
			</div>
			<div class="col-md-12">
				<div class="form-group">				
					<label for="usr_desc">Description</label>
					<textarea class="form-control" id="usr_desc" name="usr_desc" rows="2"></textarea>
				</div>
			</div>			
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_email">Email </label>
					<input type="text" class="form-control" id="usr_email" name="usr_email" placeholder="Enter email">
					<small id="error_usr_email" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_password">Password <span class="required">*</span></label>
					<input type="password" class="form-control" id="usr_password" name="usr_password">
					<small id="error_usr_password" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_phone">Phone </label>
					<input type="text" class="form-control number" id="usr_phone" name="usr_phone" placeholder="Enter phone">
				</div>
			</div>			
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_phone2">Phone 2 </label>
					<input type="text" class="form-control number" id="usr_phone2" name="usr_phone2">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_job">Position </label>
					<select class="form-control select2" id="usr_job" name="usr_job">
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="usr_birthday">Birthday </label>
					<input type="date" class="form-control" id="usr_birthday" name="usr_birthday">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="usr_address">Address </label>
					<textarea class="form-control" id="usr_address" name="usr_address" rows="3"></textarea>
				</div>
			</div>
		</div>
	</div>
</form>
