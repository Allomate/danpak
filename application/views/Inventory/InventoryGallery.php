<?php require_once(APPPATH.'/views/includes/header.php'); ?>
<div class="preloader-it">
	<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active">
	<?php require_once(APPPATH.'/views/includes/navbar&sidebar.php'); ?>
	<div class="page-wrapper">
		<div class="container">
			<div class="row heading-bg">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<h2 class="m-heading">Product List</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<ol class="breadcrumb">							 
						<li><a href="#"><span>Product Management</span></a></li>
						<li><span>Product List</span></li> 
					</ol>
				</div>
			</div>
			
			<div class="row">
				<?php foreach($inventoryListSku as $item) : ?>
					<div class="col-md-3 col-sm-4 col-xs-12">
						<div class="w-box-sec p-10 align-center m-b-30"> 											
							<a href="<?= base_url('Inventory/UpdateInventorySku/'.$item->item_id); ?>"> <img src="<?= $item->item_thumbnail; ?>" class="img-responsive"/> </a>						 
							<h5 class="m-t-15"><?= $item->item_name; ?></h5>									
							<a class="btn view-report p-l-15 p-r-15 m-t-15" href="<?= base_url('Inventory/UpdateInventorySku/'.$item->item_id); ?>"> View Detail </a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.deleteConfirmation', function(e){
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
	});
</script>