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
	/*#txtDueDate {position: relative; z-index:101;}*/
</style>
<script type="text/javascript">
	var controller='CashSale_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Cash Sale";


	var tblRowsCount=0;
	function storeTblValuesItems()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// alert($(tr).find('td:eq(3)').text().length);
	    	if( $(tr).find('td:eq(2)').text().length > 0 )
	    	{
	    		chk = $(tr).find('td:eq(7)').children().prop("checked");
	    		if( chk == false) ////Collection
	    		{
		        	TableData[i]=
		        	{
			            "itemRowId" : $(tr).find('td:eq(1)').text()
			            , "itemName" : $(tr).find('td:eq(2)').text()
			            , "qty" :$(tr).find('td:eq(3)').text()
			            , "rate" :$(tr).find('td:eq(4)').text()
			            , "amt" :$(tr).find('td:eq(5)').text()
			            , "remarks" :$(tr).find('td:eq(6)').text()
			            , "mode" :'C'
			            , "cashSaleRowId" :$(tr).find('td:eq(10)').text()
		        	} 
	        	} 
	        	else
	        	{
		        	TableData[i]=
		        	{
			            "itemRowId" : $(tr).find('td:eq(1)').text()
			            , "itemName" : $(tr).find('td:eq(2)').text()
			            , "qty" :$(tr).find('td:eq(3)').text()
			            , "rate" :$(tr).find('td:eq(4)').text()
			            , "amt" :$(tr).find('td:eq(5)').text()
			            , "remarks" :$(tr).find('td:eq(6)').text()
			            , "mode" :'E'
			            , "cashSaleRowId" :$(tr).find('td:eq(10)').text()
		        	} 
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
		// alert(tblRowsCount);
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
			// alertPopup("Invalid date...", 5000, 'red');
			// $("#txtDate").focus();
			return;
		}

		totalAmt = parseFloat($("#txtTotalAmt").val());
		// remarks = $("#txtRemarks").val().trim();

		if($("#btnSave").text() == "Save Now")
		{
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								'dt': dt
								, 'totalAmt': totalAmt
								, 'TableDataItems': TableDataItems
							},
					'success': function(data)
					{
						// alert(JSON.stringify(data));
						setTableForThisDate(data['records']);
						$("#btnSave").removeClass("btn-danger");
						$("#btnSave").addClass("btn-primary");
						alertPopup("Record saved...", 8000);
					},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
		}

	}

	// function loadAllRecords()
	// {
	// 	// alert(rowId);
	// 	$.ajax({
	// 			'url': base_url + '/' + controller + '/loadAllRecords',
	// 			'type': 'POST',
	// 			'dataType': 'json',
	// 			'success': function(data)
	// 			{
	// 				if(data)
	// 				{
	// 					setTablePuraneDb(data['records'])
	// 					alertPopup('Records loaded...', 4000);
	// 					// blankControls();
	// 					// $("#txtBookName").focus();
	// 				}
	// 			}
	// 		});
	// }
</script>
<div class="container-fluid" style="width: 90%">
	<div class="row" style='margin-top:-17px;'>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off'");
          	?>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<h4 class="text-center">Cash Sale</h4>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		</div>
	</div>


    <div class="row" style="margin-top: 10px;">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 sticky-table sticky-headers sticky-ltr-cells" id="divTable" style="overflow:auto; height:490px;">
			<table style="table-layout: fixed; border: 1px solid lightgrey;" id='tbl1' class="table table-bordered">
	           <thead>
	           <tr class="sticky-row" style="">
	            <th class="sticky-cell1" width="50">S.N.</th>
	            <th width="50" style='display:none1;'>Item Row Id</th>
	            <th width="300">Item</th>
	            <th width="100">Qty</th>
	            <th width="100">Rate</th>
	            <th width="100">Amt</th>
	            <th width="200">Remarks</th>
	            <th width="50">Exp.</th>
	            <th width="100">&nbsp;</th>
	            <th width="100" style='display:none;'>&nbsp;</th>
	            <th width="100">RowId</th>
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
				echo "<label style='color: black; font-weight: normal;'>Exp. Amt.:</label>";
				echo '<input type="number"  step="1" name="txtTotalExp" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalExp" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Difference:</label>";
				echo '<input type="number"  step="1" name="txtDifference" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtDifference" />';
          	?>
      	</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
				// echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
          	?>
          	<button id="btnSave" class="btn btn-primary btn-block" onclick="saveData();">Save Now</button>
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
</div> <!-- CONTAINER CLOSE -->



<script type="text/javascript">
	$( "#txtDate" ).datepicker({
		dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
	});
    // Set the Current Date as Default
	$("#txtDate").val(dateFormat(new Date()));
	

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
		          // cell.style.backgroundColor="#F0F0F0";
		          // cell.className = " sticky-cell";
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
		          cell.className = "clsAmt";

		          var cell = row.insertCell(6);
		          cell.innerHTML = "";
		          cell.contentEditable="true";
		          cell.className = "clsRemarks";

		          var cell = row.insertCell(7);
		          cell.innerHTML = "<input type='checkbox' class='clsChk' />";
		          cell.style.textAlign = "center";
		          // cell.contentEditable="true";
		          // cell.className = "clsRemarks";


		          var cell = row.insertCell(8);
		          cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";
		          cell.style.textAlign = "center";

		          var cell = row.insertCell(9);
		          cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
		          cell.style.textAlign = "center";
		          cell.style.display = "none";
		          if(sn == 2) ///remove row not required in first row
			      {
			      	cell.innerHTML = "";
			      }
			      var cell = row.insertCell(10);
		          cell.innerHTML = "";
		          cell.className = "clsCashSaleRowId";

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

			      $(".clsQty, .clsRate").off();
			      $('.clsQty, .clsRate').on('keyup', doRowTotal);

			      $('.row-remove').on('click', removeRow);

			      $("#tbl1").scrollLeft(0);
			      $("#tbl1").scrollTop($("#tbl1").prop("scrollHeight"));
			      $("#tbl1").find("tr:last").find('td').eq(2).focus();

			      $(".clsChk").off();
			      $(".clsChk").on("click", ColourChangeOnExp);
			      // $( ".clsItem" ).unbind();
			      bindItem();
			      $("#tbl1 tr td").on("keyup", saveChangesColour);
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
				$("#btnSave").removeClass("btn-primary");
				$("#btnSave").addClass("btn-danger");
				// calcBalNow();
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
				var expTotal=0;
				$("#tbl1").find("tr:gt(0)").each(function(i){
					if( isNaN(parseFloat( $(this).find("td:eq(5)").text() )) == false )
					{
						if( $(this).find("td:eq(7)").children().prop("checked") == false )
						{
							amtTotal += parseFloat( $(this).find("td:eq(5)").text() );
						}
						else
						{
							expTotal += parseFloat( $(this).find("td:eq(5)").text() );
						}
					}
				});
				$("#txtTotalAmt").val(amtTotal.toFixed(2));
				$("#txtTotalExp").val(expTotal.toFixed(2));
				$("#txtDifference").val( $("#txtTotalAmt").val() - $("#txtTotalExp").val() );
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


				doAmtTotal();
				// calcBalNow();
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
									itemLastRate: obj.rate
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
					    var rowIndex = $(this).parent().index();
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").text( itemRowId );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text( itemLastRate );
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


	


  </script>


  <script type="text/javascript">


	globalPreviousDate="";
	$('#txtDate').bind('change', loadDataOfThisDate);
	function loadDataOfThisDate()
	{
		dangerClass = $("#btnSave").hasClass( "btn-danger" );
		// alert(dangerClass);
		if(dangerClass == true)
		{
			msgBoxError("Error", "Changes for this date not saved...");
			$("#txtDate").val( globalPreviousDate );
			return;
		}
		// return;
		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			msgBoxError("Error", "Invalid date...");
			// alertPopup("Invalid date...", 5000, 'red');
			// $("#txtDate").focus();
			return;
		}
		globalPreviousDate = dt;
      	$.ajax({
			'url': base_url + '/' + controller + '/loadDataOfThisDate',
			'type': 'POST', 
			'data':{ 'dt':dt
					},
			'dataType': 'json',
			'success':function(data)
			{
				setTableForThisDate(data['records']);
			},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});		
	}
	
	function setTableForThisDate(records)
	{
			// alert(JSON.stringify(data['customerInfo']));
			$("#tbl1").find("tr:gt(0)").remove(); //// empty first
	        var table = document.getElementById("tbl1");
	        var totPartyDue = 0;
	        for(i=0; i<records.length; i++)
	        {
	          var newRowIndex = table.rows.length;
	          var row = table.insertRow(newRowIndex);

	          var cell = row.insertCell(0);
	          cell.innerHTML = ""; 			///SN
	          // cell.style.display="none";
	          
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].itemRowId;
	          cell.contentEditable="true";
			  // cell.className = "clsItemType";
	          // cell.style.display="none";

	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].itemName;
	          // cell.style.display="none";

	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].qty;
	          cell.contentEditable="true";
			  cell.className = "clsQty";
	          // cell.style.display="none";

	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].rate;
	          cell.contentEditable="true";
			  cell.className = "clsRate";

	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].amt;
	          cell.contentEditable="true";

	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].remarks;
	          cell.contentEditable="true";

	          var cell = row.insertCell(7);
	          cell.style.textAlign = "center";

	          if( records[i].mode == "C" )
	          {
	          	cell.innerHTML = "<input type='checkbox' class='clsChk' />";
	          	// row.style.color = "green";
	          }
	          else
	          {
	          	cell.innerHTML = "<input type='checkbox' class='clsChk' checked />";
	          	row.style.color = "#35C220";
	          }
	          var cell = row.insertCell(8);
			  cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";
			  cell.style.textAlign = "center";

			  var cell = row.insertCell(9);
			  cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
			  cell.style.textAlign = "center";
			  cell.style.display="none";
			    
			    if(i == 0) ///remove row not required in first row
				{
					cell.innerHTML = "";
				}

			  var cell = row.insertCell(10);
	          cell.innerHTML = records[i].cashSaleRowId;
	          // cell.contentEditable="true";

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

		      $(".clsQty, .clsRate").off();
		      $('.clsQty, .clsRate').on('keyup', doRowTotal);

			$('.row-remove').on('click', removeRow);

			$(".clsChk").off();
			$(".clsChk").on("click", ColourChangeOnExp);

			// $( ".clsItem" ).unbind();
			bindItem();
			$("#tbl1 tr td").on("keyup", saveChangesColour);
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
		  	addRow();
		  	$("#btnSave").removeClass("btn-danger");
			$("#btnSave").addClass("btn-primary");
			doAmtTotal();
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

			$("#txtDate").trigger("change");
		} );

		$("#tbl1 tr td").on("keyup", saveChangesColour);
		function saveChangesColour()
		{
			$("#btnSave").removeClass("btn-primary");
			$("#btnSave").addClass("btn-danger");
			// alert();
		}

		$(".clsChk").on("click", ColourChangeOnExp);
		function ColourChangeOnExp()
		{
			chk = $(this).prop("checked");
			if ( chk == true )
			{
				$(this).parent().parent().css({"color":"#35C220"});
			}
			else
			{
				$(this).parent().parent().css({"color":"black"});
			}
			$("#btnSave").removeClass("btn-primary");
			$("#btnSave").addClass("btn-danger");
			doAmtTotal();
		}

  </script>