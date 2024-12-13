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
</style>

<script type="text/javascript">
	var controller='Requirement_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Requirements";

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
	          cell.style.display="none";

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
	          cell.style.display="none";
	          cell.innerHTML = records[i].rowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].itemRowId;
	          cell.style.display="none";
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].itemName + "<span style='color:green;'> [" + records[i].remarks + "]</span>" + "<span style='color:blue;'> [" + records[i].qty + "]</span>";
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].lastPurchasePrice;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].lastPurchaseFrom;
	          var cell = row.insertCell(7);
	          if( records[i].lastPurchaseDate == null )
	          {
	          	cell.innerHTML = "";
	          }
	          else
	          {
	          	cell.innerHTML = dateFormat(new Date(records[i].lastPurchaseDate));
	          }
	          var cell = row.insertCell(8);
	          cell.innerHTML = "<input type='checkbox' class='chk' name='chk' style='width:14px;height:14px;'/>";
	  	  }


	  	// $('.editRecord').bind('click', editThis);

		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

		});
		} );

		// $("#divTable").scrollTop($("#divTable").prop("scrollHeight"));
		$("#tbl1 tr").off();
		$("#tbl1 tr").on("dblclick", setGlobalItemRowId);
		$("#tbl1 tr").on("click, dblclick", highlightRowAlag);
	}
	var globalItemRowIdForPurchaseLog;
	function setGlobalItemRowId()
	{
		globalItemRowIdForPurchaseLog = 0;
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		globalItemRowIdForPurchaseLog = $(this).closest('tr').children('td:eq(3)').text();
		itemNameForHeading = $(this).closest('tr').children('td:eq(4)').text();
		$("#tblPurchaseLog").find("tr:gt(0)").remove(); //// empty first
		$("#h4PurchaseLog").html("Purchase Log - <span style='color:blue;'>" + itemNameForHeading + "</span>");
		if( globalItemRowIdForPurchaseLog == "-1" )
		{
			return;
		}
		// // alert(globalSaleRowId);
		// // return;
		$.ajax({
			'url': base_url + '/' + controller + '/getPurchaseLog',
			'type': 'POST', 
			'data':{'itemRowId':globalItemRowIdForPurchaseLog},
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
						// $("#txtItemName").focus();
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
		itemName = $("#txtItemName").val().trim();
		// alert(itemName);
		if(itemName == "")
		{
			alertPopup("Item Namecan not be blank...", 8000, 'red');
			$("#txtItemName").focus();
			return;
		}
		remarks = $("#txtRemarks").val().trim();
		qty = $("#txtQty").val().trim();

		itemRowId = $("#lblItemId").text();
		if(itemRowId == "")
		{
			alertPopup("RowId is null...", 8000, 'red');
			$("#txtItemName").focus();
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
								'itemName': itemName
								, 'itemRowId': itemRowId
								, 'remarks': remarks
								, 'qty': qty
							},
					'success': function(data)
					{
						if(data)
						{
							// alert();
							setTable(data['records']) ///loading records in tbl1

							alertPopup('Record saved...', 4000);
							$("#lblItemId").text("-1")
							blankControls();
							$("#txtItemName").focus();
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


</script>
<div class="container-fluid" style="width: 95%;">
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<label style='color: lightgrey; font-weight: normal;' id='lblItemId'></label>
			<h3 class="text-center" style='margin-top:-20px'>Requirement</h3>
			<h5 class="text-center" style='margin-top:0;color:red;'>(Double click on item row to get Purchase Log)</h5>
			<div class="row" style="margin-top:25px;">
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
					<?php
						// echo "<label style='color: black; font-weight: normal;'>Item Name:</label>";
						echo form_input('txtItemName', '', "class='form-control' id='txtItemName' style='text-transform: capitalize;' maxlength=99 autocomplete='off' autoFocus placeholder='Item Name'");
	              	?>
	          	</div>
	          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<?php
						// echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
						echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' style='' maxlength=99 autocomplete='off' placeholder='Remarks'");
	              	?>
	          	</div>
	          	<div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
					<?php
						// echo "<label style='color: black; font-weight: normal;'>Item Qty:</label>";
						// echo "<label style='color: lightgrey; font-weight: normal;' id='lblItemId'></label>";
						echo form_input('txtQty', '', "class='form-control' id='txtQty' style='' maxlength=8 autocomplete='off' placeholder='Qty.'");
	              	?>
	          	</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<?php
						// echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
						echo "<input type='button' onclick='saveData();' value='Save' id='btnSave' class='btn btn-success form-control'>";
	              	?>
	          	</div>
			</div>
		</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:400px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
					 	<th style="display: none;" width="50" class="editRecord text-center">Edit</th>
					 	<th  width="50" class="text-center">Delete</th>
						<th style='width:0px;display:none;'>rowid</th>
					 	<th style="display: none;">ItemRowId</th>
					 	<th>Item</th>
					 	<th>Last Rate (Per Pc.)</th>
					 	<th>From</th>
					 	<th>Dt.</th>
					 	<th>Check</th>
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
						 	$rowId = $row['rowId'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand;display:none;" class="editRecord text-center" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
								   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rowId.');" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='width:0px;display:none;'>".$row['rowId']."</td>";
						 	echo "<td style='display: none;'>".$row['itemRowId']."</td>";
						 	echo "<td>".$row['itemName']."<span style='color:green;'> [" . $row['remarks']."]</span><span style='color:blue;'> [" . $row['qty']."]</span></td>";
						 	echo "<td>".$row['lastPurchasePrice']."</td>";
						 	echo "<td>".$row['lastPurchaseFrom']."</td>";
						 	if($row['lastPurchaseDate'] == null)
						 	{
						 		echo "<td></td>";
						 	}
						 	else
						 	{
							 	$vdt = strtotime($row['lastPurchaseDate']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
							 }
							 echo "<td style='text-align:center;'><input type='checkbox' class='chk' name='chk' style='width:14px;height:14px;'/></td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>

		<div class="" style="border:1px solid lightgray; padding: 10px;height:400px; overflow:auto;">
          <table id='tblPurchaseLog' class="table table-bordered table-striped table-hover">
          	<caption>Purchase Log</caption>
          		<th style='display:none;'>Rowid</th>
			 	<th>Date</th>
			 	<th>Supplier Name</th>
			 	<th>Item</th>
			 	<th>Qty</th>
			 	<th>Rate</th>
			 	<th style='display:none;'>Amt</th>
			 	<th style='display:none;'>D%</th>
			 	<th style='display:none;'>DAmt</th>
			 	<th style='display:none;'>CGST%</th>
			 	<th style='display:none;'>SGST%</th>
			 	<th>Net</th>
			 	<th>PP</th>
			 	<th style='display:none;'>Fr</th>
          </table>
        </div>


	</div>

	<div class="row" style="margin-top:15px;margin-bottom: 10px;">
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<input type='button' onclick='exportData();' value='Export as PDF' id='btnExport' class='btn btn-danger form-control'>";
          	?>
      	</div>
      	<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
      	</div>
      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<input type='button' onclick='deleteChecked();' value='Delete Checked' id='btnExport' class='btn btn-danger form-control'>";
          	?>
      	</div>
	</div>
		
		
</div>




<script type="text/javascript">
	var globalrowid;
	function delrowid(rowid)
	{
		globalrowid = rowid;
		deleteRecord(globalrowid);
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


$(document).ready( function () 
	{
		select = false;
		var jSonArray = '<?php echo json_encode($itemList); ?>';
		var jSonArray = jSonArray.replace(/(\r\n|\n|\r)/gm,", "); ///Multilinse of Address field with comma replce
				var availableTags = $.map(JSON.parse(jSonArray), function(obj){
							return{
									label: obj.itemName,
									itemRowId: obj.itemRowId
							}
					});

				    $(function() {
			        $( "#txtItemName" ).autocomplete({
			            source: function(request, response) {
			                
			                var aryResponse = [];
			                var arySplitRequest = request.term.split(" ");
			                // alert(JSON.stringify(arySplitRequest));
			                for( i = 0; i < availableTags.length; i++ ) {
			                    var intCount = 0;
			                    for( j = 0; j < arySplitRequest.length; j++ ) {
			                        regexp = new RegExp(arySplitRequest[j], 'i');
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
			    		$("#lblItemId").text( ui.item.itemRowId );
			        	}

			        }).blur(function() {
						  if( !select ) 
						  {
						  	$("#lblItemId").text('-1');
						  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
						  }
						  	if( $("#lblItemId").text() == '-1' )
						  	{
						  	}
						  	else
						  	{
						  	}
						}).focus(function(){            
					            $(this).autocomplete("search");
					        });
			    });
    } );


	function storeTblValuesItems()
		{
		    var TableData = new Array();
		    var i=0;
		    $('#tbl1 tr').each(function(row, tr)
		    {
	        	TableData[i]=
	        	{
		            "rowId" : $(tr).find('td:eq(2)').text()
		            , "itemName" : $(tr).find('td:eq(4)').text()
		            , "lastRate" :$(tr).find('td:eq(5)').text()
		            , "purchasedFrom" :$(tr).find('td:eq(6)').text()
		            , "purchaseDate" :$(tr).find('td:eq(7)').text()
	        	}   
	        	i++; 
		    }); 
		    TableData.shift();  // first row will be heading - so remove
		    tblRowsCount = i;
		    return TableData;
		}	
	function exportData()
	{
		var TableDataItems;
		TableDataItems = storeTblValuesItems();
		TableDataItems = JSON.stringify(TableDataItems);
		// alert(JSON.stringify(TableDataItems));
		// return;
		// alert(tblRowsCount);
		if(tblRowsCount == 0)
		{
			alertPopup("Zero items to export", 5000, 'red');
			// $("#txtDate").focus();
			return;
		}
		var tblRowsCount=0;
		$.ajax({
				'url': base_url + '/' + controller + '/exportData',
				'type': 'POST',
				// 'dataType': 'json',
				'data': {
							'TableDataItems': TableDataItems
						},
				'success': function(data)
				{
					// blankControls();	
					// $("#txtDate").val(dateFormat(new Date()));
					// alertPopup("Record saved...", 8000);
					window.location.href=data;
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
	}

	$(document).ready(function() {
		// alert();
		$("#tbl1 tr").off();
		$("#tbl1 tr").on("dblclick", setGlobalItemRowId);
		$("#tbl1 tr").on("click, dblclick", highlightRowAlag);

	});

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
          cell.innerHTML = records[i].itemName;
          // cell.style.display="none";
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].qty;
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].rate;
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].amt;
          cell.style.display="none";
          var cell = row.insertCell(7);
          cell.innerHTML = records[i].discountPer;
          cell.style.display="none";
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].discountAmt;
          cell.style.display="none";
          var cell = row.insertCell(9);
          cell.innerHTML = records[i].cgst;
          cell.style.display="none";
          var cell = row.insertCell(10);
          cell.innerHTML = records[i].sgst;
          cell.style.display="none";
          var cell = row.insertCell(11);
          cell.innerHTML = records[i].netAmt;

          var cell = row.insertCell(12);
          var pp = records[i].netAmt / records[i].qty;
          cell.innerHTML = pp.toFixed(2);
          cell.style.color = 'red';
          var cell = row.insertCell(13);
          cell.innerHTML = records[i].freight;
          cell.style.display="none";
        }
	}
</script>


<!-- delete checked -->
<script type="text/javascript">
	var checkedRows=0;
	function storeTblValuesChecked()
	{
	    var TableData = new Array();
	    var i=0, j=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	if(j>=0)
	    	{
	    		if($(tr).find('td:eq(8)').find('input[type=checkbox]').is(':checked'))
	    		{
		        	TableData[i]=
		        	{
			            "rowId" : $(tr).find('td:eq(2)').text()
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
	
	function deleteChecked()
	{
		var TableData;
		TableData = storeTblValuesChecked();
		TableData = JSON.stringify(TableData);
		// alert(JSON.stringify(TableData));
		// return;

		$.ajax({
			'url': base_url + '/' + controller + '/deleteChecked',
			'type': 'POST',
			'dataType': 'json',
			'data': {
						'TableData': TableData
					},
			'success': function(data)
			{
				alertPopup('Done...', 4000);
				setTable(data['records'])
				$(".chk").prop("checked", false);
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});	
	}
</script>