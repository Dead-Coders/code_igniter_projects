<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='Reminders_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Reminders";

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
	          cell.setAttribute("onclick", "delrowid(" + records[i].reminderRowId +")");
	          // data-toggle="modal" data-target="#myModal"
	          cell.setAttribute("data-toggle", "modal");
	          cell.setAttribute("data-target", "#myModal");

	          var cell = row.insertCell(2);
	          cell.style.display="none";
	          cell.innerHTML = records[i].reminderRowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = dateFormat(new Date(records[i].dt));
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].remarks;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].repeat;
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
						if( data['dependent'] == "yes" )
						{
							alertPopup('Record can not be deleted... Dependent records exist...', 8000, 'red');
						}
						else
						{
							setTable(data['records'])
							alertPopup('Record deleted...', 4000);
							blankControls();
							$("#txtDate").val(dateFormat(new Date()));
							$("#txtRemarks").focus();
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
	
	function saveData()
	{	
		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#txtDate").focus();
			return;
		}

		remarks = $("#txtRemarks").val().trim();
		if(remarks == "")
		{
			alertPopup("Remarks can not be blank...", 8000, 'red');
			$("#txtRemarks").focus();
			return;
		}
		repeat = $("#cboRepeat").val().trim();
		if(repeat == "-1")
		{
			alertPopup("Select REPEAT frequeny...", 8000, 'red');
			$("#cboRepeat").focus();
			return;
		}

		if($("#btnSave").val() == "Save")
		{
			// alert("save");
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								'dt': dt
								, 'remarks': remarks
								, 'repeat': repeat
							},
					'success': function(data)
					{
						if(data)
						{
							// alert(data);
							if(data == "Duplicate record...")
							{
								alertPopup("Duplicate record...", 4000, 'red');
								$("#txtRemarks").focus();
							}
							else
							{
								setTable(data['records']) ///loading records in tbl1

								alertPopup('Record saved...', 4000);
								// blankControls();
								// $("#txtDate").val(dateFormat(new Date()));
								$("#cboRepeat").val('-1');
								$("#txtRemarks").val('');
								$("#cboRepeat").focus();
								// location.reload();
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
		else if($("#btnSave").val() == "Update")
		{
			// alert("update");
			$.ajax({
					'url': base_url + '/' + controller + '/update',
					'type': 'POST',
					'dataType': 'json',
					'data': {'globalrowid': globalrowid
								, 'dt': dt
								, 'remarks': remarks
								, 'repeat': repeat
							},
					'success': function(data)
					{
						if(data)
						{
							// alert(data);
							if(data == "Duplicate record...")
							{
								alertPopup("Duplicate record...", 4000, 'red');
								$("#txtRemarks").focus();
							}
							else
							{
								setTable(data['records']) ///loading records in tbl1
								alertPopup('Record updated...', 4000);
								// blankControls();
								$("#btnSave").val("Save");
								// $("#txtDate").val(dateFormat(new Date()));
								$("#cboRepeat").val('-1');
								$("#txtRemarks").val('');
								$("#cboRepeat").focus();
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
						alertPopup('Records loaded...', 4000);
						blankControls();
						$("#txtRemarks").focus();
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
	<div class="row1">
		<h3 class="text-center" style='margin-top:-20px'>Reminders</h3>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Date:</label>";
				echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
      		<?php
				$repeat = array();
				$repeat['-1'] = '--- Select ---';
				$repeat['Once'] = "Once";
				$repeat['Weekly'] = "Weekly";
				$repeat['Monthly'] = "Monthly";
				$repeat['Yearly'] = "Yearly";
				echo "<label style='color: black; font-weight: normal;'>Repeat:</label>";
				echo form_dropdown('cboRepeat', $repeat, '-1',"class='form-control' id='cboRepeat'");
          	?>
      	</div>
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
				echo form_input('txtRemarks', '', "class='form-control' autofocus id='txtRemarks' style='' maxlength=250 autocomplete='off'");
          	?>
        </div>
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
				echo "<input type='button' onclick='saveData();' value='Save' id='btnSave' class='btn btn-success form-control'>";
				echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
          	?>
      	</div>
	</div>




	<div class="row1" style="margin-top:20px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div> 

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
					 	<th  width="50" class="editRecord text-center">Edit</th>
					 	<th  width="50" class="text-center">Delete</th>
						<th style='width:0px;display:none;'>rowid</th>
					 	<th>Date</th>
					 	<th>Remarks</th>
					 	<th>Repeat</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						if($errorfound=="no") ////When Saved Or Updated Successfully
						{
							// echo "<script> blankcontrol(); </script>";
							// echo "<script> document.getElementById('btnSave').value = 'Save'; </script>";
						}
						else 
						{
							// echo $errorfound;
						}


						foreach ($records as $row) 
						{
						 	$rowId = $row['reminderRowId'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='width:0px;display:none;'>".$row['reminderRowId']."</td>";
						 	$vdt = strtotime($row['dt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	// echo "<td>".$row['dt']."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	echo "<td>".$row['repeat']."</td>";
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

	<div class="row1" style="margin-top:20px;" >
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-0">
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
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
		dt = $(this).closest('tr').children('td:eq(3)').text();
		remarks = $(this).closest('tr').children('td:eq(4)').text();
		repeat = $(this).closest('tr').children('td:eq(5)').text();
		globalrowid = $(this).closest('tr').children('td:eq(2)').text();

		$("#txtDate").val(dt);
		$("#txtRemarks").val(remarks);
		$("#cboRepeat").val(repeat);
		$("#txtRemarks").focus();
		$("#btnSave").val("Update");
	}


	$(document).ready( function () {
	    myDataTable = $('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

		});
	} );


	$( "#txtDate" ).datepicker({
		dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
	});
    // Set the Current Date as Default
	$("#txtDate").val(dateFormat(new Date()));
</script>