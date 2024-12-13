<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/jquery.stickytable.min.js"></script>
<link rel='stylesheet' href='<?php  echo base_url();  ?>bootstrap/css/jquery.stickytable.min.css'>
<link rel='stylesheet' href='<?php  echo base_url();  ?>bootstrap/css/suriprint.css'>

<style type="text/css">
	.ui-autocomplete {
	    max-height: 200px;
	    overflow-y: auto;   /* prevent horizontal scrollbar */
	    overflow-x: hidden; /* add padding to account for vertical scrollbar */
	    z-index:1000 !important;
	}

	#txtDate {position: relative; z-index:101;}
	#txtDueDate {position: relative; z-index:101;}
</style>
<script type="text/javascript">
	var controller='Sale_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Sale";


	var tblRowsCount=0;
	function storeTblValuesItems()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// alert($(tr).find('td:eq(3)').text().length);
	    	if( $(tr).find('td:eq(3)').text().length > 0 )
	    	{
	    		str = $(tr).find("td:eq(18)").text();
	    		// alert(str);
				// pp= str.substring(str.indexOf("K")+1, str.length)
				if( str.substring(str.indexOf("K")+1, str.length) == "0" || str == "") /// agar pp nahi h ya zero h.
				{
					pp = parseFloat( $(tr).find("td:eq(5)").text() );
				}
				else
				{
					pp = str.substring(str.indexOf("K")+1, str.length);
				}
				// alert(pp);
				// return;
	        	TableData[i]=
	        	{
		            "itemRowId" : $(tr).find('td:eq(1)').text()
		            , "itemName" : $(tr).find('td:eq(2)').text()
		            , "qty" :$(tr).find('td:eq(3)').text()
		            , "rate" :$(tr).find('td:eq(4)').text()
		            , "amt" :$(tr).find('td:eq(5)').text()
		            , "discountPer" :$(tr).find('td:eq(6)').text()
		            , "discountAmt" :$(tr).find('td:eq(7)').text()
		            , "pretaxAmt" :$(tr).find('td:eq(8)').text()
		            , "igst" :$(tr).find('td:eq(9)').text()
		            , "igstAmt" :$(tr).find('td:eq(10)').text()
		            , "cgst" :$(tr).find('td:eq(11)').text()
		            , "cgstAmt" :$(tr).find('td:eq(12)').text()
		            , "sgst" :$(tr).find('td:eq(13)').text()
		            , "sgstAmt" :$(tr).find('td:eq(14)').text()
		            , "netAmt" :$(tr).find('td:eq(15)').text()
		            , "itemRemarks" :$(tr).find('td:eq(16)').text()
		            , "pp" :pp
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
			alertPopup("Zero items to save", 5000, 'red');
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
			msgBoxError("Error","Special character found in ITEM NAME...");
			return;
		}
		///// END - Checking special chars in itemName like '"\'
		
		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			msgBoxError("Error","Invalid date...");
			// $("#txtDate").focus();
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
		mobile1 = $("#txtMobile").val().trim();
		if(mobile1 == "" )
		{
			msgBoxError("Error", "Mobile no. can not be blank...");
			return;
		}
		address = $("#txtAddress").val().trim();
		customerRemarks = $("#txtCustomerRemarks").val().trim();
		totalAmt = parseFloat($("#txtTotalAmt").val());
		totalDiscount = parseFloat($("#txtTotalDiscount").val());
		totalPretaxAmt = parseFloat($("#txtPretaxAmt").val());
		totalIgst = parseFloat($("#txtTotalIgst").val());
		totalCgst = parseFloat($("#txtTotalCgst").val());
		totalSgst = parseFloat($("#txtTotalSgst").val());
		netAmt = parseFloat($("#txtNetAmt").val());
		advancePaid = parseFloat($("#txtAmtPaid").val());
		balance = parseFloat($("#txtBalance").val());
		dueDate = $("#txtDueDate").val().trim();
		if( dueDate != "" || balance>0)
		{
			dtOk = testDate("txtDueDate");
			if(dtOk == false)
			{
				msgBoxError("Error","Invalid due date...");
				// $("#txtDueDate").focus();
				return;
			}
		}
		remarks = $("#txtRemarks").val().trim();
		inWords = $("#txtWords").val().trim();

		str = $("#txtHappy").val();
		// alert(str);
		// pp= str.substring(str.indexOf("K")+1, str.length)
		if( str.substring(str.indexOf("P")+1, str.length) == "0" || str == "") /// agar pp nahi h ya zero h.
		{
			np = 0;
		}
		else
		{
			np = str.substring(str.indexOf("P")+1, str.length);
		}

		if($("#btnSave").text() == "Save Sale Invoice")
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
								, 'totalDiscount': totalDiscount
								, 'totalPretaxAmt': totalPretaxAmt
								, 'totalIgst': totalIgst
								, 'totalCgst': totalCgst
								, 'totalSgst': totalSgst
								, 'netAmt': netAmt
								, 'advancePaid': advancePaid
								, 'balance': balance
								, 'dueDate': dueDate
								, 'remarks': remarks
								, 'inWords': inWords
								, 'TableDataItems': TableDataItems
								, 'np': np
							},
					'success': function(data)
					{
						blankControls();	
						setTablePuraneDb(data['records'])
						$("#txtDate").val(dateFormat(new Date()));
						alertPopup("Record saved...", 8000);
						// window.location.href=data;
						$("#tbl1").find("tr:gt(0)").remove();
						addRow();
						$("#divPrint").html(data['html']);
						setTimeout(function() {
	                        window.print();
	                    }, 750);

					},
					'error': function(jqXHR, exception)
			          {
			            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
			            $("#modalAjaxErrorMsg").modal('toggle');
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
								, 'totalDiscount': totalDiscount
								, 'totalPretaxAmt': totalPretaxAmt
								, 'totalIgst': totalIgst
								, 'totalCgst': totalCgst
								, 'totalSgst': totalSgst
								, 'netAmt': netAmt
								, 'advancePaid': advancePaid
								, 'balance': balance
								, 'dueDate': dueDate
								, 'remarks': remarks
								, 'inWords': inWords
								, 'TableDataItems': TableDataItems							
								, 'np': np
							},
					'success': function(data)
					{
						blankControls()
						setTablePuraneDb(data['records'])
						$("#txtDate").val(dateFormat(new Date()));;
						// alertPopup("Record updated...", 8000);
						$("#btnSave").text("Save Sale Invoice");
						$("#tbl1").find("tr:gt(0)").remove();
						addRow();
						$("#txtCustomerName").prop("disabled", false);
						$("#txtAmtPaid").prop("disabled", false);

						// window.location.href=data;
						// window.open(data, "_blank");
						$("#divPrint").html(data['html']);
						setTimeout(function() {
	                        window.print();
	                    }, 750);

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

	function searchRecords()
	{
		// alert(rowId);
		searchWhat = $("#txtSearch").val().trim();
		if(searchWhat == "" )
		{
			msgBoxError("Error", "Blank search...");
			return;
		}
		$.ajax({
				'url': base_url + '/' + controller + '/searchRecords',
				'type': 'POST',
				'dataType': 'json',
				'data': {
								'searchWhat': searchWhat
								
							},
				'success': function(data)
				{
					if(data)
					{
						setTablePuraneDb(data['records'])
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

	function setQuotationTable(records)
	{
		$("#tblQuotations").find("tr:gt(0)").remove(); //// empty first
        var table = document.getElementById("tblQuotations");

        // alert(JSON.stringify(data));
        for(i=0; i<records.length; i++)
		{
	        newRowIndex = table.rows.length;
				row = table.insertRow(newRowIndex);

          var cell = row.insertCell(0);
          // cell.style.display="none";
          cell.innerHTML = records[i].quotationRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = dateFormat(new Date(records[i].quotationDt));
          var cell = row.insertCell(2);
          cell.innerHTML = records[i].customerRowId;
          cell.style.display="none";
          var cell = row.insertCell(3);
          cell.innerHTML = records[i].customerName;
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].totalAmount;
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].remarks;
        }

        $("#tblQuotations tr").on("click", highlightRow);
        $("#tblQuotations tr").on("click", setGlobalQuotationRowId);		  			
	}

	function loadFromQuotation()
	{
		$.ajax({
			'url': base_url + '/Sale_Controller/getQuotations',
			'type': 'POST', 
			'data':{'rowid':'globalrowid'},
			'dataType': 'json',
			'success':function(data)
			{
				// alert(JSON.stringify(data));
				setQuotationTable(data['records']);

			},
					'error': function(jqXHR, exception)
			          {
			            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
			            $("#modalAjaxErrorMsg").modal('toggle');
			          }
		});
	}

	function loadAllQuotations()
	{
	$.ajax({
		'url': base_url + '/Sale_Controller/getAllQuotations',
		'type': 'POST', 
		'data':{'rowid':'globalrowid'},
		'dataType': 'json',
		'success':function(data)
		{
			setQuotationTable(data['records']);

		},
		'error': function(jqXHR, exception)
          {
            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
            $("#modalAjaxErrorMsg").modal('toggle');
          }
	});
	}

	globalQuotationRowId = 0;
	function setGlobalQuotationRowId()
	{
		rowIndex = $(this).parent().index();
		colIndex = $(this).index();
		globalQuotationRowId = $(this).closest('tr').children('td:eq(0)').text();
		// alert(globalQuotationRowId);
	}

	function loadQuotationProducts()
	{
		// alert();
		$.ajax({
			'url': base_url + '/Sale_Controller/getQuotationProducts',
			'type': 'POST', 
			'data':{'quotationRowId': globalQuotationRowId},
			'dataType': 'json',
			'success':function(data)
			{
				// alert(JSON.stringify(data));
				setQuotationProducts(data['records']);
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});
	}

	function setQuotationProducts(records)
	{
		$("#tbl1").find("tr:gt(0)").remove(); //// empty first
	    var table = document.getElementById("tbl1");

	    // alert(JSON.stringify(data));
	    for(i=0; i<records.length; i++)
		{
			var newRowIndex = table.rows.length;
	          var row = table.insertRow(newRowIndex);

	          var cell = row.insertCell(0);
	          cell.innerHTML = ""; 			///SN
	          // cell.style.display="none";
	          
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].itemRowId;
	          // cell.contentEditable="true";
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
	          // cell.contentEditable="true";

	          var cell = row.insertCell(6);
	          cell.innerHTML = 0;
	          // cell.contentEditable="true";
	          cell.className = "clsDiscountPer";
	          cell.style.display="none";

	          var cell = row.insertCell(7);
	          cell.innerHTML = 0;
	          cell.className = "clsDiscountAmt";
	          cell.style.display="none";

	          var cell = row.insertCell(8);
	          cell.innerHTML = 0;
	          cell.className = "clsPreTaxAmt";
	          cell.style.display="none";

	          var cell = row.insertCell(9);
	          cell.innerHTML = 0;
	          // cell.contentEditable="true";
	          cell.className = "clsIgst";
	          cell.style.display="none";

	          var cell = row.insertCell(10);
	          cell.innerHTML = 0;
	          cell.className = "clsIgstAmt";
	          cell.style.display="none";

	          var cell = row.insertCell(11);
	          cell.innerHTML = 0;
	          // cell.contentEditable="true";
	          cell.className = "clsCgst";
	          cell.style.display="none";

	          var cell = row.insertCell(12);
	          cell.innerHTML = 0;
	          cell.className = "clsCgstAmt";
	          cell.style.display="none";

	          var cell = row.insertCell(13);
	          cell.innerHTML = 0;
	          // cell.contentEditable="true";
	          cell.className = "clsSgst";
	          cell.style.display="none";

	          var cell = row.insertCell(14);
	          cell.innerHTML = 0;
	          cell.className = "clsSgstAmt";
	          cell.style.display="none";

	          var cell = row.insertCell(15);
	          cell.innerHTML = records[i].amt;
	          cell.className = "clsNetAmt";
	          cell.style.display="none";

	          var cell = row.insertCell(16);
	          cell.innerHTML = "";
	          cell.className = "clsNetAmt";

	          var cell = row.insertCell(17);
			  cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";
			  cell.style.textAlign="center";
			  
			  var cell = row.insertCell(18);
			  cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
			  cell.style.textAlign="center";
			    
			    if(i == 0) ///remove row not required in first row
				{
					cell.innerHTML = "";
				}
			  var cell = row.insertCell(19);
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

			      $(".clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst").off();
			      $('.clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst').on('keyup', doRowTotal);

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
			  	doAmtTotal();
			  	calcBalNow();
			  	// var netInWords = number2text( parseFloat( $("#txtNetAmt").val() ) ) ;
			  	// $("#txtWords").val( netInWords );

	}
</script>
<div class="container" style="width:95%">
	<div class="row" style='margin-top:-25px;'>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<h4 class="text-center">Sale</h4>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-right">
			<label style='font-size: 16pt;' id='lblNewOrOld'><span id='spanNewOrOld' class='label label-danger'>New Customer</span></label><label style='color: lightgrey; font-weight: normal;' id='lblCustomerId'></label>
		</div>
	</div>
	 
	<div class="row" style="background-color: #F0F0F0; padding-top: 10px; padding-bottom: 10px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Date:</label>";
				echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Customer Name:</label>";
				// echo "<label style='color: lightgrey; font-weight: normal;' id='lblCustomerId'></label>";
				echo form_input('txtCustomerName', '', "class='form-control' id='txtCustomerName' style='' maxlength=70 autocomplete='off'");
          	?>
      	</div>
      	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-5">
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Balance:</label>";
				echo form_input('txtCustomerBalance', '', "class='form-control' id='txtCustomerBalance' style='' placeholder='0' disabled='yes'");
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style='margin-top: 5px;'>
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Mobile No.:</label>";
				echo form_input('txtMobile', '', "class='form-control' id='txtMobile' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style='margin-top: 5px;'>
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Address:</label>";
				echo form_input('txtAddress', '', "class='form-control' id='txtAddress' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style='margin-top: 5px;'>
			<?php
				// echo "<label style='color: black; font-weight: normal;'>Customer Remarks:</label>";
				echo form_input('txtCustomerRemarks', '', "class='form-control' id='txtCustomerRemarks' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
      	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style='margin-top: 5px;'>
			<?php
				// echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
				echo "<input type='button' onclick='loadFromQuotation();' value='Items From Quotation' id='btnLoadFromQuotation' class='btn btn-primary btn-block' data-toggle='modal' data-target='#myModalQuotation'>";
          	?>
      	</div>
	</div>

	

    <div class="row" style="margin-top: 5px;">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 sticky-table sticky-headers sticky-ltr-cells" id="divTable" style="overflow:auto; height:320px;">
			<table style="table-layout: fixed; border: 1px solid lightgrey;" id='tbl1' class="table table-condensed">
	           <thead>
	           <tr class="sticky-row" style="">
	            <th class="sticky-cell" width="50">S.N.</th>
	            <th width="50" style='display:none1;'>Item Row Id</th>
	            <th width="200">Item</th>
	            <th width="50">Qty</th>
	            <th width="50">Rate</th>
	            <th width="80">Amt</th>
	            <th width="50" style='display:none;'>D. Per</th>
	            <th width="50" style='display:none;'>D. Amt.</th>
	            <th width="80" style='display:none;'>Pre Tax Amt</th>
	            <th width="50" style='display:none;'>IGST</th>
	            <th width="50" style='display:none;'>IGST Amt</th>
	            <th width="50" style='display:none;'>CGST</th>
	            <th width="50" style='display:none;'>CGST Amt</th>
	            <th width="50" style='display:none;'>SGST</th>
	            <th width="50" style='display:none;'>SGST Amt</th>
	            <th width="100" style='display:none;'>Net Amt</th>
	            <th width="100" style='display:none1;'>Remarks</th>
	            <th width="50"></th>
	            <th width="50"></th>
	            <th width="50"></th>
	           </tr>
	           </thead>
          </table>
		</div>
	</div>

	<div class="row" style="margin-top: 10px;background-color: #F0F0F0; padding-top:10px;padding-bottom:10px;">
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style="display: none;">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total Amt.:</label>";
				echo '<input type="number"  step="1" name="txtTotalAmt" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalAmt" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style="display: none;">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total Disc.:</label>";
				echo '<input type="number"  step="1" name="txtTotalDiscount" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalDiscount" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style="display: none;">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Pretax Amt.:</label>";
				echo '<input type="number"  step="1" name="txtPretaxAmt" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtPretaxAmt" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style="display: none;">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total IGST:</label>";
				echo '<input type="number"  step="1" name="txtTotalIgst" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalIgst" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style="display: none;">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total CGST:</label>";
				echo '<input type="number"  step="1" name="txtTotalCgst" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalCgst" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style="display: none;">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Total SGST:</label>";
				echo '<input type="number"  step="1" name="txtTotalSgst" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtTotalSgst" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Net Amt.:</label>";
				echo '<input type="number"  step="1" name="txtNetAmt" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtNetAmt" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Amt. Paid:</label>";
				echo '<input type="number"  step="1" name="txtAmtPaid" value="0" placeholder="" class="form-control" maxlength="15" id="txtAmtPaid" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Balance:</label>";
				echo '<input type="number"  step="1" name="txtBalance" value="0" placeholder="" class="form-control" maxlength="15" disabled id="txtBalance" />';
          	?>
      	</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style="">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Due Date:</label>";
				echo form_input('txtDueDate', '', "class='form-control' id='txtDueDate' style='' maxlength=10 autocomplete='off'");
          	?>
		</div>      	
	<!-- </div>

	<div class="row" style="margin-top: 20px;"> -->
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
				echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
      		<?php
				echo "<label style='color: black; font-weight: normal;'>Rec.Deno.:</label>";
				echo '<input type="number"  step="1" name="txtRd" value="0" placeholder="" class="form-control" maxlength="15" id="txtRd" />';
          	?>
      	</div>
      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
      		<?php
				echo "<label style='color: black; font-weight: normal;'>Return Amt.:</label>";
				echo form_input('txtReturnAmt', '', "class='form-control' id='txtReturnAmt' style='' maxlength=10 autocomplete='off' disabled");
          	?>
      	</div>
      	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
      		<?php
				echo "<label style='color: black; font-weight: normal;'>:</label>";
				echo form_input('txtHappy', '', "class='form-control' id='txtHappy' disabled");
          	?>
      	</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
          	?>
          	<button id="btnSave" class="btn btn-success btn-block" onclick="saveData();">Save Sale Invoice</button>
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

	<div class="row"  style="margin-top: 25px;">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div id="divTableOldDb" class="divTable tblScroll" style="border:1px solid lightgray; height:300px; overflow:auto;">
				<table class='table table-hover table-bordered table-striped' id='tblOldDb'>
				 <thead>
					 <tr>
					 	<th  width="50" class="editRecord text-center" style='display:none1;'>Edit</th>
					 	<th  width="50" class="text-center">Delete</th>
						<th style='display:none1;'>rowId#</th>
					 	<th>Date</th>
					 	<th style='display:none;'>customerRowId</th>
					 	<th>Customer Name</th>
					 	<th style='display:none;'>Total Amt</th>
					 	<th style='display:none;'>Total Disc.</th>
					 	<th style='display:none;'>Pretax Amt</th>
					 	<th style='display:none;'>Total IGST</th>
					 	<th style='display:none;'>Total CGST</th>
					 	<th style='display:none;'>Total SGST</th>
					 	<th>Net Amt.</th>
					 	<th>Paid</th>
					 	<th>Balance</th>
					 	<th>Due Dt.</th>
					 	<th>Remarks</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
						foreach ($records as $row) 
						{
						 	$rowId = $row['dbRowId'];
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
						 	echo "<td style='width:0px;display:none1;'>".$row['dbRowId']."</td>";
						 	$vdt = strtotime($row['dbDt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
						 	echo "<td>".$row['customerName']."</td>";
						 	echo "<td style='display:none;'>".$row['totalAmount']."</td>";
						 	echo "<td style='display:none;'>".$row['totalDiscount']."</td>";
						 	echo "<td style='display:none;'>".$row['pretaxAmt']."</td>";
						 	echo "<td style='display:none;'>".$row['totalIgst']."</td>";
						 	echo "<td style='display:none;'>".$row['totalCgst']."</td>";
						 	echo "<td style='display:none;'>".$row['totalSgst']."</td>";
						 	echo "<td>".$row['netAmt']."</td>";
						 	echo "<td>".$row['advancePaid']."</td>";
						 	echo "<td>".$row['balance']."</td>";
						 	if($row['dueDate'] != "")
							{
							 	$vdt = strtotime($row['dueDate']);
								$vdt = date('d-M-Y', $vdt);
							 	echo "<td>".$vdt."</td>";
							}
							else
							{
								echo "<td></td>";
							}
							echo "<td>".$row['remarks']."</td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="border:1px solid lightgray; height:300px; overflow:auto;">
			<table style="border: 1px solid lightgrey;" id='tblProductsSaved' class="table table-bordered table-striped table-hover ">
	           <thead>
		           <tr>
		            <th>S.N.</th>
		            <th style='display:none;'>Item Row Id</th>
		            <th>Item</th>
		            <th>Qty</th>
		            <th>Rate</th>
		            <th>Amt</th>
		          </tr>
	           </thead>
          </table>
		</div>
	</div>

	<div class="row" style="margin-top:20px;margin-bottom:20px;" >
      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo '<input type="text" placeholder="Part of Name or Remarks" class="form-control" maxlength="15" id="txtSearch" />';
          	?>
      	</div>
      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			<?php
				echo "<input type='button' onclick='searchRecords();' value='Search Records' id='btnSearch' class='btn btn-success form-control'>";
	      	?>
		</div>
      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
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
		  

		<!-- Quotations Model -->
		  <div class="modal" id="myModalQuotation" role="dialog">
		    <div class="modal-dialog modal-lg">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Select Quotation</h4>
		        </div>
		        <div class="modal-body" style="overflow: auto; height: 300px;">
		          <table id='tblQuotations' class="table table-stripped">
		          		<th style='display:none1;'>quotationRowid</th>
					 	<th>Dt</th>
					 	<th style='display:none;'>PartyRowId</th>
					 	<th>Party</th>
					 	<th>Total Amt</th>
					 	<th style='display:none1;'>Remarks</th>
		          </table>
		        </div>
		        <div class="modal-footer">
		        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		        		<button type="button" onclick="loadAllQuotations();" class="btn btn-block btn-default">Load All Quot.</button>
		        	</div>
		        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		        		
		        	</div>
		        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		        		<button type="button" onclick="loadQuotationProducts();" class="btn btn-block btn-danger" data-dismiss="modal">Load</button>
		        	</div>
		        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		        		<button type="button" class="btn btn-block btn-default" data-dismiss="modal">Cancel</button>
		        	</div>
		        </div>
		      </div>
		    </div>
		  </div>		  

<script type="text/javascript">
	
          	

	$(document).ready( function () {
		$( "#txtDate" ).datepicker({
			dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
		});
	    // Set the Current Date as Default
		$("#txtDate").val(dateFormat(new Date()));

		$( "#txtDueDate" ).datepicker({
			dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
		});

		  $("#tbl1").find("tr:gt(0)").remove();
		  addRow();

		  $("#txtCustomerName").focus();

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
		          cell.contentEditable="true";
		          cell.className = "clsRate";

		          var cell = row.insertCell(5);
		          cell.innerHTML = "";
		          cell.className = "aasda";

		          var cell = row.insertCell(6);
		          cell.innerHTML = "0";
		          // cell.contentEditable="true";
		          cell.className = "clsDiscountPer";
		          cell.style.display="none";

		          var cell = row.insertCell(7);
		          cell.innerHTML = "0";
		          cell.className = "clsDiscountAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(8);
		          cell.innerHTML = "0";
		          cell.className = "clsPreTaxAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(9);
		          cell.innerHTML = "0";
		          // cell.contentEditable="true";
		          cell.className = "clsIgst";
		          cell.style.display="none";

		          var cell = row.insertCell(10);
		          cell.innerHTML = "0";
		          cell.className = "clsIgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(11);
		          cell.innerHTML = "0";
		          // cell.contentEditable="true";
		          cell.className = "clsCgst";
		          cell.style.display="none";

		          var cell = row.insertCell(12);
		          cell.innerHTML = "0";
		          cell.className = "clsCgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(13);
		          cell.innerHTML = "0";
		          // cell.contentEditable="true";
		          cell.className = "clsSgst";
		          cell.style.display="none";

		          var cell = row.insertCell(14);
		          cell.innerHTML = "0";
		          cell.className = "clsSgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(15);
		          cell.innerHTML = "0";
		          cell.className = "clsNetAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(16);
		          cell.innerHTML = "";
		          cell.className = "clsRemarks";
		          cell.contentEditable="true";

		          var cell = row.insertCell(17);
		          cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";
		          cell.style.textAlign="center";

		          var cell = row.insertCell(18);
		          cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
		          cell.style.textAlign="center";
		          // cell.textAlign="center";
		          if(sn == 2) ///remove row not required in first row
			      {
			      	cell.innerHTML = "";
			      }

			      var cell = row.insertCell(19);
		          cell.innerHTML = "";//<button class='row-pp' style='color:lightgray;'> S </button>";
		          cell.style.textAlign="center";

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

			      $(".row-pp").off();
			      $(".row-pp").on('mouseover focus', function(){
			      	$(this).css("color", "blue");
			      });
			      $(".row-pp").on('mouseout blur', function(){
			      	$(this).css("color", "lightgrey");
			      });

			      $(".clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst").off();
			      $('.clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst').on('keyup', doRowTotal);


			      $('.row-remove').on('click', removeRow);
			      $('.row-pp').on('click', callLastPurchasePrice);

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

			function callLastPurchasePrice()
			{
				var rowIndex = $(this).parent().parent().index();
				var itemRowId = $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").text();
				btnText = $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(18)").find("button").text();
				if(btnText == "S")
				{
					$.ajax({
						'url': base_url + '/' + controller + '/getLastPurchasePrice',
						'type': 'POST',
						'dataType': 'json',
						'data': {'itemRowId': itemRowId},
						'success': function(data){
							if(data)
							{
								// alert(JSON.stringify(data));
								$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(19)").find("button").text(data['lastPurchasePrice'] );
								$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(19)").css({'color':'lightgrey'})
							}
						},
					'error': function(jqXHR, exception)
			          {
			            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
			            $("#modalAjaxErrorMsg").modal('toggle');
			          }
					});
				}
				else
				{
					$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(19)").find("button").text("S");
				}
				// alert(itemRowId);
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
				var discountTotal=0;
				var pretaxTotal=0;
				var igstTotal=0;
				var cgstTotal=0;
				var sgstTotal=0;
				var netTotal=0;
				var ppTotal=0;
				$("#tbl1").find("tr:gt(0)").each(function(i){
					if( isNaN(parseFloat( $(this).find("td:eq(5)").text() )) == false )
					{
						amtTotal += parseFloat( $(this).find("td:eq(5)").text() );
						discountTotal += parseFloat( $(this).find("td:eq(7)").text() );
						pretaxTotal += parseFloat( $(this).find("td:eq(8)").text() );
						igstTotal += parseFloat( $(this).find("td:eq(10)").text() );
						cgstTotal += parseFloat( $(this).find("td:eq(12)").text() );
						sgstTotal += parseFloat( $(this).find("td:eq(14)").text() );
						netTotal += parseFloat( $(this).find("td:eq(15)").text() );
						str = $(this).find("td:eq(19)").text();
						// alert((str.isNull()));
						if( str.substring(str.indexOf("K")+1, str.length) == "0" || str == "") /// agar pp nahi h ya zero h.
						{
							ppTotal += parseFloat( $(this).find("td:eq(5)").text() );
						}
						else
						{
							ppTotal += parseFloat( str.substring(str.indexOf("K")+1, str.length ) ) *  parseFloat( $(this).find("td:eq(3)").text() );
						}
					}
				});
				$("#txtTotalAmt").val(amtTotal.toFixed(2));
				$("#txtTotalDiscount").val(discountTotal.toFixed(2));
				$("#txtPretaxAmt").val(pretaxTotal.toFixed(2));
				$("#txtTotalIgst").val(igstTotal.toFixed(2));
				$("#txtTotalCgst").val(cgstTotal.toFixed(2));
				$("#txtTotalSgst").val(sgstTotal.toFixed(2));
				$("#txtNetAmt").val( Math.round(netTotal).toFixed(2) );
				// alert(netTotal);
				var netInWords = number2text( parseFloat( $("#txtNetAmt").val() ) ) ;
			  	$("#txtWords").val( netInWords );
			  	var np = (Math.round(netTotal).toFixed(2) - Math.round(ppTotal).toFixed(2))
			  	// alert(Math.round(ppTotal).toFixed(2));
			  	var npp = ((np * 100)/Math.round(ppTotal)).toFixed(1);
			  	$("#txtHappy").val( npp + "%XYTRP" + (Math.round(netTotal).toFixed(2) - Math.round(ppTotal).toFixed(2)) );
			}

			function calcBalNow()
			{
				if( $("#txtAmtPaid").val() !== "" )
				{
					$("#txtBalance").val( (parseFloat($("#txtNetAmt").val()) - parseFloat($("#txtAmtPaid").val())).toFixed(2) );
				}
				else
				{
					$("#txtBalance").val( parseFloat($("#txtNetAmt").val()) - 0 );
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
				var rate = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text() ); 
				if( isNaN(rate) ) 
				{
					rate = 0;
				}
				var rowAmt = qty * rate;
				rowAmt = rowAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(5)").text( rowAmt );

				var dis = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(6)").text() );				
				if( isNaN(dis) ) 
				{
					dis = 0;
				}
				var rowDiscountAmt = rowAmt * dis / 100;
				rowDiscountAmt = rowDiscountAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(7)").text( rowDiscountAmt );

				var rowPreTaxAmt = rowAmt - rowDiscountAmt;
				rowPreTaxAmt = rowPreTaxAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(8)").text( rowPreTaxAmt );

				var igst = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(9)").text() );				
				if( isNaN(igst) ) 
				{
					igst = 0;
				}
				// alert(igst);
				var rowIgstAmt = rowPreTaxAmt * igst / 100;
				rowIgstAmt = rowIgstAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(10)").text( rowIgstAmt );

				var cgst = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(11)").text() );				
				if( isNaN(cgst) ) 
				{
					cgst = 0;
				}
				var rowCgstAmt = rowPreTaxAmt * cgst / 100;
				rowCgstAmt = rowCgstAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(12)").text( rowCgstAmt );

				var sgst = parseFloat ($("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(13)").text() );				
				if( isNaN(sgst) ) 
				{
					sgst = 0;
				}
				var rowSgstAmt = rowPreTaxAmt * sgst / 100;
				rowSgstAmt = rowSgstAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(14)").text( rowSgstAmt );

				var rowNetAmt = parseFloat(rowPreTaxAmt) + parseFloat(rowIgstAmt) + parseFloat(rowCgstAmt) + parseFloat(rowSgstAmt);
				rowNetAmt = rowNetAmt.toFixed(2);
				$("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(15)").text( rowNetAmt );

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



				// var someList = ["seven nine five", "five fifteen twenty", "twenty-five maybe one", "two (five) one"];
				var jSonArray = '<?php echo json_encode($items); ?>';
				var availableTags = $.map(JSON.parse(jSonArray), function(obj){
							return{
									label: obj.itemName,
									itemRowId: obj.itemRowId,
									itemLastRate: obj.rate,
									pp: obj.pp
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
					    var pp = ui.item.pp;
					    pp = parseFloat(pp);
					    if(isNaN(pp) == true )
					    {
					    	pp=0;
					    }
					    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
					    var rowIndex = $(this).parent().index();
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").text( itemRowId );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text( itemLastRate );
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(19)").text( itemRowId + "K" + pp + possible.charAt(Math.floor(Math.random() * possible.length)));
					    $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(19)").css("color", "lightgray");
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
							remarks: obj.remarks,
							balance: obj.balance
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
			    $("#txtCustomerBalance").val( ui.item.balance );
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
				        $("#txtMobile").prop('disabled', false);
					    $("#txtAddress").prop('disabled', false);
					    $("#txtCustomerRemarks").prop('disabled', false);
					    // $("#txtCustomerBalance").prop('disabled', false);
					    $("#txtMobile").val( '' );
					    $("#txtAddress").val( '' );
					    $("#txtCustomerRemarks").val( '' );
					    $("#txtCustomerBalance").val( '' );
					    if( $("#txtCustomerName").val().trim().length>0 )
					    {
					    	$("#txtMobile").focus();
					    }
				  	}
				  	else
				  	{
				  		$("#spanNewOrOld").text("Old Customer");
				  		$("#spanNewOrOld").removeClass("label-danger");
				  		$("#spanNewOrOld").addClass("label-success");
				        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanNewOrOld").animate({opacity: '1'}, 1000);
				        $("#txtMobile").prop('disabled', true);
					    $("#txtAddress").prop('disabled', true);
					    $("#txtCustomerRemarks").prop('disabled', true);
					    $("#txtCustomerBalance").prop('disabled', true);
				  	}
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );


    $(document).ready(function()
    {
      $("#txtAmtPaid").on('keyup change', calcBalNow);
      $("#txtRd").on('keyup', calcReturnAmt);
	  $("#tblOldDb tr").on('click', highlightRowAlag);
      $("#tblOldDb tr").find("td:gt(1)").on('click', showDetailsSaved);
  	});
  	
    function calcReturnAmt()
	{
		var amtPaid = parseInt($("#txtAmtPaid").val());
		var amtRecd = parseInt($("#txtRd").val());
		var diff = amtRecd - amtPaid;
		$("#txtReturnAmt").val(diff);
		//globalrowid = rowid;
	}
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
							blankControls();
							$("#btnSave").text("Save Sale Invoice");
							$("#tbl1").find("tr:gt(0)").remove();
							addRow();
							$("#txtDate").val(dateFormat(new Date()));;
							$("#txtCustomerName").prop("disabled", false);
							$("#txtAmtPaid").prop("disabled", false);
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
	          cell.setAttribute("onclick", "delrowid(" + records[i].dbRowId +")");
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
          cell.innerHTML = records[i].dbRowId;
          var cell = row.insertCell(3);
          cell.innerHTML = dateFormat(new Date(records[i].dbDt));
          // cell.style.display="none";
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].customerRowId;
          cell.style.display="none";
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].customerName;
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].totalAmount;
          cell.style.display="none";
          var cell = row.insertCell(7);
          cell.innerHTML = records[i].totalDiscount;
          cell.style.display="none";
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].pretaxAmt;
          cell.style.display="none";
          var cell = row.insertCell(9);
          cell.innerHTML = records[i].totalIgst;
          cell.style.display="none";
          var cell = row.insertCell(10);
          cell.innerHTML = records[i].totalCgst;
          cell.style.display="none";
          var cell = row.insertCell(11);
          cell.innerHTML = records[i].totalSgst;
          cell.style.display="none";
          var cell = row.insertCell(12);
          cell.innerHTML = records[i].netAmt;
          var cell = row.insertCell(13);
          cell.innerHTML = records[i].advancePaid;
          var cell = row.insertCell(14);
          cell.innerHTML = records[i].balance;
          var cell = row.insertCell(15);
          if(records[i].dueDate == null)
          {
          	cell.innerHTML = "";
          }
          else
          {
          	cell.innerHTML = dateFormat(new Date(records[i].dueDate));
          }
          var cell = row.insertCell(16);
          cell.innerHTML = records[i].remarks;
	    }

	    $("#tblOldDb tr").on('click', highlightRowAlag);
        $("#tblOldDb tr").find("td:gt(1)").on('click', showDetailsSaved);
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
		$("#txtTotalDiscount").val( $(this).closest('tr').children('td:eq(7)').text() );
		$("#txtPretaxAmt").val( $(this).closest('tr').children('td:eq(8)').text() );
		$("#txtTotalIgst").val( $(this).closest('tr').children('td:eq(9)').text() );
		$("#txtTotalCgst").val( $(this).closest('tr').children('td:eq(10)').text() );
		$("#txtTotalSgst").val( $(this).closest('tr').children('td:eq(11)').text() );
		$("#txtNetAmt").val( $(this).closest('tr').children('td:eq(12)').text() );
		$("#txtAmtPaid").val( $(this).closest('tr').children('td:eq(13)').text() );
		
		$("#txtBalance").val( $(this).closest('tr').children('td:eq(14)').text() );
		$("#txtDueDate").val( $(this).closest('tr').children('td:eq(15)').text() );
		$("#txtRemarks").val( $(this).closest('tr').children('td:eq(16)').text() );
		$("#txtCustomerName").prop("disabled", true);
		$("#txtAmtPaid").prop("disabled", true);


      	$.ajax({
			'url': base_url + '/' + controller + '/showDetailOnUpdate',
			'type': 'POST', 
			'data':{ 'globalrowid':globalrowid
						, 'customerRowId':customerRowId
					},
			'dataType': 'json',
			'success':function(data)
			{
				// alert(JSON.stringify(data['records']));
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
		          cell.contentEditable="true";
				  cell.className = "clsRate";

		          var cell = row.insertCell(5);
		          cell.innerHTML = data['records'][i].amt;
		          // cell.contentEditable="true";

		          var cell = row.insertCell(6);
		          cell.innerHTML = data['records'][i].discountPer;
		          // cell.contentEditable="true";
		          cell.className = "clsDiscountPer";
		          cell.style.display="none";

		          var cell = row.insertCell(7);
		          cell.innerHTML = data['records'][i].discountAmt;
		          cell.className = "clsDiscountAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(8);
		          cell.innerHTML = data['records'][i].pretaxAmt;
		          cell.className = "clsPreTaxAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(9);
		          cell.innerHTML = data['records'][i].igst;
		          // cell.contentEditable="true";
		          cell.className = "clsIgst";
		          cell.style.display="none";

		          var cell = row.insertCell(10);
		          cell.innerHTML = data['records'][i].igstAmt;
		          cell.className = "clsIgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(11);
		          cell.innerHTML = data['records'][i].cgst;
		          // cell.contentEditable="true";
		          cell.className = "clsCgst";
		          cell.style.display="none";

		          var cell = row.insertCell(12);
		          cell.innerHTML = data['records'][i].cgstAmt;
		          cell.className = "clsCgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(13);
		          cell.innerHTML = data['records'][i].sgst;
		          // cell.contentEditable="true";
		          cell.className = "clsSgst";
		          cell.style.display="none";

		          var cell = row.insertCell(14);
		          cell.innerHTML = data['records'][i].sgstAmt;
		          cell.className = "clsSgstAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(15);
		          cell.innerHTML = data['records'][i].netAmt;
		          cell.className = "clsNetAmt";
		          cell.style.display="none";

		          var cell = row.insertCell(16);
		          cell.innerHTML = data['records'][i].itemRemarks;
		          cell.className = "clsRemarks";
		          cell.contentEditable="true";

		          // cell.style.display="none";

		          var cell = row.insertCell(17);
				  cell.innerHTML = "<button class='row-add' style='color:lightgray;' onclick='addRow();'> <span class='glyphicon glyphicon-plus'> </span></button>";
		          cell.style.textAlign="center";

				  var cell = row.insertCell(18);
				  cell.innerHTML = "<button class='row-remove' style='color:lightgray;'> <span class='glyphicon glyphicon-remove'> </span></button>";
		          cell.style.textAlign="center";
				    
				    if(i == 0) ///remove row not required in first row
					{
						cell.innerHTML = "";
					}

				  var cell = row.insertCell(19);
				  cell.innerHTML = data['records'][i].itemRowId + "K" + data['records'][i].pp;//"<button class='row-pp' style='color:lightgray;'> S </span></button>";
		          cell.style.textAlign="center";
		          cell.style.color="lightgray";

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

			      $(".clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst").off();
			      $('.clsQty, .clsRate, .clsDiscountPer, .clsIgst, .clsCgst, .clsSgst').on('keyup', doRowTotal);

				$('.row-remove').on('click', removeRow);
				$('.row-pp').on('click', callLastPurchasePrice);

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

			  	var netInWords = number2text( parseFloat( $("#txtNetAmt").val() ) ) ;
			  	$("#txtWords").val( netInWords );

			},
			'error': function(jqXHR, exception)
	          {
	            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
	            $("#modalAjaxErrorMsg").modal('toggle');
	          }
		});

		$("#btnSave").text("Update");
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


	function showDetailsSaved()
	{
		$("#tblProductsSaved").find("tr:gt(0)").remove();
	    // purchaseRowId = $(this).find("td:eq(2)").text();
	    dbRowId = $(this).parent().find("td:eq(2)").text();
	    // alert(dbRowId);
	    // return;
	    $.ajax({
				'url': base_url + '/' + controller + '/getSaleDetial',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dbRowId': dbRowId
						},
				'success': function(data)
				{
					// alert(JSON.stringify(data['saleDetail']));
	      			var table = document.getElementById("tblProductsSaved");
					for(i=0; i<data['saleDetail'].length; i++)
				    {

			          var newRowIndex = table.rows.length;
			          var row = table.insertRow(newRowIndex);

			          var cell = row.insertCell(0);
			          cell.innerHTML = i+1; 			///SN
			          
			          var cell = row.insertCell(1);
			          cell.innerHTML = data['saleDetail'][i].itemRowId;
			          cell.style.display="none";

			          var cell = row.insertCell(2);
			          if( data['saleDetail'][i].itemRemarks != null && data['saleDetail'][i].itemRemarks.length > 0 )
			          {
			          	cell.innerHTML = data['saleDetail'][i].itemName + " <span style='color: green;'>[" + data['saleDetail'][i].itemRemarks + "]</span>";
			          }
			          else
			          {
			          	cell.innerHTML = data['saleDetail'][i].itemName;
			          }
			          var cell = row.insertCell(3);
			          cell.innerHTML = data['saleDetail'][i].qty;

			          var cell = row.insertCell(4);
			          cell.innerHTML = data['saleDetail'][i].rate;

			          var cell = row.insertCell(5);
			          cell.innerHTML = data['saleDetail'][i].amt;
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