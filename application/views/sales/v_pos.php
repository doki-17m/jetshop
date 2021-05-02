<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title"><i class="far fa-file-alt"></i> Information</h3>
				</div>
				<div class="card-body box-profile">
					<div class="form-group row">
						<label for="pos_date" class="col-sm-3 col-form-label">Date</label>
						<div class="col-sm-9">
							<input type="date" class="form-control" id="pos_date" name="pos_date" value="<?= date('Y-m-d') ?>" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="pos_cashier" class="col-sm-3 col-form-label">Cashier</label>
						<div class="col-sm-9">
							<input type="hidden" class="form-control" id="pos_cashier_id" name="pos_cashier_id" value="<?php if ($cashier->m_job_id == 1) {
																															echo $cashier->sys_user_id;
																														} ?>" readonly>
							<input type="text" class="form-control" id="pos_cashier" name="pos_cashier" value="<?php if ($cashier->m_job_id == 1) {
																													echo $cashier->name;
																												} ?>" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="card card-primary card-outline">
				<div class="card-body">
					<div class="form-group row">
						<label for="pos_barcode" class="col-sm-2 col-form-label">Product Code</label>
						<div class="col-sm-10">
							<div class="input-group">
								<input type="text" class="form-control barcode" id="pos_barcode" name="pos_barcode" placeholder="Input Product Code / Scan Barcode" autofocus>
								<div class="input-group-append">
									<button type="button" class="btn btn-primary">
										<span class="fas fa-search"></span>
									</button>
								</div>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table id="tb_sales_pos" class="table table-bordered table-hover tb_pos table-md" style="width: 100%">
							<thead>
								<tr>
									<th>#ID Product</th>
									<th>#LQty</th>
									<th>#</th>
									<th>Product Code</th>
									<th width="130px">Qty</th>
									<th>Price</th>
									<th>Subtotal</th>
									<th width="10px">Action</th>
								</tr>
							</thead>
						</table>
					</div>

					<div class="alert alert-info alert-dismissible mt-4 p-3">
						<button class='btn btn-default btn-md' id="btn_focus"><i class='fa fa-search'></i> Focus (F8)</button>
						<h2 class="float-right">Total : Rp. <span class="grandtotal"></span></h2>
					</div>
					<div class="row">
						<div class="col-md-8">
							<p><i class="far fa-keyboard"></i> <b>Shortcut Keyboard : </b></p>
							<div class="row">
								<div class='col-sm-6'>F8 = Focus Product Code</div>
								<div class='col-sm-6'>F10 = Submit Cart</div>
								<div class='col-sm-6'>F9 = Refresh Cart</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="row float-right p-2">
								<button type="button" class="btn btn-danger mr-1" id="btn_refresh" title="Reset Cart">
									<i class="fas fa-sync-alt"></i> Refresh (F9)
								</button>
								<button type="button" class="btn btn-success" id="btn_checkout" title="Checkout">
									<i class="fas fa-cart-plus"></i> Submit (F10)
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
