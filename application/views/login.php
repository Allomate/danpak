<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<div class="page-wrapper pa-0 ma-0 auth-page">
		<div class="container-fluid">
			<div class="table-struct full-width full-height">
				<div class="table-cell vertical-align-middle auth-form-wrap">
					<?php if ($feedback = $this->session->flashdata('login_failed')) : ?>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="alert alert-dismissible alert-danger" style=" background: white; color: black;">
								<strong>Failed</strong>
								<?= $feedback; ?>
							</div>
						</div>
						<div class="col-md-3"></div>
					</div>
					<?php endif; ?>
					<div class="auth-form ml-auto mr-auto no-float">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="login-left">
										<div class="logo-company">
											<img src="<?= base_url('assets/images/allomate-logo.png'); ?>" width="168" height="45" alt="" />
										</div>
										<h4 class="txt-dark uppercase-font">Sales and Distributor</h4>
										<p class="p-text">Management System</p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="login-right">
										<div class="mb-10">
											<h3 class="txt-dark mb-10">Login</h3>
										</div>
										<div class="form-wrap">
											<?php $attributes = array('id' => 'loginForm');
											echo form_open('Login/AdminLoginOps', $attributes); ?>
											<div class="form-group">
												<div class="user">
													<span class="icon-user-icon"></span>
													<input type="text" class="form-control" name="username" placeholder="Username">
												</div>
												<?= form_error('username', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>
											<div class="form-group">
												<div class="clearfix"></div>
												<div class="pass">
													<span class="icon-pass-icon"></span>
													<input type="password" class="form-control" name="password" placeholder="Password">
												</div>
												<?= form_error('password', '<small style="color: red; font-weight: bold; margin-top: 5px; display: block">', '</small>');?>
											</div>

											<div class="radio radio-info m-b-15">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<input type="radio" name="login_type" class="loginType" id="danpak" value="danpak" checked="checked">
															<label for="danpak" class="rad-large">Danpak</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<input type="radio" name="login_type" class="loginType" id="distributor" value="dist">
															<label for="distributor" class="rad-large">Distributor</label>
														</div>
													</div>
												</div>
											</div>

											<div class="form-group">
												<button type="submit" class="btn btn-info btn-login">Login</button>
											</div>

											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
