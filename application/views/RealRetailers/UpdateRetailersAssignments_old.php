<?php 
require_once(APPPATH.'/views/includes/header.php'); ?>

<div class="container">
	<br>
	<?php if ($feedback = $this->session->flashdata('missing_information')) : ?>
		<div class="alert alert-dismissible alert-danger">
			<strong>Missing Information!</strong> <?= $feedback; ?>
		</div>
	<?php endif; ?>
	<?php $attributes = array('class' => 'form-control', 'id' => 'updateRetailerAssignmentForm');
	echo form_open('RealRetailers/UpdateRetailerAssignemntsOps/'.$RetailersAssignment->employee_id, $attributes); ?>
	<fieldset>
		<legend>Assign Retailers</legend>
		<div class="row">
			<div class="col-md-6">
				<label>Select Employee</label>
				<?php
				foreach ($Employees as $employee) : 
					$options[$employee->employee_id] = $employee->employee_username;
				endforeach; 
				$atts = array( 'class' => 'form-control' );
				echo form_dropdown('employee', $options, $RetailersAssignment->employee_id, $atts); ?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<label>Retailers Added</label>
				<ul style="list-style: none; padding: 0px" id="addedAssignmentsList">
					<?php 
					$RetailersAssignmentsUlListRetIds = explode(",", $RetailersAssignment->retailer_id);
					$RetailersAssignmentsUlListRetNames = explode("<br>", $RetailersAssignment->retailer_names);					
					for($i = 0; $i < sizeof($RetailersAssignmentsUlListRetIds); $i++) : ?>
					<li style="margin-top: 10px">
						<div>
							<input type="text" value="<?= $RetailersAssignmentsUlListRetNames[$i] ?> " class="form-control" style="width: 70%; display: inline; height: 50px" disabled="disabled"><button type="button" class="btn btn-danger removeAddedAssignment" id="<?= $RetailersAssignmentsUlListRetIds[$i]; ?>">Remove</button>
						</div>
					</li>
				<?php endfor; ?>
			</ul>
		</div>
	</div>
	<div class="row">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Retailer Name</th>
					<th>Retailer Address</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($Distributors as $retailer) : ?>
					<tr>
						<td><?= $retailer->retailer_name; ?></td>
						<td><?= $retailer->retailer_address; ?></td>
						<td>
							<input type="number" value="<?= $retailer->id; ?>" hidden>
							<button type="button" class="btn btn-danger addRetailerForAssignment">ADD</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<input type="text" name="retailersForAssignments" value="<?= $RetailersAssignment->retailer_id; ?>" id="retailersForAssignments" hidden>

	<a href="<?= base_url('RealRetailers/ListRetailersAssignments'); ?>">
		<button type="button" id="backFromUpdateRetailersAssignmentsButton" class="btn btn-secondary">Back</button>
	</a>
	&nbsp;
	<button type="button" id="updateRetailersAssignmentsButton" class="btn btn-primary">Update Assignment</button>
</fieldset>
</form>

</div>

<?php require_once(APPPATH.'/views/includes/footer.php'); ?>
<!-- Page level JS -->
<script type="text/javascript" src="<?= base_url('assets/js/Retailers.js').'?v='.time(); ?>"></script>
