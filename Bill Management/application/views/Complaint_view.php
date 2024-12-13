<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style type="text/css">
	.ui-autocomplete {
	    max-height: 200px;
	    overflow-y: auto;   /* prevent horizontal scrollbar */
	    overflow-x: hidden; /* add padding to account for vertical scrollbar */
	    z-index:1000 !important;
	}
</style>

<script type="text/javascript">
	var controller='Complaint_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Complaint";


	
	function saveData()
	{	
		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			msgBoxError("Error", "Invalid date...");
			$("#txtDate").focus();
			return;
		}

		customerRowId = $("#lblCustomerId").text();
		customerName = $("#txtCustomerName").val().trim();
		if(customerName == "" || customerRowId == ""  || customerRowId == "-2" )
		{
			msgBoxError("Error", "Invalid customer...");
			// $("#txtCustomerName").focus();
			return;
		}
		mobile1 = $("#txtMobile").val().trim();

		address = $("#txtAddress").val().trim();
		customerRemarks = $("#txtCustomerRemarks").val().trim();
		complaint = $("#txtComplaint").val().trim();
		if(complaint == "" )
		{
			msgBoxError("Error", "Enter complaint...");
			// $("#txtComplaint").focus();
			return;
		}


		if($("#btnSave").text() == "Save")
		{
			if(mobile1 == "" )
			{
				msgBoxError("Error", "Mobile no. can not be blank...");
				return;
			}

			sendSms = $("#chkSendSms").prop("checked");
			sms = $("#txtSms").val();
			// alert(sendSms);
			smsBhejo = "NO";
			if( sendSms == true && sms == "" )
			{
				msgBoxError("Error", "Can not send blank SMS...");
				return;
			}
			if(sendSms == true)
			{
				smsBhejo = "YES";
			}			
			$.ajax({
				'url': base_url + '/' + controller + '/insert',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dt': dt
							, 'customerRowId': customerRowId
							, 'customerName': customerName
							, 'mobile1': mobile1
							, 'address': address
							, 'customerRemarks': customerRemarks
							, 'complaint': complaint
							, 'sms': sms
							, 'smsBhejo': smsBhejo
						},
				'success': function(data)
				{
					if(data == "Duplicate new customer...")
					{
						msgBoxError("Error","Duplicate new customer...Check its rowId");
						$("#txtCustomerName").focus();
					}
					else
					{
						$("#txtComplaint").val("");
						$("#txtSms").val("");
						msgBoxDone("Done","Record saved...");
						setTablePuraneRecords(data['records']);
						if(customerRowId == "-1")
						{
							location.reload();
						}
					}
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
		}
		else if($("#btnSave").text() == "Update")
		{
			// alert("update");
			$.ajax({
					'url': base_url + '/' + controller + '/update',
					'type': 'POST',
					'dataType': 'json',
					'data': {'globalrowid': globalrowid
								, 'dt': dt
								, 'customerRowId': customerRowId
								, 'complaint': complaint
						},
					'success': function(data)
					{
						blankControls();
						// alert(JSON.stringify(data['records']));
						setTablePuraneRecords(data['records']);
						$("#txtDate").val(dateFormat(new Date()));
						msgBoxDone("Done","Record updated...");
						$("#txtCustomerName").prop("disabled", false);
						$("#btnSave").text("Save");
						$("#lblCustomerId").text("-1");
						$("#txtCustomerName").val("");
						$("#spanNewOrOld").text("New");
				  		$("#spanNewOrOld").removeClass("label-success");
				  		$("#spanNewOrOld").addClass("label-danger");
				        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanNewOrOld").animate({opacity: '1'}, 1000);
					},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
		}
	}

	function loadAllRecords()
	{
		// alert(rowId);
		$.ajax({
				'url': base_url + '/' + controller + '/loadAllRecords',
				'type': 'POST',
				'dataType': 'json',
				'success': function(data)
				{
					if(data)
					{
						setTablePuraneRecords(data['records'])
						alertPopup('Records loaded...', 4000);
					}
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
	}

	function loadAllOldRecords()
	{
		// alert(rowId);
		$.ajax({
				'url': base_url + '/' + controller + '/loadAllOldRecords',
				'type': 'POST',
				'dataType': 'json',
				'success': function(data)
				{
					// alert(JSON.stringify(data));
					if(data)
					{
						setTablePuraneRecordsSolved(data['records'])
						alertPopup('Records loaded...', 4000);
					}
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
	}

	function saveSolution()
	{	
		customerRowId = globalCustomerRowId;
		dt = $("#txtDateSolution").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			msgBoxError("Error", "Invalid date...");
			$("#txtDate").focus();
			return;
		}

		complaintRowId = parseFloat(globalComplaintRowId);
		if(complaintRowId <= 0 || isNaN(complaintRowId))
		{
			msgBoxError("Error", "Invalid Customer selection...");
			return;
		}
		solved = $("#cboSolved").val();
		if(solved == "-1")
		{
			msgBoxError("Error", "Select solution: Yes/No");
			return;
		}
		// alert(complaintRowId);
		remarks = $("#txtRemarks").val().trim();
		if(solved == "N" && remarks == "")
		{
			msgBoxError("Error", "Remarks zaruri in case of Problem not solved..");
			return;
		}
		amt = parseFloat( $("#txtServiceCharge").val().trim() );


		sendSms = $("#chkSendSmsSolution").prop("checked");
		sms = $("#txtSmsSolution").val();
		// alert(sendSms);
		smsBhejo = "NO";
		if( sendSms == true && sms == "" )
		{
			msgBoxError("Error", "Can not send blank SMS...");
			return;
		}
		if(sendSms == true)
		{
			smsBhejo = "YES";
		}	

		$.ajax({
			'url': base_url + '/' + controller + '/insertSolution',
			'type': 'POST',
			'dataType': 'json',
			'data': {
						'complaintRowId': complaintRowId
						, 'customerRowId': customerRowId
						, 'dt': dt
						, 'remarks': remarks
						, 'amt': amt
						, 'smsBhejo': smsBhejo
						, 'sms': sms

					},
			'success': function(data)
			{
				$("#cboSolved").val("-1");
				$("#txtServiceCharge").val("0");
				$("#txtRemarks").val("");
				$("#txtSmsSolution").val("");
				$("#lblCharsSolution").text("0");
				msgBoxDone("Done","Solution saved...");
				setTablePuraneRecords(data['records']);
				setTablePuraneRecordsSolved(data['recordsSolved']);
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});
	}
</script>
<div class="container-fluid" style="width: 95%">
	<div class="row" style='margin-top:-40px;'>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-2">
			<?php
				echo "<label style='color: lightgrey; font-weight: normal; margin-top:10px;' id='lblCustomerId'>-2</label>";
			?>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
			<h3 class="text-center" style=''>Complaint</h3>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 text-right">
			<h3 style='font-size: 16pt;' id='lblNewOrOld'><span id='spanNewOrOld' class='label label-danger'>New</span></h3>

		</div> 
	</div>
	 
	<div class="row" style="background-color: #F0F0F0; padding-top: 1px; padding-bottom: 10px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5" style='margin-top: 10px;'>
			<?php
				echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off' placeholder='date'");
          	?>
      	</div>
		<div class="col-lg-9 col-sm-9 col-md-9 col-xs-7" style='margin-top: 10px;'>
			<?php
				echo form_input('txtCustomerName', '', "class='form-control' id='txtCustomerName' style='' maxlength=70 autocomplete='off' placeholder='Customer Name'");
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5" style='margin-top: 10px;'>
			<?php
				echo form_input('txtMobile', '', "class='form-control' id='txtMobile' style='' maxlength=10 autocomplete='off'  placeholder='Mobile No.'");
          	?>
      	</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-7" style='margin-top: 10px;'>
			<?php
				echo form_input('txtAddress', '', "class='form-control' id='txtAddress' style='' maxlength=100 placeholder='Customer Address'");
          	?>
      	</div>
		<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12" style='margin-top: 10px;'>
			<?php
				echo form_input('txtCustomerRemarks', '', "class='form-control' id='txtCustomerRemarks' style='' maxlength=100 autocomplete='off' placeholder='About Customer'");
          	?>
      	</div>
	</div>

	
	<div class="row" style="margin-top: 10px;background-color: #F0F0F0; padding-top:1px;padding-bottom:10px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style='margin-top: 13px;'>
			<?php
				echo "<label style='color: black; font-weight: normal;'>Complaint:</label>";
				echo form_textarea('txtComplaint', '', "class='form-control' style='resize:none;height:100px;' id='txtComplaint'  maxlength=320");
          	?>
      	</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style='margin-top: 10px;'>
			<?php
				echo "<label style='color: black; font-weight: normal;'>SMS: </label>";
				echo "<label id='lblChars' style='color: red; font-weight: normal;'>0</label>";
				echo "&nbsp;&nbsp;&nbsp;<input id='chkSendSms' type='checkbox' checked>Send SMS";
				echo form_textarea('txtSms', '', "class='form-control' style='resize:none;height:100px;' id='txtSms' placeholder='dbl click here to generate SMS' maxlength=320 value=''");
	      	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style='margin-top: 10px;'>
    	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style='margin-top: 10px;'>
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
          	?>
          	<button id="btnSave" class="btn btn-primary btn-block" onclick="saveData();">Save</button>
          	<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
				echo "<input type='button' onclick='checkBal();' value='Check Balance' id='btnCheckBalance' class='btn btn-information col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
			?>
      	</div>

	</div>

	<div class="row" style="display: none1;">
  	</div>

	<div class="row"  style="margin-top: 25px;">
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12" style="margin-top: 10px;">
			<div id="divTableOldRecords" class="divTable tblScroll" style="border:1px solid lightgray; height:350px; overflow:auto;">
				<table class='table table-hover' id='tblOldRecords'>
				 <thead>
					 <tr>
					 	<th  width="50" class="editRecord text-center" style=''>Ed</th>
					 	<th  width="50" class="text-center">Del</th>
						<th>#</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Customer Name</th>
					 	<th>Complaint</th>
					 	<th>SMS</th>
					 	<th>Solved</th>
					 	<th>Address</th>
					 	<th>Mobile</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($records as $row) 
						{
						 	$rowId = $row['complaintRowId'];
						 	$customerRowId=$row['customerRowId'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="deleteRecord text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='width:0px;'>".$row['complaintRowId']."</td>";
						 	$vdt = strtotime($row['complaintDt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
						 	echo "<td>".$row['customerName']."</td>";

						 	echo "<td>".$row['complaint']."</td>";
							echo "<td>".$row['complaintSms']."</td>";				
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
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style="border:1px solid lightgray;margin-top: 10px; padding: 4px 1px;height:350px; overflow:auto;background-color: #f2f2f2;">
			<h4 id="solutionHeading" style="text-align: center;">Solution</h4>
			<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style='margin-top: 10px;'>
				<?php
					echo form_input('txtDateSolution', '', "class='form-control' id='txtDateSolution' style='' maxlength=10 autocomplete='off' placeholder='date'");
	          	?>
	      	</div>
	      	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style='margin-top: 10px;'>
		      	<?php
					$solved = array();
					$solved['-1'] = '--- Solved ---';
					$solved['Y'] = "Yes";
					$solved['N'] = "No";
					echo form_dropdown('cboSolved', $solved, '-1',"class='form-control' id='cboSolved'");
	          	?>
	      	</div>
	      	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style='margin-top: 10px;'>
				<?php
					echo '<input type="number"  step="1" name="txtServiceCharge" value="0" class="form-control" maxlength="15" id="txtServiceCharge"  placeholder="Service Charge"/>';
	          	?>
	      	</div>
	      	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style='margin-top: 20px;'>
				<?php
					echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
					echo form_textarea('txtRemarks', '', "class='form-control' style='resize:none;height:100px;' id='txtRemarks'  maxlength=320");
	          	?>	      	
            </div>
	      	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style='margin-top: 20px;'>
	      		<?php
					echo "<label style='color: black; font-weight: normal;'>SMS: </label>";
					echo "<label id='lblCharsSolution' style='color: red; font-weight: normal;'>0</label>";
					echo "&nbsp;&nbsp;&nbsp;<input id='chkSendSmsSolution' type='checkbox' checked>Send SMS";
					echo form_textarea('txtSmsSolution', '', "class='form-control' style='resize:none;height:100px;' id='txtSmsSolution' placeholder='dbl click here to generate SMS' maxlength=320 value=''");
	      		?>
	      	</div>
	      	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style='margin-top: 20px;'>
	      	</div>
	      	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style='margin-top: 40px;'>
	      		<button id="btnSaveSolution" class="btn btn-danger btn-block" onclick="saveSolution();">Save</button>
	      	</div>
		</div>
	</div>

	<div class="row" style="margin-top:20px;margin-bottom:20px;" >
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<input type='button' onclick='loadAllRecords();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-0">
		</div>
	</div>

	<!-- Solvaed Complaints -->
	<div class="row"  style="margin-top: 25px;">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="margin-top: 10px;">
			<div id="divTableOldRecordsSolved" class="divTable tblScroll" style="border:1px solid lightgray; height:350px; overflow:auto;">
				<table class='table table-hover' id='tblOldRecordsSolved'>
				 <thead>
					 <tr>
						<th>#</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Customer Name</th>
					 	<th>Complaint</th>
					 	<th>SMS</th>
					 	<th>Solved</th>
					 	<th>Sol.Dt.</th>
					 	<th>Amt</th>
					 	<th>Rem.</th>
					 	<th>SMS</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($recordsSolved as $row) 
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
							echo "<td>".$row['complaintSms']."</td>";				
							echo "<td>".$row['solved']."</td>";

						 	$vdt = strtotime($row['solutionDt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";							
						 	echo "<td>".$row['amt']."</td>";
						 	echo "<td>".$row['solutionRemarks']."</td>";
						 	echo "<td>".$row['solutionSms']."</td>";
						 	echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style="margin-top: 10px;">
			<?php
				echo "<input type='button' onclick='loadAllOldRecords();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-0">
		</div>
	</div>	
</div> <!-- CONTAINER CLOSE -->


		<div class="modal" id="myModal" role="dialog">
		    <div class="modal-dialog modal-sm">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">BS</h4>
		        </div>
		        <div class="modal-body">
		          <p>Are you sure <br /> Delete this record..?</p>
		        </div>
		        <div class="modal-footer">
		          <button type="button" onclick="deleteRecord(globalrowid);" class="btn btn-danger" data-dismiss="modal">Yes</button>
		          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		        </div>
		      </div>
		    </div>
		</div>
		  

<script type="text/javascript">


    $(document).ready(function()
    {
		$( "#txtDate" ).datepicker({
			dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
		});
	    // Set the Current Date as Default
		$("#txtDate").val(dateFormat(new Date()));

		$( "#txtDateSolution" ).datepicker({
			dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
		});
	    // Set the Current Date as Default
		$("#txtDateSolution").val(dateFormat(new Date()));

		var smsBalance = '<?php echo $smsBalance;?>';
		$("#btnCheckBalance").val("Check Balance ("+ smsBalance +")");
  	});

    function checkBal()
	{
		$.ajax({
			'url': base_url + '/' + controller + '/checkBal',
			'type': 'POST',
			'data': {'Ta': 'Ta'},
			'success': function(data)
			{
				if(data)
				{
					// alert(data);
					$("#btnCheckBalance").val("Check Balance ("+ data +")");
				}
			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
	}	

	

	var select = false;
    $( "#txtCustomerName" ).focus(function(){ 
	  			select = false; 
	  			// $("#txtAddress").val(select);
	  		});

	$(document).ready( function () 
	{
		select = false;
		var jSonArray = '<?php echo json_encode($customers); ?>';
		// alert(jSonArray);
		var jSonArray = jSonArray.replace(/(\r\n|\n|\r)/gm,", "); ///Multilinse of Address field with comma replce
		var availableTags = $.map(JSON.parse(jSonArray), function(obj){
					return{
							label: obj.customerName,
							customerRowId: obj.customerRowId,
							address: obj.address,
							mobile1: obj.mobile1,
							remarks: obj.remarks,
							remarks2: obj.remarks2
					}
		});

		// var availableTags = ["Gold", "Silver", "Metal"];
		// var select = false;
		// alert(availableTags);
		var remarks2 = "";
	    $( "#txtCustomerName" ).autocomplete({
		      source: availableTags,
		      autoFocus: true,
			  selectFirst: true,
			  open: function(event, ui) { if(select) select=false; },
			  // select: function(event, ui) { select=true; },	
		      minLength: 0,
		      select: function (event, ui) {
		      	select = true;
		      	var selectedObj = ui.item; 
			    // var customerRowId = ui.item.customerRowId;
			    $("#lblCustomerId").text( ui.item.customerRowId );
			    $("#txtMobile").val( ui.item.mobile1 );
			    $("#txtAddress").val( ui.item.address );
			    $("#txtCustomerRemarks").val( ui.item.remarks );
			    remarks2 = ui.item.remarks2;
	        	}
		    }).blur(function() {
				  if( !select ) 
				  {
				  	$("#lblCustomerId").text('-1');
				  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  	if( $("#lblCustomerId").text() == '-1' )
				  	{
				  		$("#spanNewOrOld").text("New");
				  		$("#spanNewOrOld").removeClass("label-success");
				  		$("#spanNewOrOld").addClass("label-danger");
				        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanNewOrOld").animate({opacity: '1'}, 1000);
					    $("#txtMobile").val( '' );
					    $("#txtAddress").val( '' );
					    $("#txtCustomerRemarks").val( '' );

				  	}
				  	else
				  	{
				  		$("#spanNewOrOld").text("Old");
				  		$("#spanNewOrOld").removeClass("label-danger");
				  		$("#spanNewOrOld").addClass("label-success");
				        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanNewOrOld").animate({opacity: '1'}, 1000);
				        if (remarks2 == null)
				        {
				        	
				        }
				        else
				        {
				        	alert(remarks2);
				        }
				  	}
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );
  </script>


  <script type="text/javascript">
	var globalrowid;
	var globalVtype;
	var editFlag = 0;
	$('.deleteRecord').bind('click', delrowid);
	function delrowid(rowid)
	{
		// globalrowid = rowid;
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		globalrowid = $(this).closest('tr').children('td:eq(2)').text();
		// alert(vType);
	}
	function deleteRecord(rowId)
	{
		// alert(globalrowid);
		// return;
		$.ajax({
				'url': base_url + '/' + controller + '/delete',
				'type': 'POST',
				'dataType': 'json',
				'data': {'globalrowid': globalrowid, 'globalVtype': globalVtype
						},
				'success': function(data){
					// alert(data);
					if(data)
					{
						if( data == "yes" )
						{
							alertPopup('Record can not be deleted... Dependent records exist...', 8000);
						}
						else
						{
							setTablePuraneRecords(data['records'])
							alertPopup('Record deleted...', 8000);
						}
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
	}

	function setTablePuraneRecords(records)
	{
		// alert();
		// var totalAdvance = 0;
		// $("#tblOldRecords").find("tr:gt(0)").remove(); //// empty first
		$("#tblOldRecords").empty();
        var table = document.getElementById("tblOldRecords");
        for(i=0; i<records.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);

          var cell = row.insertCell(0);
          cell.innerHTML = "<span class='glyphicon glyphicon-pencil'></span>";
          cell.style.textAlign = "center";
          cell.style.color='lightgray';
          cell.setAttribute("onmouseover", "this.style.color='green', this.style.cursor='pointer'");
          cell.setAttribute("onmouseout", "this.style.color='lightgray'");
          cell.className = "editRecord";
          // cell.style.display="none";

          var cell = row.insertCell(1);
			  cell.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";
          cell.style.textAlign = "center";
          cell.style.color='lightgray';
          cell.setAttribute("onmouseover", "this.style.color='red', this.style.cursor='pointer'");
          cell.setAttribute("onmouseout", "this.style.color='lightgray'");
          cell.setAttribute("onclick", "delrowid(" + records[i].complaintRowId +")");
          // data-toggle="modal" data-target="#myModal"
          cell.setAttribute("data-toggle", "modal");
          cell.setAttribute("data-target", "#myModal");
          cell.className = "deleteRecord";

          var cell = row.insertCell(2);
          cell.innerHTML = records[i].complaintRowId;
          var cell = row.insertCell(3);
          cell.innerHTML = dateFormat(new Date(records[i].complaintDt));
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].customerRowId;
          cell.style.display="none";
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].customerName;
          // cell.style.display="none";
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].complaint;
          var cell = row.insertCell(7);
          cell.innerHTML = records[i].complaintSms;
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].solved;
          var cell = row.insertCell(9);
          cell.innerHTML = records[i].address;
          var cell = row.insertCell(10);
          cell.innerHTML = records[i].mobile1;
	    }

	    $('.editRecord').bind('click', editThis);
	    $('.deleteRecord').bind('click', delrowid);
	    $("#tblOldRecords tr").on("click", highlightRow);
	    $("#tblOldRecords tr").on("click", setSolutionData);

		myDataTable.destroy();
	    myDataTable=$('#tblOldRecords').DataTable({
		    paging: false,
		    ordering: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		});

	}


	function setTablePuraneRecordsSolved(records)
	{
		// alert();
		// var totalAdvance = 0;
		// $("#tblOldRecords").find("tr:gt(0)").remove(); //// empty first
		$("#tblOldRecordsSolved").empty();
        var table = document.getElementById("tblOldRecordsSolved");
        for(i=0; i<records.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);

          var cell = row.insertCell(0);
          cell.innerHTML = records[i].complaintRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = dateFormat(new Date(records[i].complaintDt));
          var cell = row.insertCell(2);
          cell.innerHTML = records[i].customerRowId;
          cell.style.display="none";
          var cell = row.insertCell(3);
          cell.innerHTML = records[i].customerName;
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].complaint;
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].complaintSms;
          // cell.style.display="none";
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].solved;
          var cell = row.insertCell(7);
          cell.innerHTML = dateFormat(new Date(records[i].solutionDt));
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].amt;
          var cell = row.insertCell(9);
          cell.innerHTML = records[i].solutionRemarks;
          var cell = row.insertCell(10);
          cell.innerHTML = records[i].solutionSms;
	    }


		myDataTableSolved.destroy();
	    myDataTableSolved=$('#tblOldRecordsSolved').DataTable({
		    paging: false,
		    // ordering: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		});

	}	


	$('.editRecord').bind('click', editThis);
	function editThis(jhanda)
	{
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		globalrowid = $(this).closest('tr').children('td:eq(2)').text();
		
		$("#txtDate").val( $(this).closest('tr').children('td:eq(3)').text() );
		$("#lblCustomerId").text( $(this).closest('tr').children('td:eq(4)').text() );
		var customerRowId = $(this).closest('tr').children('td:eq(4)').text();
		$("#txtCustomerName").val( $(this).closest('tr').children('td:eq(5)').text() );
		$("#txtComplaint").val( $(this).closest('tr').children('td:eq(6)').text() );
		$("#txtSms").val( "" );

		$("#txtCustomerName").attr("disabled", true);


		$("#spanNewOrOld").text("Old");
  		$("#spanNewOrOld").removeClass("label-danger");
  		$("#spanNewOrOld").addClass("label-success");
        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
        $("#spanNewOrOld").animate({opacity: '1'}, 1000);

		$("#btnSave").text("Update");
	}  

	
  </script>

  <script type="text/javascript">
		$(document).ready( function () {
		    myDataTable = $('#tblOldRecords').DataTable({
			    paging: false,
			    ordering: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});

		    myDataTableSolved = $('#tblOldRecordsSolved').DataTable({
			    paging: false,
			    // ordering: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});
		} );

  </script>

  <script type="text/javascript">
	$(document).ready( function () {
	 //    myDataTableLedger = $('#tbl1').DataTable({
		//     paging: false,
		//     iDisplayLength: -1,
		//     aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		// });
		$("#tblOldRecords tr").on("click", highlightRow);
	} );


	$("#txtSms").on("dblclick", setSms);
	function setSms()
	{
		customerName = $("#txtCustomerName").val().trim();
		sms = "";
		sms += "Dear Customer,";
		sms += "\nYour complaint [" + $("#txtComplaint").val().trim();
		sms += "] is noted. Electrician will be there on given time.";
		sms += "\n-Thanx n Regards,\nSEACO TECH\n1478500000";
		$("#txtSms").val(sms);
		countCharacters();
	}

	globalCustomerName = "";
	globalComplaint = "";
	globalComplaintRowId = -1;
	globalCustomerRowId = -1;	
	$("#tblOldRecords tr").on("click", setSolutionData);
	function setSolutionData()
	{
		globalComplaintRowId = $(this).find("td:eq(2)").text();
		globalCustomerRowId = $(this).find("td:eq(4)").text();
		globalCustomerName = $(this).find("td:eq(5)").text();
		globalComplaint = $(this).find("td:eq(6)").text();
		$("#solutionHeading").html("");
		$("#solutionHeading").html( $("#solutionHeading").text() + "Solution to <span style='color:red;'>" + globalCustomerName + "</span>");
		// alert(globalComplaintRowId + " " + globalCustomerName);
	}

	$("#txtSmsSolution").on("dblclick", setSmsSolution);
	function setSmsSolution()
	{
		customerName = globalCustomerName;
		sms = "";
		sms += "Dear Customer,";
		sms += "\nYour complaint [" + globalComplaint;
		sms += "] is solved. Amt. Rs." + $("#txtServiceCharge").val();
		sms += " received.\nThanx n Regards,\nSEACO TECH\n1478500000";
		$("#txtSmsSolution").val(sms);
		countCharactersSolution();
	}

	$("#txtSms").on("change, keyup", countCharacters);
	function countCharacters()
	{
		// alert($("#txtSms").val().length);
		$("#lblChars").text( $("#txtSms").val().length );
	}

	$("#txtSmsSolution").on("change, keyup", countCharactersSolution);
	function countCharactersSolution()
	{
		// alert($("#txtSms").val().length);
		$("#lblCharsSolution").text( $("#txtSmsSolution").val().length );
	}	
  </script>