<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6">
					<h2 class="m-heading">Reports List</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<ol class="breadcrumb">
						<li>
							<a href="#">
								<span>Reports Management</span>
							</a>
						</li>
						<li>
							<span>Reports List</span>
						</li>
					</ol>
				</div>
			</div>
			<?php if(!isset($_COOKIE['repT'])){ ?>
			<div class="row" id="reportsList">
				<div class="box-white m-b-30">
					<div class="col-md-6">
						<div class="reporting-div">
							<h2>Product Reports</h2>
							<ul class="m-b-30">
								<li>
									<a id="prodRep" href="">Products Report</a>
									<span>Your basic products report.</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

			</div>
			<?php }else{ 
				if($_COOKIE['repT'] == "products"){ ?>
			<div class="row">
				<!-- <button id="expToPdf">EXPORT TO PDF</button> -->
				<div class="col-md-12">
					<div class="box-white p-20">
						<button id="expToExc" class="btn add-emp">
							<i class="fa fa-plus"> </i> EXPORT TO EXCEL</button>
						&nbsp;&nbsp;&nbsp;
						<select id="brandFilter" class="form-control add-emp" style="width: 150px; margin-right: 10px">
							<option value="0" <?=(!isset($_COOKIE['brand_filter']) || $_COOKIE['brand_filter']=="0" ? "selected" : "" ) ?>
								>All Brands</option>
							<?php foreach($brandsList as $brand) { ?>
							<option value="<?= $brand->item_brand; ?>" <?=isset($_COOKIE['brand_filter']) &&
							 strtolower($_COOKIE['brand_filter'])==strtolower(trim($brand->item_brand,' ')) ? "selected" : ""; ?> >
								<?= $brand->item_brand; ?>
							</option>
							<?php }?>
						</select>
						<h2 class="m-b-0 less_600">Inventory List</h2>
						<div class="table-wrap">
							<table class="table table-hover display  pb-30">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Sku</th>
										<th>Name</th>
										<th>Unit</th>
										<th style="width: 150px">Trade Price</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>S.No</th>
										<th>Sku</th>
										<th>Name</th>
										<th>Unit</th>
										<th style="width: 150px">Trade Price</th>
									</tr>
								</tfoot>
								<tbody>
									<?php $sno = 1;foreach ($Inventory as $inventory): ?>
									<tr>
										<td>
											<?= $sno++; ?>
										</td>
										<td>
											<?=$inventory->item_sku;?>
										</td>
										<td>
											<?=$inventory->item_name;?>
										</td>
										<td>
											<?=$inventory->unit_name;?>
										</td>
										<td>
											<?= $inventory->item_trade_price   ; ?>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php }
			} ?>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script>
	$(document).ready(function () {

		setCookieReports('repT', 'products', -1);
		var brandSelected = "0";

		$('#prodRep').click(function () {
			setCookieReports('repT', 'products', 1);
			location.reload();
		});

		$('#expToPdf').click(function () {
			window.location = "/export-formats/exportProductsReport.php?form=pdf";
		});

		$('#expToExc').click(function () {
			window.location = "/export-formats/exportProductsReport.php?form=exc&brand=" + encodeURIComponent(brandSelected);
		});

		$('#brandFilter').change(function () {
			brandSelected = encodeURIComponent($(this).val());
			$('#expToExc').attr('disabled', 'disabled');
			$.ajax({
				type: 'GET',
				url: '/Dashboard/GetBrandItems/' + brandSelected,
				success: function (response) {
					var response = JSON.parse(response);
					$('.table-wrap').empty()
					$('.table-wrap').append(
						'<table class="table table-hover display  pb-30"><thead><tr><th>S.No</th><th>Sku</th><th>Name</th><th>Unit</th><th style="width: 150px">Trade Price</th></tr></thead><tfoot><tr><th>S.No</th><th>Sku</th><th>Name</th><th>Unit</th><th style="width: 150px">Trade Price</th></tr></tfoot><tbody></tbody></table>'
					);
					var sNo = 1
					response.forEach(element => {
						$('.table-wrap table tbody').append('<tr><td>' + (sNo++) + '</td><td>' + element['item_sku'] +
							'</td><td>' + element['item_name'] + '</td><td>' + element['unit_name'] + '</td><td>' + element[
								'item_trade_price'] + '</td></tr>');
					});
					$('.table').DataTable();
					$('#expToExc').removeAttr('disabled');
				}
			});
		});
	});

	function setCookieReports(name, value, days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "") + expires + "; path=/";
	}

</script>
