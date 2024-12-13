<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel='stylesheet' href='<?php  echo base_url();  ?>bootstrap/css/suriprint.css'>

<style type="text/css">
	.ui-autocomplete {
	    max-height: 200px;
	    overflow-y: auto;   /* prevent horizontal scrollbar */
	    overflow-x: hidden; /* add padding to account for vertical scrollbar */
	    z-index:1000 !important;
	}
</style>


<script type="text/javascript">

	var controller='RptLedger_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Ledger";

	vGlobalVtypeForPrint="";

	$(document).ready(function(){
		var argCustomerRowId='<?php echo $argCustomerRowId;?>';
		// alert(argCustomerRowId);
		// $("#cboCustomer").val(argCustomerRowId);
		$("#lblCustomerId").text(argCustomerRowId);

		$("#btnShow").trigger('click');
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
          	  if( bal == 0)
          	  {
          	  	row.style.color = 'blue';
          	  }
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

	function printBill(invNo)
	{
		if( vGlobalVtypeForPrint == "DB")
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
		else if( vGlobalVtypeForPrint == "PV" )
		{
			$.ajax({
					'url': base_url + '/' + 'Purchase_Controller' + '/printNow/11',
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

	function setPurchaseDetailTable(records)
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
          cell.innerHTML = records[i].purchaseRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = records[i].itemName;
          var cell = row.insertCell(2);
          cell.innerHTML = records[i].qty;
          var cell = row.insertCell(3);
          cell.innerHTML = records[i].rate + " [" + records[i].discountAmt +", " + records[i].cgstAmt +", " + records[i].sgstAmt + "]";
          // cell.style.display="none";
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].netAmt;
        }
	}

	function setGlobalSaleRowId()
	{
		globalSaleRowId = 0;
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		globalSaleRowId = $(this).closest('tr').children('td:eq(1)').text().substr(3,$(this).closest('tr').children('td:eq(1)').text().length);
		x = $(this).closest('tr').children('td:eq(1)').text().substr(0,2);
		vGlobalVtypeForPrint = x;
		// alert(x + "    ,  " + globalSaleRowId);
		$("#tblSaleDetail").find("tr:gt(0)").remove(); //// empty first
		// $("#h4SaleDetail").text("Sale Detail - " + $( "#cboCustomer option:selected" ).text() );
		if( x == "DB" )
		{
			$("#h4SaleDetail").text("Sale Detail - " + $( "#txtCustomerName" ).val() );
			$.ajax({
				'url': base_url + '/' + controller + '/getSaleDetail',
				'type': 'POST', 
				'data':{'rowid':globalSaleRowId},
				'dataType': 'json',
				'success':function(data)
				{
					// alert(JSON.stringify(data['recordsSr']));
					setSaleDetailTable(data['records'], data['recordsSr']);
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
		}
		else if( x == "PV" )
		{
			$("#h4SaleDetail").text("Purchase Detail - " + $( "#txtCustomerName" ).val() );
			$.ajax({
				'url': base_url + '/' + controller + '/getPurchaseDetail',
				'type': 'POST', 
				'data':{'rowid':globalSaleRowId},
				'dataType': 'json',
				'success':function(data)
				{
					// alert(JSON.stringify(data['records']));
					setPurchaseDetailTable(data['records']);
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
		}
		else
		{
			alertPopup("Only SV and PV...",3000);
			return;
		}
		// alert(globalSaleRowId);
		
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

		customerRowId = $("#lblCustomerId").text();
		if(customerRowId < 0)
		{
			alertPopup("Select customer...", 8000);
			$("#txtCustomerName").focus();
			return;
		}

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
							setTable(data['opBal'], data['records']) 
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


	// var tblRowsCount;
	// function storeTblValues()
	// {
	//     var TableData = new Array();
	//     var i=0;
	//     $('#tbl1 tr').each(function(row, tr)
	//     {
	//     	// if( $(tr).find('td:eq(3)').text() > 0 )
	//     	// {
	//         	TableData[i]=
	//         	{
	// 	            "qpoRowId" : $(tr).find('td:eq(2)').text()
	// 	            , "vType" : $(tr).find('td:eq(3)').text()
	// 	            , "vNo" :$(tr).find('td:eq(4)').text()
	// 	            , "vDt" :$(tr).find('td:eq(5)').text()
	// 	            , "partyRowId" :$(tr).find('td:eq(6)').text()
	// 	            , "partyName" :$(tr).find('td:eq(7)').text()
	// 	            , "letterNo" :$(tr).find('td:eq(8)').text()
	// 	            , "totalAmt" :$(tr).find('td:eq(9)').text()
	// 	            , "discountPer" :$(tr).find('td:eq(10)').text()
	// 	            , "discountAmt" :$(tr).find('td:eq(11)').text()
	// 	            , "vatPer" :$(tr).find('td:eq(13)').text()
	// 	            , "vatAmt" :$(tr).find('td:eq(14)').text()
	// 	            , "net" :$(tr).find('td:eq(15)').text()
	// 	            , "totalQty" :$(tr).find('td:eq(16)').text()
	//         	}   
	//         	i++; 
	//         // }
	//     }); 
	//     // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	//     tblRowsCount = i-1;
	//     return TableData;
	// }



</script>
<div class="container">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Ledger</h3>
			<?php
				echo "<label style='color: lightgrey; font-weight: normal; margin-top:10px;' id='lblCustomerId'>-2</label>";
				echo "<label style='color: red; font-weight: normal; margin-top:10px; margin-left:10px;' id='lblCustomerAddress'> - </label>";
				echo "<label style='color: green; font-weight: normal; margin-top:10px; margin-left:10px;' id='lblCustomerMobile'> - </label>";
				echo "<label style='color: blue; font-weight: normal; margin-top:10px; margin-left:10px;' id='lblCustomerRemarks'> - </label>";
			?>
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
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="display: none;">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>Party:</label>";
							echo form_dropdown('cboCustomer',$customers, '-1',"class='form-control' id='cboCustomer'");
		              	?>
		          	</div>
		          	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						<?php
							echo form_input('txtCustomerName', '', "class='form-control' id='txtCustomerName' style='' maxlength=70 autocomplete='off' placeholder='Name'");
			          	?>
			      	</div>
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
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
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:470px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='display:none;'>ledgerRowid</th>
					 	<th style='display:none1;'>V.Type</th>
					 	<th style='display:none1;'>Rem</th>
					 	<th>Dt</th>
					 	<th style='display:none;'>For What</th>
					 	<th>Paid</th>
					 	<th>Recd.</th>
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
		          		<th style='display:none1;'>V.Rowid</th>
					 	<th>Item</th>
					 	<th>Qty</th>
					 	<th>Rate [dis,c/sgst]</th>
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
		            , "Rem" :$(tr).find('td:eq(2)').text()
		            , "dt" :$(tr).find('td:eq(3)').text()
		            , "Dr" :$(tr).find('td:eq(5)').text()
		            , "Cr" :$(tr).find('td:eq(6)').text()
		            , "Bal" :$(tr).find('td:eq(7)').text()
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
					console.log(data);
					if(data)
					{
						window.location.href=data;
					}
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
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
							balance: obj.balance
					}
		});

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
			    $("#lblCustomerId").text( ui.item.customerRowId );
			    $("#lblCustomerMobile").text( ui.item.mobile1 );
			    $("#lblCustomerAddress").text( ui.item.address );
			    $("#lblCustomerRemarks").text( ui.item.remarks );
			    // $("#txtBalance").val( ui.item.balance );
			    // alert();
	        	}
		    }).blur(function() {
				  if( !select ) 
				  {
				  	$("#lblCustomerId").text('-1');
				  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  	if( $("#lblCustomerId").text() == '-1' )
				  	{
				  		// $("#spanNewOrOld").text("New");
				  		// $("#spanNewOrOld").removeClass("label-success");
				  		// $("#spanNewOrOld").addClass("label-danger");
				    //     $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				    //     $("#spanNewOrOld").animate({opacity: '1'}, 1000);
					   //  $("#txtMobile").val( '' );
					   //  $("#txtAddress").val( '' );
					   //  $("#txtCustomerRemarks").val( '' );

				  	}
				  	else
				  	{
				  		// $("#spanNewOrOld").text("Old");
				  		// $("#spanNewOrOld").removeClass("label-danger");
				  		// $("#spanNewOrOld").addClass("label-success");
				    //     $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				    //     $("#spanNewOrOld").animate({opacity: '1'}, 1000);
				  	}
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );
</script>