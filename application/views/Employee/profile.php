<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row pt-25">
				<div class="col-md-12">
					<div class="box-emp-top">
						<div class="row">
							<div class="col-md-12">
								<span class="emp_name">
									<img src="<?= $employee->employee_picture ? $employee->employee_picture : base_url('assets/images/no-image.png') ; ?>" alt=""
									class="emp_img img-circle">
									<?= $employee->employee_first_name.' '.$employee->employee_last_name;?>
								</span>
								<span class="emp-top-m">ID: #
									<?= $employee->employee_id; ?>
								</span>
								<span class="emp-top-m">Area:
									<?= $employee->area; ?>
								</span>
								<span class="emp-top-m">Territory:
									<?= $employee->territory; ?>
								</span>
								<span class="emp-top-m">
									<i class="fa fa-phone"> </i>
									<?= $employee->employee_phone; ?>
								</span>
								<span class="emp-top-m">
									<i class="fa fa-map-marker"> </i>
									<?= $employee->employee_address; ?>
								</span>
								<span class="emp_status">
									<span></span> Active </span>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-md-12 m-b-15" align="right">
					<div class="btn-group btn-group-justified opt_filter ">
						<?php if(isset($_COOKIE["stat_type"]) && $_COOKIE["stat_type"] == "overall") : ?>
						<a class="btn view_filter currMonth" role="button">Current Month</a>
						<a class="btn view_filter act_filter overall" role="button">Overall</a>
						<?php else: ?>
						<a class="btn view_filter act_filter currMonth" role="button">Current Month</a>
						<a class="btn view_filter overall" role="button">Overall</a>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-md-12">
					<div class="w-box-emp p-20">
						<h2>Monthly Sales Stats</h2>
						<div class="S_overflow">
							<table class="S_table">
								<tbody>
									<tr>
										<td rowspan="2" class="emp_SS">
											<span class="counter-anim font_s">
												<?= $data["revenue_generated"] ? $data["revenue_generated"] : "0"; ?>
											</span>
											<span class="uppercase-font block">Total Revenue Generated</span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data["avg_monthly_sale"] ? $data["avg_monthly_sale"] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Monthly Sales</span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data["avg_per_week_sale"] ? $data["avg_per_week_sale"] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Weekly Sales</span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data["avg_daily_sale"] ? $data["avg_daily_sale"] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Daily Sales</span>
										</td>
										<td class="emp_S1 border-r-none">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data["avg_order_value"] ? $data["avg_order_value"] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Order Value</span>
										</td>
									</tr>
									<tr>
										<td class="emp_S2">
											<span>
												<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
													<?= $data["productive_sales_ratio"] ? $data["productive_sales_ratio"] : "0"; ?>
												</span>%</span>
											<span class="uppercase-font block p-t-5">Productive Sales Ratio</span>
										</td>
										<td class="emp_S2">
											<span>
												<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
													<?= $data["return_ratio"] ? $data["return_ratio"] : "0"; ?>
												</span>%</span>
											<span class="uppercase-font block p-t-5">Return Ratio</span>
										</td>
										<td class="emp_S2">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data["avg_products_per_order"] ? $data["avg_products_per_order"] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Products/Sales Order</span>
										</td>
										<td class="emp_S2 border-none">
											<span>
												<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;"> N/A </span>%</span>
											<span class="uppercase-font block p-t-5">AVG Target Achievement</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="w-box-emp p-20">
						<h2>Retail Outlets Stats</h2>
						<div class="S_overflow">
							<table class="S_table">
								<tbody>
									<tr>
										<td rowspan="2" class="emp_SS">
											<span class="counter-anim font_s">
												<?= $data['total_retail_outlets'] ? $data['total_retail_outlets'] : "0"; ?>
											</span>
											<span class="uppercase-font block">Total Retail Outlets</span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_prod_shops_per_month'] ? $data['avg_prod_shops_per_month'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Monthly
												<br>Productive Shops </span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_productive_shops_per_week'] ? $data['avg_productive_shops_per_week'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Weekly
												<br>Productive Shops</span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_daily_prod_shops'] ? $data['avg_daily_prod_shops'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Daily
												<br>Productive Shops</span>
										</td>
										<td class="emp_S1 border-r-none">
											<span>
												<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
													<?= $data['productive_ratio'] ? $data['productive_ratio'] : "0"; ?>
												</span>%</span>
											<span class="uppercase-font block p-t-5">Productive
												<br>Ratio</span>
										</td>
									</tr>
									<tr>
										<td class="emp_S2">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_monthly_visits'] ? $data['avg_monthly_visits'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Monthly
												<br>Retail Visits</span>
										</td>
										<td class="emp_S2">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_weekly_visits'] ? $data['avg_weekly_visits'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Weekly
												<br>Retail Visits</span>
										</td>
										<td class="emp_S2">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_daily_visits'] ? $data['avg_daily_visits'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Daily
												<br>Retail Visits</span>
										</td>
										<td class="emp_S2 border-none">
											<span>
												<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
													<?= $data['expansion_ratio'] ? $data['expansion_ratio'] : "0"; ?>
												</span>%</span>
											<span class="uppercase-font block p-t-5">Expansion
												<br>Ratio</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="w-box-emp p-20">
						<h2>Orders Stats</h2>
						<div class="S_overflow">
							<table class="S_table">
								<tbody>
									<tr>
										<td rowspan="2" class="emp_SS">
											<span class="counter-anim font_s">
												<?= $data['total_orders_booked'] ? $data['total_orders_booked'] : "0"; ?>
											</span>
											<span class="uppercase-font block">Total Orders Booked</span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_order_monthly'] ? $data['avg_order_monthly'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Monthly
												<br>Orders</span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_order_weekly'] ? $data['avg_order_weekly'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Weekly
												<br>Orders</span>
										</td>
										<td class="emp_S1">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_order_daily'] ? $data['avg_order_daily'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Daily
												<br>Orders</span>
										</td>
										<td class="emp_S1 border-r-none">
											<span>
												<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
													<?= $data['order_compliance'] ? $data['order_compliance'] : "0"; ?>
												</span>%</span>
											<span class="uppercase-font block p-t-5">Order Compliance
												<br>Ratio</span>
										</td>
									</tr>
									<tr>
										<td class="emp_S2">
											<span>
												<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
													<?= $data['return_ratio'] ? $data['return_ratio'] : "0"; ?>
												</span>%</span>
											<span class="uppercase-font block p-t-5">Return
												<br>Ratio</span>
										</td>
										<td class="emp_S2">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_order_value'] ? $data['avg_order_value'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Order
												<br>Value</span>
										</td>
										<td class="emp_S2">
											<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
												<?= $data['avg_products_per_order'] ? $data['avg_products_per_order'] : "0"; ?>
											</span>
											<span class="uppercase-font block p-t-5">AVG Products
												<br>Per Order</span>
										</td>
										<td class="emp_S2 border-none">
											<span>
												<span class="counter-anims" style="font-size: 25px; font-weight: 800; line-height: normal; color: #001e35;">
													<?= $data['avg_discount_per_order'] ? $data['avg_discount_per_order'] : "0"; ?>
												</span>%</span>
											<span class="uppercase-font block p-t-5">AVG Discount
												<br>Per Order</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/includes/footer.php';?>
<script>
	$(document).ready(function () {
		$('.currMonth').click(function () {
			setCookie('stat_type', 'curr', 1);
			$('.opt_filter').children().removeClass("act_filter");
			$('.currMonth').addClass('act_filter');
			location.reload();
		});
		$('.overall').click(function () {
			setCookie('stat_type', 'overall', 1);
			$('.opt_filter').children().removeClass("act_filter");
			$('.overall').addClass('act_filter');
			location.reload();
		});
	});

	function setCookie(name, value, days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "") + expires + "; path=/";
	}

</script>
