<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/jquery.stickytable.min.js"></script>
<link rel='stylesheet' href='<?php  echo base_url();  ?>bootstrap/css/jquery.stickytable.min.css'>

<style type="text/css">
	.ui-autocomplete {
	    max-height: 200px;
	    overflow-y: auto;   /* prevent horizontal scrollbar */
	    overflow-x: hidden; /* add padding to account for vertical scrollbar */
	    z-index:1000 !important;
	}

	#txtDate {position: relative; z-index:101;}
	#txtDueDate {position: relative; z-index:101;}
</style>
<script type="text/javascript">
	var controller='SalesReturn_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Sales Return";


	var tblRowsCount=0;
	function storeTblValuesItems()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// alert($(tr).find('td:eq(3)').text().length);
	    	if( $(tr).find('td:eq(3)').text().length > 0 )
	    	{
	    		
	        	TableData[i]=
	        	{
		            "itemRowId" : $(tr).find('td:eq(1)').text()
		            , "itemName" : $(tr).find('td:eq(2)').text()
		            , "qty" :$(tr).find('td:eq(3)').text()
		            , "rqty" :$(tr).find('td:eq(4)').text()
		            , "rate" :$(tr).find('td:eq(5)').text()
		            , "amt" :$(tr).find('td:eq(6)').text()
	        	}   
	        	i++; 
	        }
	    }); 
	    // TableData.shift();  // first row will be heading - so remove
	    tblRowsCount = i;
	    return TableData;
	}
	
	function saveData()
	{	
		// alert(serviceChargeFlag);
		var TableDataItems;
		TableDataItems = storeTblValuesItems();
		TableDataItems = JSON.stringify(TableDataItems);
		// alert(JSON.stringify(TableDataItems));
		// return;
		// alert(tblRowsCount);
		if(tblRowsCount == 0)
		{
			alertPopup("Zero items to save", 5000, 'red');
			// $("#txtDate").focus();
			return;
		}	
		
		
		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			msgBoxError("Error","Invalid date...");
			// $("#txtDate").focus();
			return;
		}

		totalAmt = parseFloat($("#txtTotalAmt").val());
		alreadySrDone = $("#txtAlreadySrDone").val();
		srRowId = $("#txtSrRowId").val();
		
		// alert(globalDbRowId);
		// return;
		if($("#btnSave").text() == "Save Sales Return")
		{
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					// 'dataType': 'json',
					'data': {
								'dt': dt
								, 'dbRowId': globalDbRowId
								, 'alreadySrDone': alreadySrDone
								, 'srRowId': srRowId
								, 'customerRowId': globalCustomerRowId
								, 'totalAmt': totalAmt
								, 'TableDataItems': TableDataItems
							},
					'success': function(data)
					{
						alertPopup('Reloading Page...', 8000);

						location.reload();
						
					},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
		}
		
	}


	function loadAllRecordsSold()
	{
		// alert(rowId);
		$.ajax({
				'url': base_url + '/' + controller + '/loadAllRecordsSold',
				'type': 'POST',
				'dataType': 'json',
				'success': function(data)
				{
					if(data)
					{
						setTableSold(data['records'])
						alertPopup('Records loaded...', 4000);
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
	}

	// function searchRecords()
	// {
	// 	// alert(rowId);
	// 	searchWhat = $("#txtSearch").val().trim();
	// 	if(searchWhat == "" )
	// 	{
	// 		msgBoxError("Error", "Blank search...");
	// 		return;
	// 	}
	// 	$.ajax({
	// 			'url': base_url + '/' + controller + '/searchRecords',
	// 			'type': 'POST',
	// 			'dataType': 'json',
	// 			'data': {
	// 							'searchWhat': searchWhat
								
	// 						},
	// 			'success': function(data)
	// 			{
	// 				if(data)
	// 				{
	// 					setTablePuraneDb(data['records'])
	// 					alertPopup('Records loaded...', 4000);
	// 				}
	// 			}
	// 		});
	// }


</script>
<div class="container" style="width:95%">
	<div class="row" style='margin-top:-25px;'>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off'");
          	?>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<h4 class="text-center">Sales Return</h4>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-right">
			<?php
				echo "<input type='button' onclick='loadAllRecordsSold();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
	</div>
	 
	<div class="row" style="background-color: #F0F0F0; padding-top: 10px; padding-bottom: 10px;" >
		<div id="divTableSold" class="divTable tblScroll" style="border:1px solid lightgray; height:240px; overflow:auto;">
			<table class='table  table-striped table-hover' id='tblSold'>
			 <thead>
				 <tr>
					<th style='display:none1;'>rowId#</th>
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
				 	<th>Advance Paid</th>
				 	<th>Balance</th>
				 	<th>Due Dt.</th>
				 	<th>Remarks</th>
				 </tr>
			 </thead>
			 <tbody>
				 <?php 
					foreach ($recordsSold as $row) 
					{
					 	$rowId = $row['dbRowId'];
					 	echo "<tr>";						//onClick="editThis(this);
					 	echo "<td style='width:0px;display:none1;'>".$row['dbRowId']."</td>";
					 	$vdt = strtotime($row['dbDt']);
						$vdt = date('d-M-Y', $vdt);
					 	echo "<td>".$vdt."</td>";
					 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
					 	echo "<td>".$row['customerName']."</td>";
					 	echo "<td>".$row['totalAmount']."</td>";
					 	echo "<td>".$row['totalDiscount']."</td>";
					 	echo "<td>".$row['pretaxAmt']."</td>";
					 	echo "<td>".$row['totalIgst']."</td>";
					 	echo "<td>".$row['totalCgst']."</td>";
					 	echo "<td>".$row['totalSgst']."</td>";
					 	echo "<td>".$row['netAmt']."</td>";
					 	echo "<td>".$row['advancePaid']."</td>";
					 	echo "<td>".$row['balance']."</td>";
					 	if($row['dueDate'] != "")
						{
						 	$vdt = strtotime($row['dueDate']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						}
						else
						{
							echo "<td></td>";
						}
						echo "<td>".$row['remarks']."</td>";
						echo "</tr>";
					}
				 ?>
			 </tbody>
			</table>
		</div>
	</div>

    <div class="row" style="margin-top: 5px;">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 sticky-table sticky-headers sticky-ltr-cells" id="divTable" style="overflow:auto; height:320px;">
			<table style="table-layout: fixed; border: 1px solid lightgrey;" id='tbl1' class="table table-condensed">
	           <thead>
	           <tr class="sticky-row" style="">
	            <th class="sticky-cell" width="50">S.N.</th>
	            <th width="50" style='display:none1;'>Item Row Id</th>
	            <th width="200">Item</th>
	            <th width="50">Qty</th>
	            <th width="60">R.Qty</th>
	            <th width="50">Rate</th>
	            <th width="80">Amt</th>
	            <th width="50" style='display:none;'>D. Per</th>
	            <th width="50" style='display:none;'>D. Amt.</th>
	            <th width="80" style='display:none;'>Pre Tax Amt</th>
	            <th width="50" style='display:none;'>IGST</th>
	            <th width="50" style='display:none;'>IGST Amt</th>
	            <th width="50" style='display:none;'>CGST</th>
	            <th width="50" style='display:none;'>CGST Amt</th>
	            <th width="50" style='display:none;'>SGST</th>
	            <th width="50" style='display:none;'>SGST Amt</th>
	            <th width="100" style='display:none;'>Net Amt</th>
	            
	           </tr>
	           </thead>
          </table>
		</div>
	</div>

	<div class="row" style="margin-top: 10px;background-color: #F0F0F0; padding-top:10px;padding-bottom:10px;">
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total Amt.:</label>";
				echo '<input type="number"  step="1" name="txtTotalAmt" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalAmt" />';
          	?>
      	</div>
		   	
	<!-- </div>

	<div class="row" style="margin-top: 20px;"> -->
		
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<input type="text" id="txtAlreadySrDone" disabled="">
			<input type="text" id="txtSrRowId" disabled="">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
          	?>
          	<button id="btnSave" class="btn btn-warning btn-block" onclick="saveData();">Save Sales Return</button>
      	</div>
	</div>

	<div class="row" style="display: none;">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
		<?php
			// echo "<label style='color: black; font-weight: normal;'>In Words:</label>";
			// echo '<input type="text" disabled name="txtWords" value="" placeholder="" class="form-control" id="txtWords" />';
      	?>
      	</div>
  	</div>


</div> <!-- CONTAINER CLOSE -->


		  

<script type="text/javascript">
	$( "#txtDate" ).datepicker({
		dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
	});
    // Set the Current Date as Default
	$("#txtDate").val(dateFormat(new Date()));

	$( "#txtDueDate" ).datepicker({
		dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
	});
          	

	
	      	
			function doAmtTotal()
			{
				var amtTotal=0;
				var discountTotal=0;
				var pretaxTotal=0;
				var igstTotal=0;
				var cgstTotal=0;
				var sgstTotal=0;
				var netTotal=0;
				var ppTotal=0;
				$("#tbl1").find("tr:gt(0)").each(function(i){
					if( isNaN(parseFloat( $(this).find("td:eq(6)").text() )) == false )
					{
						amtTotal += parseFloat( $(this).find("td:eq(6)").text() );
						
					}
				});
				$("#txtTotalAmt").val(amtTotal.toFixed(2));
				
			}

			
			function doRowTotal()
			{
				// alert();
				var rowIndex = $(this).parent().index();
				var qty = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text() );				
				if( isNaN(qty) ) 
				{
					qty = 0;
				}
				var rate = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(5)").text() ); 
				if( isNaN(rate) ) 
				{
					rate = 0;
				}
				var rowAmt = qty * rate;
				rowAmt = rowAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(6)").text( rowAmt );

				var dis = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(6)").text() );				
				if( isNaN(dis) ) 
				{
					dis = 0;
				}
				

				doAmtTotal();
				// calcBalNow();
			}

		

	

  </script>


  <script type="text/javascript">
	var globalrowid;
	var editFlag = 0;
	


	function setTableSold(records)
	{
		// var totalAdvance = 0;
		// $("#tblOldDb").find("tr:gt(0)").remove(); //// empty first
		$("#tblSold").empty();
        var table = document.getElementById("tblSold");
        for(i=0; i<records.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);

         
          var cell = row.insertCell(0);
          // cell.style.display="none";
          cell.innerHTML = records[i].dbRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = dateFormat(new Date(records[i].dbDt));
          // cell.style.display="none";
          var cell = row.insertCell(2);
          cell.innerHTML = records[i].customerRowId;
          cell.style.display="none";
          var cell = row.insertCell(3);
          cell.innerHTML = records[i].customerName;
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].totalAmount;
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].totalDiscount;
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].pretaxAmt;
          var cell = row.insertCell(7);
          cell.innerHTML = records[i].totalIgst;
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].totalCgst;
          var cell = row.insertCell(9);
          cell.innerHTML = records[i].totalSgst;
          var cell = row.insertCell(10);
          cell.innerHTML = records[i].netAmt;
          var cell = row.insertCell(11);
          cell.innerHTML = records[i].advancePaid;
          var cell = row.insertCell(12);
          cell.innerHTML = records[i].balance;
          var cell = row.insertCell(13);
          if(records[i].dueDate == null)
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


		myDataTable.destroy();
	    myDataTable=$('#tblSold').DataTable({
		    paging: false,
		    ordering: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

		});

	    $('#tblSold tr').off();
	    $('#tblSold tr').on('click', highlightRowAlag);
	    $('#tblSold').off();
	    $("#tblSold tr").find("td:gt(0)").on('click', loadDetail);

	}
	
	var globalDbRowId;
	var globalCustomerRowId;
	function loadDetail()
	{
		$("#tbl1").find("tr:gt(0)").remove();
	    dbRowId = $(this).parent().find("td:eq(0)").text();
	    globalDbRowId = $(this).parent().find("td:eq(0)").text();
	    globalCustomerRowId = $(this).parent().find("td:eq(2)").text();
	    // alert(dbRowId);
	    $.ajax({
				'url': base_url + '/' + controller + '/getSoldDetial',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dbRowId': dbRowId
						},
				'success': function(data)
				{
				    	// alert(JSON.stringify(data));
						// alert(JSON.stringify(data['srDetail']));

	      			var table = document.getElementById("tbl1");
					for(i=0; i<data['soldDetail'].length; i++)
				    {

			          var newRowIndex = table.rows.length;
			          var row = table.insertRow(newRowIndex);

			          var cell = row.insertCell(0);
			          cell.innerHTML = i+1; 			///SN
			          
			          var cell = row.insertCell(1);
			          cell.innerHTML = data['soldDetail'][i].itemRowId;
			          // cell.style.display="none";

			          var cell = row.insertCell(2);
			          cell.innerHTML = data['soldDetail'][i].itemName;

			          var cell = row.insertCell(3);
			          cell.innerHTML = data['soldDetail'][i].qty;

			          var cell = row.insertCell(4);
			          cell.innerHTML = 0;
		          	  cell.contentEditable="true";
		          	  cell.className = "clsReturnQty";


			          var cell = row.insertCell(5);
			          cell.innerHTML = data['soldDetail'][i].rate;

			          var cell = row.insertCell(6);
			          // var amt =
			          cell.innerHTML = "0";//data['soldDetail'][i].amt;

			          var cell = row.insertCell(7);
			          cell.innerHTML = data['soldDetail'][i].discountPer;
			          cell.style.display="none";

			          var cell = row.insertCell(8);
			          cell.innerHTML = data['soldDetail'][i].discountAmt;
			          cell.style.display="none";

			          var cell = row.insertCell(9);
			          cell.innerHTML = data['soldDetail'][i].pretaxAmt;
			          cell.style.display="none";

			          var cell = row.insertCell(10);
			          cell.innerHTML = data['soldDetail'][i].igst;
			          cell.style.display="none";

			          var cell = row.insertCell(11);
			          cell.innerHTML = data['soldDetail'][i].igstAmt;
			          cell.style.display="none";

			          var cell = row.insertCell(12);
			          cell.innerHTML = data['soldDetail'][i].cgst;
			          cell.style.display="none";

			          var cell = row.insertCell(13);
			          cell.innerHTML = data['soldDetail'][i].cgstAmt;
			          cell.style.display="none";

			          var cell = row.insertCell(14);
			          cell.innerHTML = data['soldDetail'][i].sgst;
			          cell.style.display="none";

			          var cell = row.insertCell(15);
			          cell.innerHTML = data['soldDetail'][i].sgstAmt;
			          cell.style.display="none";

			          var cell = row.insertCell(16);
			          cell.innerHTML = data['soldDetail'][i].netAmt;
			          cell.style.display="none";

			    	}	
			    	// alert(data['srDetail'].length);
			    	for(i=0; i<data['srDetail'].length; i++)
				    {
			         	$("#tbl1").find("tr:eq(" + (i+1) + ")" ).find("td:eq(4)").text(data['srDetail'][i].rqty);
			         	$("#tbl1").find("tr:eq(" + (i+1) + ")" ).find("td:eq(6)").text(data['srDetail'][i].amt);
			         	if(data['srDetail'][i].rqty > 0)
			         	{
			            	$("#tbl1").find("tr:eq(" + (i+1) + ")" ).find("td:eq(4)").css({'color':'red'});
			        	}
			    	}	

					$('.clsReturnQty').on('keyup', doRowTotal);
					if(data['srDetail'].length > 0)
					{
						$("#txtAlreadySrDone").val("Yes");
						$("#txtSrRowId").val(data['srDetail'][0].srRowId);
					}
					else
					{
						$("#txtAlreadySrDone").val("No");
						$("#txtSrRowId").val("-1");

					}
					doRowTotal();
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
		    myDataTable = $('#tblSold').DataTable({
			    paging: false,
			    ordering: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});

	    	$('#tblSold tr').on('click', highlightRowAlag);
	    	$("#tblSold tr").find("td:gt(0)").on('click', loadDetail);

		} );


	
  </script>