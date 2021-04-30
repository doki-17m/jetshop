<div class="sidebar">
	<!-- Sidebar user panel (optional) -->
	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
			<img src="<?= base_url('assets/dist/img/icon-user.png')
						?>" class="img-circle elevation-2" alt="User Image">
		</div>
		<div class="info">
			<a href="#" class="d-block"><?= ucwords($username->name) ?></a>
		</div>
	</div>

	<!-- Sidebar Menu -->
	<!-- has-treeview menu-open -->
	<!-- active -->
	<nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<li class="nav-item">
				<a href="<?php echo site_url() ?>" class="nav-link <?php if ($this->uri->segment(1) == '') {
																		echo "active";
																	} ?>">
					<i class="nav-icon fas fa-home"></i>
					<p>Dashboard</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?php echo site_url('sales') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'sales' && $this->uri->segment(2) == '') {
																				echo "active";
																			} ?>">
					<i class="nav-icon fas fa-shopping-cart"></i>
					<p>Sales Order</p>
				</a>
			</li>
			<?php if ($this->uri->segment(1) == 'expense' || $this->uri->segment(2) == 'viewSo') { ?>
				<li class="nav-item has-treeview menu-open">
					<a href="#" class="nav-link active">
						<i class="nav-icon fas fa-exchange-alt"></i>
						<p>Transaction<i class="fas fa-angle-left right"></i></p>
					</a>
				<?php } else { ?>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-exchange-alt"></i>
						<p>Transaction<i class="fas fa-angle-left right"></i></p>
					</a>
				<?php } ?>

				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo site_url('sales/viewSo') ?>" class="nav-link <?php if ($this->uri->segment(2) == 'viewSo') {
																								echo "active";
																							} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Sales Order Details</p>
						</a>
					</li>
					<!-- <li class="nav-item">
						<a href="<?php echo site_url('retur') ?>" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Return</p>
						</a>
					</li> -->
					<li class="nav-item">
						<a href="<?php echo site_url('expense') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'expense') {
																						echo "active";
																					} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Expense</p>
						</a>
					</li>
				</ul>
				</li>
				<?php if ($this->uri->segment(1) == 'insentif' || $this->uri->segment(1) == 'keuntungan') { ?>
					<li class="nav-item has-treeview menu-open">
						<a href="#" class="nav-link active">
							<i class="nav-icon fas fa-recycle"></i>
							<p>Report<i class="fas fa-angle-left right"></i></p>
						</a>
					<?php } else { ?>
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-recycle"></i>
							<p>Report<i class="fas fa-angle-left right"></i></p>
						</a>
					<?php } ?>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('insentif') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'insentif') {
																								echo "active";
																							} ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Insentif Sales</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('keuntungan') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'keuntungan') {
																								echo "active";
																							} ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Keuntungan</p>
							</a>
						</li>
					</ul>
					</li>
					<!-- <li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fab fa-product-hunt"></i>
							<p>Product Data<i class="fas fa-angle-left right"></i></p>
						</a> -->
					<?php if ($this->uri->segment(1) == 'product' || $this->uri->segment(1) == 'category' || $this->uri->segment(1) == 'brand' || $this->uri->segment(1) == 'uom') { ?>
						<li class="nav-item has-treeview menu-open">
							<a href="#" class="nav-link active">
								<i class="nav-icon fab fa-product-hunt"></i>
								<p>Product Data<i class="fas fa-angle-left right"></i></p>
							</a>
						<?php } else { ?>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fab fa-product-hunt"></i>
								<p>Product Data<i class="fas fa-angle-left right"></i></p>
							</a>
						<?php } ?>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?php echo site_url('product') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'product') {
																								echo "active";
																							} ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Product</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url('category') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'category') {
																									echo "active";
																								} ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Category</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url('brand') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'brand') {
																								echo "active";
																							} ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Brand</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url('uom') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'uom') {
																							echo "active";
																						} ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Unit of Measure</p>
								</a>
							</li>
						</ul>
						</li>
						<!-- <li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-compass"></i>
								<p>Destination<i class="fas fa-angle-left right"></i></p>
							</a> -->
						<?php if ($this->uri->segment(1) == 'city' || $this->uri->segment(1) == 'province') { ?>
							<li class="nav-item has-treeview menu-open">
								<a href="#" class="nav-link active">
									<i class="nav-icon fas fa-compass"></i>
									<p>Destination<i class="fas fa-angle-left right"></i></p>
								</a>
							<?php } else { ?>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-compass"></i>
									<p>Destination<i class="fas fa-angle-left right"></i></p>
								</a>
							<?php } ?>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?php echo site_url('city') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'city') {
																									echo "active";
																								} ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>City</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo site_url('province') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'province') {
																										echo "active";
																									} ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Province</p>
									</a>
								</li>
							</ul>
							</li>
							<!-- <li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-laptop"></i>
									<p>Master Data<i class="fas fa-angle-left right"></i></p>
								</a> -->
							<?php if (
								$this->uri->segment(1) == 'supplier' || $this->uri->segment(1) == 'customer'
								|| $this->uri->segment(1) == 'user'
								|| $this->uri->segment(1) == 'account'
								|| $this->uri->segment(1) == 'courier'
								|| $this->uri->segment(1) == 'job'
								|| $this->uri->segment(1) == 'greeting'
							) { ?>
								<li class="nav-item has-treeview menu-open">
									<a href="#" class="nav-link active">
										<i class="nav-icon fas fa-laptop"></i>
										<p>Master Data<i class="fas fa-angle-left right"></i></p>
									</a>
								<?php } else { ?>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<i class="nav-icon fas fa-laptop"></i>
										<p>Master Data<i class="fas fa-angle-left right"></i></p>
									</a>
								<?php } ?>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?php echo site_url('supplier') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'supplier') {
																											echo "active";
																										} ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Supplier</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo site_url('customer') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'customer') {
																											echo "active";
																										} ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Customer</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo site_url('user') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'user') {
																										echo "active";
																									} ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>User</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo site_url('account') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'account') {
																										echo "active";
																									} ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Bank Account</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo site_url('courier') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'courier') {
																										echo "active";
																									} ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Courier</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo site_url('job') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'job') {
																									echo "active";
																								} ?>">
											<i class="far fa-circle nav-icon"></i>
											<p>Job</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo site_url('greeting') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'greeting') {
																											echo "active";
																										} ?>">
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
