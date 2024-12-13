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
	#txtDeliveryDate {position: relative; z-index:101;}
</style>
<script type="text/javascript">
	var controller='Order_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Orders";


	var tblRowsCount=0;
	var firstItem = "";
	function storeTblValuesItems()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// alert($(tr).find('td:eq(3)').text().length);
	    	if( $(tr).find('td:eq(2)').text().length > 0 )
	    	{
	    		if(i==0)
	    		{
	    			firstItem = $(tr).find('td:eq(2)').text();
	    		}
	        	TableData[i]=
	        	{
		            "itemRowId" : $(tr).find('td:eq(1)').text()
		            , "itemName" : $(tr).find('td:eq(2)').text()
		            , "qty" :$(tr).find('td:eq(3)').text()
		            , "rate" :$(tr).find('td:eq(4)').text()
		            , "amt" :$(tr).find('td:eq(5)').text()
		            , "itemRemarks" :$(tr).find('td:eq(6)').text()
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
		// return;
		// alert(serviceChargeFlag);
		var TableDataItems;
		TableDataItems = storeTblValuesItems();
		TableDataItems = JSON.stringify(TableDataItems);
		// alert(JSON.stringify(TableDataItems));
		// return;
		// alert(tblRowsCount);
		if( tblRowsCount > 1)
		{
			firstItem += " +" + (tblRowsCount-1) + " more.";
		}
		// alert(firstItem);
		// return;
		if(tblRowsCount == 0)
		{
			msgBoxError("Error", "Zero items to save...");
			// alertPopup("Zero items to save", 5000, 'red');
			// $("#txtDate").focus();
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
			return;
		}

		customerRowId = $("#lblCustomerId").text();
		customerName = $("#txtCustomerName").val().trim();
		if(customerName == "" )
		{
			msgBoxError("Error", "Invalid customer name...");
			// alertPopup("Invalid customer name...", 5000, 'red');
			// $("#txtCustomerName").focus();
			return;
		}
		mobile1 = $("#txtMobile").val().trim();
		if(mobile1 == "" )
		{
			msgBoxError("Error", "Mobile no. can not be blank...");
			return;
		}
		address = $("#txtAddress").val().trim();
		customerRemarks = $("#txtCustomerRemarks").val().trim();
		totalAmt = parseFloat($("#txtTotalAmt").val());
		advance = parseFloat($("#txtAdvance").val());
		due = parseFloat($("#txtDueAmt").val());
		deliveryDt = $("#txtDeliveryDate").val().trim();
		dtOk = testDate("txtDeliveryDate");
		if(dtOk == false)
		{
			msgBoxError("Error", "Invalid delivery date...");
			return;
		}
		remarks = $("#txtRemarks").val();
		// inWords = $("#txtWords").val().trim();



		flagItemRemarks = 0;
		$('#tbl1 tr').each(function(row, tr)
	    {
		    itemRem = $(tr).find('td:eq(6)').text();
		    if (itemRem.length > 100 )
		    {
		    	flagItemRemarks = 1;
		    }
	    }); 

		if(flagItemRemarks == 1 )
		{
			msgBoxError("Error","Item Remarks Length must be less than 100...");
			return;
		}

		if($("#btnSave").text() == "Save Order")
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
								, 'advance': advance
								, 'due': due
								, 'deliveryDt': deliveryDt
								, 'remarks': remarks
								// , 'inWords': inWords
								, 'TableDataItems': TableDataItems
								, 'firstItem': firstItem
								, 'sendSms': sendSms
								, 'sms': sms
								, 'smsBhejo': smsBhejo
							},
					'success': function(data)
					{
						blankControls();	
						$("#txtDate").val(dateFormat(new Date()));
						$("#txtDeliveryDate").val(dateFormat(new Date()));
						$("#tbl1").find("tr:gt(0)").remove();
						addRow();
						alertPopup("Record saved...", 8000);
						setTablePuraneDb(data['records'])
					},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
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
								, 'advance': advance
								, 'due': due
								, 'deliveryDt': deliveryDt
								, 'remarks': remarks
								// , 'inWords': inWords
								, 'TableDataItems': TableDataItems							},
					'success': function(data)
					{
						blankControls()
						setTablePuraneDb(data['records'])
						$("#txtDate").val(dateFormat(new Date()));
						$("#txtDeliveryDate").val(dateFormat(new Date()));
						$("#tbl1").find("tr:gt(0)").remove();
						addRow();
						alertPopup("Record updated...", 8000);
						$("#btnSave").text("Save Order");
						$("#txtCustomerName").prop("disabled", false);
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
						setTablePuraneDb(data['records'])
						alertPopup('Records loaded...', 4000);
						// blankControls();
						// $("#txtBookName").focus();
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
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<h3 class="text-center" style='margin-top:-7px;'>Order</h3>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-right">
			<label style='font-size: 16pt;margin-top: -20px;' id='lblNewOrOld'><span id='spanNewOrOld' class='label label-danger'>New Customer</span></label>
		</div>
	</div>
	 
	<div class="row" style="background-color: #F0F0F0; padding-top: 10px; padding-bottom: 10px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Date:</label>";
				echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Customer Name:</label>";
				echo "<label style='color: lightgrey; font-weight: normal;' id='lblCustomerId'></label>";
				// <h4>Example <span class="label label-default">New</span></h4>
				echo form_input('txtCustomerName', '', "class='form-control' id='txtCustomerName' style='' maxlength=70 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Mobile No.:</label>";
				echo form_input('txtMobile', '', "class='form-control' id='txtMobile' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Address:</label>";
				echo form_input('txtAddress', '', "class='form-control' id='txtAddress' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Customer Remarks:</label>";
				echo form_input('txtCustomerRemarks', '', "class='form-control' id='txtCustomerRemarks' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
	</div>

	

    <div class="row" style="margin-top: 10px;">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 sticky-table sticky-headers sticky-ltr-cells" id="divTable" style="overflow:auto; height:220px;">
			<table style="table-layout: fixed; border: 1px solid lightgrey;" id='tbl1' class="table table-bordered">
	           <thead>
	           <tr class="sticky-row" style="">
	            <th class="sticky-cell" width="50">S.N.</th>
	            <th width="50" style='display:none1;'>Item Row Id</th>
	            <th width="200">Item</th>
	            <th width="80">Qty</th>
	            <th width="80">Rate</th>
	            <th width="80">Amt</th>
	            <th width="200">Remarks</th>
	            <th width="80">&nbsp;</th>
	            <th width="80">&nbsp;</th>
	           </tr>
	           </thead>
          </table>
		</div>
	</div>

	<div class="row" style="margin-top: 10px;background-color: #F0F0F0; padding-top:10px;padding-bottom:10px;">
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total Amt.:</label>";
				echo '<input type="number"  step="1" name="txtTotalAmt" value="0" class="form-control" disabled id="txtTotalAmt" />';
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Advance Paid:</label>";
				echo '<input type="number"  step="1" name="txtAdvance" value="0" class="form-control" id="txtAdvance" />';
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Amt. Due:</label>";
				echo '<input type="number"  step="1" name="txtDueAmt" value="0"  class="form-control" disabled id="txtDueAmt" />';
          	?>
      	</div>
      	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Delivery Date:</label>";
				echo form_input('txtDate', '', "class='form-control' id='txtDeliveryDate' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
				// echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' style='' maxlength=100 autocomplete='off'");
				echo form_textarea('txtRemarks', '', "class='form-control' style='resize:none;height:100px;' id='txtRemarks'  maxlength=320");
          	?>
      	</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>SMS: </label>";
				echo "<label id='lblChars' style='color: red; font-weight: normal;'>0</label>";
				echo "&nbsp;&nbsp;&nbsp;<input id='chkSendSms' type='checkbox' checked>Send SMS";
				echo form_textarea('txtSms', '', "class='form-control' style='resize:none;height:100px;' id='txtSms' placeholder='dbl click here to generate SMS' maxlength=320 value=''");
	      	?>
      	</div>
      	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
          	?>
          	<button id="btnSave" class="btn btn-success btn-block" onclick="saveData();">Save Order</button>
      	</div>
      	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
				echo "<input type='button' onclick='checkBal();' value='Check Balance' id='btnCheckBalance' class='btn btn-information col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
			?>
		</div>	
	</div>



	<div class="row"  style="margin-top: 25px;">
		<div id="divTableOldDb" class="divTable tblScroll" style="border:1px solid lightgray; height:300px; overflow:auto;">
			<table class='table table-hover' id='tblOldDb'>
			 <thead>
				 <tr>
				 	<th  width="50" class="editRecord text-center" style='display:none1;'>Edit</th>
				 	<th  width="50" class="text-center">Delete</th>
					<th style='display:none1;'>rowId#</th>
				 	<th>Date</th>
				 	<th style='display:none;'>customerRowId</th>
				 	<th>Customer Name</th>
				 	<th>Total Amt</th>
				 	<th>Advance</th>
				 	<th>Due</th>
				 	<th>Del. Dt.</th>
				 	<th>Remarks</th>
				 </tr>
			 </thead>
			 <tbody>
				 <?php 
					foreach ($records as $row) 
					{
					 	$rowId = $row['orderRowId'];
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
					 	echo "<td style='width:0px;display:none1;'>".$row['orderRowId']."</td>";
					 	$vdt = strtotime($row['orderDt']);
						$vdt = date('d-M-Y', $vdt);
					 	echo "<td>".$vdt."</td>";
					 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
					 	echo "<td>".$row['customerName']."</td>";
					 	echo "<td>".$row['totalAmount']."</td>";
					 	echo "<td>".$row['advance']."</td>";
					 	echo "<td>".$row['due']."</td>";
					 	$vdt = strtotime($row['deliveryDt']);
						$vdt = date('d-M-Y', $vdt);
					 	echo "<td>".$vdt."</td>";
						echo "<td>".$row['remarks']."</td>";
						echo "</tr>";
					}
				 ?>
			 </tbody>
			</table>
		</div>
	</div>

	<div class="row" style="margin-top:20px;margin-bottom:20px;" >
		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<label style='color: red; font-weight: normal;'>*SMS will not go on update.</label>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<input type='button' onclick='loadAllRecords();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
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
	$( "#txtDate" ).datepicker({
		dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
	});
    // Set the Current Date as Default
	$("#txtDate").val(dateFormat(new Date()));

	$( "#txtDeliveryDate" ).datepicker({
		dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
	});
	// Set the Current Date as Default
	$("#txtDeliveryDate").val(dateFormat(new Date()));
          	

	$(document).ready( function () {
		  $("#tbl1").find("tr:gt(0)").remove();
		  addRow();
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
		          cell.className = "clsRate";

		          var cell = row.insertCell(5);
		          cell.innerHTML = "";
		          cell.contentEditable="true";
		          cell.className = "clsAmt";

		          var cell = row.insertCell(6);
		          cell.innerHTML = "";
		          cell.contentEditable="true";
		          cell.className = "clsRemarks";


		          var cell = row.insertCell(7);
		          cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";
		          cell.style.textAlign = "center";

		          var cell = row.insertCell(8);
		          cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
		          cell.style.textAlign = "center";
		          if(sn == 2) ///remove row not required in first row
			      {
			      	cell.innerHTML = "";
			      }

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

			      $(".clsQty, .clsAmt").off();
			      $('.clsQty, .clsAmt').on('keyup', doRowTotal);

			      $('.row-remove').on('click', removeRow);

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

			function removeRow()
			{
				var rowIndex = $(this).parent().parent().index();
				$("#tbl1").find("tr:eq(" + rowIndex + ")").remove();
				resetSerialNo();
				doAmtTotal();
				calcBalNow();
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
				$("#tbl1").find("tr:gt(0)").each(function(i){
					if( isNaN(parseFloat( $(this).find("td:eq(5)").text() )) == false )
					{
						amtTotal += parseFloat( $(this).find("td:eq(5)").text() );
					}
				});
				$("#txtTotalAmt").val(amtTotal.toFixed(2));

				var netInWords = number2text( parseFloat( $("#txtTotalAmt").val() ) ) ;
			  	$("#txtWords").val( netInWords );
			}

			function calcBalNow()
			{
				if( $("#txtAdvance").val() !== "" )
				{
					$("#txtDueAmt").val( (parseFloat($("#txtTotalAmt").val()) - parseFloat($("#txtAdvance").val())).toFixed(2) );
				}
				else
				{
					$("#txtDueAmt").val( parseFloat($("#txtTotalAmt").val()) - 0 );
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
				var amt = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(5)").text() ); 
				if( isNaN(amt) ) 
				{
					amt = 0;
				}
				var rate = amt / qty;
				rate = rate.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text( rate );


				doAmtTotal();
				calcBalNow();
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
									itemRowId: obj.itemRowId
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
			                        // alert(new RegExp(arySplitRequest[j], 'i'));

			                        // arySplitRequest[j].replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
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
					    // var itemLastRate = ui.item.itemLastRate;
					    var rowIndex = $(this).parent().index();
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").text( itemRowId );
					    // $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text( itemLastRate );
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
							remarks: obj.remarks
					}
		});

		// var availableTags = ["Gold", "Silver", "Metal"];
		// var select = false;
		// alert(availableTags);
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
	        	}
		    }).blur(function() {
				  if( !select ) 
				  {
				  	$("#lblCustomerId").text('-1');
				  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  	if( $("#lblCustomerId").text() == '-1' )
				  	{
				  		$("#spanNewOrOld").text("New Customer");
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
				  		$("#spanNewOrOld").text("Old Customer");
				  		$("#spanNewOrOld").removeClass("label-danger");
				  		$("#spanNewOrOld").addClass("label-success");
				        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanNewOrOld").animate({opacity: '1'}, 1000);
				  	}
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );

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
						document.write(jqXHR.responseText);
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
	          cell.setAttribute("onclick", "delrowid(" + records[i].orderRowId +")");
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
          cell.innerHTML = records[i].orderRowId;
          var cell = row.insertCell(3);
          cell.innerHTML = dateFormat(new Date(records[i].orderDt));
          // cell.style.display="none";
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].customerRowId;
          cell.style.display="none";
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].customerName;
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].totalAmount;
          var cell = row.insertCell(7);
          cell.innerHTML = records[i].advance;
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].due;
          var cell = row.insertCell(9);
          cell.innerHTML = dateFormat(new Date(records[i].deliveryDt));

          var cell = row.insertCell(10);
          cell.innerHTML = records[i].remarks;
	    }

	    $('.editRecord').bind('click', editThis);

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
		$("#lblCustomerId").text( $(this).closest('tr').children('td:eq(4)').text() );
		var customerRowId = $(this).closest('tr').children('td:eq(4)').text();
		$("#txtCustomerName").val( $(this).closest('tr').children('td:eq(5)').text() );
		
		$("#txtTotalAmt").val( $(this).closest('tr').children('td:eq(6)').text() );
		$("#txtAdvance").val( $(this).closest('tr').children('td:eq(7)').text() );
		$("#txtDueAmt").val( $(this).closest('tr').children('td:eq(8)').text() );
		$("#txtDeliveryDate").val( $(this).closest('tr').children('td:eq(9)').text() );

		$("#txtRemarks").val( $(this).closest('tr').children('td:eq(10)').text() );
		$("#txtCustomerName").prop("disabled", true);


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

		          var cell = row.insertCell(3);
		          cell.innerHTML = data['records'][i].qty;
		          cell.contentEditable="true";
				  cell.className = "clsQty";
		          // cell.style.display="none";

		          var cell = row.insertCell(4);
		          cell.innerHTML = data['records'][i].rate;
		          // cell.contentEditable="true";
				  cell.className = "clsRate";

		          var cell = row.insertCell(5);
		          cell.innerHTML = data['records'][i].amt;
		          cell.contentEditable="true";
		          cell.className = "clsAmt";

		          var cell = row.insertCell(6);
		          cell.innerHTML = data['records'][i].itemRemarks;
		          cell.contentEditable="true";
				  cell.className = "clsRemarks";

		          var cell = row.insertCell(7);
				  cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";
				  cell.style.textAlign = "center";

				  var cell = row.insertCell(8);
				  cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
				  cell.style.textAlign = "center";
				    
				    if(i == 0) ///remove row not required in first row
					{
						cell.innerHTML = "";
					}

			    }

			    ////Setting Customer Info
			    $("#txtMobile").val( data['customerInfo'][0].mobile1 );
			    $("#txtAddress").val( data['customerInfo'][0].address );
			    $("#txtCustomerRemarks").val( data['customerInfo'][0].remarks );


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

			      $(".clsQty, .clsAmt").off();
			      $('.clsQty, .clsAmt').on('keyup', doRowTotal);

				$('.row-remove').on('click', removeRow);

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

			  	var netInWords = number2text( parseFloat( $("#txtTotalAmt").val() ) ) ;
			  	$("#txtWords").val( netInWords );

			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});

		$("#btnSave").text("Update");
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
					$("#btnCheckBalance").val("Check Balance ("+ data +")");
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
		    myDataTable = $('#tblOldDb').DataTable({
			    paging: false,
			    ordering: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});
		} );

		$(document).ready(function()
	    {
	      $("#txtAdvance").on('keyup change', calcBalNow);

	      var smsBalance = '<?php echo $smsBalance;?>';
	      // alert(smsBalance)
	      $("#btnCheckBalance").val("Check Balance ("+ smsBalance +")");
	  	});


		$("#txtSms").on("dblclick", setSms);
		function setSms()
		{
			// alert( $("#tbl1").find("tr:eq(1)").find("td:eq(2)").text() );
			plusItems = $("#tbl1 tr").length - 2;
			// alert(totalItems);
			customerName = $("#txtCustomerName").val().trim();
			sms = "";
			sms += "Dear Customer,";
			if( plusItems > 0 )
			{
				sms += "\nYour order for " + $("#tbl1").find("tr:eq(1)").find("td:eq(2)").text() + "+" + plusItems;
			}
			else
			{
				sms += "\nYour order for " + $("#tbl1").find("tr:eq(1)").find("td:eq(2)").text();
			}
			// sms += ", Your order for " + $("#tbl1").find("tr:eq(1)").find("td:eq(2)").text();
			sms += " has been placed.";
			sms += "\nDelivery Dt.:" + $("#txtDeliveryDate").val();
			sms += "\nTotal Amt:" + parseInt($("#txtTotalAmt").val());
			sms += "\nAdv:" + parseInt($("#txtAdvance").val());
			sms += "\nBal:" + parseInt($("#txtDueAmt").val());
			sms += "\nThanx n Regards:\nSEACO TECH\n7896544444";
			$("#txtSms").val(sms);
			countCharacters();
		}
		$("#txtSms").on("change, keyup", countCharacters);
		function countCharacters()
		{
			// alert($("#txtSms").val().length);
			$("#lblChars").text( $("#txtSms").val().length );
		}
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
  </script>

