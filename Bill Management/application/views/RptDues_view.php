<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel='stylesheet' href='<?php  echo base_url();  ?>bootstrap/css/suriprint.css'>

<script type="text/javascript">
	var controller='RptDues_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Dues";


	function setTable(records, recordsNegative)
	{
		 // alert(JSON.stringify(records));
		 	var msgWp = "";
			msgWp += "Respected Customer,";
			msgWp += "%0aPls clear your dues at *SEACO TECH*. This is auto generated msg, ignore if already cleared.";
			msgWp += "%0a-Regards,";
			msgWp += "%0aLiam Moore";
			msgWp += "%0a1478500000";


		  $("#tbl1").empty();
	      var table = document.getElementById("tbl1");
	      var tot=0;
	      for(i=0; i<records.length; i++)
	      {
			amtWp = "%0aDue Amt Rs. *" + records[i].balance + "* only.";

	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].customerRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          cell.innerHTML = "<input type='checkbox' id='chk' class='chk' name='chk' style='width:14px;height:14px;'/> <a id='contraac' href='#' onClick='loadLedger("+records[i].customerRowId+");'>" + records[i].customerName + "</a><br>[" + records[i].mobile1 + "] <kbd><a style='color:#fff;' target='_blank' href='https://web.whatsapp.com/send?phone=91"+records[i].mobile1+"&text="+msgWp+amtWp+"&source=&data'>WhatsApp</a></kbd>"
	          // cell.innerHTML = records[i].customerName;

	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].balance;
	          cell.style.textAlign="right";
	          cell.style.border="thin solid lightgray";

	          tot += parseFloat(records[i].balance);


	          var cell = row.insertCell(3);
	          cell.innerHTML = "";
	          cell.style.color="red";
	          cell.contentEditable="true";
	          cell.style.border="thin solid lightgray";

	          var cell = row.insertCell(4);
	          cell.innerHTML = "";
	          cell.style.color="blue";
	          cell.contentEditable="true";
	          cell.style.border="thin solid lightgray";

	          var cell = row.insertCell(5);
	          cell.innerHTML = "<button class='clsBtnReceive btn btn-success form-control'>Receive</button>";

	          var cell = row.insertCell(6);
	          cell.innerHTML = "<a target='_blank' href='https://web.whatsapp.com/send?phone=91"+records[i].mobile1+"&text="+msgWp+amtWp+"&source=&data'>" + records[i].mobile1 + "</a>";
	          cell.style.color="red";
	          cell.style.display="none";

	          var cell = row.insertCell(7);
	          cell.innerHTML = "<button class='clsBtnDoobat btn btn-warning form-control'>" + records[i].doobat + "</button>";
	          cell.style.border="thin solid lightgray";
	  	  }
	  	  $("#txtTotalDues").val(tot);
	  	  /////////// -ve dues
	  	  for(i=0; i<recordsNegative.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          row.style.color="red";

	          var cell = row.insertCell(0);
	          cell.innerHTML = recordsNegative[i].customerRowId;
	          cell.style.display="none";
	          var cell = row.insertCell(1);
	          cell.innerHTML = "<a id='contraac' href='#' onClick='loadLedger("+recordsNegative[i].customerRowId+");'>" + recordsNegative[i].customerName + "</a>"
	          var cell = row.insertCell(2);
	          cell.innerHTML = recordsNegative[i].balance;
	          cell.style.border="thin solid lightgray";
	          // tot += parseFloat(records[i].balance);
	          var cell = row.insertCell(3);
	          cell.innerHTML = "";
	          cell.style.color="red";
	          cell.contentEditable="true";
	          cell.style.border="thin solid lightgray";
	          var cell = row.insertCell(4);
	          cell.innerHTML = "";
	          cell.style.color="blue";
	          cell.contentEditable="true";
	          cell.style.border="thin solid lightgray";
	          var cell = row.insertCell(5);
	          cell.innerHTML = "<button class='clsBtnPaid btn btn-primary form-control'>Paid</button>";
	          var cell = row.insertCell(6);
	          cell.innerHTML = "";
	          cell.style.color="red";
	          cell.style.display="none";
	          var cell = row.insertCell(7);
	          cell.innerHTML = "";
	          cell.style.border="thin solid lightgray";

	  	  }


			// $("#txtSms").on("change, keyup", countCharactersReady);

	  	    var msg = "";
			msg += "Respected Customer,";
			msg += "\nPls clear your dues at SEACO TECH. This is auto generated msg, ignore if already cleared.";
			msg += "\n-Regards,";
			msg += "\nLiam Moore";
			msg += "\n1478500000";
			$("#txtSms").val(msg);
			countCharactersReady();

		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		    "ordering": false
		});
		} );

		$("#tbl1 tr").on("click", highlightRowAlag);
		$(".clsBtnReceive").on('click', jamaKaro);
		$(".clsBtnPaid").on('click', payKaro);
		$(".clsBtnDoobat").on('click', markDoobat);
			
	}
	function countCharactersReady()
			{
				$("#lblChars").text( $("#txtSms").val().length );
			}

	function jamaKaro()
	{
		rowIndex = $(this).parent().parent().index();
		customerRowId = $(this).closest('tr').children('td:eq(0)').text();
		rAmt = $(this).closest('tr').children('td:eq(3)').text();
		remarks = $(this).closest('tr').children('td:eq(4)').text();
		if(rAmt == "" || isNaN(rAmt))
		{
			msgBoxError("Error", "Invalid Amt...");
			return;
		}
		$.ajax({
			'url': base_url + '/' + controller + '/receiveAmt',
			'type': 'POST',
			'dataType': 'json',
			'data': {
						'customerRowId': customerRowId, 'rAmt': rAmt, 'remarks': remarks
					},
			'success': function(data)
			{
				if(data)
				{
				// alert(JSON.stringify(data));
					setTable(data['records'], data['recordsNegative']) 
					alertPopup('Done...', 4000);
				}
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});	
	}

	function payKaro()
	{
		rowIndex = $(this).parent().parent().index();
		customerRowId = $(this).closest('tr').children('td:eq(0)').text();
		rAmt = $(this).closest('tr').children('td:eq(3)').text();
		remarks = $(this).closest('tr').children('td:eq(4)').text();
		if(rAmt == "" || isNaN(rAmt))
		{
			msgBoxError("Error", "Invalid Amt...");
			return;
		}
		$.ajax({
			'url': base_url + '/' + controller + '/payAmt',
			'type': 'POST',
			'dataType': 'json',
			'data': {
						'customerRowId': customerRowId, 'rAmt': rAmt, 'remarks': remarks
					},
			'success': function(data)
			{
				if(data)
				{
				// alert(JSON.stringify(data));
					setTable(data['records'], data['recordsNegative']) 
					alertPopup('Done...', 4000);
				}
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});	
	}

	function markDoobat()
	{
		rowIndex = $(this).parent().parent().index();
		customerRowId = $(this).closest('tr').children('td:eq(0)').text();
		abhiDoobatHaiKya = $(this).text();
		// alert(abhiDoobatHaiKya);
		$.ajax({
			'url': base_url + '/' + controller + '/markDoobat',
			'type': 'POST',
			'dataType': 'json',
			'data': {
						'customerRowId': customerRowId, 'abhiDoobatHaiKya': abhiDoobatHaiKya
					},
			'success': function(data)
			{
				if(data)
				{
				// alert(JSON.stringify(data));
					setTable(data['records'], data['recordsNegative']) 
					alertPopup('Done...', 3000);
				}
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});	
	}

	function loadData()
	{	
		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'customerRowId': 'customerRowId'
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
							setTable(data['records'], data['recordsNegative']) 
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

	function setTableNegative(records)
	{
		 // alert(JSON.stringify(records));
		  $("#tblNegative").empty();
	      var table = document.getElementById("tblNegative");
	      var tot=0;
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].customerRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          cell.innerHTML = "<a id='contraac' href='#' onClick='loadLedger("+records[i].customerRowId+");'>" + records[i].customerName + "</a>"
	          // cell.innerHTML = records[i].customerName;

	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].balance;

	          tot += parseFloat(records[i].balance);
	  	  }

	  	  $("#txtTotalDuesNegative").val(tot);

		myDataTableNegative.destroy();
		$(document).ready( function () {
	    myDataTableNegative=$('#tblNegative').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		    "ordering": false
		});
		} );

		$("#tblNegative tr").on("click", highlightRowAlag);
		// $("#tbl1 tr").on('click', showDetail);
			
	}

	function loadDataNegative()
	{	
		$.ajax({
				'url': base_url + '/' + controller + '/showDataNegative',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'customerRowId': 'customerRowId'
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
							setTableNegative(data['records']) 
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

	// var jhanda=0;
	var gCustomerRowId = -1;


	var gLedgerRowId, gCeRowId, gReminder;
	function editThis()
	{
		rowIndex = $(this).parent().parent().index();
		colIndex = $(this).parent().index();
		gLedgerRowId = $(this).closest('tr').children('td:eq(0)').text();
		gCeRowId = $(this).closest('tr').children('td:eq(2)').text();
		gReminder = $(this).closest('tr').children('td:eq(7)').text();
		$( "#txtDateNew" ).val(gReminder);
		// alert(gReminder);
	}


</script>
<div class="container" style="width: 95%">
	<div class="row" id="divDues">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="row">
				<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<h3 class="text-center" style='margin-top:-20px'>Dues</h3>
					<form name='frm1' id='frm1' method='post' enctype='multipart/form-data' action="">
						<div class="row" style="margin-top:-15px;">
							<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
								<?php
									//echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
									echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow1' class='btn btn-primary form-control'>";
				              	?>
				          	</div>
				          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
				          	</div>
							<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				          	</div>
							<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
				          	</div>
						</div>
					</form>
				</div>
				<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
				</div>
			</div>


			<div class="row" style="margin-top:20px;" >
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:500px; overflow:auto;">
						<table class='table table-bordered table-striped table-hover' id='tbl1'>
						 <thead>
							 <tr>
								<th style='display:none;'>customerRowid</th>
							 	<th style='display:none1;'>Name</th>
							 	<th style='display:none1;'>Dues</th>
							 	<th style='display:none1;'>Receive</th>
							 	<th style='display:none1;'>Remarks</th>
							 	<th style='display:none1;'></th>
							 	<th style='display:none;'>Mobile</th>
							 	<th style='display:none1;'>Doobat</th>
							 </tr>
						 </thead>
						 <tbody>

						 </tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top:5px;" >
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>SMS:</label>";
						echo "<label id='lblChars' style='color: red; font-weight: normal;'>0</label>";
						// echo "&nbsp;&nbsp;&nbsp;<input id='chkSendSms' type='checkbox' checked>Send SMS";
						echo form_textarea('txtSms', '', "class='form-control' style='resize:none;height:100px;' id='txtSms'  maxlength=320 value=''");
		          	?>
				</div>
				
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
						echo "<input type='button' onclick='sendMsg();' value='Send Msg' id='btnShowNegative' class='btn btn-danger form-control'>";
	              	?>
				</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Total Dues:</label>";
						echo form_input('txtTotalDues', '', "class='form-control' placeholder='' id='txtTotalDues' maxlength='10' disabled='yes'");
		          	?>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
						echo "<input type='button' onclick='checkBal();' value='Check Balance' id='btnCheckBalance' class='btn btn-information col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
					?>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
						
					?>
				</div>
			</div>
		</div>

		<!-- ledger -->
		<div id='divLedger' class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="border:1px solid lightgray;margin-top: 50px; padding: 4px 10px;height:450px; overflow:auto;background-color: #f2f2f2;">
			<div class="row">
			
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
							<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="display: none;">
								<?php
									echo "<label style='color: black; font-weight: normal;'>Range Difference:</label>";
									echo form_input('txtRangeDiff', '', "class='form-control' placeholder='' id='txtRangeDiff' maxlength='10' disabled='yes'");
					          	?>
							</div>
						</div>
					</form>
				</div>
			
			</div>
			<div class="row" style="margin-top:10px;" >
				<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<div id="divTableLedger" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:350px; overflow:auto;">
						<table class='table table-bordered table-striped table-hover' id='tblLedger'>
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
		<!-- END - ledger -->

	</div>
	
	<div class="row" style="margin-top: 20px;">
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
					echo form_input('txtDateDelete', '01-Apr-2018', "class='form-control' id='txtDateDelete' style='' maxlength=11 autocomplete='off' placeholder='date'");
	          	?>
	          	<script>
					$( "#txtDateDelete" ).datepicker({
						dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
					});
					// Set the 1st of this month
					// $("#txtDateDelete").val(dateFormat(new Date()));
				</script>	
	      	</div>
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<?php
					echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
					echo "<input type='button' onclick='deleteOldRecs();' value='Del. Old Rec., Sale, Purchase < dt' id='btnDelOldRec' class='btn btn-danger btn-block'>";
		      	?>
			</div>
			<label>IN ABOVE DEL -> del from ledger before defined dt and carry OB, del BKP table all, del Solved Complaints, del Notifications (deleted), reminders(deleted), del replacement(sent n recd), SendSms table all, Sale before defined dt, Purchase before defined dt</label>
		</div>
</div>



		<!-- Model -->
		  <div class="modal" id="myModalSaleDetail" role="dialog">
		    <div class="modal-dialog modal-lg">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title" id="h4SaleDetail">Sale Detail</h4>
		        </div>
		        <div class="modal-body" style="overflow: auto; height: 300px;">
		          <table id='tblSaleDetail' class="table table-bordered table-striped table-hover">
		          		<th style='display:none1;'>DbRowid</th>
					 	<th>Item</th>
					 	<th>Qty</th>
					 	<th>Rate</th>
					 	<th>Amt</th>
		          </table>
		        </div>
		        <div class="modal-footer">
		        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		        		<button type="button" onclick='printBill(globalSaleRowId);' class="btn btn-block btn-primary" data-dismiss="modal">Print</button>
		        	</div>
		        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		        		
		        	</div>
		        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		        	</div>
		        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		        		<button type="button" class="btn btn-block btn-default" data-dismiss="modal">Cancel</button>
		        	</div>
		        </div>
		      </div>
		    </div>
		  </div>		  


<script type="text/javascript">
	

	$(document).ready( function () {
	    myDataTable = $('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]]

		});

	    

	    $("#divLedger").height( $("#divTable").height() + 20);
	    // var po = $("#divDues").offset();
	    // // alert(po.top);
	    // $("#divLedger").css({"top":po.top+'px'} );

	} );


		$(document).ready( function () {
		    myDataTableLedger = $('#tblLedger').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});

			$("#btnShow1").trigger("click");
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
				'url': base_url + '/' + controller + '/showDataLedger',
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
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});
		
	}


	function setLedgerTable(opBal, records)
	{
		 // alert(JSON.stringify(records));
		 var dr=0;
		 var cr=0;
		 var bal = 0;
		  $("#tblLedger").empty();
	      var table = document.getElementById("tblLedger");

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
	          if( records[i].vType == "DB" )
	          {
	          	cell.innerHTML = records[i].vType + "-" + records[i].refRowId + " <span style='color:blue;' class='glyphicon glyphicon-print' onclick='printBill(" + records[i].refRowId + ");'></span>";
	          }
	          else
	          {
	          	cell.innerHTML = records[i].vType + "-" + records[i].refRowId;
	          }

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
          	  cell.style.color = "blue";
	  	  }
	  	  ////////////// END - Records in Range

	  	  ////////////// Total
	  	    var totDr = 0;
	  	    var totCr = 0;
	  	    var rangeTotDr = 0;
	  	    var rangeTotCr = 0;
		    $('#tblLedger tr').each(function(row, tr)
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

		      newRowIndex = $("#tblLedger tr").length;
	          row = table.insertRow(newRowIndex);
	          // row.attr("id", "lastRow");
	          cell.setAttribute("id", "lastRow");

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
	          // $("#txtRangeDiff").css({'color':'red'});
	  	// $('.editRecord').bind('click', editThis);

		myDataTableLedger.destroy();
		$(document).ready( function () {
	    myDataTableLedger=$('#tblLedger').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		    "ordering": false
		});
		} );

		$("#tblLedger tr").on("click", highlightRow);
		$("#tblLedger tr").on("dblclick", setGlobalSaleRowId);
		// $("#tblLedger tr").attr("data-toggle", "modal");
		// $("#tblLedger tr").attr("data-target", "#myModalSaleDetail");
		$('#tblLedger tr').dblclick(function () {
		   	$('#myModalSaleDetail').modal('toggle');
		});


		/////Scoll to last row

        var scrollBottom = Math.max($('#tblLedger').height() - $('#divTableLedger').height() + 80, 0);
   		// $('#divTableLedger').scrollTop(scrollBottom);
   		$('#divTableLedger').animate({
				        scrollTop: scrollBottom
				    }, 500);

			//animate({
					 //        scrollTop: $("#btnLoadAll").offset().top
					 //    }, 2000);
        /////END - Scoll to last row

	}


	function setSaleDetailTable(records, recordsSr)
	{
		$("#tblSaleDetail").find("tr:gt(0)").remove(); //// empty first
        var table = document.getElementById("tblSaleDetail");

        // alert(JSON.stringify(data));
        for(i=0; i<records.length; i++)
		{
	        newRowIndex = table.rows.length;
				row = table.insertRow(newRowIndex);

          var cell = row.insertCell(0);
          // cell.style.display="none";
          cell.innerHTML = records[i].dbRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = records[i].itemName;
          var cell = row.insertCell(2);
          cell.innerHTML = records[i].qty;
          var cell = row.insertCell(3);
          cell.innerHTML = records[i].rate;
          // cell.style.display="none";
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].amt;
        }
	  	
	  	/////Loading SalesReturn Data
        for(i=0; i<recordsSr.length; i++)
		{
			if (recordsSr[i].rqty >0 )
			{
		        newRowIndex = table.rows.length;
				row = table.insertRow(newRowIndex);
				row.style.color="red";

	          var cell = row.insertCell(0);
	          // cell.style.display="none";
	          cell.innerHTML = recordsSr[i].dbRowId + " [SR-" + recordsSr[i].srRowId + "]";
	          var cell = row.insertCell(1);
	          cell.innerHTML = recordsSr[i].itemName;
	          var cell = row.insertCell(2);
	          cell.innerHTML = recordsSr[i].rqty;
	          var cell = row.insertCell(3);
	          cell.innerHTML = recordsSr[i].rate;
	          // cell.style.display="none";
	          var cell = row.insertCell(4);
	          cell.innerHTML = recordsSr[i].amt * -1;
	        }
        }		
	}

	function setGlobalSaleRowId()
	{
		globalSaleRowId = 0;
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		globalSaleRowId = $(this).closest('tr').children('td:eq(1)').text().substr(3,$(this).closest('tr').children('td:eq(1)').text().length);
		x = $(this).closest('tr').children('td:eq(1)').text().substr(0,2);
		//alert(x);
		$("#tblSaleDetail").find("tr:gt(0)").remove(); //// empty first
		$("#h4SaleDetail").text("Sale Detail - " + $( "#cboCustomer option:selected" ).text() );
		if( x != "DB" )
		{
			return;
		}
		// alert(globalSaleRowId);
		// return;
		$.ajax({
			'url': base_url + '/' + controller + '/getSaleDetail',
			'type': 'POST', 
			'data':{'rowid':globalSaleRowId},
			'dataType': 'json',
			'success':function(data)
			{
				// alert(JSON.stringify(data));
				setSaleDetailTable(data['records'], data['recordsSr']);

			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});
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
  		$("#dtTo").val( dateFormat(new Date()) );
  		var dtTo = $("#dtTo").val();
  		// $("#dtTo").val( $("#txtDate").val() );
  		
  		$("#cboCustomer4Ledger").val(customerRowId);

  		$.ajax({
				'url': base_url + '/' + controller + '/showDataLedger',
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
						// $('html, body').animate({
					 //        scrollTop: $("#btnLoadAll").offset().top
					 //    }, 2000);
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




	    $(document).ready( function () {
		    myDataTableNegative = $('#tblNegative').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]]

			});

			$("#txtSms").on("change, keyup", countCharactersReady);
			var smsBalance = '<?php echo $smsBalance;?>';
			// alert(smsBalance);
			$("#btnCheckBalance").val(smsBalance);
			
		});

	var checkedRows=0;
	function storeTblValuesChecked()
	{
	    var TableData = new Array();
	    var i=0, j=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	if(j>=0)
	    	{
	    		if($(tr).find('td:eq(1)').find('input[type=checkbox]').is(':checked'))
	    		{
		        	TableData[i]=
		        	{
			            "mobileNo" : $(tr).find('td:eq(6)').text()
		        	}   
		        	i++; 
		    	}
	    	}	 
	    	j++;   	
	    }); 
	    checkedRows = i;
	    // TableData.shift();  // first row will be heading - so remove
	    return TableData;
	}
	function sendMsg()
	{
		var TableData;
		TableData = storeTblValuesChecked();
		TableData = JSON.stringify(TableData);
		// alert(JSON.stringify(TableData));
		// return;

		var sms = $("#txtSms").val().trim();
		// alert(sms);
		$.ajax({
			'url': base_url + '/' + controller + '/sendMsg',
			'type': 'POST',
			'dataType': 'json',
			'data': {
						'TableData': TableData
						, 'sms': sms
					},
			'success': function(data)
			{
				alertPopup('Done...', 4000);
				$(".chk").prop("checked", false);
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});	
	}
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
					$("#btnCheckBalance").val(data);
				}
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});

	}	

	function printBill(invNo)
	{
		$.ajax({
					'url': base_url + '/' + 'Sale_Controller' + '/printNow/11',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								'globalrowid': invNo
							},
					'success': function(data)
					{
						$("#divPrint").html(data['html']);
						window.print();
					},
					'error': function(jqXHR, exception)
			          {
			            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
			            $("#modalAjaxErrorMsg").modal('toggle');
			          }
			});

	}
</script>


<!-- Delete zero bal from ledger -->
<script type="text/javascript">
	function deleteOldRecs()
	{
		dt = $("#txtDateDelete").val().trim();
		dtOk = testDate("txtDateDelete");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#txtDateDelete").focus();
			return;
		}

		var p = prompt("Enter Password...", "M...B...9...0");
		if (p === null) {
	        return; //break out of the function early
	    }
		
		$.ajax({
			'url': base_url + '/' + controller + '/deleteOldRecs',
			'type': 'POST',
			'dataType': 'json',
			'data': {'p': p, 'dt': dt},
			'success': function(data){
				if(data == "Invalid...")
				{
	                alertPopup("Invalid pwd... ", 6000, 'red', 'white');
				}
				else
				{
	                alertPopup("Updated... ", 6000);
	            }
			},
	          'error': function(jqXHR, exception)
	          {
	            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
	            $("#modalAjaxErrorMsg").modal('toggle');
	          }
		});

	}
</script>