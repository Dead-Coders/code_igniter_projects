
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daily Expense Tracker || Change Password</title>
<?php echo link_tag('assets/css/bootstrap.min.css')?>
	<?php echo link_tag('assets/css/datepicker3.css')?>
	<?php echo link_tag('assets/css/styles.css')?>
	<?php echo link_tag('assets/css/font-awesome.min.css')?>
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

</head>
<body>
<?php include APPPATH.'views/includes/header.php';?>
<?php include APPPATH.'views/includes/sidebar.php';?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Change Password</li>
			</ol>
		</div><!--/.row-->
		
		
				
		
		<div class="row">
			<div class="col-lg-12">
			
				
				
				<div class="panel panel-default">
					<div class="panel-heading">Change Password</div>
	<!--success message -->
<?php if($this->session->flashdata('success')){?>
<p style="color:red"><?php  echo $this->session->flashdata('success');?></p>	
<?php } ?>

<!--error message -->
<?php if($this->session->flashdata('error')){?>
<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>	
<?php } ?>				
					<div class="panel-body">

						<div class="col-md-12">

<?php echo form_open('Changepassword',['name'=>'signup']);?>
								<div class="form-group">
									<label>Current Password</label>
<?php echo form_password(['name'=>'currentpassword','id'=>'currentpassword','class'=>'form-control','placeholder'=>'Enter the Password','value'=>set_value('currentpassword')]);?>	
<?php echo form_error('currentpassword','<div style="color:red">','<div>')?>
								</div>
								<div class="form-group">
									<label style="color:#000">New Password</label>
<?php echo form_password(['name'=>'newpassword','id'=>'newpassword','class'=>'form-control','placeholder'=>'Enter the Password','value'=>set_value('newpassword')]);?>	
<?php echo form_error('newpassword','<div style="color:red">','<div>')?>
								</div>
								
								<div class="form-group">
									<label style="color:#000">Confirm Password</label>
	<?php echo form_password(['name'=>'confirmpassword','id'=>'confirmpassword','class'=>'form-control','placeholder'=>'Confirm the Password','value'=>set_value('confirmpassword')]);?>	
<?php echo form_error('confirmpassword','<div style="color:red">','<div>')?>
								</div>
								
								<div class="form-group has-success">
						<?php echo form_submit(['name'=>'submit','id'=>'submit','class'=>'btn btn-primary','value'=>'Change']);?>
								</div>
								
		<?php echo form_close();?>
						</div>
					</div>
				</div><!-- /.panel-->
			</div><!-- /.col-->
<?php include APPPATH.'views/includes/footer.php';?>
		</div><!-- /.row -->
	</div><!--/.main-->
	
<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/chart.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/chart-data.js');?>"></script>
	<script src="<?php echo base_url('assets/js/easypiechart.js');?>"></script>
	<script src="<?php echo base_url('assets/js/easypiechart-data.js');?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js');?>"></script>
	<script src="<?php echo base_url('assets/js/custom.js');?>"></script>
	
</body>
</html>
