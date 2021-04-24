<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-6">
				<div class="small-box bg-success">
					<div class="inner">
						<p>Penjualan Hari ini</p>
						<h4><?= 'Rp. ' . formatRupiah($omset->total_omzet); ?></h4>
					</div>
					<div class="icon">
						<i class="ion ion-calculator"></i>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-info">
					<div class="inner">
						<p>Transaksi Hari ini</p>
						<h4><?= $transaksi->num_rows(); ?></h4>
					</div>
					<div class="icon">
						<i class="ion ion-bag"></i>
					</div>
				</div>
			</div>
			<!-- <div class="col-lg-3 col-6">
				<div class="small-box bg-secondary">
					<div class="inner">
						<p>Retur Hari ini</p>
						<h3>150</h3>
					</div>
					<div class="icon">
						<i class="ion ion-arrow-return-left"></i>
					</div>
				</div>
			</div> -->
			<div class="col-lg-3 col-6">
				<div class="small-box bg-default">
					<div class="inner">
						<p>Produk</p>
						<h4><?= $product->num_rows(); ?></h4>
					</div>
					<div class="icon">
						<i class="ion ion-tshirt-outline"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
