<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='RptReminders_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Rpt Reminders";

	function setTable(records)
	{
	  // $("#tbl1").find("tr:gt(0)").remove(); //// empty first
	  $("#tbl1").empty(); //// empty first
	  var table = document.getElementById("tbl1");
      for(i=0; i<records.length; i++)
      {
			  var newRowIndex = table.rows.length;
	          var row = table.insertRow(newRowIndex);

			  var cell = row.insertCell(0);
	          cell.innerHTML = records[i].ledgerRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].vType;
	          cell.style.display="none1";

	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].refRowId;
	          cell.style.display="none1";

	          var cell = row.insertCell(3);
	          cell.innerHTML = dateFormat(new Date(records[i].refDt));

	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].customerName;

	          var cell = row.insertCell(5);
	          if( records[i].remarks != null )
		      {
	          	cell.innerHTML = records[i].remarks.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br>' + '$2');
	          }
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].amt;

	          var cell = row.insertCell(7);
	          cell.innerHTML = records[i].bal;

	          var cell = row.insertCell(8);
	          if( records[i].reminder == null )
	          {
	          	cell.innerHTML = "<span id='spanEdit' style='cursor: pointer;' data-toggle='modal' data-target='#myModal' class='spanEdit glyphicon glyphicon-pencil'></span>";
	          }
	          else
	          {
	          	cell.innerHTML = "<span id='spanEdit' style='cursor: pointer;' data-toggle='modal' data-target='#myModal' class='spanEdit glyphicon glyphicon-pencil'></span>" + dateFormat(new Date(records[i].reminder));
	          }

	        var cell = row.insertCell(9);
			cell.innerHTML = "<input type='checkbox' id='chk' class='chk' name='chk'/>";
			cell.style.textAlign="center";

			var cell = row.insertCell(10);
	          cell.innerHTML = records[i].mobile1;
	          // cell.style.display="none";
       }
        // $("#tblDetail tr").on("click", highlightRow);	
        $('.spanEdit').bind('click', editThis);
        $('.chk').bind('click', chkSelectAll);
		$('#tbl1 tr').bind('click', trCheckBox);
  		// $('#chkHead').bind('click', chkHeading);


		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		    "ordering": false
		});
		} );

		// $("#tbl1 tr").on("click", highlightRow);
	}

	var gLedgerRowId, gCeRowId, gReminder;
	function editThis()
	{
		rowIndex = $(this).parent().parent().index();
		colIndex = $(this).parent().index();
		gLedgerRowId = $(this).closest('tr').children('td:eq(0)').text();
		gCeRowId = $(this).closest('tr').children('td:eq(2)').text();
		gReminder = $(this).closest('tr').children('td:eq(8)').text();
		$( "#txtDateNew" ).val(gReminder);
		// alert(gReminder);
	}


	function loadData()
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


		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dtFrom': dtFrom
							, 'dtTo': dtTo
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
							setTable(data['records']) 
							alertPopup('Records loaded...', 5000);
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
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
				// alertPopup('Msg. sent...', 6000);
				// blankControls();
				// $("#tbl").find("tr:gt(0)").remove(); 
				// sn=0;
				if(data)
				{
					// alert(data);
					$("#txtBal").val(data);
				}
			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});

	}	


	var checkedRows=0;
	function storeTblValues()
	{
	    var TableData = new Array();
	    var i=0, j=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// if(j>0)
	    	// {
	    		if($(tr).find('td:eq(9)').find('input[type=checkbox]').is(':checked'))
	    		{
		        	TableData[i]=
		        	{
			            "name" : $(tr).find('td:eq(4)').text()
			            , "mobile" :$(tr).find('td:eq(10)').text()
		        	}   
		        	i++; 
		    	}
	    	// }	 
	    	// j++;   	
	    }); 
	    // TableData[i]=
    	// {
     //        "name" : "SL"
     //        , "mobile" : "9929598700"
    	// }

	    checkedRows = i;
	    // TableData.shift();  // first row will be heading - so remove
	    return TableData;
	}

	function sendSms()
	{
		
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		// alert(TableData);
		// return;

		var sms = $("#txtSms").val().trim();
		if(sms == "")
		{
			myAlert("SMS can not be blank...");
			return;
		}
		if(checkedRows == 0)
		{
			myAlert("Zero record selected...");
			return;	
		}

		var senderRowId = 1;
		var senderId = "poojaa";

		chkDear = "N";

		$.ajax({
				'url': base_url + '/' + controller + '/doSms',
				'type': 'POST',
				'data': {'TableData': TableData
							, 'senderRowId': senderRowId
							, 'senderId': senderId
							, 'sms': sms
							, 'chkDear': chkDear},
				'success': function(data)
				{
					alertPopup('Msg. sent...', 6000);
					// blankControls();
					$("#tbl1").find("tr:gt(0)").remove(); 
					sn=0;
					// if(data)
					// {
					// 	alert(data);
					// }
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});

	}

</script>
<div class="container">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Reminders</h3>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:-1px;">
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>From:</label>";
							echo form_input('dtFrom', '', "class='form-control' placeholder='' id='dtFrom' maxlength='10'");
		              	?>
		              	<script>
							$( "#dtFrom" ).datepicker({
								dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
							});
							$("#dtFrom").val(dateFormat(new Date()));
						</script>					
		          	</div>
		          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>To:</label>";
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
		          	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		          	</div>
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow' class='btn btn-primary form-control'>";
		              	?>
		          	</div>
					
				</div>
			</form>
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
						<th style='display:none;'>ledgerRowid</th>
					 	<th style='display:none1;'>V.Type</th>
					 	<th style='display:none1;'>V.No.</th>
					 	<th>Dt</th>
					 	<th>Cust. Name</th>
					 	<th style='display:none1;'>For What</th>
					 	<th>Amt</th>
					 	<th>Bal</th>
					 	<th>Reminder</th>
					 	<th align='left' width="40"> <input type='checkbox' id='chkHead' name='chkHead' style='display:none;'  /> </th>
					 	<th style='display:none1;'>Mobile</th>
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

	<div class="row" style="margin-top:10px;">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<?php
					echo "<label style='color: red; font-weight: normal;'> Contact Count: &nbsp; </label>";
					echo "<label id='contactCount' style='color: red; font-weight: normal;'> 0</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<label style='color: green; font-weight: normal;'> &nbsp;&nbsp;&nbsp;&nbsp;Char Count: &nbsp; </label>";
					echo "<label id='charCount' style='color: green; font-weight: normal;'> 0</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					// echo "<input type='checkbox' id='chkDear' ><label for='chkDear' style='color: blue; font-weight: normal;'>&nbsp;Include Dear ....,</label>";
					echo form_textarea('txtSms', "\r\n\r\nFrom: Pooja Jewellers-9414666615, 9414536615", "class='form-control' style='resize:none;height:100px;max-height:100px;min-height:20px;' id='txtSms' value=''");
				?>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<?php
					echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
					echo "<input type='button' onclick='sendSms();' value='Send SMS' id='btnSendSms' class='btn btn-information col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
					echo "<label style='color: red; font-weight: normal;'> Note: 1 SMS includes 160 chars. If exceed then SMS cost will be multiplied... </label>";
				?>
			</div>

		</div>
		<div class="row" style="margin-top:10px;margin-bottom: 20px;">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<?php
					echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
					echo "<input type='button' onclick='checkBal();' value='Check Balance' id='btnCheckBalance' class='btn btn-information col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
				?>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<?php
					echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
					echo "<input type='text' disabled class='form-control text-center' id='txtBal'>";
				?>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			</div>
		</div>
</div>

<div class="modal" id="myModal" role="dialog">
	<div class="modal-dialog modal-md">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">PJ</h4>
	    </div>
	    <div class="modal-body">
	        <?php
				echo "<label style='color: black; font-weight: normal;'>Remind Date:</label>";
				echo form_input('txtDateNew', '', "class='form-control' id='txtDateNew' style='' maxlength=10 autocomplete='off'");
	      	?>
	      	<script>
				$( "#txtDateNew" ).datepicker({
					dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2017:2050"
				});
			    // Set the Current Date as Default
				// $("#txtDateNew").val(dateFormat(new Date()));
			</script>	
	    </div>
	    <div class="modal-footer">
	    	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-0">
	    	</div>
	    	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-0">
	    	</div>

	    	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<button type="button" onclick="saveDateNew(gLedgerRowId);" class="btn btn-danger form-control" data-dismiss="modal">Save</button>
		    </div>
	      	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
	      		<button type="button" class="btn btn-default form-control" data-dismiss="modal">Cancel</button>
	      	</div>
	    </div>
	  </div>
	</div>
</div>



<script type="text/javascript">
	function saveDateNew()
	{
		dtNew = $("#txtDateNew").val().trim();
		if(dtNew !="")
		{
			dtOk = testDate("txtDateNew");
			if(dtOk == false)
			{
				alertPopup("Invalid date...", 5000);
				$('#myModal').modal('show');
				return;
			}
		}
		// alert(gCeRowId);
		// alert(dtNew);
		$.ajax({
				'url': base_url + '/' + controller + '/saveDateNew',
				'type': 'POST',
				// 'dataType': 'json',
				'data': {
							'gCeRowId': gCeRowId
							, 'gLedgerRowId': gLedgerRowId
							, 'dtNew': dtNew
						},
				'success': function(data)
				{
					alertPopup('Records updated...', 5000);
					$("#btnShow").trigger( "click" );
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
	}

	$(document).ready( function () {
	    myDataTable = $('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		});
	} );


	$(document).ready( function () {
	    
	    $("#btnShow").trigger("click");

	});
	
	$("#charCount").text($("#txtSms").val().length);

	$("#txtSms").keyup(function(){
		$("#charCount").text($("#txtSms").val().length);
	});

	$("#chkHead").click(function () {
		alert();
		  $('.chk').prop('checked', this.checked);
	});	

	// function chkHeading()
	// {
	// 	alert();
	// }

	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	function chkSelectAll()
	{
		var x = parseInt($(".chk").length);
		var y = parseInt($(".chk:checked").length);
		if( x == y ) 
		{
			$("#chkHead").prop("checked", true);
		} 
		else 
		{
			$("#chkHead").prop("checked", false);
		}
	}


	function trCheckBox()
	{
	  	// alert();
	    if (event.target.type !== 'checkbox') {
	      $(':checkbox', this).trigger('click');
	    }
	    countCheckedRows();
	}

	function countCheckedRows()
	{
		var cnt=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
    		if($(tr).find('td:eq(9)').find('input[type=checkbox]').is(':checked'))
    		{
	        	cnt++;
	    	}
	    }); 
	    $('#contactCount').text(cnt);
	}


</script>