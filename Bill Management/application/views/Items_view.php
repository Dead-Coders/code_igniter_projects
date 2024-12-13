<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='Items_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Items";

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
	          cell.setAttribute("onclick", "delrowid(" + records[i].itemRowId +")");
	          // data-toggle="modal" data-target="#myModal"
	          cell.setAttribute("data-toggle", "modal");
	          cell.setAttribute("data-target", "#myModal");

	          var cell = row.insertCell(2);
	          // cell.style.display="none";
	          cell.innerHTML = records[i].itemRowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].sellingPrice;
	  	  }


	  	$('.editRecord').bind('click', editThis);

		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

		});
		} );

		$("#tbl1 tr").on("click", highlightRow);
		// $('#tbl1 tr').each(function(){
		// 	$(this).bind('click', highlightRow);
		// });
			
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
						// alert(data);
						if( data['dependent'] == "yes" )
						{
							msgBoxError("Error", "Record can not be deleted...<br> Dependent records exist...");
							// alertPopup('Record can not be deleted... Dependent records exist...', 8000, 'red');
						}
						else
						{
							setTable(data['records'])
							msgBoxDone("Done", "Record deleted...");
							// alertPopup('Record deleted...', 4000);
							blankControls();
							$("#txtItemName").focus();
						}
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
	}
	
	function saveData()
	{	
		itemName = $("#txtItemName").val().trim();
		// alert(itemName);
		if(itemName == "")
		{
			msgBoxError("Error", "Item name can not be blank...");
			// alertPopup("Prefix type can not be blank...", 8000, 'red');
			$("#txtItemName").focus();
			return;
		}

		sellingPrice = $("#txtSellingPrice").val();

		if($("#btnSave").val() == "Save")
		{
			// alert("save");
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								'itemName': itemName
								, 'sellingPrice': sellingPrice
							},
					'success': function(data)
					{
						if(data)
						{
							// alert(data);
							if(data == "Duplicate record...")
							{
								msgBoxError("Error", "Duplicate record...");
								// alertPopup("Duplicate record...", 4000, 'red');
								$("#txtItemName").focus();
							}
							else
							{
								setTable(data['records']) ///loading records in tbl1
								//msgBoxDone("Done", "Record saved...");
								 alertPopup('Record saved...', 4000);
								blankControls();
								$("#txtItemName").focus();
								// location.reload();
							}
						}
							
					},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
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
								, 'itemName': itemName
								, 'sellingPrice': sellingPrice
							},
					'success': function(data)
					{
						if(data)
						{
							// alert(data);
							if(data == "Duplicate record...")
							{
								msgBoxError("Error", "Duplicate record...");
								// alertPopup("Duplicate record...", 5000, 'red');
								$("#txtItemName").focus();
							}
							else
							{
								setTable(data['records']) ///loading records in tbl1
								//msgBoxDone("Done", "Record updated...");
								 alertPopup('Record updated...', 4000);
								blankControls();
								$("#btnSave").val("Save");
								$("#txtItemName").focus();
							}
						}
							
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
						setTable(data['records'])
						// msgBoxDone("Done...", "Records loaded...")
						alertPopup('Records loaded...', 4000);
						blankControls();
						$("#txtItemName").focus();
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
		<!-- <div class="col-lg-4 col-sm-4 col-md-4 col-xs-0">
		</div> -->
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h1 class="text-center" style='margin-top:-20px'>Items</h1>
			<div class="row" style="margin-top:25px;">
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<?php
						// echo $this->session->orgRowId;
						// echo    "    " . $this->session->orgName;
						echo "<label style='color: black; font-weight: normal;'>Item Name:</label>";
						echo form_input('txtItemName', '', "class='form-control' autofocus id='txtItemName' style='text-transform: capitalize;' maxlength=99 autocomplete='off'");
	              	?>
	          	</div>
			</div>

			<div class="row" style="margin-top:1px;">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Selling Price</label>";
						echo "<input type='number' value='0' id='txtSellingPrice' class='form-control'>";
					?>
				</div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
				</div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
						echo "<input type='button' onclick='saveData();' value='Save' id='btnSave' class='btn btn-success form-control'>";
	              	?>
	          	</div>
			</div>


		</div>
		<!-- <div class="col-lg-4 col-sm-4 col-md-4 col-xs-0">
		</div> -->
	</div>


	<div class="row" style="margin-top:20px;" >
		<!-- <div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div> -->

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto;">
				<table class='table table-hover table-striped table-bordered' id='tbl1'>
				 <thead>
					 <tr>
					 	<th  width="50" class="editRecord text-center">Edit</th>
					 	<th  width="50" class="text-center">Delete</th>
						<th style='width:0px;display:none1;'>rowid</th>
					 	<th>Item Name</th>
					 	<th>S.Price</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						if($errorfound=="no") ////When Saved Or Updated Successfully
						{
						}
						else 
						{
						}


						foreach ($records as $row) 
						{
						 	$rowId = $row['itemRowId'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='width:0px;display:none1;'>".$row['itemRowId']."</td>";
						 	echo "<td>".$row['itemName']."</td>";
						 	echo "<td>".$row['sellingPrice']."</td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>

		<!-- <div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div> -->
	</div>

	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-0">
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<input type='button' onclick='loadAllRecords();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>

	</div>
</div>



		  <div class="modal" id="myModal" role="dialog">
		    <div class="modal-dialog modal-sm">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">WSS</h4>
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
		itemName = $(this).closest('tr').children('td:eq(3)').text();
		globalrowid = $(this).closest('tr').children('td:eq(2)').text();
		sellingPrice = $(this).closest('tr').children('td:eq(4)').text();

		$("#txtItemName").val(itemName);
		$("#txtSellingPrice").val(sellingPrice);
		$("#txtItemName").focus();
		$("#btnSave").val("Update");
	}


		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
		} );

</script>