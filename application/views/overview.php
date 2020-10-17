<?php isNotLogin(); ?>
<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('_partials/head') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">

		<!-- Navbar -->
		<?php $this->load->view('_partials/navbar') ?>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<?php $this->load->view('_partials/brand_logo') ?>
			<!-- Sidebar -->
			<?php $this->load->view('_partials/sidebar') ?>
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<?php $this->load->view('_partials/content_head') ?>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<?= $contents ?>
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<!-- Footer -->
		<?php $this->load->view('_partials/footer') ?>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- Modal -->
	<?php $this->load->view('_partials/modal') ?>
	<!-- JS -->
	<?php $this->load->view('_partials/js') ?>
</body>

</html>
