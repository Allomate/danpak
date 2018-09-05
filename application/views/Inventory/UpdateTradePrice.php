<?php require_once APPPATH . '/views/includes/header.php';?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once APPPATH . '/views/includes/navbar&sidebar.php';?>
	<div class="page-wrapper">
		<div class="container-fluid">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Trade Prices</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">

						<li><a href="#"><span>Organization</span></a></li>
						<li><span>Trade Prices</span></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="box-white p-20">
						<h2 class="m-b-0 less_600">Inventory List</h2>
						<div class="table-wrap">
							<div class="table-responsive">
								<table class="table table-hover display  pb-30">
									<thead>
										<tr>
											<th>S.No</th>
											<th>Sku</th>
											<th>Name</th>
											<th>Unit</th>
											<th>Barcode</th>
											<th style="width: 150px">Trade Price</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>S.No</th>
											<th>Sku</th>
											<th>Name</th>
											<th>Unit</th>
											<th>Barcode</th>
											<th style="width: 150px">Trade Price</th>
											<th>Action</th>
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
												<?=$inventory->item_barcode;?>
											</td>
											<td>
												<input class="form-control" type="number" value="<?= $inventory->item_trade_price   ; ?>" min="1" />
											</td>
											<td>
												<button id="<?= $inventory->pref_id; ?>" class="btn view-report updateTradePrice">UPDATE</button>
											</td>
										</tr>
										<?php endforeach;?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH . '/views/includes/footer.php';?>
<script type="text/javascript">
	$(document).ready(function () {
		$(document).on('click', '.deleteConfirmation', function (e) {
			var thisRef = $(this);
			e.preventDefault();
			swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					window.location.href = thisRef.attr('href');
				}
			})
		});

		$(document).on('click', '.updateTradePrice', function (e) {
			var thisRef = $(this);
			if (!thisRef.parent().parent().find('td:eq(5)').find('input[type="number"]').val() || thisRef.parent().parent().find(
					'td:eq(5)').find('input[type="number"]').val() == "" || thisRef.parent().parent().find('td:eq(5)').find(
					'input[type="number"]').val() <= 0) {
				alert("Please provide value quantity");
				return;
			}
			$(this).attr('disabled', 'disabled');
			$.ajax({
				type: "POST",
				url: "/Inventory/UpdateTradePriceBulk",
				data: {
					pref_id: thisRef.attr("id"),
					price: thisRef.parent().parent().find('td:eq(5)').find('input[type="number"]').val()
				},
				success: function (response) {
					if (response) {
						thisRef.css('background', 'green');
						thisRef.text('UPDATED');
						setTimeout(function () {
							thisRef.css('background', '#001e35');
							thisRef.text('UPDATE');
							thisRef.removeAttr('disabled');
						}, 3000);
					} else {
						alert('An error occured');
					}
				}
			});
		});
	});

</script>
