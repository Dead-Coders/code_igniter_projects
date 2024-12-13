<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">

	var controller='RptDayBook_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "DayBook";

	$(document).ready(function(){
		var argCustomerRowId='<?php echo $argCustomerRowId;?>';
		// // alert(argCustomerRowId);
		// $("#cboCustomer").val(argCustomerRowId);
		// $("#btnShow").trigger('click');
	});

	function setTable(opBal, records)
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
          cell.style.display="none";

          var cell = row.insertCell(8);
          cell.innerHTML = "";
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
	          cell.innerHTML = records[i].customerName;

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
	          // bal = parseFloat(bal) + parseFloat(records[i].amt) - parseFloat(records[i].recd);
	          // bal=bal.toFixed(2);
          	//   cell.innerHTML = bal;
          	  cell.style.display="none";

          	  var cell = row.insertCell(8);
          	  cell.innerHTML = records[i].remarks;
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
	          cell.style.display="none";
	          var cell = row.insertCell(8);
       

	          var diff = totDr - totCr
	          $("#txtDiff").val(diff);

	          var rangeDiff = rangeTotDr - rangeTotCr
	          rangeDiff=rangeDiff.toFixed(2);
	          $("#txtRangeDiff").val(rangeDiff);
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
		$("#tbl1 tr").on("dblclick", setGlobalSaleRowId);
		// $("#tbl1 tr").attr("data-toggle", "modal");
		// $("#tbl1 tr").attr("data-target", "#myModalSaleDetail");
		$('#tbl1 tr').dblclick(function () {
		   	$('#myModalSaleDetail').modal('toggle');
		});
				
	}

	function setSaleDetailTable(records)
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
		$.ajax({
			'url': base_url + '/' + controller + '/getSaleDetail',
			'type': 'POST', 
			'data':{'rowid':globalSaleRowId},
			'dataType': 'json',
			'success':function(data)
			{
				// alert(JSON.stringify(data));
				setSaleDetailTable(data['records']);

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

		// customerRowId = $("#cboCustomer").val();
		// if(customerRowId == "-1")
		// {
		// 	alertPopup("Select customer...", 8000);
		// 	$("#cboCustomer").focus();
		// 	return;
		// }

		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							// 'customerRowId': customerRowId
							'dtFrom': dtFrom
							, 'dtTo': dtTo
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
							setTable(data['opBal'], data['records']) 
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
	    	// if( $(tr).find('td:eq(3)').text() > 0 )
	    	// {
	        	TableData[i]=
	        	{
		            "qpoRowId" : $(tr).find('td:eq(2)').text()
		            , "vType" : $(tr).find('td:eq(3)').text()
		            , "vNo" :$(tr).find('td:eq(4)').text()
		            , "vDt" :$(tr).find('td:eq(5)').text()
		            , "partyRowId" :$(tr).find('td:eq(6)').text()
		            , "partyName" :$(tr).find('td:eq(7)').text()
		            , "letterNo" :$(tr).find('td:eq(8)').text()
		            , "totalAmt" :$(tr).find('td:eq(9)').text()
		            , "discountPer" :$(tr).find('td:eq(10)').text()
		            , "discountAmt" :$(tr).find('td:eq(11)').text()
		            , "vatPer" :$(tr).find('td:eq(13)').text()
		            , "vatAmt" :$(tr).find('td:eq(14)').text()
		            , "net" :$(tr).find('td:eq(15)').text()
		            , "totalQty" :$(tr).find('td:eq(16)').text()
	        	}   
	        	i++; 
	        // }
	    }); 
	    // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i-1;
	    return TableData;
	}



</script>
<div class="container">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h4 class="text-center" style='margin-top:-20px'>Day Book</h4>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:15px;">
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>From:</label>";
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
		          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>To:</label>";
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
		          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow' class='btn btn-primary form-control'>";
		              	?>
		          	</div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>Party:</label>";
							// echo form_dropdown('cboCustomer',$customers, '-1',"class='form-control' id='cboCustomer'");
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
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:470px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='display:none;'>ledgerRowid</th>
					 	<th style='display:none1;'>V.Type</th>
					 	<th style='display:none1;'>Party</th>
					 	<th>Dt</th>
					 	<th style='display:none;'>For What</th>
					 	<th>Paid</th>
					 	<th>Recd.</th>
					 	<th style='display:none;'>Bal.</th>
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

	<div class="row" style="margin-top:0px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Difference:</label>";
				echo form_input('txtDiff', '', "class='form-control' placeholder='' id='txtDiff' maxlength='10' disabled='yes'");
          	?>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Range Difference:</label>";
				echo form_input('txtRangeDiff', '', "class='form-control' placeholder='' id='txtRangeDiff' maxlength='10' disabled='yes'");
          	?>
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
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
		} );



	var tblRowsCount;
	function storeTblValues()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// if( $(tr).find('td:eq(3)').text() > 0 )
	    	// {
	        	TableData[i]=
	        	{
		             "vType" : $(tr).find('td:eq(1)').text()
		            , "Party" :$(tr).find('td:eq(2)').text()
		            , "dt" :$(tr).find('td:eq(3)').text()
		            , "Dr" :$(tr).find('td:eq(5)').text()
		            , "Cr" :$(tr).find('td:eq(6)').text()
		            , "Rem" :$(tr).find('td:eq(8)').text()
	        	}   
	        	i++; 
	        // }
	    }); 
	    // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i-1;
	    return TableData;
	}


	function exportData()
	{	
		// alert();
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

		partyRowId = $("#cboCustomer").val();
		var party = $("#cboCustomer option:selected").text();
		var difference = $("#txtDiff").val().trim();

		$.ajax({
				'url': base_url + '/' + controller + '/exportData',
				'type': 'POST',
				// 'dataType': 'json',
				'data': {
							'TableData': TableData
							, 'dtFrom': dtFrom
							, 'dtTo': dtTo
							, 'party': party
							, 'difference': difference
						},
				'success': function(data)
				{
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