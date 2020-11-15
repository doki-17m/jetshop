<form class="form-horizontal" id="form_so">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="so_orderno">Order No</label>
					<input type="text" class="form-control" id="so_orderno" name="so_orderno">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="so_cusname">Customer</label>
					<input type="text" class="form-control" id="so_cusname" name="so_cusname" placeholder="Enter customer">
				</div>
			</div>
			<!-- <div class="col-md-12">
				<div class="form-group">
					<label for="pro_desc">Description</label>
					<textarea class="form-control" id="pro_desc" name="pro_desc" rows="2"></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_catg">Product Category</label>
					<select class="form-control select2" style="width: 100%;" id="pro_catg" name="pro_catg">
						<option selected="selected" value="1">Baju</option>
						<option value="2">Lain-Lain</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_uom">UOM</label>
					<select class="form-control select2" style="width: 100%;" id="pro_uom" name="pro_uom">
						<option selected="selected" value="pcs">Pcs</option>
						<option value="pk">Pack</option>
						<option value="ea">Each</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="pro_purchidr">Purchase IDR</label>
					<input type="number" class="form-control" id="pro_purchidr" name="pro_purchidr">
				</div>
			</div> -->
			<div class="col-md-6">
				<div class="form-group">
					<label for="so_qty">Quantity</label>
					<input type="number" class="form-control" id="so_qty" name="so_qty">
				</div>
				<!-- <div class="custom-control custom-checkbox">
					<input class="custom-control-input" type="checkbox" id="pro_isactive" name="pro_isactive">
					<label for="pro_isactive" class="custom-control-label">Active</label>
				</div> -->
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="so_pricelist">List Price</label>
					<input type="number" class="form-control" id="so_pricelist" name="so_pricelist">
				</div>
			</div>
			<div class="col-md-12">
				<div class="float-right">
					<button type="button" class="btn btn-block bg-gradient-primary btn-sm" id="new_details"><i class="fas fa-plus-circle"></i></button>
				</div>
			</div>
			<div class="col-md-12 table-responsive">
				<table id="tb_salesdetail" class="table table-bordered table-hover" style="cursor:pointer; width: 100%">
					<thead>
						<tr>
							<!-- <th>ID</th> -->
							<th>Product</th>
							<th width="12%">Qty</th>
							<th>Price List</th>
							<th width="5%">Action</th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</form>
