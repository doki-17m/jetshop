<form class="form-horizontal" id="form_checkout">
	<div class="row">
		<!-- left column -->
		<div class="col-md-8" id="detail_datacustomer">
			<!-- Input addon -->
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-laptop"> Data Customer</i></h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="pos_ismember" checked>
									<label for="pos_ismember" class="custom-control-label">Member</label>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" id="pos_cust_id">
								<label for="pos_cust_id">Customer <span class="required">*</span></label>
								<select class="form-control select2" id="pos_cust_id" name="pos_cust_id"></select>
								<small id="error_pos_cust_id" class="form-text text-danger"></small>
							</div>
							<div class="form-group" id="pos_cust_name">
								<label for="pos_cust_name">Customer <span class="required">*</span></label>
								<input type="text" class="form-control" id="pos_cust_name" name="pos_cust_name" placeholder="Enter customer name">
								<small id="error_pos_cust_name" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="pos_phone">Phone <span class="required">*</span></label>
								<input type="text" class="form-control number" id="pos_phone" name="pos_phone" placeholder="Enter phone">
								<small id="error_pos_phone" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="pos_courier">Courier <span class="required">*</span></label>
								<select class="form-control select2" id="pos_courier" name="pos_courier"></select>
								<small id="error_pos_courier" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="pos_total_weight">Total Weight (gram) </label>
								<div class="input-group">
									<input type="text" class="form-control number" id="pos_total_weight" name="pos_total_weight" readonly>
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" id="pos_province">
								<label for="pos_province">Province <span class="required">*</span></label>
								<select class="form-control select2" id="pos_province" name="pos_province"></select>
								<small id="error_pos_province" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" id="pos_city">
								<label for="pos_city">City <span class="required">*</span></label>
								<select class="form-control select2" id="pos_city" name="pos_city"></select>
								<small id="error_pos_city" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group" id="pos_address">
								<label for="pos_address">Full Address <span class="required">*</span></label>
								<textarea class="form-control" id="pos_address" name="pos_address" rows="2"></textarea>
								<small id="error_pos_faddress" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group" id="pos_delivery">
								<label for="pos_delivery">Delivery Service <span class="required">*</span></label>
								<select class="form-control select2" id="pos_delivery" name="pos_delivery"></select>
								<small id="error_pos_delivery" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group" id="pos_job_market">
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
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!--/.col (left) -->
		<!-- right column -->
		<div class="col-md-4" id="detail_cart">
			<!-- general form elements disabled -->
			<div class="card card-warning">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-shopping-cart"> List Cart</i></h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<ul class="list-group list-group-unbordered mb-3" id="detail_cart_list">
						<!-- <li class="list-group-item">
							<a class="sku"><b>Following</b> x 1</a> <a class="float-right subtotal">543</a>
						</li>
						<li class="list-group-item">
							<p style="text-align: center">Subtotal: <a class="float-right">Test</a></p>
						</li>
						<li class="list-group-item">
							<p style="text-align: center">Ongkos Kirim: <a class="float-right">Test</a></p>
						</li>
						<li class="list-group-item">
							<p style="text-align: center">Grand Total: <a class="float-right">Test</a></p>
						</li> -->
					</ul>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!--/.col (right) -->
	</div>
	<!-- /.row -->
</form>
