<div class="sidebar">
	<!-- Sidebar user panel (optional) -->
	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
			<!-- <img src="<?php //echo base_url('assets/dist/img/user2-160x160.jpg') 
							?>" class="img-circle elevation-2" alt="User Image"> -->
		</div>
		<div class="info">

		</div>
	</div>

	<!-- Sidebar Menu -->
	<!-- has-treeview menu-open -->
	<!-- active -->
	<nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<li class="nav-item">
				<a href="<?php echo site_url() ?>" class="nav-link">
					<i class="nav-icon fas fa-home"></i>
					<p>Dashboard</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?php echo site_url('sales') ?>" class="nav-link">
					<i class="nav-icon fas fa-shopping-cart"></i>
					<p>Sales Order</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-exchange-alt"></i>
					<p>Transaction<i class="fas fa-angle-left right"></i></p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo site_url('sales/views') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Sales Order Detail</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('retur') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Return</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('expense') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Expense</p>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fab fa-product-hunt"></i>
					<p>Product Data<i class="fas fa-angle-left right"></i></p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo site_url('product') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Product</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('category') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Category</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('uom') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Unit of Measure</p>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-compass"></i>
					<p>Destination<i class="fas fa-angle-left right"></i></p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo site_url('city') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>City</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('province') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Province</p>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-laptop"></i>
					<p>Master Data<i class="fas fa-angle-left right"></i></p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo site_url('supplier') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Supplier</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('customer') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Customer</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('user') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>User</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('account') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Bank Account</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('courier') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Courier</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('job') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Job</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo site_url('greeting') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Greeting</p>
						</a>
					</li>
				</ul>
			</li>
			<!-- <li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-cogs"></i>
					<p>System Configurator<i class="fas fa-angle-left right"></i></p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo site_url('setting') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Setting</p>
						</a>
					</li>				
				</ul>
			</li>		 -->
		</ul>
	</nav>
	<!-- /.sidebar-menu -->
</div>
