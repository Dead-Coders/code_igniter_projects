
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daily Expense Tracker - Login</title>
	<?php echo link_tag('assets/css/bootstrap.min.css')?>
	<?php echo link_tag('assets/css/datepicker3.css')?>
	<?php echo link_tag('assets/css/styles.css')?>

	
</head>
<body>

	<div class="row">
			<h2 align="center">Daily Expense Tracker</h2>
	<hr />
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">User Log in</div>
				<div class="panel-body">
					<p style="font-size:16px; color:red" align="center">  </p>
			
<?php
if($this->session->flashdata('error')){ ?>
<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>	
<?php } ?>

<?php echo form_open('login',['name'=>'login']);?>

						<fieldset>
							<div class="form-group">
						
<?php echo form_input(['name'=>'email','id'=>'email','class'=>'form-control','placeholder'=>'Enter  registered email id','value'=>set_value('email')]);?>
<?php echo form_error('email','<div style="color:red">','<div>')?>
							</div>
		<a href="<?php echo site_url('Resetpassword');?>">Forgot Password?</a>
							<div class="form-group">
							
<?php echo form_password(['name'=>'password','id'=>'password','class'=>'form-control','placeholder'=>'Enter the Password','value'=>set_value('password')]);?>
<?php echo form_error('password','<div style="color:red">','<div>')?>	

							</div>
							<div class="checkbox">

<?php echo form_submit(['name'=>'login','id'=>'login','class'=>'btn btn-primary','value'=>'login']);?>	
								
									<hr />
							<p style="color:blue">Not registered yet ? 
								<a href="<?php echo site_url('Signup');?>"> Rgistere Here</a></p>
							</div>
							</fieldset>
					<?php echo form_close();?>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	

<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>

</body>
</html>
