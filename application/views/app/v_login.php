<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('_partials/head') ?>
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="javascript:void(0)"><b>Admin</b>LTE</a>
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Sign in</p>

				<form id="form_login">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" id="lgn_username" name="lgn_username" placeholder="Username">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
						</div>
						<small id="error_lgn_username" class="form-text text-danger"></small>
					</div>
					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control" id="lgn_pass" name="lgn_pass" placeholder="Password">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock lock"></span>
								</div>
							</div>
						</div>
						<small id="error_lgn_pass" class="form-text text-danger"></small>
					</div>
					<div class="row">
						<div class="col-8">
							<!-- <div class="icheck-primary">
							<input type="checkbox" id="remember">
							<label for="remember">
								Remember Me
							</label>
							</div> -->
						</div>
						<!-- /.col -->
						<div class="col-4">
							<button type="button" class="btn btn-primary btn-block" id="do_login">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
<?php $this->load->view('_partials/js') ?>

</html>
