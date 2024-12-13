<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='StageItems_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Stage Items";

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
	          cell.setAttribute("onclick", "delrowid(" + records[i].stageItemRowId +")");
	          // data-toggle="modal" data-target="#myModal"
	          cell.setAttribute("data-toggle", "modal");
	          cell.setAttribute("data-target", "#myModal");

	          var cell = row.insertCell(2);
	          cell.style.display="none";
	          cell.innerHTML = records[i].stageItemRowId;
	          var cell = row.insertCell(3);
	          cell.style.display="none";
	          cell.innerHTML = records[i].stageRowId;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].stageName;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].stageItemName;
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
							alertPopup('Record can not be deleted... Dependent records exist...', 8000);
						}
						else
						{
							setTable(data['records'])
							alertPopup('Record deleted...', 4000);
							blankControls();
							$("#txtStageItemName").focus();
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
		stageRowId = $("#cboStage").val();
		// alert(stageRowId);
		if(stageRowId == "-1")
		{
			msgBoxError("Error", "Select stage...");
			// alertPopup("Select stage...", 8000);
			$("#cboStage").focus();
			return;
		}
		stageItemName = $("#txtStageItemName").val().trim();
		if(stageItemName == "")
		{
			msgBoxError("Error", "Stage item can not be blank...");
			// alertPopup("Stage item can not be blank...", 8000);
			$("#txtStageItemName").focus();
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
								'stageRowId': stageRowId
								, 'stageItemName': stageItemName
							},
					'success': function(data)
					{
						if(data)
						{
							// alert(data);
							if(data == "Duplicate record...")
							{
								// alertPopup("Duplicate record...", 4000);
								msgBoxError("Error", "Duplicate record...");
								$("#txtStageItemName").focus();
							}
							else
							{
								setTable(data['records']) 
								alertPopup('Record saved...', 4000);
								// blankControls();
								$("#txtStageItemName").val('');
								$("#txtStageItemName").focus();
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
								, 'stageRowId': stageRowId
								, 'stageItemName': stageItemName
							},
					'success': function(data)
					{
						if(data)
						{
							// alert(data);
							if(data == "Duplicate record...")
							{
								// alertPopup("Duplicate record...", 4000);
								msgBoxError("Error", "Duplicate record...");
								$("#txtStageItemName").focus();
							}
							else
							{
								setTable(data['records']) ///loading records in tbl1
								alertPopup('Record updated...', 4000);
								blankControls();
								$("#btnSave").val("Save");
								$("#txtStageItemName").focus();
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


	var tblRowsCount;
	function storeTblValues()
	{
		// var myFilteredRows = myDataTable.$('tr', {"filter":"applied"});
		// alert(JSON.stringify(myFilteredRows));
		// return;
		var searchString = $('.dataTables_filter input').val().toLowerCase();
		// alert(searchString);

	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// alert($(tr).find('td:eq(4)').text().toLowerCase().indexOf(searchString));
	    	if( $(tr).find('td:eq(4)').text().toLowerCase().indexOf(searchString) >= 0 )
	    	{
	        	TableData[i]=
	        	{
		            "stageItemRowId" : $(tr).find('td:eq(2)').text()
		            , "stageName" : $(tr).find('td:eq(4)').text()
		            , "stageItemName" :$(tr).find('td:eq(5)').text()

	        	}   
	        	i++; 
	        }
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

		$.ajax({
				'url': base_url + '/' + controller + '/exportData',
				'type': 'POST',
				// 'dataType': 'json',
				'data': {
							'TableData': TableData
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
<div class="container">
	<div class="row">
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
			<h1 class="text-center" style='margin-top:-20px'>Stage Items</h1>
			<div class="row" style="margin-top:25px;">
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Stage Name:</label>";
						echo form_dropdown('cboStage',$stages, '-1',"class='form-control' autofocus id='cboStage'");
	              	?>
	          	</div>

				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<?php
						// echo $this->session->orgRowId;
						// echo    "    " . $this->session->orgName;
						echo "<label style='color: black; font-weight: normal;'>Stage Item:</label>";
						echo form_input('txtStageItemName', '', "class='form-control' id='txtStageItemName' style='text-transform: capitalize;' maxlength=200 autocomplete='off'");
	              	?>
	          	</div>
			</div>

			<div class="row" style="margin-top:0;">
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
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
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
					 	<th  width="50" class="editRecord text-center">Edit</th>
					 	<th  width="50" class="text-center">Delete</th>
						<th style='width:0px;display:none;'>stageItemRowId</th>
						<th style='width:0px;display:none;'>stageRowId</th>
					 	<th>Stage Name</th>
					 	<th>Stage Item Name</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($records as $row) 
						{
						 	$rowId = $row['stageItemRowId'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='display:none;'>".$row['stageItemRowId']."</td>";
						 	echo "<td style='display:none;'>".$row['stageRowId']."</td>";
						 	echo "<td>".$row['stageName']."</td>";
						 	echo "<td>".$row['stageItemName']."</td>";
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
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-0">
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<input type='button' onclick='exportData();' value='Export Table Data' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
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
		stageItemName = $(this).closest('tr').children('td:eq(5)').text();
		globalrowid = $(this).closest('tr').children('td:eq(2)').text();

		$("#cboStage").val($(this).closest('tr').children('td:eq(3)').text());
		$("#txtStageItemName").val(stageItemName);
		$("#txtStageItemName").focus();
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