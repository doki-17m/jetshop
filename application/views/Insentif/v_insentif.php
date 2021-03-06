<div class="row">
	<div class="col-6">
		<div class="card card-outline card-info">
			<div class="card-header">
				<h3 class="card-title">Report Insentif</h3>
			</div>
			<div class="card-body">
				<form class="form-horizontal" action="<?= base_url('/insentif/export') ?>" id="form_insentif" method="POST">
					<div class="form-group row">
						<label for="ins_date" class="col-sm-3 col-form-label">Date Order</label>
						<div class="input-group col-sm-8">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="far fa-calendar-alt"></i>
								</span>
							</div>
							<input type="text" class="form-control float-right" name="ins_date" id="ins_date" value="<?= $date_range ?>">
							<!-- <small class="form-text text-danger">Pilih Tanggal Transaksi Order. Sesuai Waktu Penjualan.</small> -->
						</div>
					</div>
			</div>
			<div class="card-footer">
				<div class="float-right">
					<button type="submit" class="btn btn-primary rpt_export"><i class="fas fa-file-export"> Export</i></button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
