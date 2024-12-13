<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='RptPurchase_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Rpt Purchase";

	function setTable(records)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl1").empty();
        var table = document.getElementById("tbl1");
        var totalAmt =0;
        var totalDiscount =0;
        var totalPretaxAmt =0;
        var totalIgst =0;
        var totalCgst =0;
        var totalSgst =0;
        var totalNetAmt =0;
        for(i=0; i<records.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);

          var cell = row.insertCell(0);
          // cell.style.display="none";
          cell.innerHTML = records[i].purchaseRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = dateFormat(new Date(records[i].purchaseDt));
          // cell.style.display="none";
          var cell = row.insertCell(2);
          cell.innerHTML = records[i].customerName;
          cell.style.display="none";
          var cell = row.insertCell(3);
          cell.innerHTML = records[i].customerName;
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].totalAmount;
          totalAmt += parseFloat(records[i].totalAmount);
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].totalDiscount;
          totalDiscount += parseFloat(records[i].totalDiscount);
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].pretaxAmt;
          totalPretaxAmt += parseFloat(records[i].pretaxAmt);
          var cell = row.insertCell(7);
          cell.innerHTML = records[i].totalIgst;
          totalIgst += parseFloat(records[i].totalIgst);
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].totalCgst;
          totalCgst += parseFloat(records[i].totalCgst);
          var cell = row.insertCell(9);
          cell.innerHTML = records[i].totalSgst;
          totalSgst += parseFloat(records[i].totalSgst);
          var cell = row.insertCell(10);
          cell.innerHTML = records[i].netAmt;
          totalNetAmt += parseFloat(records[i].netAmt);
          var cell = row.insertCell(11);
          cell.innerHTML = records[i].advancePaid;
          var cell = row.insertCell(12);
          cell.innerHTML = records[i].balance;
          var cell = row.insertCell(13);
          if(records[i].dueDate == null )
          {
          	cell.innerHTML = "";
          }
          else
          {
          	cell.innerHTML = dateFormat(new Date(records[i].dueDate));
          }
          var cell = row.insertCell(14);
          cell.innerHTML = records[i].remarks;
	    }
	    // $("#txtTotalNet").val(totalNetAmt);
	    ///////Total Row
		      newRowIndex = $("#tbl1 tr").length;
	          row = table.insertRow(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = "";

	          var cell = row.insertCell(1);
	          cell.innerHTML = "";

	          var cell = row.insertCell(2);
	          cell.innerHTML = "";
	          cell.style.display="none";

	          var cell = row.insertCell(3);
	          cell.innerHTML = "Total";
	          cell.style.color = "red";
	          

	          var cell = row.insertCell(4);
	          cell.innerHTML = totalAmt.toFixed(2);
	          // cell.style.display="none";
	          cell.style.color = "red";

	          var cell = row.insertCell(5);
	          cell.innerHTML = totalDiscount.toFixed(2);
	          cell.style.color = "red";
	          
	          var cell = row.insertCell(6);
	          cell.innerHTML = totalPretaxAmt.toFixed(2);
	          cell.style.color = "red";
	          var cell = row.insertCell(7);
	          cell.innerHTML = totalIgst.toFixed(2);
	          cell.style.color = "red";
	          var cell = row.insertCell(8);
	          cell.innerHTML = totalCgst.toFixed(2);
	          cell.style.color = "red";
	          var cell = row.insertCell(9);
	          cell.innerHTML = totalSgst.toFixed(2);
	          cell.style.color = "red";
	          var cell = row.insertCell(10);
	          cell.innerHTML = totalNetAmt.toFixed(2);
	          cell.style.color = "red";
	          var cell = row.insertCell(11);
	          cell.style.color = "red";
	          var cell = row.insertCell(12);
	          cell.style.color = "red";
	          var cell = row.insertCell(13);
	          cell.style.color = "red";
	          var cell = row.insertCell(14);
	          cell.style.color = "red";


	  	// $('.editRecord').bind('click', editThis);

		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		    "ordering": false
		});
		} );

		$("#tbl1 tr").on("click", highlightRow);
		$("#tbl1 tr").on('click', showDetail);
			
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
							alertPopup('Records loaded...', 4000);
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
		
	}



	var tblRowsCount;
	function storeTblValues()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
        	TableData[i]=
        	{
	            "dbRowId" : $(tr).find('td:eq(0)').text()
	            , "dt" : $(tr).find('td:eq(1)').text()
	            , "customerName" :$(tr).find('td:eq(2)').text()
	            , "totalAmt" :$(tr).find('td:eq(4)').text()
	            , "totalDiscount" :$(tr).find('td:eq(5)').text()
	            , "pretaxAmt" :$(tr).find('td:eq(6)').text()
	            , "totalIgst" :$(tr).find('td:eq(7)').text()
	            , "totalCgst" :$(tr).find('td:eq(8)').text()
	            , "totalSgst" :$(tr).find('td:eq(9)').text()
	            , "netAmt" :$(tr).find('td:eq(10)').text()
	            , "paid" :$(tr).find('td:eq(11)').text()
	            , "balance" :$(tr).find('td:eq(12)').text()
	            , "dueDate" :$(tr).find('td:eq(13)').text()
	            , "remarks" :$(tr).find('td:eq(14)').text()
        	}   
        	i++; 
	    }); 
	    // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i-1;
	    return TableData;
	}
	function exportData()
	{	
		// alert();
		// return;
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		// alert(JSON.stringify(TableData));
		// return;
		if(tblRowsCount == 0)
		{
			alertPopup("No product selected...", 8000);
			$("#cboProducts").focus();
			return;
		}
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

		partyRowId = $("#cboParty").val();
		var party = $("#cboParty option:selected").text();

		$.ajax({
				'url': base_url + '/' + controller + '/exportData',
				'type': 'POST',
				// 'dataType': 'json',
				'data': {
							'TableData': TableData
							, 'dtFrom': dtFrom
							, 'dtTo': dtTo
							, 'party': party
						},
				'success': function(data)
				{
					// alert(data);
					if(data)
					{
						window.location.href=data;
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
			<h1 class="text-center" style='margin-top:-20px'>Purchase Report</h1>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:25px;">
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
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
		          	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
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
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		          	</div>

					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
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
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					<tr>
						<th style='display:none1;'>DB#</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Customer</th>
					 	<th>Total Amt</th>
					 	<th>Disc.</th>
					 	<th>Pretax Amt</th>
					 	<th>Total IGST</th>
					 	<th>Total CGST</th>
					 	<th>Total SGST</th>
					 	<th>Net Amt.</th>
					 	<th>Paid</th>
					 	<th>Balance</th>
					 	<th>Due Dt.</th>
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

	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Total Net Amt.:</label>";
				// echo form_input('txtTotalNet', '0', "class='form-control' id='txtTotalNet' maxlength='10' disabled");
	      	?>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
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
				<table class='table table-bordered table-striped table-hover' id='tblProducts'>
				 <thead>
					 <tr>
					 	<th>Item</th>
					 	<th>Qty</th>
					 	<th>Rate</th>
					 	<th>Amt</th>
					 	<th>Discount</th>
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


	// $(document).ready(function()
	// {
	//     $("#tbl1 tr").on('click', showDetail);
	// });
	var globalVno, globalVdt, globalPartyName, globalTransporter,globalRemarks, globalPrGrNo 
	function showDetail()
	{
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		dbRowId = $(this).closest('tr').children('td:eq(0)').text();
		$.ajax({
			'url': base_url + '/RptPurchase_Controller/getProducts',
			'type': 'POST', 
			'data':{'rowid':dbRowId},
			'dataType': 'json',
			'success':function(data)
			{
				// alert(JSON.stringify(data));
				// return;
				$("#tblProducts").find("tr:gt(0)").remove(); //// empty first
		        var table = document.getElementById("tblProducts");
		        for(i=0; i<data['products'].length; i++)
		        {
		          var newRowIndex = table.rows.length;
		          var row = table.insertRow(newRowIndex);
		          var cell = row.insertCell(0);
		          cell.innerHTML = data['products'][i].itemName;
		          // cell.style.display = "none";
		          var cell = row.insertCell(1);
		          cell.innerHTML = data['products'][i].qty;
		          var cell = row.insertCell(2);
		          cell.innerHTML = data['products'][i].rate;
		          var cell = row.insertCell(3);
		          cell.innerHTML = data['products'][i].amt;
		          var cell = row.insertCell(4);
		          cell.innerHTML = data['products'][i].discountPer;
		        }
		        $("#tblProducts tr").on("click", highlightRow);	
			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});

	}
</script>