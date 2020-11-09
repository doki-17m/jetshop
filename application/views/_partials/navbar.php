<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fas fa-cogs"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<!-- <a href="#" class="dropdown-item">
					<i class="fas fa-user"></i> Profile
				</a> -->
				<a href="javascript:void(0)" onclick="changePass(<?= $this->session->userdata('user_id') ?>)" class="dropdown-item">
					<i class="fas fa-cog"></i> Change Password
				</a>
				<a href="<?php echo site_url('auth/logout') ?>" class="dropdown-item">
					<i class="fas fa-sign-out-alt"></i> Log Out
				</a>
			</div>
		</li>
	</ul>
</nav>
<!-- /.navbar -->
