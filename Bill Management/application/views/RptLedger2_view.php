<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">

	var controller='RptLedger2_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Ledger2";

	$(document).ready(function(){
		// var argCustomerRowId='<?php echo $argCustomerRowId;?>';
		// // alert(argCustomerRowId);
		// $("#cboCustomer").val(argCustomerRowId);
		// $("#btnShow").trigger('click');
	});

	function setTable(records)
	{
		 // alert(JSON.stringify(records));
		 var dr=0;
		 var cr=0;
		 var bal = 0;
		  $("#tbl1").empty();
	      var table = document.getElementById("tbl1");


          ////////////// Records in Range
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].ledgerRowId;
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].vType + "-" + records[i].refRowId;

	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].customerName;

	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].remarks;

	          var cell = row.insertCell(4);
	          cell.innerHTML = dateFormat(new Date(records[i].refDt));

	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].remarks;
	          cell.style.display="none";

	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].amt;

	          var cell = row.insertCell(7);
	          cell.innerHTML = records[i].recd;

	          var cell = row.insertCell(8);
	          bal = parseFloat(bal) + parseFloat(records[i].amt) - parseFloat(records[i].recd);

	          bal=bal.toFixed(2);
          	  cell.innerHTML = bal;
	  	  }
	  	  ////////////// END - Records in Range

	  	  ////////////// Total
	  	    var totDr = 0;
	  	    var totCr = 0;
	  	    var rangeTotDr = 0;
	  	    var rangeTotCr = 0;
		    $('#tbl1 tr').each(function(row, tr)
		    {
		    	if( $(tr).find('td:eq(6)').text() > 0 ) 
		    	{
		        	totDr += parseInt( $(tr).find('td:eq(6)').text() ); 
		        }
		    	if( $(tr).find('td:eq(7)').text() > 0 ) 
		    	{
		        	totCr += parseInt( $(tr).find('td:eq(7)').text() ); 
		        }
		        rangeTotDr = totDr - $('#tbl1').find('tr:eq(0)').find('td:eq(6)').text();
		        rangeTotCr = totCr - $('#tbl1').find('tr:eq(0)').find('td:eq(7)').text();
		    }); 

		      newRowIndex = $("#tbl1 tr").length;
	          row = table.insertRow(newRowIndex);
	          // alert(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = "";
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          cell.innerHTML = "";

	          var cell = row.insertCell(2);
	          cell.innerHTML = "";

	          var cell = row.insertCell(3);
	          cell.innerHTML = "";

	          var cell = row.insertCell(4);
	          cell.innerHTML = "Total";
	          cell.style.color = "red";
	          

	          var cell = row.insertCell(5);
	          cell.innerHTML = "";
	          cell.style.display="none";

	          var cell = row.insertCell(6);
	          	cell.innerHTML = totDr;
	          cell.style.color = "red";
	          
	          var cell = row.insertCell(7);
	          	cell.innerHTML = totCr;
	          cell.style.color = "red";

	          var cell = row.insertCell(8);
	          var diff = totDr - totCr
	          $("#txtDiff").val(diff);

	          var rangeDiff = rangeTotDr - rangeTotCr
	          rangeDiff=rangeDiff.toFixed(2);
	          $("#txtRangeDiff").val(rangeDiff);
	  	// $('.editRecord').bind('click', editThis);

		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		    "ordering": false
		});
		} );

		$("#tbl1 tr").on("click", highlightRow);
			
	}

	function loadData()
	{	
		// $("#tbl1").find("tr:gt(0)").remove(); /* empty except 1st (head) */	
		var dtFrom = $("#dtFrom").val().trim();
		dtOk = testDate("dtFrom");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#dtFrom").focus();
			return;
		}

		var dtTo = $("#dtTo").val().trim();
		dtOk = testDate("dtTo");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#dtTo").focus();
			return;
		}

		// customerRowId = $("#cboCustomer").val();
		// if(customerRowId == "-1")
		// {
		// 	alertPopup("Select customer...", 8000);
		// 	$("#cboCustomer").focus();
		// 	return;
		// }

		var customerRowId="";
		$('input:checked.chkCustomers').each(function() 
		{
			customerRowId = $(this).val() + "," + customerRowId;
		});
		if(customerRowId == "")
		{
			alertPopup("Select customer...", 8000);
			return;
		}
		customerRowId = customerRowId.substr(0, customerRowId.length-1);

		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'customerRowId': customerRowId
							, 'dtFrom': dtFrom
							, 'dtTo': dtTo
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
							setTable(data['records']) 
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
<div class="container">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Ledger 2</h3>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div id="style-1" class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style='background:rgba(128,128,128,.2);padding:0 50px;border-radius:5px;height:250px;overflow:auto;margin: 10px;'>
					<span class="btn" style='margin-left:-42px;'>
						<label for="chkAllProducts" style="font-weight:bold;color:black;">Select Account(s)
					</span>
					
					<?php
						foreach ($customers as $key => $value) 
						{
					?>
							<div class="checkbox1" style='margin-left:-30px;'>
								<input type="checkbox" class="chkCustomers" txt='<?php echo $value;?>' id='<?php echo "P".$key;?>' value='<?php echo $key;?>'></input>
								<label  style="color: black;" for='<?php echo  "P".$key;?>'><?php echo $value;?></label>
							</div>
					<?php
						}
					?>
				</div>
				<div align="left" class="col-lg-3 col-sm-3 col-md-3 col-xs-12" style='padding-left:30px;'>
						<div class="row" style='margin-top:5px;'>
							<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
								<?php
									echo "<label style='color: black; font-weight: normal;'>From:</label>";
									echo form_input('dtFrom', '', "class='form-control' placeholder='' id='dtFrom' maxlength='10'");
				              	?>
				              	<script>
									$( "#dtFrom" ).datepicker({
										dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
									});

								    // Set the 1st of this month
									var date = new Date();
									var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
									$("#dtFrom").val(dateFormat(firstDay));
								</script>	
							</div>
						</div>
						<div class="row" style='margin-top:5px;'>
							<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
								<?php
									echo "<label style='color: black; font-weight: normal;'>To:</label>";
									echo form_input('dtTo', '', "class='form-control' placeholder='' id='dtTo' maxlength='10'");
				              	?>
				              	<script>
									$( "#dtTo" ).datepicker({
										dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
									});
								    // Set the Current Date as Default
									$("#dtTo").val(dateFormat(new Date()));
								</script>
							</div>
						</div>
						<div class="row" style='margin-top:5px;'>
							<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
								<?php
									echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
									echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow' class='btn btn-primary form-control'>";
				              	?>
							</div>
						</div>
					</div>
			</form>
		</div>
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:330px; overflow:auto;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='display:none;'>ledgerRowid</th>
					 	<th style='display:none1;'>V.Type</th>
					 	<th>Ac. Name</th>
					 	<th style='display:none1;'>Rem</th>
					 	<th>Dt</th>
					 	<th style='display:none;'>For What</th>
					 	<th>Dr.</th>
					 	<th>Cr.</th>
					 	<th>Bal.</th>
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

</div>





<script type="text/javascript">


		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
		} );


</script>