<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='RptReminders2_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Rpt Reminders";


</script>
<div class="container">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Reminders (Alarms)</h3>
			<h4 class="text-center" style='margin-top:10px; color:red;'>For: <?php echo date('d-m-Y') ?></h4>
		</div>
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:400px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='width:0px;display:none;'>rowid</th>
					 	<th>Date</th>
					 	<th>Remarks</th>
					 	<th>Repeat</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($recordsOnce as $row) 
						{
						 	$rowId = $row['reminderRowId'];
						 	echo "<tr>";						
						 	echo "<td style='width:0px;display:none;'>".$row['reminderRowId']."</td>";
						 	$vdt = strtotime($row['dt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	echo "<td>".substr($row['repeat'],0,1)."</td>";
							echo "</tr>";
						}

						foreach ($recordsWeekly as $row) 
						{
						 	$rowId = $row['reminderRowId'];
						 	echo "<tr>";						
						 	echo "<td style='width:0px;display:none;'>".$row['reminderRowId']."</td>";
						 	$vdt = strtotime($row['dt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	echo "<td>".substr($row['repeat'],0,1)."</td>";
							echo "</tr>";
						}

						foreach ($recordsMonthly as $row) 
						{
						 	$rowId = $row['reminderRowId'];
						 	echo "<tr>";						
						 	echo "<td style='width:0px;display:none;'>".$row['reminderRowId']."</td>";
						 	$vdt = strtotime($row['dt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	echo "<td>".substr($row['repeat'],0,1)."</td>";
							echo "</tr>";
						}

						foreach ($recordsYearly as $row) 
						{
						 	$rowId = $row['reminderRowId'];
						 	echo "<tr>";						
						 	echo "<td style='width:0px;display:none;'>".$row['reminderRowId']."</td>";
						 	$vdt = strtotime($row['dt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	echo "<td>".substr($row['repeat'],0,1)."</td>";
							echo "</tr>";
						}
						// echo date('l');
					 ?>
				 </tbody>
				</table>
			</div>
		</div>

		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>
</div>



<script type="text/javascript">


	$(document).ready( function () {
	    myDataTable = $('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		});
	} );


</script>