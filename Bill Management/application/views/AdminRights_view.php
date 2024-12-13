<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='AdminRights_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Admin Rights";

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
				cell.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";
				cell.style.textAlign = "center";
				cell.style.color='lightgray';
				cell.setAttribute("onmouseover", "this.style.color='red'");
				cell.setAttribute("onmouseout", "this.style.color='lightgray'");
				cell.setAttribute("onclick", "delrowid(" + records[i].rightrowid +")");
				// data-toggle="modal" data-target="#myModal"
				cell.setAttribute("data-toggle", "modal");
				cell.setAttribute("data-target", "#myModal");

				var cell = row.insertCell(1);
				cell.style.display="none";
				cell.innerHTML = records[i].rightrowid;
				var cell = row.insertCell(2);
				cell.innerHTML = records[i].menuoption;
	  	  }


	  	  $("#tbl1 tr").on("click", highlightRow);

			myDataTable.destroy();
			$(document).ready( function () {
		    myDataTable=$('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
			} );

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
						$("#txtMenuOption").focus();
					}
				}
			});
	}
	
	function saveData()
	{	

		menuOption = $("#txtMenuOption").val().trim();
		if(menuOption == "")
		{
			alertPopup("Invalid menu option...", 8000);
			$("#txtMenuOption").focus();
			return false;
		}

		if($("#btnSave").val() == "Save")
		{
			// alert(menuOption);
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								  'menuOption': menuOption
							},
					'success': function(data)
					{
							// alert(data);
						if(data)
						{
							if(data == "Duplicate record...")
							{
								myAlert("Duplicate record...");
							}
							else
							{
								setTable(data['records']) ///loading records in tbl1

								alertPopup('Record saved...', 4000);
								blankControls();
								$("#txtMenuOption").focus();
							}
						}
							
					}
			});
		}

	}
</script>
<div class="container">
	<div class="row">
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
			<h1 class="text-center" style='margin-top:-20px'>Admin Rights</h1>
			<div class="row" style="margin-top:5px;">
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<?php
						$this->load->helper('form');
						echo "<label style='color: black; font-weight: normal;'>Menu Option:</label>";
						echo form_input('txtMenuOption', '', "class='form-control' autofocus placeholder='' id='txtMenuOption' style='' maxlength=50 autocomplete='off'");
	              	?>
	          	</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
						echo "<input type='button' onclick='saveData();' value='Save' id='btnSave' class='btn btn-primary form-control'>";
	              	?>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>

		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto; height:400px;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
					 	<th  width="50" class="text-center">Delete</th>
						<th style='width:0px;display:none;'>rowid</th>
					 	<th>Menu Option</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						if($errorfound=="no") ////When Saved Or Updated Successfully
						{
							echo "<script> blankcontrol(); </script>";
							echo "<script> document.getElementById('btnSave').value = 'Save'; </script>";
						}
						else 
						{
							// echo $errorfound;
						}


						foreach ($records as $row) 
						{
						 	$rowid = $row['rightrowid'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowid.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='display:none;'>".$row['rightrowid']."</td>";
						 	echo "<td>".$row['menuoption']."</td>";
							echo "</tr>";
						}
					 ?>

				 </tbody>
				</table>
			</div>
		</div>

		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>

		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
			<!-- <span style="color:red;">
				Vehicles rowId is stored instead of veh.# (So... do not delete them)
			</span> -->
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
		          <h4 class="modal-title">Neer</h4>
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

	

		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
		} );

</script>