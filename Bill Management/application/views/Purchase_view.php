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
	var controller='Purchase_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Purchase";


	var tblRowsCount=0;
	var sareSellingPriceDale = "Y";
	function storeTblValuesItems()
	{
		sareSellingPriceDale = "Y";
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// alert($(tr).find('td:eq(3)').text().length);
	    	if( $(tr).find('td:eq(5)').text().length > 0 )
	    	{
	        	TableData[i]=
	        	{
		            "itemRowId" : $(tr).find('td:eq(1)').text()
		            , "itemName" : $(tr).find('td:eq(2)').text()
		            , "qty" :$(tr).find('td:eq(3)').text()
		            , "rate" :$(tr).find('td:eq(4)').text()
		            , "amt" :$(tr).find('td:eq(5)').text()
		            , "discountPer" :$(tr).find('td:eq(6)').text()
		            , "discountAmt" :$(tr).find('td:eq(7)').text()
		            , "pretaxAmt" :$(tr).find('td:eq(8)').text()
		            , "igst" :$(tr).find('td:eq(9)').text()
		            , "igstAmt" :$(tr).find('td:eq(10)').text()
		            , "cgst" :$(tr).find('td:eq(11)').text()
		            , "cgstAmt" :$(tr).find('td:eq(12)').text()
		            , "sgst" :$(tr).find('td:eq(13)').text()
		            , "sgstAmt" :$(tr).find('td:eq(14)').text()
		            , "netAmt" :$(tr).find('td:eq(15)').text()
		            , "sellingPricePer" :$(tr).find('td:eq(16)').text()
		            , "sellingPrice" :$(tr).find('td:eq(17)').text()
		            , "itemRemarks" :$(tr).find('td:eq(18)').text()
		            , "freightPerItem" :$(tr).find('td:eq(22)').text()
	        	}   
	        	if( row>0 && (isNaN(parseFloat($(tr).find('td:eq(16)').text())) == true || isNaN(parseFloat($(tr).find('td:eq(17)').text())) == true) )
	        	{
	        		sareSellingPriceDale = "N";
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
		if(tblRowsCount == 0)
		{
			msgBoxError("Error", "Zero items to save...");
			return;
		}

		if(sareSellingPriceDale	 == "N")
		{
			msgBoxError("Error", "Enter all SELLING prices");
			return;
		}


		///// Checking special chars in itemName like '"\'
		vSpecialCharFound = 0;
		$('#tbl1 tr').each(function(row, tr)
	    {
		    itemName = $(tr).find('td:eq(2)').text();
		    if (itemName.indexOf('\'') >= 0 || itemName.indexOf('"') >= 0)
		    {
		    	vSpecialCharFound = 1;
		    }
	    }); 		
		// alert(vSpecialCharFound);
		if(vSpecialCharFound == 1)
		{
			msgBoxError("Error", "Special character found in ITEM NAME...");
			// alertPopup("Special character found in ITEM NAME...", 8000, 'red');
			return;
		}
		///// END - Checking special chars in itemName like '"\'

		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			msgBoxError("Error", "Invalid date...");
			// alertPopup("Invalid date...", 5000, 'red');
			// $("#txtDate").focus();
			return;
		}

		customerRowId = $("#lblSupplierId").text();
		customerName = $("#txtSupplierName").val().trim();
		if(customerName == "" )
		{
			msgBoxError("Error", "Invalid supplier name...");
			// alertPopup("Invalid supplier name...", 5000, 'red');
			// $("#txtSupplierName").focus();
			return;
		}
		mobile1 = $("#txtMobile").val().trim();
		if(mobile1 == "" )
		{
			msgBoxError("Error", "Mobile no. can not be blank...");
			return;
		}
		address = $("#txtAddress").val().trim();
		customerRemarks = $("#txtSupplierRemarks").val().trim();
		totalAmt = parseFloat($("#txtTotalAmt").val());
		totalDiscount = parseFloat($("#txtTotalDiscount").val());
		totalPretaxAmt = parseFloat($("#txtPretaxAmt").val());
		totalIgst = parseFloat($("#txtTotalIgst").val());
		totalCgst = parseFloat($("#txtTotalCgst").val());
		totalSgst = parseFloat($("#txtTotalSgst").val());
		netAmt = parseFloat($("#txtNetAmt").val());
		advancePaid = parseFloat($("#txtAmtPaid").val());
		balance = parseFloat($("#txtBalance").val());
		dueDate = $("#txtDueDate").val().trim();
		if( dueDate != "" || balance>0)
		{
			dtOk = testDate("txtDueDate");
			if(dtOk == false)
			{
				msgBoxError("Error", "Invalid due date...");
				// alertPopup("Invalid due date...", 8000, 'red');
				// $("#txtDueDate").focus();
				return;
			}
		}
		remarks = $("#txtRemarks").val().trim();
		inWords = $("#txtWords").val().trim();
		totalFreight = $("#txtTotalFreight").val();
		if(totalFreight<=0)
		{
			zeroF=confirm("Freight is ZERO\nPress OK to Continue...");
			if(zeroF==false)
			{
				return;
			}
		}
		totalQty = $("#txtTotalQty").val();

		if($("#btnSave").text() == "Save Purchase")
		{
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
								, 'totalAmt': totalAmt
								, 'totalDiscount': totalDiscount
								, 'totalPretaxAmt': totalPretaxAmt
								, 'totalIgst': totalIgst
								, 'totalCgst': totalCgst
								, 'totalSgst': totalSgst
								, 'totalFreight': totalFreight
								, 'totalQty': totalQty
								, 'netAmt': netAmt
								, 'advancePaid': advancePaid
								, 'balance': balance
								, 'dueDate': dueDate
								, 'remarks': remarks
								, 'inWords': inWords
								, 'TableDataItems': TableDataItems
							},
					'success': function(data)
					{
						blankControls();	
						$("#lblSupplierId").text("");
						$("#tbl1").find("tr:gt(0)").remove();
						addRow();
						$("#txtDate").val(dateFormat(new Date()));
						msgBoxDone("Done", "Record saved...");
						// alertPopup("Record saved...", 8000);
						setTablePuraneDb(data['records']);
						if(customerRowId == "-1")
						{
							location.reload();
						}
						// window.location.href=data;
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
								, 'customerName': customerName
								, 'mobile1': mobile1
								, 'address': address
								, 'customerRemarks': customerRemarks
								, 'totalAmt': totalAmt
								, 'totalDiscount': totalDiscount
								, 'totalPretaxAmt': totalPretaxAmt
								, 'totalIgst': totalIgst
								, 'totalCgst': totalCgst
								, 'totalSgst': totalSgst
								, 'totalFreight': totalFreight
								, 'totalQty': totalQty
								, 'netAmt': netAmt
								, 'advancePaid': advancePaid
								, 'balance': balance
								, 'dueDate': dueDate
								, 'remarks': remarks
								, 'inWords': inWords
								, 'TableDataItems': TableDataItems							},
					'success': function(data)
					{
						blankControls()
						$("#tbl1").find("tr:gt(0)").remove();
						addRow();
						$("#txtDate").val(dateFormat(new Date()));;
						msgBoxDone("Done", "Record updated...");
						// alertPopup("Record updated...", 8000);
						setTablePuraneDb(data['records']);
						$("#txtSupplierName").prop("disabled", false);
						$("#btnSave").text("Save Purchase");
						// window.location.href=data;
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
					setTablePuraneDb(data['records'])
					alertPopup('Records loaded...', 4000);
					// blankControls();
					// $("#txtBookName").focus();
				}
			},
			'error': function(jqXHR, exception)
	          {
	            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
	            $("#modalAjaxErrorMsg").modal('toggle');
	          }
		});
	}

	function searchRecords()
	{
		// alert(rowId);
		searchWhat = $("#txtSearch").val().trim();
		if(searchWhat == "" )
		{
			msgBoxError("Error", "Blank search...");
			return;
		}
		$.ajax({
				'url': base_url + '/' + controller + '/searchRecords',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'searchWhat': searchWhat
						},
				'success': function(data)
				{
					if(data)
					{
						setTablePuraneDb(data['records'])
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
</script>
<div class="container" style="width: 95%;">
	<div class="row" style='margin-top: -25px;'>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
			<h4 class="text-center" style=''>Purchase</h4>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 text-right">
			<label style='font-size: 16pt;' id='lblNewOrOld'><span id='spanNewOrOld' class='label label-danger'>New Supplier</span></label>
			<label style='color: lightgrey; font-weight: normal;' id='lblSupplierId'></label>

		</div>
	</div>
	 
	<div class="row" style="background-color: #F0F0F0; padding-top: 10px; padding-bottom: 10px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Date:</label>";
				echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Supplier Name:</label>";
				// <h4>Example <span class="label label-default">New</span></h4>
				echo form_input('txtSupplierName', '', "class='form-control' id='txtSupplierName' style='' maxlength=70 autocomplete='off' placeholder='Supplier'");
          	?>
      	</div>
      	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Balance:</label>";
				echo form_input('txtSupplierBalance', '', "class='form-control' id='txtSupplierBalance' style='' placeholder='0' disabled='yes'");
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style="margin-top: 5px;">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Mobile No.:</label>";
				echo form_input('txtMobile', '', "class='form-control' id='txtMobile' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="margin-top: 5px;">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Address:</label>";
				echo form_input('txtAddress', '', "class='form-control' id='txtAddress' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style="margin-top: 5px;">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Supplier Remarks:</label>";
				echo form_input('txtSupplierRemarks', '', "class='form-control' id='txtSupplierRemarks' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
	</div>

	

    <div class="row" style="margin-top: 10px;">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 sticky-table sticky-headers sticky-ltr-cells" id="divTable" style="overflow:auto; height:320px;">
			<table style="table-layout: fixed; border: 1px solid lightgrey;" id='tbl1' class="table table-condensed ">
	           <thead>
	           <tr class="sticky-row" style="">
	            <th class="sticky-cell" width="50">S.N.</th>
	            <th width="50" style='display:none1;'>Item Row Id</th>
	            <th width="200">Item</th>
	            <th width="50">Qty</th>
	            <th width="50">Rate</th>
	            <th width="80">Amt</th>
	            <th width="50">D. Per</th>
	            <th width="50">D. Amt.</th>
	            <th width="80">Pre Tax Amt</th>
	            <th width="50" style='display:none;'>IGST</th>
	            <th width="50" style='display:none;'>IGST Amt</th>
	            <th width="50">CGST</th>
	            <th width="50" style='display:none;'>CGST Amt</th>
	            <th width="50">SGST</th>
	            <th width="50" style='display:none;'>SGST Amt</th>
	            <th width="50">Net Amt</th>
	            <th width="50">SP%</th>
	            <th width="80">SP/pc</th>
	            <th width="100">Remarks</th>
	            <th width="50"></th>
	            <th width="50"></th>
	            <th width="50">PPPP</th>
	            <th width="50">Fr.</th>
	            <th width="50">Log</th>
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
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total Disc.:</label>";
				echo '<input type="number"  step="1" name="txtTotalDiscount" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalDiscount" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Pretax Amt.:</label>";
				echo '<input type="number"  step="1" name="txtPretaxAmt" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtPretaxAmt" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total IGST:</label>";
				echo '<input type="number"  step="1" name="txtTotalIgst" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalIgst" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total CGST:</label>";
				echo '<input type="number"  step="1" name="txtTotalCgst" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalCgst" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total SGST:</label>";
				echo '<input type="number"  step="1" name="txtTotalSgst" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalSgst" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Net Amt.:</label>";
				echo '<input type="number"  step="1" name="txtNetAmt" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtNetAmt" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Amt. Paid:</label>";
				echo '<input type="number"  step="1" name="txtAmtPaid" value="0" placeholder="" class="form-control" maxlength="15" id="txtAmtPaid" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Balance:</label>";
				echo '<input type="number"  step="1" name="txtBalance" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtBalance" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style="">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Due Date:</label>";
				echo form_input('txtDueDate', '', "class='form-control' id='txtDueDate' style='' maxlength=10 autocomplete='off'");
          	?>
		</div>      	
	<!-- </div>

	<div class="row" style="margin-top: 20px;"> -->
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
				echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
      	
      	
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total Qty:</label>";
				echo form_input('txtTotalQty', '', "class='form-control' id='txtTotalQty' style='' maxlength=20 autocomplete='off' disabled");
          	?>
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Freight:</label>";
				echo '<input type="number"  step="1" name="txtTotalFreight" value="0" placeholder="" class="form-control" maxlength="15" id="txtTotalFreight" />';
          	?>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-center">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-center">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
          	?>
          	<button id="btnSave" class="btn btn-danger btn-block" onclick="saveData();">Save Purchase</button>
      	</div>
	</div>

	<div class="row" style="display: none;">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
		<?php
			echo "<label style='color: black; font-weight: normal;'>In Words:</label>";
			echo '<input type="text" disabled name="txtWords" value="" placeholder="" class="form-control" id="txtWords" />';
      	?>
      	</div>
  	</div>

	<div class="row"  style="margin-top: 25px;">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div id="divTableOldDb" class="divTable tblScroll" style="border:1px solid lightgray; height:300px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover ' id='tblOldDb'>
				 <thead>
					 <tr>
					 	<th  width="50" class="editRecord text-center" style='display:none1;'>Edit</th>
					 	<th  width="50" class="text-center">Delete</th>
						<th style='display:none1;'>rowId</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Supplier Name</th>
					 	<th>Total Amt</th>
					 	<th>Total Disc.</th>
					 	<th>Pretax Amt</th>
					 	<th>Total IGST</th>
					 	<th>Total CGST</th>
					 	<th>Total SGST</th>
					 	<th>Net Amt.</th>
					 	<th>Advance Paid</th>
					 	<th>Balance</th>
					 	<th>Due Dt.</th>
					 	<th>Remarks</th>
					 	<th>T.Fr.</th>
					 	<th>T.Qty</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($records as $row) 
						{
						 	$rowId = $row['purchaseRowId'];
						 	echo "<tr>";						//onClick="editThis(this);
						 	if($row['deleted'] == "N")
						 	{
								echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
							}
							else
							{
								echo '<td style="color: red;" class="text-center"><span class="">Deleted</span></td>
								   <td style="color: red;" class="text-center"><span class="">Deleted</span></td>';		
							}
						 	echo "<td style='width:0px;display:none1;'>".$row['purchaseRowId']."</td>";
						 	$vdt = strtotime($row['purchaseDt']);
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
						 	echo "<td>".$row['freightTotal']."</td>";
						 	echo "<td>".$row['totalQty']."</td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="border:1px solid lightgray; height:300px; overflow:auto;">
			<table style="border: 1px solid lightgrey;" id='tblProductsSaved' class="table table-bordered">
	           <thead>
	           <tr>
	            <th>S.N.</th>
	            <th style='display:none;'>Item Row Id</th>
	            <th>Item</th>
	            <th>Qty</th>
	            <th>Rate</th>
	            <th>Amt</th>
	            <th>D. Per</th>
	            <th style='display:none;'>D. Amt.</th>
	            <th style='display:none;'>Pre Tax Amt</th>
	            <th style='display:none;'>IG</th>
	            <th style='display:none;'>IGST Amt</th>
	            <th>CG</th>
	            <th style='display:none;'>CGST Amt</th>
	            <th>SG</th>
	            <th style='display:none;'>SGST Amt</th>
	            <th>Net</th>
	            <th style='display:none;'>SP%</th>
	            <th>SP/pc</th>
	            <th>PP</th>
	            <th>Fr</th>
	           </tr>
	           </thead>
          </table>
		</div>
	</div>

	<div class="row" style="margin-top:20px;margin-bottom:20px;" >
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo '<input type="text" placeholder="Part of Name or Remarks" class="form-control" maxlength="15" id="txtSearch" />';
          	?>
      	</div>
      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<input type='button' onclick='searchRecords();' value='Search Records' id='btnSearch' class='btn btn-success form-control'>";
	      	?>
		</div>
      	
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<input type='button' onclick='loadAllRecords();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
	</div>

			<!-- Model PurchaseLog -->
			  <div class="modal" id="myModalPurchaseLog" role="dialog">
			    <div class="modal-dialog modal-lg">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title" id="h4PurchaseLog">Purchase Log</h4>
			        </div>
			        <div class="modal-body" style="overflow: auto; height: 300px;">
			          <table id='tblPurchaseLog' class="table table-stripped">
			          		<th style='display:none;'>Rowid</th>
						 	<th>Date</th>
						 	<th>Supplier Name</th>
						 	<th>Item</th>
						 	<th>Qty</th>
						 	<th>Rate</th>
						 	<th>Amt</th>
						 	<th>D%</th>
						 	<th>DAmt</th>
						 	<th>CGST%</th>
						 	<th>SGST%</th>
						 	<th>Net</th>
						 	<th>PP</th>
						 	<th>Fr</th>
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
	
          	

	$(document).ready( function () {
		$( "#txtDate" ).datepicker({
			dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
		});
	    // Set the Current Date as Default
		$("#txtDate").val(dateFormat(new Date()));

		$( "#txtDueDate" ).datepicker({
			dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
		});


		$("#txtTotalFreight").keyup(function(e) {
			// var totalQty = $('#txtTotalQty').val();
			// var totalFreight = $('#txtTotalFreight').val();
			// var amtForEachItem = totalFreight/totalQty;
			// $('#tbl1 tr').each(function(row, tr)
	  //   	{
			// 	$(tr).find('td:eq(21)').text( amtForEachItem.toFixed(2) );
	  //   	});
	  		var totalAmt = $('#txtNetAmt').val();
			var totalFreight = $('#txtTotalFreight').val();
			// var amtForEachItem = totalFreight/totalQty;
			$('#tbl1 tr').each(function(row, tr)
	    	{
				amtPer = $(tr).find('td:eq(15)').text() * 100 / totalAmt;
				freightShare = totalFreight * amtPer / 100;
				freightPerPc = freightShare / $(tr).find('td:eq(3)').text();
				$(tr).find('td:eq(22)').text( freightPerPc.toFixed(2) );
	    	});



		});

		$("#txtEval").keypress(function(e) {
		    if(e.which == 13) {
		    	var result = eval($('#txtEval').val());
		        $('#txtEvalResult').val( result.toFixed(2) );
		    }
		});

		  $("#tbl1").find("tr:gt(0)").remove();
		  addRow();

		  $("#txtSupplierName").focus();

		});


	      $("button.table-add").on("click",addRow);
	      	var sn=1;
			function addRow()
			{
				  var table = document.getElementById("tbl1");
		          newRowIndex = table.rows.length;
		          row = table.insertRow(newRowIndex);

		          var cell = row.insertCell(0);
		          cell.innerHTML = parseInt(sn++) ;
		          cell.style.backgroundColor="#F0F0F0";
		          cell.className = " sticky-cell";

		          var cell = row.insertCell(1);
		          cell.innerHTML = "";
		          cell.style.display="none1";

		          var cell = row.insertCell(2);
		          cell.innerHTML = "";
		          cell.contentEditable="true";
		          cell.className = "clsItem";
		          var cell = row.insertCell(3);
		          cell.innerHTML = "1";
		          cell.contentEditable="true";
		          cell.className = "clsQty";

		          var cell = row.insertCell(4);
		          cell.innerHTML = "";
		          cell.contentEditable="true";
		          cell.className = "clsRate";

		          var cell = row.insertCell(5);
		          cell.innerHTML = "";
		          // cell.contentEditable="true";
		          cell.className = "clsAmt";

		          var cell = row.insertCell(6);
		          cell.innerHTML = "0";
		          cell.contentEditable="true";
		          cell.className = "clsDiscountPer";

		          var cell = row.insertCell(7);
		          cell.innerHTML = "0";
		          cell.className = "clsDiscountAmt";

		          var cell = row.insertCell(8);
		          cell.innerHTML = "0";
		          cell.className = "clsPreTaxAmt";

		          var cell = row.insertCell(9);
		          cell.innerHTML = "0";
		          cell.contentEditable="true";
		          cell.className = "clsIgst";
		          cell.style.display="none";

		          var cell = row.insertCell(10);
		          cell.innerHTML = "0";
		          cell.className = "clsIgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(11);
		          cell.innerHTML = "0";
		          cell.contentEditable="true";
		          cell.className = "clsCgst";

		          var cell = row.insertCell(12);
		          cell.innerHTML = "0";
		          cell.className = "clsCgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(13);
		          cell.innerHTML = "0";
		          cell.contentEditable="true";
		          cell.className = "clsSgst";

		          var cell = row.insertCell(14);
		          cell.innerHTML = "0";
		          cell.className = "clsSgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(15);
		          cell.innerHTML = "0";
		          cell.className = "clsNetAmt";

		          var cell = row.insertCell(16);
		          cell.innerHTML = "0";
		          cell.className = "clsSpPer";
		          cell.contentEditable="true";

		          var cell = row.insertCell(17);
		          cell.innerHTML = "0";
		          cell.className = "clsSp";	
		          cell.contentEditable="true";	    

		          var cell = row.insertCell(18);
		          cell.innerHTML = "";
		          cell.className = "clsRemarks";	
		          cell.contentEditable="true";	       

		          var cell = row.insertCell(19);
		          cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";

		          var cell = row.insertCell(20);
		          cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
		          if(sn == 2) ///remove row not required in first row
			      {
			      	cell.innerHTML = "";
			      }

			      var cell = row.insertCell(21);
		          cell.innerHTML = "";
		          cell.style.color="red";

		          var cell = row.insertCell(22);
		          cell.innerHTML = "";
		          cell.contentEditable="true";	          

		          var cell = row.insertCell(23);
		          cell.innerHTML = "<button class='row-log' style='color:red;'> <span class=''> Log </span></button>";

			      $(".row-add").off();
			      $(".row-add").on('mouseover focus', function(){
			      	$(this).css("color", "green");
			      });
			      $(".row-add").on('mouseout blur', function(){
			      	$(this).css("color", "lightgrey");
			      });

			      $(".row-remove").off();
			      $(".row-remove").on('mouseover focus', function(){
			      	$(this).css("color", "red");
			      });
			      $(".row-remove").on('mouseout blur', function(){
			      	$(this).css("color", "lightgrey");
			      });

			      $(".clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst").off();
			      $('.clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst').on('keyup', doRowTotal);

			      $(".clsSpPer").off();
			      $('.clsSpPer').on('keyup', setSellingPrice);
			      $(".clsSp").off();
			      $('.clsSp').on('keyup', setSellingPercentage);

			      $('.row-remove').on('click', removeRow);

			      $(".row-log").off();
			      $('.row-log').on('click', showPurchaseLog);
			      $('.row-log').click(function () {
		   	$('#myModalPurchaseLog').modal('toggle');});

			      $("#tbl1").scrollLeft(0);
			      $("#tbl1").scrollTop($("#tbl1").prop("scrollHeight"));
			      $("#tbl1").find("tr:last").find('td').eq(2).focus();

			      // $( ".clsItem" ).unbind();
			      bindItem();

			      	///////Following function to add select TD text on FOCUS
				  	$("#tbl1 tr td").on("focus", function(){
				  		// alert($(this).text());
				  		 var range, selection;
						  if (document.body.createTextRange) {
						    range = document.body.createTextRange();
						    range.moveToElementText(this);
						    range.select();
						  } else if (window.getSelection) {
						    selection = window.getSelection();
						    range = document.createRange();
						    range.selectNodeContents(this);
						    selection.removeAllRanges();
						    selection.addRange(range);
						  }
				  	}); 

				  	resetSerialNo();

			}
			function setSellingPrice()
			{
				// alert();
				var rowIndex = $(this).parent().index();
				var qty = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(3)").text() );		
				var netAmt = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(15)").text() );	
				var purchaseRatePerPc = netAmt/qty;
				var spPercentage = parseFloat ( $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(16)").text() );	
				var sellingPricePerPc = purchaseRatePerPc + (purchaseRatePerPc*spPercentage/100);
				sellingPricePerPc=sellingPricePerPc.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(17)").text( sellingPricePerPc );
			}
			function setSellingPercentage()
			{
				// alert();
				var rowIndex = $(this).parent().index();
				var qty = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(3)").text() );		
				var netAmt = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(15)").text() );	
				var purchaseRatePerPc = netAmt/qty;
				var sellingPricePerPc = parseFloat ( $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(17)").text() );	
				var spPercentage = (sellingPricePerPc-purchaseRatePerPc)*100/purchaseRatePerPc;
				spPercentage=spPercentage.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(16)").text( spPercentage );
			}

			function removeRow()
			{
				var rowIndex = $(this).parent().parent().index();
				$("#tbl1").find("tr:eq(" + rowIndex + ")").remove();
				resetSerialNo();
				doAmtTotal();
				calcBalNow();
			}

			function showPurchaseLog()
			{
				var rowIndex = $(this).parent().parent().index();
				var itemRowIdForPurchaseLog = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").text() );	
				// alert(itemRowIdForPurchaseLog);
				itemNameForHeading = $(this).closest('tr').children('td:eq(2)').text();
				$("#tblPurchaseLog").find("tr:gt(0)").remove(); //// empty first
				$("#h4PurchaseLog").html("Purchase Log - <span style='color:blue;'>" + itemNameForHeading + "</span>");
				if( itemRowIdForPurchaseLog == "-1" )
				{
					return;
				}
				// // alert(globalSaleRowId);
				// // return;
				$.ajax({
					'url': base_url + '/' + controller + '/getPurchaseLog',
					'type': 'POST', 
					'data':{'itemRowId':itemRowIdForPurchaseLog},
					'dataType': 'json',
					'success':function(data)
					{
						// alert(JSON.stringify(data));
						setPurchaseLogTable( data['records'] );

					},
					'error': function(jqXHR, exception)
			          {
			            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
			            $("#modalAjaxErrorMsg").modal('toggle');
			          }
				});
			}

			function setPurchaseLogTable(records)
			{
				$("#tblPurchaseLog").find("tr:gt(0)").remove(); //// empty first
		        var table = document.getElementById("tblPurchaseLog");
		        for(i=0; i<records.length; i++)
				{
			        newRowIndex = table.rows.length;
					row = table.insertRow(newRowIndex);

		          var cell = row.insertCell(0);
		          cell.style.display="none";
		          cell.innerHTML = records[i].purchaseRowId;
		          var cell = row.insertCell(1);
		          cell.innerHTML = dateFormat(new Date(records[i].purchaseDt));
		          var cell = row.insertCell(2);
		          cell.innerHTML = records[i].customerName;
		          var cell = row.insertCell(3);
		          cell.innerHTML = records[i].itemName  + " <span style='color: green;'>[" + records[i].itemRemarks + "]</span>";
		          // cell.style.display="none";
		          var cell = row.insertCell(4);
		          cell.innerHTML = records[i].qty;
		          var cell = row.insertCell(5);
		          cell.innerHTML = records[i].rate;
		          var cell = row.insertCell(6);
		          cell.innerHTML = records[i].amt;
		          var cell = row.insertCell(7);
		          cell.innerHTML = records[i].discountPer;
		          var cell = row.insertCell(8);
		          cell.innerHTML = records[i].discountAmt;
		          var cell = row.insertCell(9);
		          cell.innerHTML = records[i].cgst;
		          var cell = row.insertCell(10);
		          cell.innerHTML = records[i].sgst;
		          var cell = row.insertCell(11);
		          cell.innerHTML = records[i].netAmt;
		          var cell = row.insertCell(12);
		          var pp = records[i].netAmt / records[i].qty;
		          cell.innerHTML = pp.toFixed(2);
		          cell.style.color = 'red';
		          var cell = row.insertCell(13);
		          cell.innerHTML = records[i].freight;
		        }
			}

			function resetSerialNo()
			{
				$("#tbl1 tr").each(function(i){
					$(this).find("td:eq(0)").text(i);
				});
			}

			function doAmtTotal()
			{
				var amtTotal=0;
				var discountTotal=0;
				var pretaxTotal=0;
				var igstTotal=0;
				var cgstTotal=0;
				var sgstTotal=0;
				var netTotal=0;
				var qtyTotal=0;
				$("#tbl1").find("tr:gt(0)").each(function(i){
					if( isNaN(parseFloat( $(this).find("td:eq(5)").text() )) == false )
					{
						qtyTotal += parseFloat( $(this).find("td:eq(3)").text() );
						amtTotal += parseFloat( $(this).find("td:eq(5)").text() );
						discountTotal += parseFloat( $(this).find("td:eq(7)").text() );
						pretaxTotal += parseFloat( $(this).find("td:eq(8)").text() );
						igstTotal += parseFloat( $(this).find("td:eq(10)").text() );
						cgstTotal += parseFloat( $(this).find("td:eq(12)").text() );
						sgstTotal += parseFloat( $(this).find("td:eq(14)").text() );
						netTotal += parseFloat( $(this).find("td:eq(15)").text() );
					}
				});
				$("#txtTotalAmt").val(amtTotal.toFixed(2));
				$("#txtTotalDiscount").val(discountTotal.toFixed(2));
				$("#txtPretaxAmt").val(pretaxTotal.toFixed(2));
				$("#txtTotalIgst").val(igstTotal.toFixed(2));
				$("#txtTotalCgst").val(cgstTotal.toFixed(2));
				$("#txtTotalSgst").val(sgstTotal.toFixed(2));
				$("#txtNetAmt").val( Math.round(netTotal).toFixed(2) );
				$("#txtTotalQty").val( (qtyTotal).toFixed(2) );

				var netInWords = number2text( parseFloat( $("#txtNetAmt").val() ) ) ;
			  	$("#txtWords").val( netInWords );
			}

			function calcBalNow()
			{
				if( $("#txtAmtPaid").val() !== "" )
				{
					$("#txtBalance").val( (parseFloat($("#txtNetAmt").val()) - parseFloat($("#txtAmtPaid").val())).toFixed(2) );
				}
				else
				{
					$("#txtBalance").val( parseFloat($("#txtNetAmt").val()) - 0 );
				}
			}

			
			function doRowTotal()
			{
				// alert();
				var rowIndex = $(this).parent().index();
				var qty = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(3)").text() );				
				if( isNaN(qty) ) 
				{
					qty = 0;
				}
				var rate = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text() ); 
				if( isNaN(rate) ) 
				{
					rate = 0;
				}
				var rowAmt = qty * rate;
				rowAmt = rowAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(5)").text( rowAmt );

				var dis = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(6)").text() );				
				if( isNaN(dis) ) 
				{
					dis = 0;
				}
				var rowDiscountAmt = rowAmt * dis / 100;
				rowDiscountAmt = rowDiscountAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(7)").text( rowDiscountAmt );

				var rowPreTaxAmt = rowAmt - rowDiscountAmt;
				rowPreTaxAmt = rowPreTaxAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(8)").text( rowPreTaxAmt );

				var igst = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(9)").text() );				
				if( isNaN(igst) ) 
				{
					igst = 0;
				}
				// alert(igst);
				var rowIgstAmt = rowPreTaxAmt * igst / 100;
				rowIgstAmt = rowIgstAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(10)").text( rowIgstAmt );

				var cgst = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(11)").text() );				
				if( isNaN(cgst) ) 
				{
					cgst = 0;
				}
				var rowCgstAmt = rowPreTaxAmt * cgst / 100;
				rowCgstAmt = rowCgstAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(12)").text( rowCgstAmt );

				var sgst = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(13)").text() );				
				if( isNaN(sgst) ) 
				{
					sgst = 0;
				}
				var rowSgstAmt = rowPreTaxAmt * sgst / 100;
				rowSgstAmt = rowSgstAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(14)").text( rowSgstAmt );

				var rowNetAmt = parseFloat(rowPreTaxAmt) + parseFloat(rowIgstAmt) + parseFloat(rowCgstAmt) + parseFloat(rowSgstAmt);
				rowNetAmt = rowNetAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(15)").text( rowNetAmt );

				purchaseRatePerPc = rowNetAmt/qty;
				purchaseRatePerPc = purchaseRatePerPc.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(21)").text( purchaseRatePerPc );

				doAmtTotal();
				calcBalNow();
				$("#txtTotalFreight").trigger('keyup');
			}

			
  
			function bindItem()
		  	{
		  		var select = false;
			  	var defaultText = "";
			    $( ".clsItem" ).focus(function(){ 
		  			select = false; 
		  			defaultText = $(this).text();
		  		});
	


				var jSonArray = '<?php echo json_encode($items); ?>';
				var availableTags = $.map(JSON.parse(jSonArray), function(obj){
							return{
									label: obj.itemName,
									itemRowId: obj.itemRowId,
									itemLastRate: obj.rate,
									igst: obj.igst,
									cgst: obj.cgst,
									sgst: obj.sgst,
									sellingPricePer: obj.sellingPricePer,
									sellingPrice: obj.sp,
									discountPer: obj.discountPer
							}
					});

				    $(function() {
			        $( ".clsItem" ).autocomplete({
			            source: function(request, response) {
			                
			                var aryResponse = [];
			                var arySplitRequest = request.term.split(" ");
			                // alert(JSON.stringify(arySplitRequest));
			                for( i = 0; i < availableTags.length; i++ ) {
			                    var intCount = 0;
			                    for( j = 0; j < arySplitRequest.length; j++ ) {
			                        var cleanString = arySplitRequest[j].replace(/[|&;$%@"<>()+,]/g, "");
			                        regexp = new RegExp(cleanString, 'i');
			                        var test = JSON.stringify(availableTags[i].label.toLowerCase()).match(regexp);

			                        
			                        if( test ) {
			                            intCount++;
			                        } else if( !test ) {
			                        intCount = arySplitRequest.length + 1;
			                        }
			                        if ( intCount == arySplitRequest.length ) {
			                            aryResponse.push( availableTags[i] );
			                        }
			                    };
			                }
			                response(aryResponse);
			            },
			            select: function (event, ui) {
				      	select = true;
				      	var selectedObj = ui.item; 
					    var itemRowId = ui.item.itemRowId;
					    var itemLastRate = ui.item.itemLastRate;
					    var itemLastIgst = ui.item.igst;
					    var itemLastCgst = ui.item.cgst;
					    var itemLastSgst = ui.item.sgst;
					    var itemSellingPricePer = ui.item.sellingPricePer;
					    var itemSellingPrice = ui.item.sellingPrice;
					    var itemLastDiscountPer = ui.item.discountPer;
					    var rowIndex = $(this).parent().index();
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").text( itemRowId );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text( itemLastRate );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(6)").text( itemLastDiscountPer );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(9)").text( itemLastIgst );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(11)").text( itemLastCgst );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(13)").text( itemLastSgst );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(16)").text( itemSellingPricePer );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(17)").text( itemSellingPrice );
			        	}

			        }).blur(function() {
				    	var rowIndex = $(this).parent().index();
					    var newText = $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(2)").text(); 
					    // $("#txtAddress").val(defaultText + "  " + newText);
						  if( !select && !(defaultText == newText)) 
						  {
						  	$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(2)").css("color", "red");
						  	$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").text( '-1' );
						  }
						  else
						  {
						  	$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(2)").css("color", "black");
						  }
						  doRowTotal();
						});	///////////

			    });





		  	}


	

	var select = false;
    $( "#txtSupplierName" ).focus(function(){ 
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

	    $( "#txtSupplierName" ).autocomplete({
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
			    $("#lblSupplierId").text( ui.item.customerRowId );
			    $("#txtMobile").val( ui.item.mobile1 );
			    $("#txtAddress").val( ui.item.address );
			    $("#txtSupplierRemarks").val( ui.item.remarks );
			    $("#txtSupplierBalance").val( ui.item.balance );
	        	}
		    }).blur(function() {
				  if( !select ) 
				  {
				  	$("#lblSupplierId").text('-1');
				  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  	if( $("#lblSupplierId").text() == '-1' )
				  	{
				  		$("#spanNewOrOld").text("New Supplier");
				  		$("#spanNewOrOld").removeClass("label-success");
				  		$("#spanNewOrOld").addClass("label-danger");
				        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanNewOrOld").animate({opacity: '1'}, 1000);
					    $("#txtMobile").prop('disabled', false);
					    $("#txtAddress").prop('disabled', false);
					    $("#txtSupplierRemarks").prop('disabled', false);
					    // $("#txtSupplierBalance").prop('disabled', false);
					    $("#txtMobile").val( '' );
					    $("#txtAddress").val( '' );
					    $("#txtSupplierRemarks").val( '' );
					    $("#txtSupplierBalance").val( '' );
					    if( $("#txtSupplierName").val().trim().length>0 )
					    {
					    	$("#txtMobile").focus();
					    }
				  	}
				  	else
				  	{
				  		$("#spanNewOrOld").text("Old Supplier");
				  		$("#spanNewOrOld").removeClass("label-danger");
				  		$("#spanNewOrOld").addClass("label-success");
				        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanNewOrOld").animate({opacity: '1'}, 1000);
				        $("#txtMobile").prop('disabled', true);
					    $("#txtAddress").prop('disabled', true);
					    $("#txtSupplierRemarks").prop('disabled', true);
					    $("#txtSupplierBalance").prop('disabled', true);
				  	}
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );


    $(document).ready(function()
    {
      $("#txtAmtPaid").on('keyup change', calcBalNow);
      $("#tblOldDb tr").on('click', highlightRowAlag);
      $("#tblOldDb tr").find("td:gt(1)").on('click', showDetailsSaved);
  	});
  	

  </script>


  <script type="text/javascript">
	var globalrowid;
	var editFlag = 0;
	function delrowid(rowid)
	{
		globalrowid = rowid;
	}
	function deleteRecord(rowId)
	{
		// alert(rowId);
		// return;
		$.ajax({
				'url': base_url + '/' + controller + '/delete',
				'type': 'POST',
				'dataType': 'json',
				'data': {'rowId': rowId
						},
				'success': function(data){
					if(data)
					{
						if( data == "yes" )
						{
							alertPopup('Record can not be deleted... Dependent records exist...', 8000);
						}
						else
						{
							setTablePuraneDb(data['records'])
							alertPopup('Record deleted...', 8000);
							// blankControls();
							// $("#txtTownName").focus();
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

	function setTablePuraneDb(records)
	{
		// var totalAdvance = 0;
		// $("#tblOldDb").find("tr:gt(0)").remove(); //// empty first
		$("#tblOldDb").empty();
        var table = document.getElementById("tblOldDb");
        for(i=0; i<records.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);

          if(records[i].deleted == "N")
          {
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
	          cell.setAttribute("onclick", "delrowid(" + records[i].purchaseRowId +")");
	          // data-toggle="modal" data-target="#myModal"
	          cell.setAttribute("data-toggle", "modal");
	          cell.setAttribute("data-target", "#myModal");
      	  }
      	  else
      	  {
	          var cell = row.insertCell(0);
	          cell.innerHTML = "<span class=''>Deleted</span>";
	          cell.style.textAlign = "center";
	          cell.style.color='red';

	          var cell = row.insertCell(1);
				  cell.innerHTML = "<span class=''>Deleted</span>";
	          cell.style.textAlign = "center";
	          cell.style.color='red';
      	  }

          var cell = row.insertCell(2);
          // cell.style.display="none";
          cell.innerHTML = records[i].purchaseRowId;
          var cell = row.insertCell(3);
          cell.innerHTML = dateFormat(new Date(records[i].purchaseDt));
          // cell.style.display="none";
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].customerRowId;
          cell.style.display="none";
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].customerName;
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].totalAmount;
          var cell = row.insertCell(7);
          cell.innerHTML = records[i].totalDiscount;
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].pretaxAmt;
          var cell = row.insertCell(9);
          cell.innerHTML = records[i].totalIgst;
          var cell = row.insertCell(10);
          cell.innerHTML = records[i].totalCgst;
          var cell = row.insertCell(11);
          cell.innerHTML = records[i].totalSgst;
          var cell = row.insertCell(12);
          cell.innerHTML = records[i].netAmt;
          var cell = row.insertCell(13);
          cell.innerHTML = records[i].advancePaid;
          var cell = row.insertCell(14);
          cell.innerHTML = records[i].balance;
          var cell = row.insertCell(15);
          if(records[i].dueDate == null)
          {
          	cell.innerHTML = "";
          }
          else
          {
          	cell.innerHTML = dateFormat(new Date(records[i].dueDate));
          }
          var cell = row.insertCell(16);
          cell.innerHTML = records[i].remarks;
          var cell = row.insertCell(17);
          cell.innerHTML = records[i].freightTotal;
          var cell = row.insertCell(18);
          cell.innerHTML = records[i].totalQty;
	    }

	    $('.editRecord').bind('click', editThis);
	    $("#tblOldDb tr").on('click', highlightRowAlag);
        $("#tblOldDb tr").find("td:gt(1)").on('click', showDetailsSaved);

		myDataTable.destroy();
	    myDataTable=$('#tblOldDb').DataTable({
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
		globalrowid = $(this).closest('tr').children('td:eq(2)').text();


		$("#txtDate").val( $(this).closest('tr').children('td:eq(3)').text() );
		$("#lblSupplierId").text( $(this).closest('tr').children('td:eq(4)').text() );
		var customerRowId = $(this).closest('tr').children('td:eq(4)').text();
		$("#txtSupplierName").val( $(this).closest('tr').children('td:eq(5)').text() );
		
		$("#txtTotalAmt").val( $(this).closest('tr').children('td:eq(6)').text() );
		$("#txtTotalDiscount").val( $(this).closest('tr').children('td:eq(7)').text() );
		$("#txtPretaxAmt").val( $(this).closest('tr').children('td:eq(8)').text() );
		$("#txtTotalIgst").val( $(this).closest('tr').children('td:eq(9)').text() );
		$("#txtTotalCgst").val( $(this).closest('tr').children('td:eq(10)').text() );
		$("#txtTotalSgst").val( $(this).closest('tr').children('td:eq(11)').text() );
		$("#txtNetAmt").val( $(this).closest('tr').children('td:eq(12)').text() );
		$("#txtAmtPaid").val( $(this).closest('tr').children('td:eq(13)').text() );
		
		$("#txtBalance").val( $(this).closest('tr').children('td:eq(14)').text() );
		$("#txtDueDate").val( $(this).closest('tr').children('td:eq(15)').text() );
		$("#txtRemarks").val( $(this).closest('tr').children('td:eq(16)').text() );
		$("#txtTotalFreight").val( $(this).closest('tr').children('td:eq(17)').text() );
		$("#txtTotalQty").val( $(this).closest('tr').children('td:eq(18)').text() );
		$("#txtSupplierName").prop("disabled", true);
		// $("#txtAmtPaid").prop("disabled", true);


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
				$("#tbl1").find("tr:gt(0)").remove(); //// empty first
		        var table = document.getElementById("tbl1");
		        var totPartyDue = 0;
		        for(i=0; i<data['records'].length; i++)
		        {
		          var newRowIndex = table.rows.length;
		          var row = table.insertRow(newRowIndex);

		          var cell = row.insertCell(0);
		          cell.innerHTML = ""; 			///SN
		          // cell.style.display="none";
		          
		          var cell = row.insertCell(1);
		          cell.innerHTML = data['records'][i].itemRowId;
		          // cell.contentEditable="true";
				  // cell.className = "clsItemType";
		          cell.style.display="none1";

		          var cell = row.insertCell(2);
		          cell.innerHTML = data['records'][i].itemName;
		          // cell.style.display="none";
		          // cell.className = "clsItemName";

		          var cell = row.insertCell(3);
		          cell.innerHTML = data['records'][i].qty;
		          cell.contentEditable="true";
				  cell.className = "clsQty";
		          // cell.style.display="none";

		          var cell = row.insertCell(4);
		          cell.innerHTML = data['records'][i].rate;
		          cell.contentEditable="true";
				  cell.className = "clsRate";

		          var cell = row.insertCell(5);
		          cell.innerHTML = data['records'][i].amt;
		          cell.contentEditable="true";

		          var cell = row.insertCell(6);
		          cell.innerHTML = data['records'][i].discountPer;
		          cell.contentEditable="true";
		          cell.className = "clsDiscountPer";

		          var cell = row.insertCell(7);
		          cell.innerHTML = data['records'][i].discountAmt;
		          cell.className = "clsDiscountAmt";

		          var cell = row.insertCell(8);
		          cell.innerHTML = data['records'][i].pretaxAmt;
		          cell.className = "clsPreTaxAmt";

		          var cell = row.insertCell(9);
		          cell.innerHTML = data['records'][i].igst;
		          cell.contentEditable="true";
		          cell.className = "clsIgst";
		          cell.style.display="none";

		          var cell = row.insertCell(10);
		          cell.innerHTML = data['records'][i].igstAmt;
		          cell.className = "clsIgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(11);
		          cell.innerHTML = data['records'][i].cgst;
		          cell.contentEditable="true";
		          cell.className = "clsCgst";

		          var cell = row.insertCell(12);
		          cell.innerHTML = data['records'][i].cgstAmt;
		          cell.className = "clsCgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(13);
		          cell.innerHTML = data['records'][i].sgst;
		          cell.contentEditable="true";
		          cell.className = "clsSgst";

		          var cell = row.insertCell(14);
		          cell.innerHTML = data['records'][i].sgstAmt;
		          cell.className = "clsSgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(15);
		          cell.innerHTML = data['records'][i].netAmt;
		          cell.className = "clsNetAmt";

		          var cell = row.insertCell(16);
		          cell.innerHTML = data['records'][i].sellingPricePer;
		          cell.className = "clsSpPer";
		          cell.contentEditable="true";

		          var cell = row.insertCell(17);
		          cell.innerHTML = data['records'][i].sp;
		          cell.className = "clsSp";
		          cell.contentEditable="true";

		          var cell = row.insertCell(18);
		          cell.innerHTML = data['records'][i].itemRemarks;
		          cell.className = "clsRemarks";
		          cell.contentEditable="true";

		          var cell = row.insertCell(19);
				  cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";

				  var cell = row.insertCell(20);
				  cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
				    
				    if(i == 0) ///remove row not required in first row
					{
						cell.innerHTML = "";
					}

				 	var cell = row.insertCell(21);
				  cell.innerHTML =(data['records'][i].netAmt/data['records'][i].qty).toFixed(2);
				  cell.style.color="red";

					var cell = row.insertCell(22);
				  cell.innerHTML = data['records'][i].freight;

				  var cell = row.insertCell(23);
				  cell.innerHTML = "<button class='row-log' style='color:red;'> <span class=''> Log </span></button>";
				    
			    }

			    ////Setting Supplier Info
			    $("#txtMobile").val( data['customerInfo'][0].mobile1 );
			    $("#txtAddress").val( data['customerInfo'][0].address );
			    $("#txtSupplierRemarks").val( data['customerInfo'][0].remarks );


				$(".row-add").off();
				$(".row-add").on('mouseover focus', function(){
					$(this).css("color", "green");
				});
				$(".row-add").on('mouseout blur', function(){
					$(this).css("color", "lightgrey");
				});

				$(".row-remove").off();
				$(".row-remove").on('mouseover focus', function(){
					$(this).css("color", "red");
				});
				$(".row-remove").on('mouseout blur', function(){
					$(this).css("color", "lightgrey");
				});

			      $(".clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst").off();
			      $('.clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst').on('keyup', doRowTotal);

			    $(".clsSpPer").off();
			    $('.clsSpPer').on('keyup', setSellingPrice);
			    $(".clsSp").off();
			    $('.clsSp').on('keyup', setSellingPercentage);

				$('.row-remove').on('click', removeRow);

				$(".row-log").off();
				$('.row-log').on('click', showPurchaseLog);
			      $('.row-log').click(function () {
		   		$('#myModalPurchaseLog').modal('toggle');});


				// $( ".clsItem" ).unbind();
				bindItem();

				///////Following function to add select TD text on FOCUS
			  	$("#tbl1 tr td").on("focus", function(){
			  		// alert($(this).text());
			  		 var range, selection;
					  if (document.body.createTextRange) {
					    range = document.body.createTextRange();
					    range.moveToElementText(this);
					    range.select();
					  } else if (window.getSelection) {
					    selection = window.getSelection();
					    range = document.createRange();
					    range.selectNodeContents(this);
					    selection.removeAllRanges();
					    selection.addRange(range);
					  }
			  	}); 

			  	resetSerialNo();

			  	// var netInWords = number2text( parseFloat( $("#txtNetAmt").val() ) ) ;
			  	// $("#txtWords").val( netInWords );

			},
			'error': function(jqXHR, exception)
	          {
	            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
	            $("#modalAjaxErrorMsg").modal('toggle');
	          }
		});

		$("#btnSave").text("Update");
	}  	
  </script>

  <script type="text/javascript">


		$(document).ready( function () {
		    myDataTable = $('#tblOldDb').DataTable({
			    paging: false,
			    ordering: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});

        	// $("#tbl1 tr").find("td:gt(1)").on('click', showDetailsSaved);

		} );


	function number2text(value) {
	    var fraction = Math.round(frac(value)*100);
	    var f_text  = "";

	    if(fraction > 0) {
	        f_text = "AND "+convert_number(fraction)+" PAISE";
	    }

	    return convert_number(value)+" RUPEES "+f_text+" ONLY";
	}

	function frac(f) {
	    return f % 1;
	}

	function convert_number(number)
	{
	    if ((number < 0) || (number > 999999999)) 
	    { 
	        return "NUMBER OUT OF RANGE!";
	    }
	    var Gn = Math.floor(number / 10000000);  /* Crore */ 
	    number -= Gn * 10000000; 
	    var kn = Math.floor(number / 100000);     /* lakhs */ 
	    number -= kn * 100000; 
	    var Hn = Math.floor(number / 1000);      /* thousand */ 
	    number -= Hn * 1000; 
	    var Dn = Math.floor(number / 100);       /* Tens (deca) */ 
	    number = number % 100;               /* Ones */ 
	    var tn= Math.floor(number / 10); 
	    var one=Math.floor(number % 10); 
	    var res = ""; 

	    if (Gn>0) 
	    { 
	        res += (convert_number(Gn) + " CRORE"); 
	    } 
	    if (kn>0) 
	    { 
	            res += (((res=="") ? "" : " ") + 
	            convert_number(kn) + " LAKH"); 
	    } 
	    if (Hn>0) 
	    { 
	        res += (((res=="") ? "" : " ") +
	            convert_number(Hn) + " THOUSAND"); 
	    } 

	    if (Dn) 
	    { 
	        res += (((res=="") ? "" : " ") + 
	            convert_number(Dn) + " HUNDRED"); 
	    } 


	    var ones = Array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX","SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN","FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN","NINETEEN"); 
		var tens = Array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY","SEVENTY", "EIGHTY", "NINETY"); 

	    if (tn>0 || one>0) 
	    { 
	        if (!(res=="")) 
	        { 
	            res += " AND "; 
	        } 
	        if (tn < 2) 
	        { 
	            res += ones[tn * 10 + one]; 
	        } 
	        else 
	        { 

	            res += tens[tn];
	            if (one>0) 
	            { 
	                res += ("-" + ones[one]); 
	            } 
	        } 
	    }

	    if (res=="")
	    { 
	        res = "zero"; 
	    } 
	    return res;
	}	

	function showDetailsSaved()
	{
		$("#tblProductsSaved").find("tr:gt(0)").remove();
	    // purchaseRowId = $(this).find("td:eq(2)").text();
	    purchaseRowId = $(this).parent().find("td:eq(2)").text();
	    // alert(purchaseRowId);
	    // return;
	    $.ajax({
				'url': base_url + '/' + controller + '/getPurchaseDetial',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'purchaseRowId': purchaseRowId
						},
				'success': function(data)
				{
					// alert(JSON.stringify(data['purchaseDetail']));
	      			var table = document.getElementById("tblProductsSaved");
					for(i=0; i<data['purchaseDetail'].length; i++)
				    {

			          var newRowIndex = table.rows.length;
			          var row = table.insertRow(newRowIndex);

			          var cell = row.insertCell(0);
			          cell.innerHTML = i+1; 			///SN
			          // cell.style.display="none";
			          
			          var cell = row.insertCell(1);
			          cell.innerHTML = data['purchaseDetail'][i].itemRowId;
			          // cell.contentEditable="true";
					  // cell.className = "clsItemType";
			          cell.style.display="none";

			          var cell = row.insertCell(2);
			          cell.innerHTML = data['purchaseDetail'][i].itemName + " <span style='color: green;'>[" + data['purchaseDetail'][i].itemRemarks + "]</span>";
			          // cell.style.display="none";
			          // cell.className = "clsItemName";

			          var cell = row.insertCell(3);
			          cell.innerHTML = data['purchaseDetail'][i].qty;
			          // cell.contentEditable="true";
					  // cell.className = "clsQty";
			          // cell.style.display="none";

			          var cell = row.insertCell(4);
			          cell.innerHTML = data['purchaseDetail'][i].rate;
			          // cell.contentEditable="true";
					  // cell.className = "clsRate";

			          var cell = row.insertCell(5);
			          cell.innerHTML = data['purchaseDetail'][i].amt;
			          // cell.contentEditable="true";

			          var cell = row.insertCell(6);
			          cell.innerHTML = data['purchaseDetail'][i].discountPer;
			          // cell.contentEditable="true";
			          // cell.className = "clsDiscountPer";

			          var cell = row.insertCell(7);
			          cell.innerHTML = data['purchaseDetail'][i].discountAmt;
			          // cell.className = "clsDiscountAmt";
			          cell.style.display="none";

			          var cell = row.insertCell(8);
			          cell.innerHTML = data['purchaseDetail'][i].pretaxAmt;
			          // cell.className = "clsPreTaxAmt";
			          cell.style.display="none";

			          var cell = row.insertCell(9);
			          cell.innerHTML = data['purchaseDetail'][i].igst;
			          // cell.contentEditable="true";
			          // cell.className = "clsIgst";
			          cell.style.display="none";

			          var cell = row.insertCell(10);
			          cell.innerHTML = data['purchaseDetail'][i].igstAmt;
			          // cell.className = "clsIgstAmt";
			          cell.style.display="none";

			          var cell = row.insertCell(11);
			          cell.innerHTML = data['purchaseDetail'][i].cgst;
			          // cell.contentEditable="true";
			          // cell.className = "clsCgst";

			          var cell = row.insertCell(12);
			          cell.innerHTML = data['purchaseDetail'][i].cgstAmt;
			          // cell.className = "clsCgstAmt";
			          cell.style.display="none";

			          var cell = row.insertCell(13);
			          cell.innerHTML = data['purchaseDetail'][i].sgst;
			          // cell.contentEditable="true";
			          // cell.className = "clsSgst";

			          var cell = row.insertCell(14);
			          cell.innerHTML = data['purchaseDetail'][i].sgstAmt;
			          // cell.className = "clsSgstAmt";
			          cell.style.display="none";

			          var cell = row.insertCell(15);
			          cell.innerHTML = data['purchaseDetail'][i].netAmt;
			          // cell.className = "clsNetAmt";

			          var cell = row.insertCell(16);
			          cell.innerHTML = data['purchaseDetail'][i].sellingPricePer;
			          // cell.className = "clsSpPer";
			          // cell.contentEditable="true";
			          cell.style.display="none";

			          var cell = row.insertCell(17);
			          cell.innerHTML = data['purchaseDetail'][i].sp;
			          cell.style.color="blue";

			          // cell.className = "clsSp";
			          // cell.contentEditable="true";


					 var cell = row.insertCell(18);
					  cell.innerHTML =(data['purchaseDetail'][i].netAmt/data['purchaseDetail'][i].qty).toFixed(2);
					  cell.style.color="red";

					 var cell = row.insertCell(19);
					  cell.innerHTML =data['purchaseDetail'][i].freight;
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