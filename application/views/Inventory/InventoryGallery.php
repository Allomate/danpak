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
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb" style="width: 300px;">
						<li style="width: 100%;">
							<input type="text" class="form-control" id="searchText" placeholder="Please type SKU/Name/Description">
						</li>
					</ol>
				</div>
			</div>

			<input type="text" value="<?= $inventoryListSku['total_records']; ?>" id="totalRecords" hidden>

			<div class="content">
				<?php
			$rowCounter = 0;
			foreach($inventoryListSku["data"] as $item) { ?>
				<?php if($rowCounter == 0){ ?>
				<div class="row">
					<?php } ?>
					<div class="col-md-3 col-sm-4 col-xs-12">
						<div class="w-box-sec p-10 align-center m-b-30">
							<a href="<?= base_url('Inventory/UpdateInventorySku/'.$item->item_id); ?>"> <img src="<?= $item->item_thumbnail; ?>"
								class="img-responsive" /> </a>
							<h5 class="m-t-15">
								<?= $item->item_name; ?>
							</h5>
							<a class="btn view-report p-l-15 p-r-15 m-t-15" href="<?= base_url('Inventory/UpdateInventorySku/'.$item->item_id); ?>">
								View Detail </a>
						</div>
					</div>
					<?php if($rowCounter == 3){ $rowCounter = -1; ?>
				</div>
				<?php }
			$rowCounter++; } ?>
			</div>

			<div class="searchContent" style="display: none"></div>
			<hr>
			<button id="loadMore" class="btn" style="display: block; margin: 0 auto; border-radius: 20em; padding: 10px 80px; box-shadow: 0px 5px 8px 0px #e5d6d6; background: #fff; color: black">
				<span id="loadMoreText" style="display: block">LOAD MORE</span>
				<span id="loadingText" style="display: none">LOADING...</span>
				<!-- <img src="/assets/images/table-loader.gif" id="loader" style="display: none; margin: 0 auto;" width="70px" alt=""> -->
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

		var scrollCounter = 12;
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
					scrolling_counter: scrollCounter
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
							'<div class="col-md-3 col-sm-4 col-xs-12"><div class="w-box-sec p-10 align-center m-b-30"><a href="/Inventory/UpdateInventorySku/' +
							response[i].item_id + '"> <img src="' + response[i].item_thumbnail +
							'" class="img-responsive" /> </a><h5 class="m-t-15">' + response[i].item_name +
							'</h5><a class="btn view-report p-l-15 p-r-15 m-t-15" href="/Inventory/UpdateInventorySku/' + response[
								i].item_id + '"> View Detail </a></div></div>');
						if (rowCounter == 3) {
							// $('.page-wrapper .container .content').append('</div>');
							rowCounter = -1;
							currentRowLoopingContent++;
						}
						rowCounter++;
					}
					scrollCounter += 12;
					if (scrollCounter > $('#totalRecords').val()) {
						$('#loadMore').fadeOut();
					}
				}
			});
			// }
		});

		$('#searchText').on('input', function () {
			if ($(this).val().length > 3) {
				$('.content').fadeOut();
				$('.loader').show();
				var searchText = $(this).val();
				$.ajax({
					type: 'POST',
					url: '/Inventory/fetchSearched',
					data: {
						searchedText: searchText
					},
					success: function (response) {
						var rowCounterSearch = 0;
						$('.searchContent').empty();
						var response = JSON.parse(response);
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
								'" class="img-responsive" /> </a><h5 class="m-t-15">' + response[i].item_name +
								'</h5><a class="btn view-report p-l-15 p-r-15 m-t-15" href="/Inventory/UpdateInventorySku/' + response[
									i].item_id + '"> View Detail </a></div></div>');
							if (rowCounterSearch == 3) {
								// $('.searchContent').append('</div>');
								rowCounterSearch = -1;
								currentRowLoopingSearch++;
							}
							rowCounterSearch++;
						}
						$('.loader').hide();
						$('.searchContent').fadeIn();
					}
				});
			} else {
				$('.loader').hide();
				$('.searchContent').hide();
				$('.content').fadeIn();
			}
		});

	});

</script>
