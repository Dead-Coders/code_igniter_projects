<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<script type="text/javascript">
	var controller='OrdersStatus_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Order Status";



	function setTablePuraneRecords(records)
	{
		 // alert(JSON.stringify(records));
		  $("#tblOldRecords").empty();
	      var table = document.getElementById("tblOldRecords");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);

	          var cell = row.insertCell(0);
	          // cell.style.display="none";
	          cell.innerHTML = records[i].orderRowId;
	          var cell = row.insertCell(1);
	          cell.innerHTML = dateFormat(new Date(records[i].orderDt));
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].customerRowId;
	          cell.style.display="none";
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].customerName;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].totalAmount;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].advance;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].due;
	          var cell = row.insertCell(7);
	          cell.innerHTML = dateFormat(new Date(records[i].deliveryDt));
	          var cell = row.insertCell(8);
	          cell.innerHTML = records[i].remarks;
	          var cell = row.insertCell(9);
	          cell.innerHTML = records[i].mobile1;
	          var cell = row.insertCell(10);
	          cell.innerHTML = records[i].readySms;
	          var cell = row.insertCell(11);
	          cell.innerHTML = records[i].readyStamp;
	          var cell = row.insertCell(12);
	          cell.innerHTML = records[i].deliverSms;
	          var cell = row.insertCell(13);
	          cell.innerHTML = records[i].deliverStamp;
	  	  }


		myDataTableOldRecords.destroy();
		$(document).ready( function () {
	    myDataTableOldRecords=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

		});
		} );

		// $("#tbl1 tr").on("click", highlightRow);
		$("#tbl1 tr").on("click", highlightRowAlag);
		// $("#tbl1 tr").on('click', showDetail);
	}

	// var gCustomerRowId = -1;
	var globalOrderRowId;
	var globalOrderRowIndex;
	var vGlobalMobileNo;
	var vGlobalAdvanceAtOrder;
	var vGlobalOrderRemarks;


	// var globalRowIndex = -1;

	function showDetail()
	{
		// alert();
		var burl = '<?php echo base_url();?>';
		rowIndex = $(this).index();
		globalOrderRowIndex = rowIndex;
		colIndex = $(this).index();
		orderRowId = $(this).closest('tr').children('td:eq(0)').text();
		customerName =  $(this).closest('tr').children('td:eq(3)').text();
		vGlobalMobileNo = $(this).closest('tr').children('td:eq(9)').text();
		// alert(orderRowId);
		globalOrderRowId = orderRowId;

		firstItemName="";
		totalItems = 0;

		$.ajax({
			'url': base_url + '/' + controller + '/showDetail',
			'type': 'POST', 
			'data':{'orderRowId':orderRowId},
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
		          cell.innerHTML = data['records'][i].orderRowId;
		          cell.style.display="none";

		          var cell = row.insertCell(1);
		          cell.innerHTML = data['records'][i].orderDetailRowId;
		          cell.style.display="none";
		          
		          var cell = row.insertCell(2);
				  if(data['records'][i].ready == 'Y')
				  {
					cell.innerHTML = "<input type='checkbox' id='chk' class='chk' name='chk' style='width:20px;height:20px;' checked/>";
				  }
				  else
				  {
					cell.innerHTML = "<input type='checkbox' id='chk' class='chk' style='width:20px;height:20px;' name='chk'/>";
				  }
				  cell.style.textAlign = "center";

		          var cell = row.insertCell(3);
		          cell.innerHTML = data['records'][i].itemRowId;
		          cell.style.display="none";

		          var cell = row.insertCell(4);
		          cell.innerHTML = data['records'][i].itemName;
		          // cell.style.color = "red";

		          var cell = row.insertCell(5);
		          cell.innerHTML = data['records'][i].qty;
		          // cell.style.color = "red";

		          var cell = row.insertCell(6);
		          cell.innerHTML = data['records'][i].rate;
		          // cell.style.color = "red";

		          var cell = row.insertCell(7);
		          cell.innerHTML = data['records'][i].amt;
		          // cell.style.color = "black";

		          var cell = row.insertCell(8);
		          cell.innerHTML = data['records'][i].itemRemarks;
		          var cell = row.insertCell(9);
		          cell.innerHTML = data['records'][i].ready;
		        }
		
				//////Items Ready SMS
				firstItemName = $("#tblDetail").find("tr:eq(1)").find("td:eq(4)").text();
				totalItems = $("#tblDetail tr").length-1;
				var msg = "";
				msg += "Dear Sir,";
				msg += "\nYour order";
				if(totalItems>1)
					msg += " (" + firstItemName + "+" + (totalItems-1) + ")";
				else
					msg += " (" + firstItemName + ")";
				msg += " is ready. Pls collect.\n-Thanx n Regards,\nSEACO TECH\n7896544444";
				$("#txtSmsForItemReady").val(msg);
				countCharactersReady();

				//// Delivery SMS
				var msg = "";
				msg += "Dear Sir,";
				msg += "\nYour order";
				if(totalItems>1)
					msg += " (" + firstItemName + "+" + (totalItems-1) + ")";
				else
					msg += " (" + firstItemName + ")";
				msg += " is delivered.\n-Thanx n Regards\nSEACO TECH\n7896544444";
				$("#txtSmsForDelivery").val(msg);
				countCharactersDelivery();
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
	    $('#tblDetail tr').each(function(row, tr)
	    {
	    	if(j>0)
	    	{
	    		if($(tr).find('td:eq(2)').find('input[type=checkbox]').is(':checked'))
	    		{
		        	TableData[i]=
		        	{
			            "orderDetailRowId" : $(tr).find('td:eq(1)').text()
			            , "isChecked" : 'Y'
		        	}   
		        	i++; 
		    	}
		    	else
	    		{
		        	TableData[i]=
		        	{
			            "orderDetailRowId" : $(tr).find('td:eq(1)').text()
			            , "isChecked" : 'N'
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

	function saveData()
	{
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);



		$.ajax({
				'url': base_url + '/' + controller + '/saveChanges',
				'type': 'POST',
				'data': {'TableData': TableData, 'globalOrderRowId': globalOrderRowId},
				'success': function(data)
				{
					alert("Done...");
					$("#tbl1 tr:eq("+ (globalOrderRowIndex+1) +")").trigger('click');
					// $("#tbl1 tr:eq("+ (globalOrderRowIndex+1) +")").css({'color':'white', 'background': '#337ab7'})
					$("#tbl1 tr:eq("+ (globalOrderRowIndex+1) +")").addClass("highlight");
					// highlightRow();
					// location.reload();
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});

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
						// alert(JSON.stringify(data));
						setTablePuraneRecords(data['recordsOld'])
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
<div class="container-fluid" style="width: 95%">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h2 class="text-center" style='margin-top:-20px'>Orders Status</h2>
		</div>
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:220px; overflow:auto;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='display:none1;'>order#</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Customer Name</th>
					 	<th>Total Amt</th>
					 	<th>Advance</th>
					 	<th>Due</th>
					 	<th>Del. Dt.</th>
					 	<th>Remarks</th>
					 	<th>Mob.</th>
					 </tr>
				 </thead>
				 <tbody>
				 <?php 
					foreach ($records as $row) 
					{
					 	$rowId = $row['orderRowId'];
					 	echo "<tr>";		
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
						echo "<td>".$row['mobile1']."</td>";
						echo "</tr>";
					}
				 ?>
			 </tbody>
				</table>
			</div>
		</div>

		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>

	

	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:220px; overflow:auto;">
				<table class='table table-striped table-bordered' id='tblDetail'>
				 <thead>
					 <tr>
						<th style='display:none;'>odRowId</th>
						<th></th>
			            <th>Item</th>
			            <th>Qty</th>
			            <th>Rate</th>
			            <th>Amt</th>
			            <th>Remarks</th>
			            <th>Ready</th>
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

	<div class="row" style="margin-top:20px; margin-bottom: 20px; display: none1;" >

		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<input type='button' onclick='saveData();' value='Save Ready Status' id='btnSave' class='btn form-control btn-success' >";
	      	?>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<input type='button' onclick='sendSmsForItemsReady();' value='Send SMS (Items Ready)' id='btnItemsReady' class='btn form-control btn-primary' >";
	      	?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<?php
				echo "<input type='button' onclick='checkBal();' value='Check Balance' id='btnCheckBalance' class='btn btn-information col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
			?>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<input type='button' onclick='delivered();' value='Delivered' id='btnSave' class='btn form-control btn-danger' >";
	      	?>
		</div>

		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		</div>

		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style="margin-top: 10px;">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Items Ready SMS:</label>";
				echo "<label id='lblCharsReady' style='color: red; font-weight: normal;'>0</label>";
				echo "&nbsp;&nbsp;&nbsp;<input id='chkSendSms' type='checkbox' checked>Send SMS";
				echo form_textarea('txtSmsForItemReady', '', "class='form-control' style='resize:none;height:100px;' id='txtSmsForItemReady'  maxlength=320 value=''");
          	?>
      	</div>

      	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		</div>

		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style="margin-top: 10px;">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Delivery SMS:</label>";
				echo "<label id='lblCharsDeliver' style='color: red; font-weight: normal;'>0</label>";
				echo "&nbsp;&nbsp;&nbsp;<input id='chkSendSmsDelivery' type='checkbox' checked>Send SMS";
				echo form_textarea('txtSmsForDelivery', '', "class='form-control' style='resize:none;height:100px;' id='txtSmsForDelivery'  maxlength=320 value=''");
          	?>
      	</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:220px; overflow:auto;">
				<table class='table table-hover' id='tblOldRecords'>
				 <thead>
					 <tr>
						<th style='display:none1;'>order#</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Customer Name</th>
					 	<th>Total Amt</th>
					 	<th>Advance</th>
					 	<th>Due</th>
					 	<th>Del. Dt.</th>
					 	<th>Remarks</th>
					 	<th>Mob.</th>
					 	<th>Ready SMS</th>
					 	<th>Ready Stamp</th>
					 	<th>Del SMS</th>
					 	<th>Del. Stamp</th>
					 </tr>
				 </thead>
				 <tbody>
				 <?php 
					foreach ($recordsOld as $row) 
					{
					 	$rowId = $row['orderRowId'];
					 	echo "<tr>";		
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
						echo "<td>".$row['mobile1']."</td>";
						echo "<td>".$row['readySms']."</td>";
						echo "<td>".$row['readyStamp']."</td>";
						echo "<td>".$row['deliverSms']."</td>";
						echo "<td>".$row['deliverStamp']."</td>";
						echo "</tr>";
					}
				 ?>
			 </tbody>
				</table>
			</div>
		</div>

		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>

	<div class="row" style="margin-top:20px;margin-bottom:20px;" >
		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<label style='color: red; font-weight: normal;'></label>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<input type='button' onclick='loadAllRecords();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
	</div>
</div>





<script type="text/javascript">
	function sendSmsForItemsReady()
	{
		if( $('#tblDetail tr').length < 2 )
	    {
	    	msgBoxError("Error", "Items table empty!!");
	    	return;
	    }

		var i=0, j=0, flag=0;
	    $('#tblDetail tr').each(function(row, tr)
	    {
	    	if(j>0)
	    	{
		    	// if($(tr).find('td:eq(2)').find('input[type=checkbox]').is(':checked'))
		    	if($(tr).find('td:eq(9)').text() == "N")
		    	{
		    		flag = 1;
		    	}
	    	}
	    	j++;

	    }); 
	    if(flag == 1)
	    {
	    	msgBoxError("Error", "All items are not ready!!!");
	    	return;
	    }

	    sendSms = $("#chkSendSms").prop("checked");
		sms = $("#txtSmsForItemReady").val().trim();
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
		orderRowId = globalOrderRowId;
		// alert(smsBhejo);
		// return;

		$.ajax({
			'url': base_url + '/' + controller + '/sendSmsForItemsReady',
			'type': 'POST', 
			'data':{'mob': vGlobalMobileNo, 'sms': sms, 'smsBhejo': smsBhejo, 'orderRowId': orderRowId},
			'dataType': 'json',
			'success':function(data)
			{
				alert("Done...");
				setTablePuraneRecords(data['recordsOld'])
			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
	}

	function delivered()
	{
		if( $('#tblDetail tr').length < 2 )
	    {
	    	msgBoxError("Error", "Items table empty!!");
	    	return;
	    }

		var i=0, j=0, flag=0;
	    $('#tblDetail tr').each(function(row, tr)
	    {
	    	if(j>0)
	    	{
		    	if($(tr).find('td:eq(9)').text() == "N")
		    	{
		    		flag = 1;
		    	}
	    	}
	    	j++;

	    }); 
	    if(flag == 1)
	    {
	    	msgBoxError("Error", "All items are not ready!!!");
	    	return;
	    }
	    // sms = $("#txtSmsForDelivery").val().trim();

	    sendSms = $("#chkSendSmsDelivery").prop("checked");
		sms = $("#txtSmsForDelivery").val().trim();
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
		// orderRowId = globalOrderRowId;
		// alert(orderRowId);
		// return;
		$.ajax({
			'url': base_url + '/' + controller + '/sendSmsForDelivery',
			'type': 'POST', 
			'data':{'mob': vGlobalMobileNo, 'sms': sms, 'smsBhejo': smsBhejo, 'orderRowId': globalOrderRowId},
			'dataType': 'json',
			'success':function(data)
			{
				alert("Delivery msg. sent...");
				location.reload();
			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
	}
	

	// $("#cboCustomer").change(function()
 //    {
 //    	loadData();
 //    });
</script>

<script type="text/javascript">
	function highlightRowAlag()
    {
    	// alert();
       var tableObject = $(this).parent();
       // if($(this).index() > 0)
        {
            var selected = $(this).hasClass("highlightAlag");
           tableObject.children().removeClass("highlightAlag");
           // if(!selected)
                $(this).addClass("highlightAlag");
        }
    }

    $("#tbl1 tr").on("click", showDetail);

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


	$(document).ready(function()
	{
		var smsBalance = '<?php echo $smsBalance;?>';
	    $("#btnCheckBalance").val("Check Balance ("+ smsBalance +")");
	});

	$(document).ready( function () {
	    myDataTableOldRecords = $('#tblOldRecords').DataTable({
		    paging: false,
		    ordering: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		});
	} );

	$("#txtSmsForItemReady").on("change, keyup", countCharactersReady);
	function countCharactersReady()
	{
		$("#lblCharsReady").text( $("#txtSmsForItemReady").val().length );
	}

	$("#txtSmsForDelivery").on("change, keyup", countCharactersDelivery);
	function countCharactersDelivery()
	{
		$("#lblCharsDeliver").text( $("#txtSmsForDelivery").val().length );
	}
</script>
