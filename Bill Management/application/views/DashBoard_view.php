<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript">
	var controller='DashBoard_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "DashBoard";
</script>

<div class="container-fluid" style="width: 97%">
	<div class="row" style='margin-top: -25px;'>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<a href="<?php  echo base_url();  ?>index.php/RptDues_Controller" target="blank"><h4>Dues List</h4></a>
				<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:250px; overflow:auto;">
					<table class='table table-hover table-condensed table-striped table-bordered' id='tblDues'>
					 <thead>
						 <tr>
							<th style='display:none;'>customerRowid</th>
						 	<th style='display:none1;'>Name</th>
						 	<th style='display:none1;'>Dues</th>
						 	<th style='display:none;'>Receive</th>
						 	<th style='display:none;'>Remarks</th>
						 	<th style='display:none;'></th>
						 	<th style='display:none;'>Mobile</th>
						 </tr>
					 </thead>
					 <tbody>
					 	<?php 
							foreach ($recordsDues as $row) 
							{
							 	$rowId = $row['customerRowId'];
							 	echo "<tr>";						//onClick="editThis(this);
							 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
							 	echo "<td style='display:none1;'>".$row['customerName']."</td>";
							 	echo "<td>".$row['balance']."</td>";
							 	echo "<td style='display:none;'>".$row['balance']."</td>";
							 	echo "<td style='display:none;'>".$row['balance']."</td>";
							 	echo "<td style='display:none;'>".$row['balance']."</td>";
							 	echo "<td style='display:none;'>".$row['balance']."</td>";
								echo "</tr>";
							}
							foreach ($recordsDuesNegative as $row) 
							{
							 	$rowId = $row['customerRowId'];
							 	echo "<tr>";						//onClick="editThis(this);
							 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
							 	echo "<td style='display:none1;color:red;'>".$row['customerName']."</td>";
							 	echo "<td style='display:none1;color:red;'>".$row['balance']."</td>";
							 	echo "<td style='display:none;'>".$row['balance']."</td>";
							 	echo "<td style='display:none;'>".$row['balance']."</td>";
							 	echo "<td style='display:none;'>".$row['balance']."</td>";
							 	echo "<td style='display:none;'>".$row['balance']."</td>";
								echo "</tr>";
							}
						 ?>
					 </tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<a href="<?php  echo base_url();  ?>index.php/Reminders_Controller" target="blank"><h4>Notifications/Reminders</h4></a>
				<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:250px; overflow:auto;">
					<table class='table table-hover table-condensed table-striped table-bordered' id='tblReminders'>
					 <thead>
						 <tr>
							<th style='display:none;'>Rowid</th>
						 	<th style='display:none1;'>Date</th>
						 	<th style='display:none1;'>Reminder</th>
						 	<th style='display:none1;'>Repeat</th>
						 	<th style='display:none1;'>Type</th>
						 </tr>
					 </thead>
					 <tbody>
					 	<?php 
							foreach ($notifications as $row) 
							{
							 	$rowId = $row['rowId'];
							 	echo "<tr>";						//onClick="editThis(this);
							 	echo "<td style='display:none;'>".$row['rowId']."</td>";
							 	$vdt = strtotime($row['dt']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
							 	echo "<td>".$row['remarks']."</td>";
							 	echo "<td style='display:none1;'>".$row['repeat']."</td>";
							 	echo "<td style='display:none1;'>".$row['notificationType']."</td>";
								echo "</tr>";
							}
						 ?>
					 </tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<a href="<?php  echo base_url();  ?>index.php/Complaint_Controller" target="blank"><h4>Complaints</h4></a>
				<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:250px; overflow:auto;">
					<table class='table table-hover table-condensed table-striped table-bordered' id='tblComplaints'>
					 <thead>
						 <tr>
							<th>#</th>
						 	<th>Date</th>
						 	<th style='display:none;'>customerRowId</th>
						 	<th>Customer</th>
						 	<th>Complaint</th>
						 	<th>Solved</th>
						 	<th>Address</th>
						 	<th>Contact</th>
						 </tr>
					 </thead>
					 <tbody>
					 	<?php 
							foreach ($complaints as $row) 
							{
							 	$rowId = $row['complaintRowId'];
							 	$customerRowId=$row['customerRowId'];
							 	echo "<tr>";						//onClick="editThis(this);
							 	echo "<td style='width:0px;'>".$row['complaintRowId']."</td>";
							 	$vdt = strtotime($row['complaintDt']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
							 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
							 	echo "<td>".$row['customerName']."</td>";
							 	echo "<td>".$row['complaint']."</td>";
								echo "<td>".$row['solved']."</td>";
								echo "<td>".$row['address']."</td>";
								echo "<td>".$row['mobile1']."</td>";
								echo "</tr>";
							}
						 ?>
					 </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<hr/>
	<div class="row" style='margin-top: -1px;'>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<a href="<?php  echo base_url();  ?>index.php/Replacement_Controller" target="blank"><h4>Replacements</h4></a>
				<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:250px; overflow:auto;">
					<table class='table table-hover table-condensed table-striped table-bordered' id='tblReplacements'>
					 <thead>
						 <tr>
							<th style='display:none;'>rowid</th>
						 	<th>Date</th>
						 	<th style='display:none;'>ItemRowId</th>
						 	<th>Item</th>
						 	<th style='display:none;'>PartyRowId</th>
						 	<th>Party</th>
						 	<th>Qty</th>
						 	<th>Remarks</th>
						 	<th>Sent</th>
						 	<th>SentDt</th>
						 	<th>Recd</th>
						 	
						 </tr>
					 </thead>
					 <tbody>
					 	<?php 
							foreach ($replacements as $row) 
							{
							 	$rowId = $row['replacementRowId'];
							 	echo "<tr>";
							 	echo "<td style='display:none;'>".$row['replacementRowId']."</td>";
							 	$vdt = strtotime($row['dt']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
							 	echo "<td style='display:none;'>".$row['itemRowId']."</td>";
							 	echo "<td>".$row['itemName']."</td>";
							 	echo "<td style='display:none;'>".$row['partyRowId']."</td>";
							 	echo "<td>".$row['partyName']."</td>";
							 	echo "<td>".$row['qty']."</td>";
							 	echo "<td>".$row['remarks']."</td>";
							 	echo "<td style='color: red;'>".$row['sent']."</td>";
							 	if ($row['sentDt'] == "")
							 	{
							 		echo "<td></td>";
							 	}
							 	else
							 	{
							 		$vdt = strtotime($row['sentDt']);
									$vdt = date('d-M-Y', $vdt);
								 	echo "<td>".$vdt."</td>";
							 	}
							 	
								echo "</tr>";
							}
						 ?>
					 </tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<a href="<?php  echo base_url();  ?>index.php/Requirement_Controller" target="blank"><h4>Requirements</h4></a>
				<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:250px; overflow:auto;">
					<table class='table table-hover table-condensed table-striped table-bordered' id='tblRequirements'>
					 <thead>
						 <tr>
							<th style='width:0px;display:none;'>rowid</th>
						 	<th style="display: none;">ItemRowId</th>
						 	<th>Item Name</th>
						 	<th>Last Rate (Per Pc.)</th>
						 	<th>From</th>
						 	<th>Date</th>
						 </tr>
					 </thead>
					 <tbody>
					 	<?php 
							foreach ($requirements as $row) 
							{
							 	$rowId = $row['rowId'];
							 	echo "<tr>";					
							 	echo "<td style='width:0px;display:none;'>".$row['rowId']."</td>";
							 	echo "<td style='display: none;'>".$row['itemRowId']."</td>";
							 	echo "<td>".$row['itemName']."<span style='color:green;'> [" . $row['remarks']."]</span><span style='color:blue;'> [" . $row['qty']."]</span></td>";
							 	echo "<td>".$row['lastPurchasePrice']."</td>";
							 	echo "<td>".$row['lastPurchaseFrom']."</td>";
							 	if($row['lastPurchaseDate'] == null)
							 	{
							 		echo "<td></td>";
							 	}
							 	else
							 	{
								 	$vdt = strtotime($row['lastPurchaseDate']);
									$vdt = date('d-M-Y', $vdt);
								 	echo "<td>".$vdt."</td>";
								 }
								echo "</tr>";
							}
						 ?>
					 </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#tblDues tr").on("click", highlightRowAlag);
		$("#tblReminders tr").on("click", highlightRowAlag);
		$("#tblComplaints tr").on("click", highlightRowAlag);
		$("#tblReplacements tr").on("click", highlightRowAlag);
		$("#tblRequirements tr").on("click", highlightRowAlag);
	});
</script>


