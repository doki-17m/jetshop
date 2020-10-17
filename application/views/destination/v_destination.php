<div class="container-fluid">
	<div class="card card-primary card-outline card-outline-tabs">
		<div class="card-header p-0 border-bottom-0">
			<ul class="nav nav-tabs" id="tab-dest" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="tab-prov" data-toggle="pill" href="#tab-dest-prov" role="tab" aria-controls="tab-dest-prov" aria-selected="true">Province</i></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab-city" data-toggle="pill" href="#tab-dest-city" role="tab" aria-controls="tab-dest-city" aria-selected="false">City</i></a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			<div class="tab-content" id="tab-dest-content">
				<div class="toolbar-header">
					<div class="float-left">
						<button type="button" class="btn btn-block bg-gradient-primary btn-sm" id="new_destination"><i class="fas fa-cog"> New</i></button>
					</div>
				</div>
				<div class="tab-pane fade show active" id="tab-dest-prov" role="tabpanel" aria-labelledby="tab-dest-prov">
					<div class="table-responsive">
						<table id="tb_province" class="table table-bordered table-hover table-pointer" style="width: 100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>#</th>
									<th>Search Key</th>
									<th>Name</th>
									<th>Description</th>
									<th>Status</th>
									<th width="50px">Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="tab-pane fade" id="tab-dest-city" role="tabpanel" aria-labelledby="tab-dest-city">
					<div class="table-responsive">
						<table id="tb_city" class="table table-bordered table-hover table-pointer" style="width: 100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>#</th>
									<th>Search Key</th>
									<th>Name</th>
									<th>Description</th>
									<th>Status</th>
									<th width="50px">Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
