<br>
<!--=== Error msg ===-->
<?php 
    if($this->session->flashdata('login_fail'))
    {
        print '<div class= "error-msg">'.$this->session->flashdata('login_fail').'</div>';
    }

    if($this->session->flashdata('no_access'))
    {
        print '<div class= "error-msg">'.$this->session->flashdata('no_access').'</div>';
    }
?>
<div class="row justify-content-center">
	<div class="col-lg-5 col-md-6 col-sm-8">
		<div class="section-title"><i class="fas fa-sign-in-alt"></i> Login Here</div>
		<div class="login-form-area">
			<?= form_open('home/login') ?>
			<div class="form-group">
				<label><b>Email / Username</b></label>
				<?= form_input(['name' => 'email', 'value' => set_value('email'), 'class' => 'form-control']) ?>
				<div class="text-danger"><?= form_error('email')?></div>
			</div>

			<div class="form-group">
				<label><b>Password</b></label>
				<?= form_password(['name' => 'password', 'value' => '', 'class' => 'form-control'])?>
				<div class="text-danger"><?= form_error('password')?></div>
				<small><a href="#" class="text-primary">Forget password</a></small>
			</div>

			<div class="form-group">
				<?= form_submit(['name' => 'submit', 'value' => 'Login', 'class' => 'btn btn-primary login-btn'])?>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div><br>