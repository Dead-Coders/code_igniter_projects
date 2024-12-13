<div class="row">
<?php $this->load->view('alert') ?>
	<div class="col-md-3"></div>

	<div class="col-md-6">
	
		<form action="<?=site_url('authentication') ?>" method="POST" role="form">
			<legend class="text-center">Login Panel</legend>
		
			<div class="form-group">
				<label for="">Email :</label>
				<input type="email" class="form-control rounded-0" id="" placeholder="" name="email">
			</div>

			<div class="form-group">
				<label for="">Password :</label>
				<input type="password" class="form-control rounded-0" id="" name="password">
			</div>
			<div class="text-right">
				<button type="submit" class="btn btn-primary" style="border-radius:0%;">Login</button>
			</div>
		</form>

	
	</div>

	<div class="col-md-3"></div>
</div>