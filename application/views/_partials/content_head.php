<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<?php if ($this->uri->segment('1') == '' || $this->uri->segment('1') == 'app') { ?>
					<h1 class="m-0 text-dark">Dashboard</h1>
				<?php } else { ?>
					<h1 class="m-0 text-dark"><?= ucfirst($this->uri->segment('1')) ?></h1>
				<?php } ?>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<?php if ($this->uri->segment('1') == '' || $this->uri->segment('1') == 'app') { ?>
						<li class="breadcrumb-item active">Dashboard</li>
					<?php } else { ?>
						<li class="breadcrumb-item active"><?= ucfirst($this->uri->segment('1')) ?></li>
					<?php } ?>
				</ol>
			</div>
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
