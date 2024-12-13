<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='RptSaleFrequence_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Sale Frequency";

	function setTable(records, recordsCashSale)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl1").empty();
		  // $("#tbl1").find("tr:gt(0)").remove();
        var table = document.getElementById("tbl1");
        for(i=0; i<records.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);
          row.style.color = "green";

          var cell = row.insertCell(0);
          // cell.style.display="none";
          cell.innerHTML = records[i].itemRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = records[i].itemName;
          // cell.style.display="none";
          var cell = row.insertCell(2);
          cell.innerHTML = records[i].qty;
          // cell.style.display="none";
	    }

	    
	    

		myDataTable.destroy();
		$(document).ready( function () {

			findDuplicates();

	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    order: [[2, 'desc']],
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		});
	    

		} );

		$("#tbl1 tr").on("click", highlightRowAlag);			
	}

	function findDuplicates()
	{
		found = 0;
		x="";
		$('#tbl1 tr').each(function(row, tr)
	    {
	    	if(row > 0 )
	    	{
	    		x = $(this).find('td:eq(1)').text().toUpperCase().trim();
	    		y = $(this).next().find('td:eq(1)').text().toUpperCase().trim();
	    		
		    	if( x == y )
		    	{
		    		// alert( x + y);
		    		$(this).css({'color':'red'});
		    		$(this).next().css({'color':'red'});

		    		p = parseFloat($(this).find('td:eq(2)').text().toUpperCase().trim());
	    			q = parseFloat($(this).next().find('td:eq(2)').text().toUpperCase().trim());
	    			r = p+q;
	    			r = r.toFixed(2);
		    		$(this).find('td:eq(2)').text(r);
		    		$(this).next().remove();
		    		found++;
		    	}
	    	}
	    });
	    // alert(x);
	    // alert(found + " Duplicates found");
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

		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dtFrom': dtFrom
							, 'dtTo': dtTo
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
						setTable(data['records']);
						alertPopup('Records loaded...', 3000);
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
		
	}




</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Sale Frequency</h3>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:5px;">
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>From:</label>";
							echo form_input('dtFrom', '', "class='form-control' placeholder='' id='dtFrom' maxlength='10'");
		              	?>
		              	<script>
							$( "#dtFrom" ).datepicker({
								dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
							});

						    // Set the Current Date-50 as Default
						    dt=new Date();
     					    dt.setDate(dt.getDate() - 850);
   		 					$("#dtFrom").val(dateFormat(dt));
						</script>					
		          	</div>
		          	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
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
					

					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow' class='btn btn-primary form-control'>";
		              	?>
		          	</div>
		          	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		          	</div>
				</div>
			</form>
		</div>
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>


	<div class="row" style="margin-top:10px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:500px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
					 	<th style="display: none1;">itemRowId</th>
                              <th>Item</th>
                              <th>No. of Pcs.</th>
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
                   ordering: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
		} );

</script>