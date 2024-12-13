
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daily Expense Tracker || Add Expense</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">

	<?php echo link_tag('assets/css/bootstrap.min.css')?>
	<?php echo link_tag('assets/css/datepicker3.css')?>
	<?php echo link_tag('assets/css/styles.css')?>
	<?php echo link_tag('assets/css/font-awesome.min.css')?>
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
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
				<li class="active">Expense</li>
			</ol>
		</div><!--/.row-->
		
		
				
		
		<div class="row">
			<div class="col-lg-12">
			
				
				
				<div class="panel panel-default">
					<div class="panel-heading">Expense</div>

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
							
<?php echo form_open('Expenses/add',['name'=>'addexpense']);?>

					
								<div class="form-group">
									<label>Date of Expense</label>
	<?php echo form_input(['name'=>'expensedate','id'=>'expensedate','class'=>'form-control','data-date-format'=>'yyyy-mm-dd','value'=>set_value('expensedate')]);?>
	<?php echo form_error('expensedate','<div style="color:red">','<div>');?>
	
								</div>
								<div class="form-group">
									<label style="color:#000">Item</label>
<?php echo form_input(['name'=>'item','id'=>'item','class'=>'form-control','value'=>set_value('item')])?>
<?php echo form_error('item','<div style="color:red">','<div>')?>

								</div>
								
								<div class="form-group">
						<label style="color:#000">Cost of Item</label>
<?php echo form_input(['name'=>'costitem','id'=>'costitem','class'=>'form-control','value'=>set_value('costitem')])?>		
<?php echo form_error('costitem','<div style="color:red">','<div>')?>							
								</div>
																
								<div class="form-group has-success">

<?php echo form_submit(['name'=>'submit','id'=>'submit','class'=>'btn btn-primary','value'=>'Add'])?>	

								</div>
								
								
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
	<script type="text/javascript">
		$(function(){
          $("#expensedate").datepicker();
           autoclose: true;
});
	</script>
	
</body>
</html>
