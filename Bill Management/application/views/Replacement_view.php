<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style type="text/css">
	.ui-autocomplete {
	    max-height: 200px;
	    overflow-y: auto;   /* prevent horizontal scrollbar */
	    overflow-x: hidden; /* add padding to account for vertical scrollbar */
	    z-index:1000 !important;
	}

	#txtDate {position: relative; z-index:101;}
</style>

<script type="text/javascript">
	var controller='Replacement_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Replacement";

	function setTable(records)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl2").empty();
	      var table = document.getElementById("tbl2");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          if( records[i].sent == "Y" )
	          {
	          	row.style.color="blue";
	          }

	          var cell = row.insertCell(0);
	          cell.innerHTML = "<span class='glyphicon glyphicon-pencil'></span>";
	          cell.style.textAlign = "center";
	          cell.style.color='lightgray';
	          cell.setAttribute("onmouseover", "this.style.color='green'");
	          cell.setAttribute("onmouseout", "this.style.color='lightgray'");
	          cell.className = "editRecord";

	          var cell = row.insertCell(1);
				  cell.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";
	          cell.style.textAlign = "center";
	          cell.style.color='lightgray';
	          cell.setAttribute("onmouseover", "this.style.color='red'");
	          cell.setAttribute("onmouseout", "this.style.color='lightgray'");
	          cell.setAttribute("onclick", "delrowid(" + records[i].replacementRowId +")");
	          // data-toggle="modal" data-target="#myModal"
	          cell.setAttribute("data-toggle", "modal");
	          cell.setAttribute("data-target", "#myModal");

	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].replacementRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(3);
	          cell.innerHTML = dateFormat(new Date(records[i].dt));
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].itemRowId;
	          cell.style.display="none";

	           var cell = row.insertCell(5);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].partyRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(7);
	          cell.innerHTML = records[i].partyName;
	          var cell = row.insertCell(8);
	          cell.innerHTML = records[i].qty;
	          var cell = row.insertCell(9);
	          cell.innerHTML = records[i].remarks;
	          var cell = row.insertCell(10);
	          cell.innerHTML = records[i].sent;
	          // cell.style.color="red";

	          var cell = row.insertCell(11);
	          if (records[i].sentDt == null)
	          {
	          	cell.innerHTML = "";
	          }
	          else
	          {
	          	cell.innerHTML = dateFormat(new Date(records[i].sentDt));
	          }
	          var cell = row.insertCell(12);
	          cell.innerHTML = records[i].recd;
	          var cell = row.insertCell(13);
	          if (records[i].recdDt == null)
	          {
	          	cell.innerHTML = "";
	          }
	          else
	          {
	          	cell.innerHTML = dateFormat(new Date(records[i].recdDt));
	          }
	          var cell = row.insertCell(14);
	          cell.innerHTML = "<input type='checkbox' id='chk' class='chk' name='chk' style='width:14px;height:14px;'/>";
	          var cell = row.insertCell(15);
	          // cell.innerHTML = "<button class='clsRecd btn btn-danger form-control'>Recd</button>";
	  	  }

	  	$('.editRecord').bind('click', editThis);
	  	$(".clsSent").on('click', setSent);
	  	$(".clsRecd").on('click', setRecd);

		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl2').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
            ordering: false
		});
		} );

		$("#tbl2 tr").off();
		$("#tbl2 tr").on("click", highlightRowAlag);
		// $(".clsStatus").on('click', getRechargeStatus);
			
	}
	
	
	function saveData()
	{	
		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			msgBoxError("Error","Invalid date...");
			// $("#txtDate").focus();
			return;
		}
		itemRowId = $("#lblItemRowId").text();
		itemName = $("#txtItem").val().trim();
		if(itemName == "" )
		{
			msgBoxError("Error","Invalid Item name...");
			// $("#txtCustomerName").focus();
			return;
		}
		customerRowId = $("#lblCustomerId").text();
		customerName = $("#txtCustomerName").val().trim();
		if(customerName == "" )
		{
			msgBoxError("Error","Invalid customer name...");
			// $("#txtCustomerName").focus();
			return;
		}
		qty = $("#txtQty").val();
		remarks = $("#txtRemarks").val().trim();
	

		if($("#btnSave").val() == "Save")
		{
			// alert("save");
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								'dt': dt
								, 'itemRowId': itemRowId
								, 'itemName': itemName
								, 'partyRowId': customerRowId
								, 'partyName': customerName
								, 'qty': qty
								, 'remarks': remarks
							},
					'success': function(data)
					{
						if(data)
						{
							
							setTable(data['records']) ///loading records in tbl2
							alertPopup('Record saved...', 4000);
							blankControls();
							$("#txtDate").val(dateFormat(new Date()));;
							$("#lblCustomerId").text("");
							$("#lblItemRowId").text("");
							$("#txtItem").focus();
							// location.reload();
							
						}
					},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
		}
		else if($("#btnSave").val() == "Update")
		{
			// alert("update");
			$.ajax({
					'url': base_url + '/' + controller + '/update',
					'type': 'POST',
					'dataType': 'json',
					'data': {'globalrowid': globalrowid
								, 'dt': dt
								, 'itemRowId': itemRowId
								, 'itemName': itemName
								, 'partyRowId': customerRowId
								, 'partyName': customerName
								, 'qty': qty
								, 'remarks': remarks
							},
					'success': function(data)
					{
						if(data)
						{
							setTable(data['records']) ///loading records in tbl2
							alertPopup('Record updated...', 4000);
							blankControls();
							$("#btnSave").val("Save");
							$("#txtDate").val(dateFormat(new Date()));
							$("#lblCustomerId").text("");
							$("#lblItemRowId").text("");
							$("#txtItem").focus();
						}
							
					},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
		}
	}

	function deleteRecord(rowId)
	{
		// alert(rowId);
		$.ajax({
				'url': base_url + '/' + controller + '/delete',
				'type': 'POST',
				'dataType': 'json',
				'data': {'rowId': rowId},
				'success': function(data){
					if(data)
					{
						setTable(data['records'])
						alertPopup('Record deleted...', 4000);
						blankControls();
						$("#txtDate").val(dateFormat(new Date()));
						$("#txtItem").focus();
						
					}
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
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
						setTableOld(data['records']);
						// msgBoxDone("Done...", "Records loaded...")
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
<div class="container-fluid" style="width:95%;">
	<div class="row">
		<!-- <div class="col-lg-4 col-sm-4 col-md-4 col-xs-0">
		</div> -->
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h1 class="text-center" style='margin-top:-20px'>Replacement</h1>
			<div class="row" style="margin-top:25px;">
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Date:</label>";
						echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 ");
	              	?>
	          	</div>
	          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" id="divMobile" style="">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Item:</label>";
						echo "<label style='color: lightgrey; font-weight: normal;' id='lblItemRowId'></label>";
						echo form_input('txtItem', '', "class='form-control' id='txtItem' style='' maxlength=50 autofocus autocomplete='off'");
	              	?>
	          	</div>
	          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" id="divTv" style="">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Party:</label>";
						echo "<label style='color: lightgrey; font-weight: normal;' id='lblCustomerId'></label>";
						echo form_input('txtCustomerName', '', "class='form-control' id='txtCustomerName' style='' maxlength=50 autocomplete='off'");
	              	?>
	          	</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Qty:</label>";
						echo '<input type="number" value="" name="txtQty" class="form-control" maxlength="4" id="txtQty" />';
	              	?>
	          	</div>
	          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
						echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' style='' maxlength=250 autocomplete='off'");
	              	?>
	          	</div>
	          	
	          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
						echo "<input type='button' onclick='saveData();' value='Save' id='btnSave' class='btn btn-primary form-control'>";
	              	?>
	          	</div>
			</div>

			<div class="row" style="margin-top:1px;">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					
				</div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
				</div>
				
			</div>
		</div>
	</div>


	<div class="row" style="margin-top:40px;" >
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:400px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl2'>
				 <thead>
					 <tr>
					 	<th  class="editRecord text-center">Edit</th>
					 	<th  class="text-center">Delete</th>
						<th style='display:none;'>rowid</th>
					 	<th>Date</th>
					 	<th style='display:none;'>ItemRowId</th>
					 	<th>Item</th>
					 	<th style='display:none;'>PartyRowId</th>
					 	<th>Party</th>
					 	<th>Qty</th>
					 	<th>Remarks</th>
					 	<th>Sent</th>
					 	<th>SentDt</th>
					 	<th>Recd</th>
					 	<th>RecdDt</th>
					 	<th></th>
					 	<th></th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($records as $row) 
						{
						 	$rowId = $row['replacementRowId'];
						 	if($row['sent']=="Y")
							{
						 		echo "<tr style='color:blue;'>";
							}
							else
							{
						 		echo "<tr>";
							}
						 	
						 	echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='display:none;'>".$row['replacementRowId']."</td>";
						 	$vdt = strtotime($row['dt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td style='display:none;'>".$row['itemRowId']."</td>";
						 	echo "<td>".$row['itemName']."</td>";
						 	echo "<td style='display:none;'>".$row['partyRowId']."</td>";
						 	echo "<td>".$row['partyName']."</td>";
						 	echo "<td>".$row['qty']."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	echo "<td>".$row['sent']."</td>";
						 	if ($row['sentDt'] == "")
						 	{
						 		echo "<td></td>";
						 	}
						 	else
						 	{
						 		$vdt = strtotime($row['sentDt']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
						 	}
						 	
						 	echo "<td>".$row['recd']."</td>";
						 	if ($row['recdDt'] == "")
						 	{
						 		echo "<td></td>";
						 	}
						 	else
						 	{
						 		$vdt = strtotime($row['recdDt']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
						 	}
						 	echo "<td align='center'><input type='checkbox' id='chk' class='chk' name='chk' style='width:14px;height:14px;'/></td>";
						 	echo "<td></td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
				echo "<input type='button' onclick='setSent();' value='Mark Sent (Checked)' id='btnSent' class='btn btn-danger form-control'>";
          	?>
      	</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
      	</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
				echo "<input type='button' onclick='setRecd();' value='Mark Received (Checked)' id='btnSent' class='btn btn-success form-control'>";
          	?>
      	</div>
	</div>
	<hr />
	<div class="row" style="margin-top:40px; background: lightgrey;" >
		<h1 class="text-center" style='margin-top:10px'>Replacement Done</h1>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:400px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tblOld'>
				 <thead>
					 <tr>
					 	<th  style='display:none;' class="editRecord text-center">Edit</th>
					 	<th  style='display:none;' class="text-center">Delete</th>
						<th style='display:none;'>rowid</th>
					 	<th>Date</th>
					 	<th style='display:none;'>ItemRowId</th>
					 	<th>Item</th>
					 	<th style='display:none;'>PartyRowId</th>
					 	<th>Party</th>
					 	<th>Qty</th>
					 	<th>Remarks</th>
					 	<th>Sent</th>
					 	<th>SentDt</th>
					 	<th>Recd</th>
					 	<th>RecdDt</th>
					 	<th style='display:none;'></th>
					 	<th style='display:none;'></th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($recordsOld as $row) 
						{
						 	$rowId = $row['replacementRowId'];
							echo "<tr>";
						 	echo '<td style="display:none;color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="display:none;color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='display:none;'>".$row['replacementRowId']."</td>";
						 	$vdt = strtotime($row['dt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td style='display:none;'>".$row['itemRowId']."</td>";
						 	echo "<td>".$row['itemName']."</td>";
						 	echo "<td style='display:none;'>".$row['partyRowId']."</td>";
						 	echo "<td>".$row['partyName']."</td>";
						 	echo "<td>".$row['qty']."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	echo "<td style=''>".$row['sent']."</td>";
						 	if ($row['sentDt'] == "")
						 	{
						 		echo "<td></td>";
						 	}
						 	else
						 	{
						 		$vdt = strtotime($row['sentDt']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
						 	}
						 	
						 	echo "<td>".$row['recd']."</td>";
						 	if ($row['recdDt'] == "")
						 	{
						 		echo "<td></td>";
						 	}
						 	else
						 	{
						 		$vdt = strtotime($row['recdDt']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
						 	}
						 	echo "<td style='display:none;'></td>";
						 	echo "<td style='display:none;'></td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top:20px; margin-bottom: 20px;" >
		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			
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
	
</script>


<script type="text/javascript">
	var globalrowid;
	function delrowid(rowid)
	{
		globalrowid = rowid;
	}

	$('.editRecord').bind('click', editThis);
	function editThis(jhanda)
	{
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		globalrowid = $(this).closest('tr').children('td:eq(2)').text();
		dt = $(this).closest('tr').children('td:eq(3)').text();
		itemRowId = $(this).closest('tr').children('td:eq(4)').text();
		itemName = $(this).closest('tr').children('td:eq(5)').text();
		partyRowId = $(this).closest('tr').children('td:eq(6)').text();
		partyName = $(this).closest('tr').children('td:eq(7)').text();
		qty = $(this).closest('tr').children('td:eq(8)').text();
		remarks = $(this).closest('tr').children('td:eq(9)').text();

		$("#txtDate").val(dt);
		$("#lblItemRowId").text(itemRowId);
		$("#txtItem").val(itemName);
		$("#lblCustomerId").text(partyRowId);
		$("#txtCustomerName").val(partyName);
		$("#txtQty").val(qty);
		$("#txtRemarks").val(remarks);

		$("#btnSave").val("Update");
	}


	

		$(document).ready( function () {
		    myDataTable = $('#tbl2').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			    // ordering: false
			});

			myDataTableOld = $('#tblOld').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			    // ordering: false
			});

			$(".clsSent").on('click', setSent);
			$(".clsRecd").on('click', setRecd);
			// $("#cboDevice").on('change', setOperators);

			$( "#txtDate" ).datepicker({
					dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
				});
			    // Set the Current Date as Default
				$("#txtDate").val(dateFormat(new Date()));


				$("#tbl2 tr").off();
				$("#tbl2 tr").on("click", highlightRowAlag);
		} );
	


		var select = false;
    $( "#txtCustomerName" ).focus(function(){ 
	  			select = false; 
	  			// $("#txtAddress").val(select);
	  		});

	$(document).ready( function () 
	{
		bindCustomers();
		bindItems();
    } );

    function bindCustomers()
  	{
  		select = false;
		var jSonArray = '<?php echo json_encode($customers); ?>';
		// alert(jSonArray);
		var jSonArray = jSonArray.replace(/(\r\n|\n|\r)/gm,", "); ///Multilinse of Address field with comma replce
		var availableTags = $.map(JSON.parse(jSonArray), function(obj){
					return{
							label: obj.customerName,
							customerRowId: obj.customerRowId,
							
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
			    // var customerRowId = ui.item.customerRowId;
			    $("#lblCustomerId").text( ui.item.customerRowId );
	        	}
		    }).blur(function() {
				  if( !select ) 
				  {
				  	$("#lblCustomerId").text('-1');
				  	// $("#tbl2").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
  	}

    function bindItems()
  	{
  		var select = false;
	  	var defaultText = "";
	    $( "#txtItem" ).focus(function(){ 
  			select = false; 
  			defaultText = $(this).text();
  		});



		// var someList = ["seven nine five", "five fifteen twenty", "twenty-five maybe one", "two (five) one"];
		var jSonArray = '<?php echo json_encode($items); ?>';
		var availableTags = $.map(JSON.parse(jSonArray), function(obj){
					return{
							label: obj.itemName,
							itemRowId: obj.itemRowId,
							
					}
			});

		    $(function() {
	        $( "#txtItem" ).autocomplete({
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
				    
				    $("#lblItemRowId").text( ui.item.itemRowId );
	        	}

	        }).blur(function() {
				  	// alert(select);
				var newText = $("#txtItem").val(); 
		    	if( !select && !(defaultText == newText) ) 
				  {
				  	$("#lblItemRowId").text('-1');
				  	// $("#tbl2").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  
				}).focus(function(){            
			            $(this).autocomplete("search");
				});	///////////

	    });
  	}

  	var checkedRows=0;
  	var notSentButRecd=0;
	function storeTblValuesChecked()
	{
		notSentButRecd=0;
	    var TableData = new Array();
	    var i=0, j=0;
	    $('#tbl2 tr').each(function(row, tr)
	    {
	    	if(j>=0)
	    	{
	    		if($(tr).find('td:eq(14)').find('input[type=checkbox]').is(':checked'))
	    		{
		        	TableData[i]=
		        	{
			            "rowId" : $(tr).find('td:eq(2)').text()
		        	}  

		        	if( $(tr).find('td:eq(10)').text() == "N" )
			    	{
			    		notSentButRecd=1;
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

  	function setSent()
	{
		var TableData;
		TableData = storeTblValuesChecked();
		TableData = JSON.stringify(TableData);
		// alert(JSON.stringify(TableData));
		// return;
		// rowIndex = $(this).parent().parent().index();
		// rowId = $(this).closest('tr').children('td:eq(2)').text();
		$.ajax({
			'url': base_url + '/' + controller + '/setSent',
			'type': 'POST',
			'dataType': 'json',
			'data': { 'TableData': TableData },
			'success': function(data)
			{
				if(data)
				{
					setTable(data['records']);
				}
			},
			'error': function(jqXHR, exception)
	          {
	            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
	            $("#modalAjaxErrorMsg").modal('toggle');
	          }
		});

	}	

	function setRecd()
	{
		var TableData;
		TableData = storeTblValuesChecked();
		TableData = JSON.stringify(TableData);
		// rowIndex = $(this).parent().parent().index();
		// rowId = $(this).closest('tr').children('td:eq(2)').text();
		// sent = $(this).closest('tr').children('td:eq(10)').text();
		if(notSentButRecd == 1)
		{
			msgBoxError("Error", "Can not receive without sending...");
			return;
		}
		$.ajax({
			'url': base_url + '/' + controller + '/setRecd',
			'type': 'POST',
			'dataType': 'json',
			'data': { 'TableData': TableData },
			'success': function(data)
			{
				if(data)
				{
					setTable(data['records']);
				}
			},
			'error': function(jqXHR, exception)
	          {
	            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
	            $("#modalAjaxErrorMsg").modal('toggle');
	          }
		});

	}	




	function setTableOld(records)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl2").empty();
	      var table = document.getElementById("tbl2");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);

	          var cell = row.insertCell(0);
	          cell.innerHTML = "<span class='glyphicon glyphicon-pencil'></span>";
	          cell.style.textAlign = "center";
	          cell.style.color='lightgray';
	          cell.setAttribute("onmouseover", "this.style.color='green'");
	          cell.setAttribute("onmouseout", "this.style.color='lightgray'");
	          cell.className = "editRecord";
	          cell.style.display="none";


	          var cell = row.insertCell(1);
				  cell.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";
	          cell.style.textAlign = "center";
	          cell.style.color='lightgray';
	          cell.setAttribute("onmouseover", "this.style.color='red'");
	          cell.setAttribute("onmouseout", "this.style.color='lightgray'");
	          cell.setAttribute("onclick", "delrowid(" + records[i].replacementRowId +")");
	          // data-toggle="modal" data-target="#myModal"
	          cell.setAttribute("data-toggle", "modal");
	          cell.setAttribute("data-target", "#myModal");
	          cell.style.display="none";


	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].replacementRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(3);
	          cell.innerHTML = dateFormat(new Date(records[i].dt));
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].itemRowId;
	          cell.style.display="none";

	           var cell = row.insertCell(5);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].partyRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(7);
	          cell.innerHTML = records[i].partyName;
	          var cell = row.insertCell(8);
	          cell.innerHTML = records[i].qty;
	          var cell = row.insertCell(9);
	          cell.innerHTML = records[i].remarks;
	          var cell = row.insertCell(10);
	          cell.innerHTML = records[i].sent;
	          cell.style.color="red";

	          var cell = row.insertCell(11);
	          if (records[i].sentDt == null)
	          {
	          	cell.innerHTML = "";
	          }
	          else
	          {
	          	cell.innerHTML = dateFormat(new Date(records[i].sentDt));
	          }
	          var cell = row.insertCell(12);
	          cell.innerHTML = records[i].recd;
	          var cell = row.insertCell(13);
	          if (records[i].recdDt == null)
	          {
	          	cell.innerHTML = "";
	          }
	          else
	          {
	          	cell.innerHTML = dateFormat(new Date(records[i].recdDt));
	          }
	          var cell = row.insertCell(14);
	          cell.innerHTML = "<button class='clsSent btn btn-success form-control'>Sent</button>";
	          cell.style.display="none";

	          var cell = row.insertCell(15);
	          cell.innerHTML = "<button class='clsRecd btn btn-danger form-control'>Recd</button>";
	          cell.style.display="none";

	  	  }

	  	

		myDataTableOld.destroy();
		$(document).ready( function () {
	    myDataTableOld=$('#tblOld').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
            ordering: false
		});
		} );			
	}
</script>