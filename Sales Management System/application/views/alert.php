<?php  if($this->session->flashdata(ERROR) != ''): ?>
	<div class="alert alert-danger">
		<strong>Message:</strong><br/>
		<p><?=$this->session->flashdata(ERROR) ?></p>
	</div>
<?php endif; ?>

<?php  if($this->session->flashdata(SUCCESS) != ''): ?>
	<div class="alert alert-success">
		<strong>Message:</strong><br/>
		<p><?=$this->session->flashdata(SUCCESS) ?></p>
	</div>
<?php endif; ?>

<?php  if(validation_errors()): ?>
	<div class="alert alert-info">
		<strong>Message:</strong><br/>
		<p><?=validation_errors() ?></p>
	</div>
<?php endif; ?>

<?php $this->session->unset_userdata(ERROR) ?>
<?php $this->session->unset_userdata(SUCCESS) ?>