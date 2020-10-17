<form class="form-horizontal" id="form_account">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="acc_bank">Bank <span class="required">*</span></label>
					<input type="text" class="form-control" id="acc_bank" name="acc_bank">
					<small id="error_acc_bank" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="acc_accountno">Account No <span class="required">*</span></label>
					<input type="text" class="form-control number" id="acc_accountno" name="acc_accountno" placeholder="Enter Account No">
					<small id="error_acc_accountno" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="acc_name">Name <span class="required">*</span></label>
					<input type="text" class="form-control" id="acc_name" name="acc_name">
					<small id="error_acc_name" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="acc_desc">Description</label>
					<textarea class="form-control" id="acc_desc" name="acc_desc" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input active" id="acc_isactive">
					<label for="acc_isactive" class="custom-control-label">Active</label>
				</div>
			</div>
		</div>
	</div>
</form>
