<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">

	var controller='RptSearch_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Search";


	function setTable(ledgerData, reminderData, datesData, cashSaleData)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl1").empty();
	      var table = document.getElementById("tbl1");

	      for(i=0; i<ledgerData.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);

	          var cell = row.insertCell(0);
	          cell.innerHTML = dateFormat(new Date(ledgerData[i].refDt));

	          var cell = row.insertCell(1);
	          cell.innerHTML = ledgerData[i].remarks;
	          var cell = row.insertCell(2);
	          cell.innerHTML = ledgerData[i].customerName;
	          var cell = row.insertCell(3);
	          cell.innerHTML = ledgerData[i].vType + "-" + ledgerData[i].refRowId;
	          var cell = row.insertCell(4);
	          cell.innerHTML = ledgerData[i].amt;
	          var cell = row.insertCell(5);
	          cell.innerHTML = ledgerData[i].recd;
	  	  }

	  	  ////REMINDERS
	      for(i=0; i<reminderData.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = dateFormat(new Date(reminderData[i].dt));
	          cell.style.color = "red";
	          var cell = row.insertCell(1);
	          cell.innerHTML = reminderData[i].remarks;
	          cell.style.color = "red";
	          var cell = row.insertCell(2);
	          cell.innerHTML = reminderData[i].repeat;
	          cell.style.color = "red";
	          var cell = row.insertCell(3);
	          cell.innerHTML = 'REMINDER';
	          cell.style.color = "red";
	          var cell = row.insertCell(4);
	          var cell = row.insertCell(5);
	  	  }

	  	  ////DATES
	      for(i=0; i<datesData.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = dateFormat(new Date(datesData[i].dt));
	          cell.style.color = "blue";
	          var cell = row.insertCell(1);
	          cell.innerHTML = datesData[i].remarks;
	          cell.style.color = "blue";
	          var cell = row.insertCell(2);
	          var cell = row.insertCell(3);
	          cell.innerHTML = 'DATES';
	          cell.style.color = "blue";
	          var cell = row.insertCell(4);
	          var cell = row.insertCell(5);
	  	  }


	  	  ////DATES
	      for(i=0; i<cashSaleData.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = dateFormat(new Date(cashSaleData[i].dt));
	          cell.style.color = "green";
	          var cell = row.insertCell(1);
	          cell.innerHTML = cashSaleData[i].remarks;
	          cell.style.color = "green";
	          var cell = row.insertCell(2);
	          cell.innerHTML = cashSaleData[i].itemName;
	          cell.style.color = "green";
	          var cell = row.insertCell(3);
	          cell.innerHTML = 'CASH SALE';
	          cell.style.color = "green";
	          var cell = row.insertCell(4);
	          var cell = row.insertCell(5);
	          cell.innerHTML = cashSaleData[i].amt;
	          cell.style.color = "green";
	  	  }

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

		searchWhat = $("#txtSearch").val().trim();
		if(searchWhat == "")
		{
			alertPopup("Enter textto search...", 8000);
			$("#txtSearch").focus();
			return;
		}

		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'searchWhat': searchWhat
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
							setTable(data['ledgerData'], data['reminderData'], data['datesData'], data['cashSaleData']) 
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
			<h3 class="text-center" style='margin-top:-20px'>Search</h3>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:15px;">
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>Keyword to search in Ledger, Reminders, Dates:</label>";
							echo form_input('txtSearch', '', "class='form-control' placeholder='' id='txtSearch' maxlength='30'");
		              	?>			
		          	</div>

					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow' class='btn btn-primary form-control'>";
		              	?>
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
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:380px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th>Date</th>
					 	<th>Remarks</th>
					 	<th>Name</th>
					 	<th>V.No</th>
					 	<th>Paid</th>
					 	<th>Recd</th>
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