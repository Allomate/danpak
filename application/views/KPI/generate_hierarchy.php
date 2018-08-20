<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<style>
	/* width */

	.box-white ::-webkit-scrollbar {
		height: 2px
	}

	/* Track */

	.box-white ::-webkit-scrollbar-track {
		background: #fff;
	}

	/* Handle */

	.box-white ::-webkit-scrollbar-thumb {
		background: #001e35;
	}

	/* Handle on hover */

	.box-white ::-webkit-scrollbar-thumb:hover {
		background: #001e35;
	}

</style>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">KPI Management</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>KPI Management</span>
							</a>
						</li>
				 
						<li>
							<span>Employee Hierarchy Tree</span>
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0">Employee Hierarchy Tree</h2>
						<div style="display: block; margin: 20px auto; text-align: center;">
							<article style="width: 250px; background-color: #001e35; color: white; border-radius: 10px; height: 100%; padding-bottom: 5px; display: block; margin: 0 auto;">
								<header style="display: block; min-height: 250px">
									<img src="<?= base_url($Reportees['employee_picture'] ? $Reportees['employee_picture'] : 'assets/images/no-image.png
										'); ?>" width="250px" height="250px" style="border-top-right-radius: 10px; border-top-left-radius: 10px;" alt="<?= $Reportees['employee_name']; ?>">
								</header>
								<content style="display: block; padding: 10px 20px;">
									<center>
										<span style="color: white; font-weight: bolder;">
											<?= $Reportees['employee_name']; ?>
										</span>
										<br>
										<span>
											<?= $Reportees['employee_designation']; ?>
										</span>
										<br>
										<span>
											<?= $Reportees['employee_email']; ?>
										</span>
									</center>
								</content>
							</article>
							<br>
							<?php if(sizeOf($Reportees["reportees"])) : ?>
							<div style="width: 100%; min-height: 400px; overflow-x: scroll; white-space: nowrap">
								<?php $counter = 0; foreach($Reportees["reportees"] as $reportees):
                                    if($counter == 0){ ?>
								<a href="<?= $reportees->employee_username; ?>">
									<article style="display: inline-block; max-width: 250px; background-color: #001e35; color: white; border-radius: 10px; height: 100%; padding-bottom: 5px;">
										<header style="display: block; min-height: 250px">
											<img src="<?= base_url($reportees->employee_picture ? $reportees->employee_picture : 'assets/images/no-image.png
										'); ?>" width="250px" height="250px" style="border-top-right-radius: 10px; border-top-left-radius: 10px;" alt="<?= $reportees->employee_name; ?>">
										</header>
										<content style="display: block; padding: 10px 20px;">
											<center>
												<span style="color: white; font-weight: bolder">
													<?= $reportees->employee_name; ?>
												</span>
												<br>
												<span>
													<?= $reportees->employee_designation; ?>
												</span>
												<br>
												<span>
													<?= $reportees->employee_email; ?>
												</span>
											</center>
										</content>
									</article>
								</a>
								<?php }else{ ?>
								<a href="<?= $reportees->employee_username; ?>">
									<article style="display: inline-block; max-width: 250px; background-color: #001e35; color: white; border-radius: 10px; height: 100%; padding-bottom: 5px; margin-left: 50px">
										<header style="display: block; min-height: 250px">
											<img src="<?= base_url($reportees->employee_picture ? $reportees->employee_picture : 'assets/images/no-image.png
										'); ?>" width="250px" height="250px" style="border-top-right-radius: 10px; border-top-left-radius: 10px;" alt="<?= $reportees->employee_name; ?>">
										</header>
										<content style="padding: 10px 20px; display: block;">
											<center>
												<span style="color: white; font-weight: bolder">
													<?= $reportees->employee_name; ?>
												</span>
												<br>
												<span>
													<?= $reportees->employee_designation; ?>
												</span>
												<br>
												<span>
													<?= $reportees->employee_email; ?>
												</span>
											</center>
										</content>
									</article>
								</a>
								<?php } ?>
								<?php $counter++; endforeach; ?>
							</div>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/includes/footer.php';?>\
