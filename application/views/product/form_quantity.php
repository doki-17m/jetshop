<form class="form-horizontal" id="form_quantity">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-2">
				<div class="form-group">
					<div class="custom-control custom-radio">
						<input class="custom-control-input" type="radio" id="qty_in" name="customRadio">
						<label for="qty_in" class="custom-control-label">In</label>
					</div>
				</div>
			</div>
			<div class="col-sm-10">
				<div class="form-group">
					<div class="custom-control custom-radio">
						<input class="custom-control-input" type="radio" id="qty_out" name="customRadio">
						<label for="qty_out" class="custom-control-label">Out</label>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="qty_available">Quantity Available </label>
					<input type="text" class="form-control number" id="qty_available" name="qty_available">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="qty_entered">Quantity<span class="required">*</span></label>
					<input type="text" class="form-control number" id="qty_entered" name="qty_entered" placeholder="Enter quantity">
					<small id="error_qty_entered" class="form-text text-danger"></small>
				</div>
			</div>
		</div>
	</div>
</form>
