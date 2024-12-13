<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='RptDirectBills_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Rpt Sale";

	function setTable(records)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl1").empty();
	      var table = document.getElementById("tbl1");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);

	          var cell = row.insertCell(0);
	          // cell.style.display="none";
	          cell.innerHTML = records[i].dbRowId;
	          var cell = row.insertCell(1);
	          cell.innerHTML = dateFormat(new Date(records[i].dbDt));
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].customerRowId;
	          cell.style.display="none";
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].customerName;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].goldRate;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].silverRate;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].totalAmount;
	          var cell = row.insertCell(7);
	          cell.innerHTML = records[i].advancePaid;
	          cell.style.display="none";
	          var cell = row.insertCell(8);
	          cell.innerHTML = records[i].balance;
	          cell.style.display="none";
	          var cell = row.insertCell(9);
	          cell.innerHTML = dateFormat(new Date(records[i].dueDate));
	          cell.style.display="none";
	          var cell = row.insertCell(10);
	          cell.innerHTML = records[i].remarks;
	          // alert();
	  	  }


		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

		});
		} );

		$("#tbl1 tr").on("click", highlightRow);
		$("#tbl1 tr").on('click', showDetail);
	}

	// var gCustomerRowId = -1;
	function showDetail()
	{
		var burl = '<?php echo base_url();?>';
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		dbRowId = $(this).closest('tr').children('td:eq(0)').text();

		$.ajax({
			'url': base_url + '/' + controller + '/showDetail',
			'type': 'POST', 
			'data':{'dbRowId':dbRowId},
			'dataType': 'json',
			'success':function(data)
			{
				// alert(JSON.stringify(data));
				$("#tblDetail").find("tr:gt(0)").remove(); //// empty first
		        var table = document.getElementById("tblDetail");
		        var totPartyDue = 0;
		        for(i=0; i<data['records'].length; i++)
		        {
		          var newRowIndex = table.rows.length;
		          var row = table.insertRow(newRowIndex);

		          var cell = row.insertCell(0);
		          cell.innerHTML = data['records'][i].dbdRowId;
		          cell.style.display="none";
		          

		          var cell = row.insertCell(1);
		          cell.innerHTML = data['records'][i].itemType;

		          var cell = row.insertCell(2);
		          cell.innerHTML = data['records'][i].itemRowId;
		          cell.style.display="none";

		          var cell = row.insertCell(3);
		          cell.innerHTML = data['records'][i].itemName;

		          var cell = row.insertCell(4);
		          cell.innerHTML = data['records'][i].qty;
		          cell.style.display="none";

		          var cell = row.insertCell(5);
		          cell.innerHTML = data['records'][i].wt + " gm.";

		          var cell = row.insertCell(6);
		          cell.innerHTML = data['records'][i].serviceCharge;

		          var cell = row.insertCell(7);
		          cell.innerHTML = data['records'][i].amt;

		          var cell = row.insertCell(8);
		          cell.innerHTML = data['records'][i].rowTotal;
			    }
			        
			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
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

		customerRowId = $("#cboCustomer").val();

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
							setTable(data['records']) 
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
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h2 class="text-center" style='margin-top:-20px'>Direct Bills Log</h2>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:25px;">
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>From:</label>";
							echo form_input('dtFrom', '', "class='form-control' placeholder='' id='dtFrom' maxlength='10'");
		              	?>
		              	<script>
							$( "#dtFrom" ).datepicker({
								dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
							});
						    // Set the Current Date-50 as Default
						    dt=new Date();
     					    dt.setDate(dt.getDate() - 50);
   		 					$("#dtFrom").val(dateFormat(dt));
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
						<?php
							echo "<label style='color: black; font-weight: normal;'>Party:</label>";
							echo form_dropdown('cboCustomer',$customers, '-1',"class='form-control' id='cboCustomer'");
		              	?>
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
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='display:none1;'>order#</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Customer Name</th>
					 	<th>Gold Rate</th>
					 	<th>Silver Rate</th>
					 	<th>Total</th>
					 	<th style='display:none;'>Paid</th>
					 	<th style='display:none;'>Balance</th>
					 	<th style='display:none;'>Due Dt</th>
					 	<th>Remarks</th>					 	
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

	<div class="row" style="margin-top:20px; display: none;" >
		<div class="col-lg-9 col-sm-9 col-md-9 col-xs-0">
		</div>

		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<input type='button' onclick='exportData();' value='Export Data' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		<!-- <div class="col-lg-1 col-sm-1 col-md-1 col-xs-0">
		</div> -->

	</div>

	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto;">
				<table class='table table-hover' id='tblDetail'>
				 <thead>
					 <tr>
						<th style='display:none;'>dbdRowId</th>
					 	<th>Item Type</th>
					 	<th style='display:none;'>ItemRowId</th>
					 	<th>Item Name</th>
					 	<th style='display:none;'>Qty</th>
					 	<th>Wt.</th>
					 	<th>Service Charge</th>
					 	<th>Amt.</th>
					 	<th>Total</th>
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
</div>





<script type="text/javascript">


		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
		} );




	// $(document).ready(function() {
	//    // $("#cboProductCategories").append('<option value="ALL">ALL</option>');
	//    var opt = "<option value='ALL'>ALL</option>";
	//    var idx=2;
	//    $(opt).insertBefore("#cboProductCategories option:nth-child(" + idx + ")");
	//   });
</script>