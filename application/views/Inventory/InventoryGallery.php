<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<!-- <div class="preloader-it">
	<div class="la-anim-1"></div>
</div> -->
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Product List</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="_Pro-search">
						<div class="form-group _brandname">
							<select id="brandFilter" id="sel1" class="form-control">
								<option value="0" <?=(!isset($_COOKIE['brand_filter']) || $_COOKIE['brand_filter']=="0" ? "selected" : "" ) ?>
									>All Brands</option>
								<?php foreach($brandsList as $brand) { ?>
								<option value="<?= $brand->item_brand; ?>" <?=isset($_COOKIE['brand_filter']) &&
								 strtolower($_COOKIE['brand_filter'])==strtolower(trim($brand->item_brand,' ')) ? "selected" : ""; ?> >
									<?= $brand->item_brand; ?>
								</option>
								<?php }?>
							</select>
						</div>
						<input type="text" class="form-control _pr-Search" id="searchText" placeholder="Please type SKU/Name/Description">
					</div>
				</div>
			</div>
			<br>
			<input type="text" value="<?= $inventoryListSku['total_records']; ?>" id="totalRecords" hidden>

			<div id="bodyContent">
				<div class="content">
					<?php
			$rowCounter = 0;
			foreach($inventoryListSku["data"] as $item) { ?>
					<?php if($rowCounter == 0){ ?>
					<div class="row">
						<?php } ?>
						<div class="col-md-2 col-sm-4 col-xs-6 _PBox">
							<div class="w-box-sec p-5 align-center m-b-30">
								<a href="<?= base_url('Inventory/UpdateInventorySku/'.$item->item_id); ?>"> <img src="<?= $item->item_thumbnail; ?>"
									 class="img-responsive _Im-border" /> </a>
								<h5 class="pr_text">
									<?= $item->item_name; ?>
								</h5>
								<a class="btn view-report p-l-15 p-r-15 m-t-15" href="<?= base_url('Inventory/UpdateInventorySku/'.$item->item_id); ?>">
									View Detail </a>
							</div>
						</div>
						<?php if($rowCounter == 5){ $rowCounter = -1; ?>
					</div>
					<?php }
			$rowCounter++; } ?>
				</div>
			</div>
			<div style="display: none; width: 100%; min-height: 250px" class="loader">
				<img src="/assets/images/wl-loader-2.gif" style="width: 50px; margin: 0 auto; margin-bottom: 50px; display: block; margin-top: 150px !important;">
			</div>
			<div class="searchContent"></div>
			<button id="loadMore" class="btn" style="display: block; margin: 0 auto; border-radius: 20em; padding: 10px 80px; box-shadow: 0px 5px 8px 0px #e5d6d6; background: #fff; color: black"><span
				 id="loadMoreText" style="display: block">LOAD MORE</span><span id="loadingText" style="display: none">LOADING...</span>
			</button>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript">
	var scale = 'scale(1)';
	document.body.style.webkitTransform = scale; // Chrome, Opera, Safari
	document.body.style.msTransform = scale; // IE 9
	document.body.style.transform = scale; // General
	$(document).ready(function () {

		var scrollCounter = 18;
		var rowCounter = 0;
		var currentRowLoopingContent = 0;
		var currentRowLoopingSearch = 0;

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

		$('#loadMore').click(function () {
			// if (scrollCounter <= $('#totalRecords').val()) {
			$('#loadMoreText').hide();
			$('#loadingText').show();
			$(this).attr('disabled', 'disabled');
			$.ajax({
				type: 'POST',
				url: '/Inventory/loadMoreGalleryAjax',
				data: {
					scrolling_counter: scrollCounter,
					brand: $('#brandFilter').val()
				},
				success: function (response) {
					$('#loadMoreText').show();
					$('#loadingText').hide();
					$('#loadMore').removeAttr('disabled');
					var response = JSON.parse(response);
					for (var i = 0; i < response.length; i++) {
						if (rowCounter == 0) {
							$('.page-wrapper .container .content').append('<div class="row" id="row' + currentRowLoopingContent +
								'">');
						}
						$('.page-wrapper .container .content #row' + currentRowLoopingContent).append(
							'<div class="col-md-2 col-sm-4 col-xs-6 _PBox"><div class="w-box-sec p-5 align-center m-b-30"><a href="/Inventory/UpdateInventorySku/' +
							response[i].item_id + '"> <img src="' + response[i].item_thumbnail +
							'" class="img-responsive  _Im-border" /> </a><h5 class="pr_text">' + response[i].item_name +
							'</h5><a class="btn view-report p-l-15 p-r-15 m-t-15" href="/Inventory/UpdateInventorySku/' + response[
								i].item_id + '"> View Detail </a></div></div>');
						if (rowCounter == 5) {
							// $('.page-wrapper .container .content').append('</div>');
							rowCounter = -1;
							currentRowLoopingContent++;
						}
						rowCounter++;
					}
					scrollCounter += 18;
					if (scrollCounter > $('#totalRecords').val()) {
						$('#loadMore').fadeOut();
					}
				}
			});
			// }
		});

		$('#brandFilter').change(function () {
			if ($(this).val() != "0") {
				setCookieBrandFilter('brand_filter', $(this).val(), 1);
			} else {
				setCookieBrandFilter('brand_filter', $(this).val(), -1);
			}
			location.reload();
		});

		$('#searchText').on('input', function () {
			var brandSelected = $('#brandFilter').val();
			if ($(this).val().length > 3) {
				$('.content').hide();
				$('.loader').css('display', 'block');
				var searchText = $(this).val();
				$.ajax({
					type: 'POST',
					url: '/Inventory/fetchSearched',
					data: {
						searchedText: searchText,
						brandFilter: brandSelected
					},
					success: function (response) {
						var rowCounterSearch = 0;
						var response = JSON.parse(response);
						$('.searchContent').empty();
						if (!response.length) {
							$('.loader').hide();
							$('.searchContent').append('<span>No Results Found</span>');
							return;
						}
						for (var i = 0; i < response.length; i++) {
							if (rowCounterSearch == 0) {
								$('.searchContent').append('<div class="row" id="row' + currentRowLoopingSearch + '">');
							}
							$('.searchContent #row' + currentRowLoopingSearch).append(
								'<div class="col-md-3 col-sm-4 col-xs-12"><div class="w-box-sec p-10 align-center m-b-30"><a href="/Inventory/UpdateInventorySku/' +
								response[i].item_id + '"> <img src="' + response[i].item_thumbnail +
								'" class="img-responsive" /> </a><h5 class="pr_text">' + response[i].item_name +
								'</h5><a class="btn view-report p-l-15 p-r-15 m-t-15" href="/Inventory/UpdateInventorySku/' + response[
									i].item_id + '"> View Detail </a></div></div>');
							if (rowCounterSearch == 3) {
								rowCounterSearch = -1;
								currentRowLoopingSearch++;
							}
							rowCounterSearch++;
						}
						$('#loadMore').hide();
						$('.loader').hide();
						$('.searchContent').fadeIn();
					}
				});
			} else {
				$('.loader').hide();
				$('.searchContent').hide();
				$('.content').fadeIn();
				$('#loadMore').show();
			}
		});

	});

	function setCookieBrandFilter(name, value, days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "") + expires + "; path=/";
	}

</script>
