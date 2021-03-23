<form class="form-horizontal" id="form_checkout">
	<div class="row">
		<!-- left column -->
		<div class="col-md-7" id="detail_datacustomer">
			<!-- Input addon -->
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-laptop"> Data Customer</i></h3>
				</div>
				<div class="card-body">
					<form class="form-horizontal" id="form_checkout">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="pos_ismember" checked>
										<label for="pos_ismember" class="custom-control-label">Member</label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="pos_isurgent" checked>
										<label for="pos_isurgent" class="custom-control-label">Urgent</label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group" id="group_pos_cust_id">
									<label for="pos_cust_id">Customer <span class="required">*</span></label>
									<select class="form-control select2" id="pos_cust_id" name="pos_cust_id"></select>
									<small id="error_pos_cust_id" class="form-text text-danger"></small>
								</div>
								<div class="form-group" id="group_pos_cust_name">
									<label for="pos_cust_name">Customer <span class="required">*</span></label>
									<input type="text" class="form-control" id="pos_cust_name" name="pos_cust_name" placeholder="Enter customer name">
									<small id="error_pos_cust_name" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-md-6" id="group_pos_phone">
								<div class="form-group">
									<label for="pos_phone">Phone <span class="required">*</span></label>
									<input type="text" class="form-control number" id="pos_phone" name="pos_phone" placeholder="Enter phone">
									<small id="error_pos_phone" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group" id="group_pos_courier">
									<label for="pos_courier">Courier <span class="required">*</span></label>
									<select class="form-control select2" id="pos_courier" name="pos_courier"></select>
									<small id="error_pos_courier" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group" id="group_pos_total_weight">
									<label for="pos_total_weight">Total Weight (gram) </label>
									<div class="input-group">
										<input type="text" class="form-control number" id="pos_total_weight" name="pos_total_weight" readonly>
										<div class="input-group-append">
											<span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12" id="group_pos_city">
								<div class="form-group">
									<label for="pos_city">Destination <span class="required">*</span></label>
									<select class="form-control select2" id="pos_city" name="pos_city"></select>
									<small id="error_pos_city" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-md-12" id="group_pos_address">
								<div class="form-group">
									<label for="pos_address">Full Address <span class="required">*</span></label>
									<textarea class="form-control" id="pos_address" name="pos_address" rows="2"></textarea>
									<small id="error_pos_faddress" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-md-12" id="group_pos_delivery">
								<div class="form-group">
									<label for="pos_delivery">Delivery Service <span class="required">*</span></label>
									<select class="form-control select2" id="pos_delivery" name="pos_delivery"></select>
									<small id="error_pos_delivery" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-md-12" id="group_pos_job_market">
								<div class="form-group">
									<label for="pos_job_market">Job Marketplace </label>
									<input type="text" class="form-control" id="pos_job_market" name="pos_job_market" placeholder="Order from marketplace">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="pos_note">Note </label>
									<textarea class="form-control" id="pos_note" name="pos_note" rows="2"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!--/.col (left) -->

		<!-- right column -->
		<div class="col-md-5" id="detail_cart">
			<!-- general form elements disabled -->
			<div class="card card-warning">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-shopping-cart"> List Cart</i></h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<div class="row">
						<div class="table-responsive">
							<table id="list_cart" class="table">
							</table>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="pos_payment">Payment Method <span class="required">*</span></label>
								<select class="form-control select2" id="pos_payment" name="pos_payment">
									<option value="" selected></option>
									<option value="1">Cash</option>
									<option value="2">Transfer</option>
								</select>
								<small id="error_pos_payment" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-md-6" id="group_pos_bankacc">
							<div class="form-group">
								<label for="pos_bankacc">Bank Account <span class="required">*</span></label>
								<select class="form-control select2" id="pos_bankacc" name="pos_bankacc"></select>
								<small id="error_pos_bankacc" class="form-text text-danger"></small>
							</div>
						</div>
					</div>
					<div class="card-header">
						<div class="float-right">
							<button type="button" class="btn btn-outline-primary" id="btn_print"><i class="fas fa-print"></i> Print</button>
							<button type="button" class="btn btn-primary" id="btn_pos"><i class="far fa-save"></i> Save</button>
							<button type="button" class="btn btn-danger" id="btn_close_pos"><i class="fas fa-times"></i> Close</button>
						</div>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!--/.col (right) -->
	</div>
	<!-- /.row -->
</form>
