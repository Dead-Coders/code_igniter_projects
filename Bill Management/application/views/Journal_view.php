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
	var controller='Journal_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Journal";


	
	function saveData()
	{	
		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#txtDate").focus();
			return;
		}

		paidByRowId = $("#lblPaidBy").text();
		paidByName = $("#txtPaidBy").val().trim();
		if(paidByName == "" || paidByRowId == ""  || paidByRowId == "-2" )
		{
			msgBoxError("Error", "Invalid paid by party...");
			return;
		}

		receivedByRowId = $("#lblReceivedBy").text();
		receivedByName = $("#txtReceivedBy").val().trim();
		if(receivedByName == "" || receivedByRowId == ""  || receivedByRowId == "-2" )
		{
			msgBoxError("Error", "Invalid received by party...");
			return;
		}		

		amt = parseFloat($("#txtAmt").val());
		remarks = $("#txtRemarks").val().trim();
		if(remarks == "" )
		{
			msgBoxError("Error", "Enter remarks...");
			return;
		}

		// alert();
		// ///////For ledger
		// var date = new Date();
		// var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
		// dtFrom = dateFormat(firstDay);
		// $("#dtFrom").val(dateFormat(firstDay));
  // 		// var dtFrom = $("#dt").val();
  // 		var dtTo = $("#txtDate").val();
  // 		$("#dtTo").val( $("#txtDate").val() );
  // 		$("#cboCustomer4Ledger").val(customerRowId);
  // 		///////END - For ledger


		if($("#btnSave").text() == "Save")
		{
			// alert();
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								'dt': dt
								, 'paidByRowId': paidByRowId
								, 'paidByName': paidByName
								, 'receivedByRowId': receivedByRowId
								, 'receivedByName': receivedByName
								, 'amt': amt
								, 'remarks': remarks
							},
					'success': function(data)
					{
						// alert();
						if(data == "Duplicate new paid by account...")
						{
							msgBoxError("Error", "Duplicate new paid by account...Check its rowId");
							// $("#txtPaidBy").focus();
						}
						else if(data == "Duplicate new received by account...")
						{
							msgBoxError("Error", "Duplicate new received by account...Check its rowId");
							// $("#txtPaidBy").focus();
						}
						else
						{
							// alert();
							$("#txtAmt").val("0");
							$("#txtRemarks").val("");
							// $("#cboMode").val("-1");
							// funInWords();
							// $("#txtPaidBy").focus();
							// $("#txtAmt").focus();
							alertPopup("Record saved...", 8000);
							setTablePuraneReceipt(data['records']);
							if(paidByRowId > 0 && receivedByRowId > 0)
							{
								// setLedgerTable(data['opBal'], data['records4Ledger']);
							}
							if(paidByRowId == "-1" || receivedByRowId == "-1" )
							{
								location.reload();
							}
						}
					},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
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
						setTablePuraneReceipt(data['records'])
						alertPopup('Records loaded...', 4000);
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
	}
</script>
<div class="container">
	<div class="row" style='margin-top:-40px;'>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-2">
			<?php
				echo "<label style='color: lightgrey; font-weight: normal; margin-top:10px;' id='lblPaidBy'>-2</label>";

				echo "<label style='color: lightgrey; font-weight: normal; margin-top:10px;' id='lblComma'>,</label>";
				echo "<label style='color: lightgrey; font-weight: normal; margin-top:10px;' id='lblReceivedBy'>-2</label>";
			?>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
			<h4 class="text-center" style=''>Journal</h4>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 text-right">
			<h3 style='font-size: 16pt; display: inline-block;' id='lblPaidByNewOrOld'><span id='spanPaidByNewOrOld' class='label label-danger'>New</span></h3>
			<h3 style='font-size: 16pt; display: inline-block;' id='lblReceivedByNewOrOld'><span id='spanReceivedByNewOrOld' class='label label-danger'>New</span></h3>

		</div> 
	</div>
	 
	<div class="row" style="background-color: #F0F0F0; padding-top: 1px; padding-bottom: 10px;" >
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style='margin-top: 10px;'>
			<?php
				echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off' placeholder='date'");
          	?>
      	</div>
		<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12" style='margin-top: 10px;'>
			<?php
				echo form_input('txtPaidBy', '', "class='form-control' id='txtPaidBy' style='' maxlength=70 autocomplete='off' placeholder='Paid By'");
          	?>
      	</div>
		<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12" style='margin-top: 10px;'>
			<?php
				echo form_input('txtReceivedBy', '', "class='form-control' id='txtReceivedBy' style='' maxlength=70 autocomplete='off' placeholder='Received By'");
          	?>
      	</div>

	</div>

	
	<div class="row" style="margin-top: 10px;background-color: #C0C0F0; padding-top:1px;padding-bottom:10px;">
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style='margin-top: 10px;'>
			<?php
				echo '<input type="number"  step="1" name="txtAmt" value="0" class="form-control" maxlength="15" id="txtAmt"  placeholder="Amt."/>';
          	?>
      	</div>
		<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12" style='margin-top: 10px;'>
			<?php
				echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' style='' maxlength=100 autocomplete='on' placeholder='Remarks'");
          	?>
      	</div>
      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style='margin-top: 10px;'>
      	</div>

		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style='margin-top: 10px;'>
          	<button id="btnSave" class="btn btn-primary btn-block" onclick="saveData();">Save</button>
      	</div>

	</div>

	<div class="row" style="display: none1;">
  	</div>

	<div class="row"  style="margin-top: 25px;">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="margin-top: 10px;">
			<div id="divTableOldDb" class="divTable tblScroll" style="border:1px solid lightgray; height:450px; overflow:auto;">
				<table class='table table-hover' id='tblOldReceipts'>
				 <thead>
					 <tr>
					 	<th  width="50" class="editRecord text-center" style=''>Ed</th>
					 	<th  width="50" class="text-center">Del</th>
						<th>VT</th>
						<th>V#</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Customer Name</th>
					 	<th>Amt</th>
					 	<th>Remarks</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($records as $row) 
						{
							if($row['amt']>0)
							{
								$f = "RB";
							}
							else
							{
								$f = "PB";
							}
						 	$rowId = $row['refRowId'];
						 	$customerRowId=$row['customerRowId'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center">'.$f.'</td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="deleteRecord text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='width:0px;'>".$row['vType']."</td>";
						 	echo "<td style='width:0px;'>".$row['refRowId']."</td>";
						 	$vdt = strtotime($row['refDt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
						 	echo "<td><a id='contraac' href='#' onClick='loadLedger($customerRowId);'>".$row['customerName']."</a></td>";
						 	if( $row['amt'] > 0)
						 	{
						 		echo "<td>".$row['amt']."</td>";
						 	}
						 	else if( $row['recd'] > 0 )
						 	{
						 		echo "<td>".$row['recd']."</td>";
						 	}
							echo "<td>".$row['remarks']."</td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="border:1px solid lightgray;margin-top: 10px; padding: 4px 10px;height:450px; overflow:auto;background-color: #f2f2f2;">
			<div class="row">
			<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
			</div>
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
					<div class="row" style="margin-top:5px;">
						<h4 style="text-align: center;">Ledger</h4>
						<div class="col-lg-3 col-sm-3 col-md-3 col-xs-6" style='margin-top: 10px;'>
							<?php
								echo form_input('dtFrom', '', "class='form-control' placeholder='' id='dtFrom' maxlength='10'");
			              	?>
			              	<script>
								$( "#dtFrom" ).datepicker({
									dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
								});
								// Set the 1st of this month
								var date = new Date();
								var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
								$("#dtFrom").val(dateFormat(firstDay));
							</script>					
			          	</div>
			          	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-6" style='margin-top: 10px;'>
							<?php
								echo form_input('dtTo', '', "class='form-control' placeholder='' id='dtTo' maxlength='10'");
			              	?>
			              	<script>
								$( "#dtTo" ).datepicker({
									dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
								});
							    // Set the Current Date as Default
								$("#dtTo").val(dateFormat(new Date()));
							</script>					
			          	</div>
						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-6" style='margin-top: 10px;'>
							<?php
								echo form_dropdown('cboCustomer4Ledger',$customers4Ledger, '-1',"class='form-control' id='cboCustomer4Ledger'");
			              	?>
			          	</div>
						<div class="col-lg-2 col-sm-2 col-md-2 col-xs-6" style='margin-top: 10px;'>
							<?php
								echo "<input type='button' onclick='loadLedgerData();' value='Show' id='btnShow' class='btn btn-danger form-control'>";
			              	?>
			          	</div>
						<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
							<?php
								echo "<label style='color: black; font-weight: normal;'>Difference:</label>";
								echo form_input('txtDiff', '', "class='form-control' placeholder='' id='txtDiff' maxlength='10' disabled='yes'");
				          	?>
						</div>
						<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
							<?php
								echo "<label style='color: black; font-weight: normal;'>Range Difference:</label>";
								echo form_input('txtRangeDiff', '', "class='form-control' placeholder='' id='txtRangeDiff' maxlength='10' disabled='yes'");
				          	?>
						</div>
					</div>
				</form>
			</div>
			<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
			</div>
			</div>


			<div class="row" style="margin-top:10px;" >
				<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:250px; overflow:auto;">
						<table class='table table-hover' id='tbl1'>
						 <thead>
							 <tr>
								<th style='display:none;'>ledgerRowid</th>
							 	<th style='display:none1;'>V.Type</th>
							 	<th style='display:none1;'>Rem</th>
							 	<th>Dt</th>
							 	<th style='display:none;'>For What</th>
							 	<th>Recd.</th>
							 	<th>Paid</th>
							 	<th>Bal.</th>
							 </tr>
						 </thead>
						 <tbody>

						 </tbody>
						</table>
					</div>
				</div>

				<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
				</div>
			</div>

			<div class="row" style="margin-top:0px;" >
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				</div>
				<!-- <div class="col-lg-1 col-sm-1 col-md-1 col-xs-0">
				</div> -->

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
	$(document).ready( function () 
	{
		$( "#txtDate" ).datepicker({
			dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
		});
	    // Set the Current Date as Default
		$("#txtDate").val(dateFormat(new Date()));
	});


	

	var select = false;
    $( "#txtPaidBy" ).focus(function(){ 
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
							remarks: obj.remarks
					}
		});

		// var availableTags = ["Gold", "Silver", "Metal"];
		// var select = false;
		// alert(availableTags);
	    $( "#txtPaidBy" ).autocomplete({
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
			    $("#lblPaidBy").text( ui.item.customerRowId );
			    // $("#txtMobile").val( ui.item.mobile1 );
			    // $("#txtAddress").val( ui.item.address );
			    // $("#txtCustomerRemarks").val( ui.item.remarks );
	        	}
		    }).blur(function() {
				  if( !select ) 
				  {
				  	$("#lblPaidBy").text('-1');
				  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  	if( $("#lblPaidBy").text() == '-1' )
				  	{
				  		$("#spanPaidByNewOrOld").text("New");
				  		$("#spanPaidByNewOrOld").removeClass("label-success");
				  		$("#spanPaidByNewOrOld").addClass("label-danger");
				        $("#spanPaidByNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanPaidByNewOrOld").animate({opacity: '1'}, 1000);
					    // $("#txtMobile").val( '' );
					    // $("#txtAddress").val( '' );
					    // $("#txtCustomerRemarks").val( '' );

				  	}
				  	else
				  	{
				  		$("#spanPaidByNewOrOld").text("Old");
				  		$("#spanPaidByNewOrOld").removeClass("label-danger");
				  		$("#spanPaidByNewOrOld").addClass("label-success");
				        $("#spanPaidByNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanPaidByNewOrOld").animate({opacity: '1'}, 1000);
				  	}
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );

	////// Binding Names for Receiving Party
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
							remarks: obj.remarks
					}
		});

		// var availableTags = ["Gold", "Silver", "Metal"];
		// var select = false;
		// alert(availableTags);
	    $( "#txtReceivedBy" ).autocomplete({
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
			    $("#lblReceivedBy").text( ui.item.customerRowId );
			    // $("#txtMobile").val( ui.item.mobile1 );
			    // $("#txtAddress").val( ui.item.address );
			    // $("#txtCustomerRemarks").val( ui.item.remarks );
	        	}
		    }).blur(function() {
				  if( !select ) 
				  {
				  	$("#lblReceivedBy").text('-1');
				  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  	if( $("#lblReceivedBy").text() == '-1' )
				  	{
				  		$("#spanReceivedByNewOrOld").text("New");
				  		$("#spanReceivedByNewOrOld").removeClass("label-success");
				  		$("#spanReceivedByNewOrOld").addClass("label-danger");
				        $("#spanReceivedByNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanReceivedByNewOrOld").animate({opacity: '1'}, 1000);
					    // $("#txtMobile").val( '' );
					    // $("#txtAddress").val( '' );
					    // $("#txtCustomerRemarks").val( '' );

				  	}
				  	else
				  	{
				  		$("#spanReceivedByNewOrOld").text("Old");
				  		$("#spanReceivedByNewOrOld").removeClass("label-danger");
				  		$("#spanReceivedByNewOrOld").addClass("label-success");
				        $("#spanReceivedByNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanReceivedByNewOrOld").animate({opacity: '1'}, 1000);
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
		globalrowid = $(this).closest('tr').children('td:eq(3)').text();
		globalVtype = $(this).closest('tr').children('td:eq(2)').text();
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
							setTablePuraneReceipt(data['records'])
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

	function setTablePuraneReceipt(records)
	{
		// alert();
		// var totalAdvance = 0;
		// $("#tblOldReceipts").find("tr:gt(0)").remove(); //// empty first
		$("#tblOldReceipts").empty();
        var table = document.getElementById("tblOldReceipts");
        for(i=0; i<records.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);

          flagGR = "";
          if( records[i].amt > 0)
		  {
          	flagGR = "RB";
          }
          else
          {
          	flagGR = "PB";
          }
          var cell = row.insertCell(0);
          cell.innerHTML = flagGR;
          cell.style.textAlign = "center";

          var cell = row.insertCell(1);
			  cell.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";
          cell.style.textAlign = "center";
          cell.style.color='lightgray';
          cell.setAttribute("onmouseover", "this.style.color='red', this.style.cursor='pointer'");
          cell.setAttribute("onmouseout", "this.style.color='lightgray'");
          cell.setAttribute("onclick", "delrowid(" + records[i].refRowId +")");
          // data-toggle="modal" data-target="#myModal"
          cell.setAttribute("data-toggle", "modal");
          cell.setAttribute("data-target", "#myModal");
          cell.className = "deleteRecord";

          var cell = row.insertCell(2);
          cell.innerHTML = records[i].vType;
          var cell = row.insertCell(3);
          cell.innerHTML = records[i].refRowId;
          var cell = row.insertCell(4);
          cell.innerHTML = dateFormat(new Date(records[i].refDt));
          // cell.style.display="none";
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].customerRowId;
          cell.style.display="none";
          var cell = row.insertCell(6);
          cell.innerHTML = "<a id='contraac' href='#' onClick='loadLedger("+records[i].customerRowId+");'>" + records[i].customerName + "</a>";
          var cell = row.insertCell(7);
          if( records[i].amt > 0)
		  {
          	cell.innerHTML = records[i].amt;
          }
          else
          {
          	cell.innerHTML = records[i].recd;
          }
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].remarks;
	    }

	    $('.editRecord').bind('click', editThis);
	    $('.deleteRecord').bind('click', delrowid);

		myDataTable.destroy();
	    myDataTable=$('#tblOldReceipts').DataTable({
		    paging: false,
		    ordering: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

		});
	}

	


	$('.editRecord').bind('click', editThis);
	function editThis(jhanda)
	{
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		globalrowid = $(this).closest('tr').children('td:eq(3)').text();
		
		$("#txtDate").val( $(this).closest('tr').children('td:eq(4)').text() );
		$("#lblPaidBy").text( $(this).closest('tr').children('td:eq(5)').text() );
		var customerRowId = $(this).closest('tr').children('td:eq(5)').text();
		$("#txtPaidBy").val( $(this).closest('tr').children('td:eq(6)').text() );
		$("#txtAmt").val( $(this).closest('tr').children('td:eq(7)').text() );
		$("#txtRemarks").val( $(this).closest('tr').children('td:eq(8)').text() );
		if( $(this).closest('tr').children('td:eq(2)').text() == "P" )
		{
			$("#cboMode").val("Payment");
		}
		else
		{
			$("#cboMode").val("Received");
		}
		$("#txtPaidBy").prop("disabled", true);


      	$.ajax({
			'url': base_url + '/' + controller + '/showDetailOnUpdate',
			'type': 'POST', 
			'data':{ 'globalrowid':globalrowid
						, 'customerRowId':customerRowId
					},
			'dataType': 'json',
			'success':function(data)
			{
				// alert(JSON.stringify(data['customerInfo']));
			    ////Setting Customer Info
			    $("#txtMobile").val( data['customerInfo'][0].mobile1 );
			    $("#txtAddress").val( data['customerInfo'][0].address );
			    $("#txtCustomerRemarks").val( data['customerInfo'][0].remarks );


			  	var netInWords = number2text( parseFloat( $("#txtAmt").val() ) ) ;
			  	$("#txtWords").val( netInWords );

			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});

		$("#spanPaidByNewOrOld").text("Old");
  		$("#spanPaidByNewOrOld").removeClass("label-danger");
  		$("#spanPaidByNewOrOld").addClass("label-success");
        $("#spanPaidByNewOrOld").animate({opacity: '0.2'}, 1000);
        $("#spanPaidByNewOrOld").animate({opacity: '1'}, 1000);

		$("#btnSave").text("Update");
	}  

	function loadLedger(customerRowId)
	{
		// url = base_url + '/RptLedger_Controller/index/'+customerRowId
		// var win = window.open(url, '_blank');
  // 		win.focus();
  		var date = new Date();
		var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
		dtFrom = dateFormat(firstDay);
		$("#dtFrom").val(dateFormat(firstDay));
  		// var dtFrom = $("#dt").val();
  		var dtTo = $("#txtDate").val();
  		$("#dtTo").val( $("#txtDate").val() );
  		$("#cboCustomer4Ledger").val(customerRowId);

  		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'customerRowId': customerRowId
							, 'dtFrom': dtFrom
							, 'dtTo': dtTo
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
						setLedgerTable(data['opBal'], data['records']) 
						$('html, body').animate({
					        scrollTop: $("#btnLoadAll").offset().top
					    }, 2000);
						alertPopup('Records loaded...', 4000);
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
	}
	
  </script>

  <script type="text/javascript">
		$(document).ready( function () {
		    myDataTable = $('#tblOldReceipts').DataTable({
			    paging: false,
			    ordering: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});
		} );

	

  </script>

  <script type="text/javascript">
	$(document).ready( function () {
	    myDataTableLedger = $('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		});
	} );

  	function loadLedgerData()
	{	
		// $("#tbl1").find("tr:gt(0)").remove(); /* empty except 1st (head) */	
		var dtFrom = $("#dtFrom").val().trim();
		dtOk = testDate("dtFrom");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#dtFrom").focus();
			return;
		}

		var dtTo = $("#dtTo").val().trim();
		dtOk = testDate("dtTo");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#dtTo").focus();
			return;
		}

		customerRowId = $("#cboCustomer4Ledger").val();
		if(customerRowId == "-1")
		{
			alertPopup("Select customer...", 8000);
			$("#cboCustomer4Ledger").focus();
			return;
		}
		// alert(customerRowId);
		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'customerRowId': customerRowId
							, 'dtFrom': dtFrom
							, 'dtTo': dtTo
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
						setLedgerTable(data['opBal'], data['records']); 
						alertPopup('Records loaded...', 4000);
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
		
	}

	function setLedgerTable(opBal, records)
	{
		 // alert(JSON.stringify(records));
		 var dr=0;
		 var cr=0;
		 var bal = 0;
		  $("#tbl1").empty();
	      var table = document.getElementById("tbl1");

	      /////////////// Opening Balance
	      newRowIndex = table.rows.length;
          row = table.insertRow(newRowIndex);

          var cell = row.insertCell(0);
          cell.innerHTML = "";
          cell.style.display="none";

          var cell = row.insertCell(1);
          cell.innerHTML = "";

          var cell = row.insertCell(2);
          cell.innerHTML = "";

          var cell = row.insertCell(3);
          cell.innerHTML = "Op. Balance";
          cell.style.color = "red";

          var cell = row.insertCell(4);
          cell.innerHTML = "";
          cell.style.display="none";
          

          var cell = row.insertCell(5);
          if( opBal[0].amt == null)
          {
          	cell.innerHTML = "0";
          }
          else
          {
          	cell.innerHTML = opBal[0].amt;
          	dr = opBal[0].amt;
          }
          cell.style.color = "red";
          
          var cell = row.insertCell(6);
          if( opBal[0].recd == null)
          {
          	cell.innerHTML = "0";
          }
          else
          {
          	cell.innerHTML = opBal[0].recd;
          	cr = opBal[0].recd;
          }
          cell.style.color = "red";

          bal = dr - cr;
          bal=bal.toFixed(2);
          var cell = row.insertCell(7);
          cell.innerHTML = bal;
          /////////////// END - Opening Balance

          ////////////// Records in Range
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].ledgerRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].vType + "-" + records[i].refRowId;

	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].remarks;

	          var cell = row.insertCell(3);
	          cell.innerHTML = dateFormat(new Date(records[i].refDt));

	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].remarks;
	          cell.style.display="none";

	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].amt;

	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].recd;

	          var cell = row.insertCell(7);
	          bal = parseFloat(bal) + parseFloat(records[i].amt) - parseFloat(records[i].recd);

	          bal=bal.toFixed(2);
          	  cell.innerHTML = bal;
	  	  }
	  	  ////////////// END - Records in Range

	  	  ////////////// Total
	  	    var totDr = 0;
	  	    var totCr = 0;
	  	    var rangeTotDr = 0;
	  	    var rangeTotCr = 0;
		    $('#tbl1 tr').each(function(row, tr)
		    {
		    	if( $(tr).find('td:eq(5)').text() > 0 ) 
		    	{
		        	totDr += parseInt( $(tr).find('td:eq(5)').text() ); 
		        }
		    	if( $(tr).find('td:eq(6)').text() > 0 ) 
		    	{
		        	totCr += parseInt( $(tr).find('td:eq(6)').text() ); 
		        }
		        rangeTotDr = totDr - $('#tbl1').find('tr:eq(0)').find('td:eq(5)').text();
		        rangeTotCr = totCr - $('#tbl1').find('tr:eq(0)').find('td:eq(6)').text();
		    }); 

		      newRowIndex = $("#tbl1 tr").length;
	          row = table.insertRow(newRowIndex);
	          // alert(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = "";
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          cell.innerHTML = "";

	          var cell = row.insertCell(2);
	          cell.innerHTML = "";

	          var cell = row.insertCell(3);
	          cell.innerHTML = "Total";
	          cell.style.color = "red";
	          

	          var cell = row.insertCell(4);
	          cell.innerHTML = "";
	          cell.style.display="none";

	          var cell = row.insertCell(5);
	          	cell.innerHTML = totDr;
	          cell.style.color = "red";
	          
	          var cell = row.insertCell(6);
	          	cell.innerHTML = totCr;
	          cell.style.color = "red";

	          var cell = row.insertCell(7);


	          var diff = totDr - totCr
	          $("#txtDiff").val(diff);

	          var rangeDiff = rangeTotDr - rangeTotCr
	          rangeDiff=rangeDiff.toFixed(2);
	          $("#txtRangeDiff").val(rangeDiff);
	  	// $('.editRecord').bind('click', editThis);

		myDataTableLedger.destroy();
		$(document).ready( function () {
	    myDataTableLedger=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		    "ordering": false
		});
		} );

		$("#tbl1 tr").on("click", highlightRow);
			
	}
  </script>