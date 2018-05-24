<?php require_once(APPPATH.'/views/includes/header.php'); ?>

<div class="container">
	<hr>
	<a href="<?= base_url('Dashboard');?>">
		<button type="button" class="btn btn-primary">Dashboard</button>
	</a>
	<a href="<?= base_url('Bulletins/AddMessage');?>">
		<button type="button" class="btn btn-success">CREATE NEW MESSAGE</button>
	</a>
	<hr>
	<?php if ($feedback = $this->session->flashdata('message_added')) : ?>
		<div class="alert alert-dismissible alert-success">
			<strong>Sent</strong> <?= $feedback; ?>
		</div>
	<?php endif; ?>
	<?php if ($feedback = $this->session->flashdata('message_add_failed')) : ?>
		<div class="alert alert-dismissible alert-danger">
			<strong>Failed</strong> <?= $feedback; ?>
		</div>
	<?php endif; ?>
	<?php if ($feedback = $this->session->flashdata('message_updated')) : ?>
		<div class="alert alert-dismissible alert-success">
			<strong>Updated</strong> <?= $feedback; ?>
		</div>
	<?php endif; ?>
	<?php if ($feedback = $this->session->flashdata('message_update_failed')) : ?>
		<div class="alert alert-dismissible alert-danger">
			<strong>Failed</strong> <?= $feedback; ?>
		</div>
	<?php endif; ?>
	<?php if ($feedback = $this->session->flashdata('message_deleted')) : ?>
		<div class="alert alert-dismissible alert-success">
			<strong>Deleted</strong> <?= $feedback; ?>
		</div>
	<?php endif; ?>
	<?php if ($feedback = $this->session->flashdata('message_delete_failed')) : ?>
		<div class="alert alert-dismissible alert-danger">
			<strong>Failed</strong> <?= $feedback; ?>
		</div>
	<?php endif; ?>
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Message</th>
				<th>Group</th>
				<th>Individual</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php $sno = 1; foreach ($messages as $message) : ?>
			<tr>
				<td><?= $sno++; ?></td>
				<td><?= $message->message; ?></td>
				<td><?= $message->group_name ? $message->group_name : 'NA' ?></td>
				<td><?= $message->employee ? $message->employee : 'NA' ?></td>
				<td>
					<a href="<?= base_url('Bulletins/UpdateMessage/'.$message->id); ?>">
						<button class="btn btn-sm btn-secondary">Update</button>
					</a>
					&nbsp;
					<a href="<?= base_url('Bulletins/DeleteMessage/'.$message->id); ?>">
						<button class="btn btn-sm btn-danger">Delete</button>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>

<?php require_once(APPPATH.'/views/includes/footer.php'); ?>