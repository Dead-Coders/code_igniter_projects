
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daily Expense Tracker || Yearwise Expense Report</title>
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
				<li class="active">Yearwise Expense Report</li>
			</ol>
		</div><!--/.row-->
		
		
				
		
		<div class="row">
			<div class="col-lg-12">
			
				
				
				<div class="panel panel-default">
					<div class="panel-heading">Yearwise Expense Report</div>
					<div class="panel-body">

						<div class="col-md-12">
					

<?php echo form_open('Reports/yearwiserport',['name'=>'expensedqtewiserportds'])?>
								<div class="form-group">
									<label>From Date</label>
		<?php echo form_input(['name'=>'fromdate','id'=>'fromdate','class'=>'form-control','data-date-format'=>'yyyy-mm-dd','value'=>set_value('fromdate')]);?>
<?php echo form_error('fromdate','<div style="color:red">','<div>')?>
								</div>
								<div class="form-group">
									<label style="color:#000">To Date</label>
							<?php echo form_input(['name'=>'todate','id'=>'todate','class'=>'form-control','data-date-format'=>'yyyy-mm-dd','value'=>set_value('todate')]);?>
<?php echo form_error('todate','<div style="color:red">','<div>')?>
								</div>
								
							
								
								<div class="form-group has-success">
							<?php echo form_submit(['name'=>'submit','value'=>'submit','class'=>'btn btn-primary']);?>	
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
          $("#fromdate").datepicker();
          $("#todate").datepicker();
           autoclose: true
});
	</script>
	
</body>
</html>
