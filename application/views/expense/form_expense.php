<form class="form-horizontal" id="form_expense">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exp_documentno">Document No </label>
					<input type="text" class="form-control" id="exp_documentno" name="exp_documentno">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="exp_date">Date Report <span class="required">*</span></label>
					<input type="date" class="form-control" id="exp_date" name="exp_date" value="<?= date('Y-m-d') ?>">
					<small id="error_exp_date" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="exp_desc">Note</label>
					<textarea class="form-control" id="exp_desc" name="exp_desc" rows="2"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="exp_payment">Payment Method <span class="required">*</span></label>
					<select class="form-control select2" id="exp_payment" name="exp_payment">
						<option value="" selected></option>
						<option value="1">Cash</option>
						<option value="2">Transfer</option>
					</select>
					<small id="error_exp_payment" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-6" id="group_exp_bankacc">
				<div class="form-group">
					<label for="exp_bankacc">Bank Account <span class="required">*</span></label>
					<select class="form-control select2" id="exp_bankacc" name="exp_bankacc"></select>
					<small id="error_exp_bankacc" class="form-text text-danger"></small>
				</div>
			</div>
			<div class="col-md-12">
				<div class="float-right">
					<button type="button" class="btn btn-block bg-gradient-primary btn-sm" id="new_expenseline"><i class="fas fa-plus-circle"> New Item</i></button>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12" style="margin-top:20px;">
				<div class="table-responsive">
					<table id="tb_expenseline" class="table table-bordered table-hover table-pointer" style="width: 100%;">
						<thead>
							<tr>
								<th width="350px">Description</th>
								<th width="100px">Qty</th>
								<th width="200px">Price</th>
								<th width="10px">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</form>
