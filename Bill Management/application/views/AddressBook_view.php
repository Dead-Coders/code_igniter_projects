<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='AddressBook_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Address Book";

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
	          cell.setAttribute("onclick", "delrowid(" + records[i].rowId +")");
	          // data-toggle="modal" data-target="#myModal"
	          cell.setAttribute("data-toggle", "modal");
	          cell.setAttribute("data-target", "#myModal");

	          var cell = row.insertCell(2);
	          // cell.style.display="none";
	          cell.innerHTML = records[i].rowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].name;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].hNo;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].locality;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].occupation;
	          var cell = row.insertCell(7);
	          cell.innerHTML = records[i].telephone;
	          var cell = row.insertCell(8);
	          cell.innerHTML = records[i].mobile;
	          var cell = row.insertCell(9);
	          cell.innerHTML = records[i].remarks;
	          var cell = row.insertCell(10);
	          cell.innerHTML = records[i].showInDirectorySearch;
	          cell.style.display="none";
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
		name = $("#txtName").val().trim();
		if(name == "")
		{
			msgBoxError("Error", "Name can not be blank...");
			$("#txtName").focus();
			return;
		}

		hNo = $("#txtHNo").val().trim();
		locality = $("#txtLocality").val().trim();
		occupation = $("#txtOccupation").val().trim();
		telephone = $("#txtTelephone").val().trim();
		mobile = $("#txtMobile").val().trim();
		if(mobile.length<10 || mobile.length>10)///mobile no. must be 10 digit
		{
			msgBoxError("Error", "Enter valid mobile no.");
			$("#txtMobile").focus();
			return;
		}
		if(isNaN(mobile)==true)///mobile no. must be numeric
		{
			msgBoxError("Error", "Enter valid mobile no.");
			$("#txtMobile").focus();
			return;
		}
		if(mobile == "")///mobile no. must 
		{
			msgBoxError("Error", "Enter mobile no.");
			$("#txtMobile").focus();
			return;
		}
		remarks = $("#txtRemarks").val().trim();


		// var groupRowId="";
		// $('input:checked').each(function() 
		// {
		// 	groupRowId = $(this).val() + "," + groupRowId;
		// });
		// if(groupRowId == "")
		// {
		// 	alertPopup("Select group...", 8000);
		// 	// $("#cboPrefix").focus();
		// 	return;
		// }

		// var groupRowId = $("#cboGroup").val().trim();
		// if(groupRowId == "-1")
		// {
		// 	alertPopup("Select group...", 5000);
		// 	return;
		// }

		// showInDirectorySearch = $("#cboShowInDirectory").val();
		// if(showInDirectorySearch == "-1")
		// {
		// 	alertPopup("Select whether show in directory search...", 5000);
		// 	return;
		// }


		if($("#btnSave").val() == "Save")
		{
			// alert("save");
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								'name': name
								, 'hNo': hNo
								, 'locality': locality
								, 'occupation': occupation
								, 'telephone': telephone
								, 'mobile': mobile
								, 'remarks': remarks
								// , 'groupRowId': groupRowId 
								// , 'showInDirectorySearch': showInDirectorySearch 								
							},
					'success': function(data)
					{
						if(data)
						{
							// alert(data);
							if(data == "Duplicate record...")
							{
								alertPopup("Duplicate mobile no...",5000);
							}
							else
							{
								setTable(data['records']) ///loading records in tbl1

								alertPopup('Record saved...', 4000);
								// blankControls();
								$("#txtName").focus();
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
								, 'name': name
								, 'hNo': hNo
								, 'locality': locality
								, 'occupation': occupation
								, 'telephone': telephone
								, 'mobile': mobile
								, 'remarks': remarks
								// , 'groupRowId': groupRowId
								// , 'showInDirectorySearch': showInDirectorySearch
								// , 'globalGroupDetailRowId': globalGroupDetailRowId 
							},
					'success': function(data)
					{
						if(data)
						{
							// alert(data);
							if(data == "Duplicate record...")
							{
								alertPopup("Duplicate mobile no...",5000);
							}
							else
							{
								setTable(data['records']) ///loading records in tbl1
								alertPopup('Record updated...', 4000);
								// myAlert("Record updated...");
								blankControls();
								$('input:checked').each(function() {
									$(this).removeAttr('checked');
								});
								$("#btnSave").val("Save");
								$("#txtName").focus();
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
		             "name" : $(tr).find('td:eq(3)').text()
		            , "hNo" :$(tr).find('td:eq(4)').text()
		            , "locality" :$(tr).find('td:eq(5)').text()
		            , "occupation" :$(tr).find('td:eq(6)').text()
		            , "telephone" :$(tr).find('td:eq(7)').text()
		            , "mobile" :$(tr).find('td:eq(8)').text()
		            , "remarks" :$(tr).find('td:eq(9)').text()
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

	function storeTblValuesMobile()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	if( $(tr).find('td:eq(8)').text().length > 0 )
	    	{
	        	TableData[i]=
	        	{
		            "mobile" :$(tr).find('td:eq(8)').text().substr(0, 10)
	        	}   
	        	i++; 
	        }
	    }); 
	    // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i-1;
	    return TableData;
	}
	function exportDataMobile()
	{	
		// alert();
		var TableData;
		TableData = storeTblValuesMobile();
		TableData = JSON.stringify(TableData);
		// alert(JSON.stringify(TableData));
		// return;
		if(tblRowsCount == 0)
		{
			alertPopup("No product selected...", 8000);
			$("#cboProducts").focus();
			return;
		}


		$.ajax({
				'url': base_url + '/' + controller + '/exportDataMobile',
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
<div class="container-fluid" style="width: '90%'">
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Address Book</h3>
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<div class="row" style="margin-top:5px;">
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>Name: <span style='color: red;'>*</span></label>";
							echo form_input('txtName', '', "class='form-control' autofocus id='txtName' style='' maxlength=40 autocomplete='off'");
		              	?>
		          	</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>H.No.:</label>";
							echo form_input('txtHNo', '', "class='form-control' id='txtHNo' style='' maxlength=20 autocomplete='off'");
		              	?>
					</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>Locality:</label>";
							echo form_input('txtLocality', '', "class='form-control' id='txtLocality' style='' maxlength=40 autocomplete='off'");
		              	?>
		          	</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>Occupation:</label>";
							echo form_input('txtOccupation', '', "class='form-control' id='txtOccupation' style='' maxlength=30 autocomplete='off'");
		              	?>
					</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>Telephone:</label>";
							echo form_input('txtTelephone', '', "class='form-control' id='txtTelephone' style='' maxlength=25 autocomplete='off'");
		              	?>
		          	</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>Mobile: <span style='color: red;'>*</span></label>";
							echo form_input('txtMobile', '', "class='form-control' id='txtMobile' style='' maxlength=10 autocomplete='off'");
		              	?>
					</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
							echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' maxlength=250 style='' autocomplete='off'");
		              	?>
					</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='saveData();' value='Save' id='btnSave' class='btn btn-primary form-control'>";
			          	?>
			      	</div>
				</div>				
			</div>
		</div>
	</div>



	<div class="row" style="margin-top:20px;" >
		<!-- <div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div> -->

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
					 	<th  width="50" class="editRecord text-center">Edit</th>
					 	<th  width="50" class="text-center">Delete</th>
						<th style='display:none1;'>rowid</th>
					 	<th>Name</th>
					 	<th>H.No.</th>
					 	<th>Locality</th>
					 	<th>Occupation</th>
					 	<th>Telephone</th>
					 	<th>Mobile</th>
					 	<th>Remarks</th>
					 	<th style='display:none;'>ShowInDirectorySearch</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($records as $row) 
						{
						 	$rowId = $row['rowId'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='width:0px;display:none1;'>".$row['rowId']."</td>";
						 	echo "<td>".$row['name']."</td>";
						 	echo "<td>".$row['hNo']."</td>";
						 	echo "<td>".$row['locality']."</td>";
						 	echo "<td>".$row['occupation']."</td>";
						 	echo "<td>".$row['telephone']."</td>";
						 	echo "<td>".$row['mobile']."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	echo "<td style='display:none;'>".$row['showInDirectorySearch']."</td>";
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
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<input type='button' onclick='exportData();' value='Export All Records' id='btnExportAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<input type='button' onclick='exportDataMobile();' value='Export only Mobile No.' id='btnExportAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
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
		name = $(this).closest('tr').children('td:eq(3)').text();
		hNo = $(this).closest('tr').children('td:eq(4)').text();
		locality = $(this).closest('tr').children('td:eq(5)').text();
		occupation = $(this).closest('tr').children('td:eq(6)').text();
		telephone = $(this).closest('tr').children('td:eq(7)').text();
		mobile = $(this).closest('tr').children('td:eq(8)').text();
		showInDirectorySearch = $(this).closest('tr').children('td:eq(10)').text();
		remarks = $(this).closest('tr').children('td:eq(9)').text();
		globalrowid = $(this).closest('tr').children('td:eq(2)').text();
		// alert(rowIndex + "   " + colIndex);
		$("#txtName").val(name);
		$("#txtHNo").val(hNo);
		$("#txtLocality").val(locality);
		$("#txtOccupation").val(occupation);
		$("#txtTelephone").val(telephone);
		$("#txtMobile").val(mobile);
		// $("#cboGroup").val(groupRowId);
		$("#txtRemarks").val(remarks);
		// $("#cboShowInDirectory").val(showInDirectorySearch);


		// /////Setting Groups
		// $('input:checked').each(function() {
		// 	$(this).removeAttr('checked');
		// });
		// $.ajax({
		// 	'url': base_url + '/Records_Controller/getDataForCheckox',
		// 	'type': 'POST', 
		// 	'data':{'rowid':globalrowid},
		// 	'dataType': 'json',
		// 	'success':function(data)
		// 	{
		// 		// alert( JSON.stringify(data) );
		// 		var arr = data['groups'].split(",");
		// 		$('.mycon').each(function() {
		// 			for(var i=0; i<arr.length-1; i++)
		// 			{
		// 				if(arr[i].trim() == $(this).val())
		// 				{
		// 					$(this).prop('checked','checked');
		// 				}
		// 			}	
		// 		});
		// 	}
		// });
		/////END - Groups
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