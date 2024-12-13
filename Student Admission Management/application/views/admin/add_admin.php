<br>
<?php
if($this->session->flashdata('reg_success'))
{
	print '<div class="success-msg">'.$this->session->flashdata('reg_success').'</div>';
}
?>
<div class="row justify-content-center">
	<div class="col-lg-5 col-md-6 col-sm-8">
		<div class="section-title"><i class="fas fa-user-plus"></i> Register here</div>
		<div class="reg-form-area">
			<?= form_open('users/add_admin') ?>
			<div class="form-group">
				<label><b>Name</b></label>
				<?= form_input(['name' => 'admin_name', 'value' => set_value('admin_name'), 'class' => 'form-control']) ?>
				<div class="text-danger"><?= form_error('admin_name')?></div>
			</div>

			<div class="form-group">
				<label><b>Email</b></label>
				<?= form_input(['name' => 'email', 'value' => set_value('email'), 'class' => 'form-control']) ?>
				<div class="text-danger"><?= form_error('email')?></div>
			</div>

			<div class="form-group">
				<label><b>Password</b></label>
				<?= form_password(['name' => 'password', 'value' => '', 'class' => 'form-control'])?>
				<div class="text-danger"><?= form_error('password')?></div>
			</div>

			<div class="form-group">
				<label><b>Confirm Password</b></label>
				<?= form_password(['name' => 'cpassword', 'value' => '', 'class' => 'form-control'])?>
				<div class="text-danger"><?= form_error('cpassword')?></div>
			</div>

			<div class="form-group">
				<?= form_submit(['name' => 'submit', 'value' => 'Register', 'class' => 'btn btn-primary login-btn'])?>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div><br>