<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='Duplicates_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Duplicate Items";

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
	          cell.setAttribute("onclick", "delrowid(" + records[i].itemRowId +")");
	          // data-toggle="modal" data-target="#myModal"
	          cell.setAttribute("data-toggle", "modal");
	          cell.setAttribute("data-target", "#myModal");
	          cell.style.display = "none";


	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].itemRowId;
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].createdStamp;
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
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
	}
	

</script>
<div class="container-fluid" style="width: 93%;">



	<div class="row" style="margin-top:20px;" >
		<h1 class="text-center" style='margin-top:-20px'>Duplicates</h1>
		<!-- <div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div> -->

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
					 	<th style='display:none;' width="50" class="text-center">Delete</th>
						<th style='display:none1;'>rowid</th>
					 	<th>Item Name</th>
					 	<th>createdStamp</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 


						foreach ($records as $row) 
						{
						 	$rowId = $row['itemRowId'];
						 	echo "<tr>";						//onClick="editThis(this);
							echo '<td style="color: lightgray;cursor: pointer;cursor: hand; display:none;" class="text-center" onclick="delrowid('.$rowId.');" data-toggle="modal" data-target="#myModal" onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
						 	echo "<td style='width:0px;display:none1;'>".$row['itemRowId']."</td>";
						 	echo "<td>".$row['itemName']."</td>";
						 	echo "<td>".$row['createdStamp']."</td>";
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
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
			<br>
			<button id="btnFindDuplicates" class="btn btn-primary btn-block" onclick="findDuplicates();">Find Duplicates</button>
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
			<label>Kisko Hatana h</label>
			<input type="number" id="txtHatana" class="form-control" value="" />
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
			<label>Kya Rakhna h</label>
			<input type="number" id="txtKarna" class="form-control" value="" />
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
			<br>
			<button id="btnFindDuplicates" class="btn btn-primary btn-block" onclick="showData();">Show Data</button>
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
			<br>
			<button id="btnFindDuplicates" class="btn btn-primary btn-block" onclick="showNext();">Show next Dup.</button>
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>

	</div>

	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-0" style="border: 1px solid grey; height: 250px;overflow: auto;">
			<table class='table table-hover' id='tblQuotationDetail'>
				<caption>Quotations</caption>
				 <thead>
					 <tr>
					 	<th>qdRowId</th>
					 	<th>qRowId</th>
					 	<th>ItemRowId</th>
					 	<th>Item Name</th>
					 	<th>Qty</th>
					 	<th>Rate</th>
					 	<th>Amt</th>
					 </tr>
				 </thead>
			</table>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-0" style="border: 1px solid grey;height: 250px;overflow: auto;">
			<table class='table table-hover' id='tblCashSale'>
				<caption>Cash Sale</caption>
				 <thead>
					 <tr>
					 	<th>dt</th>
					 	<th>mode</th>
					 	<th>csRowId</th>
					 	<th>ItemRowId</th>
					 	<th>Item Name</th>
					 	<th>Qty</th>
					 	<th>Rate</th>
					 	<th>Amt</th>
					 	<th>rem</th>
					 </tr>
				 </thead>
			</table>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-0" style="border: 1px solid grey;height: 250px;overflow: auto;">
			<table class='table table-hover' id='tblPurchaseDetail'>
				<caption>Purchase</caption>
				 <thead>
					 <tr>
					 	<th>pdRowId</th>
					 	<th>pRowId</th>
					 	<th>ItemRowId</th>
					 	<th>Item Name</th>
					 	<th>Qty</th>
					 	<th>Rate</th>
					 	<th>Amt</th>
					 </tr>
				 </thead>
			</table>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-0" style="border: 1px solid grey;height: 250px;overflow: auto;">
			<table class='table table-hover' id='tblSaleDetail'>
				<caption>Sale</caption>
				 <thead>
					 <tr>
					 	<th>dbdRowId</th>
					 	<th>dbRowId</th>
					 	<th>ItemRowId</th>
					 	<th>Item Name</th>
					 	<th>Qty</th>
					 	<th>Rate</th>
					 	<th>Amt</th>
					 </tr>
				 </thead>
			</table>
		</div>


		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0" style="margin-bottom: 20px;">
			<br>
			<button id="btnFindDuplicates" class="btn btn-danger btn-block" onclick="replaceNow();">Replace Now</button>
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

	function findDuplicates()
	{
		found = 0;
		x="";
		$('#tbl1 tr').each(function(row, tr)
	    {
	    	if(row >0 )
	    	{
	    		x = $(this).find('td:eq(2)').text().toUpperCase().trim();
	    		y = $(this).next().find('td:eq(2)').text().toUpperCase().trim();
	    		
		    	if( x == y )
		    	{
		    		// alert( x + y);
		    		$(this).css({'color':'red'});
		    		$(this).next().css({'color':'red'});
		    		found++;
		    	}
	    	}
	    });
	    // alert(x);
	    alert(found + " Duplicates found");
	}

	function showData()
	{
		var hatana = $("#txtHatana").val();
		if(hatana <=0 )
		{
			msgBoxError("Error", "Invalid Hatana");
			return;
		}
		var karna = $("#txtKarna").val();
		if(karna <=0 )
		{
			msgBoxError("Error", "Invalid Karna");
			return;
		}
		// alert(hatana + ", " + karna)
		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'hatana': hatana
							, 'karna': karna
						},
				'success': function(data)
				{
					// alert( JSON.stringify(data) );
					setTableQuotationDetail(data['quotationDetail']);
					setTableCashSale(data['cashSale']);
					setTablePurchaseDetail(data['purchaseDetail']);
					setTableSaleDetail(data['saleDetail']);
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});
	}

	function setTableQuotationDetail(records)
	{
		 // $("#tblQuotationDetail").empty();
		 $("#tblQuotationDetail").find("tr:gt(0)").remove();

	      var table = document.getElementById("tblQuotationDetail");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].quotationDetailRowId;
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].quotationRowId;
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].itemRowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].qty;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].rate;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].amt;
	  	  }
	}
	function setTableCashSale(records)
	{
		 // $("#tblQuotationDetail").empty();
		 $("#tblCashSale").find("tr:gt(0)").remove();

	      var table = document.getElementById("tblCashSale");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].dt;
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].mode;
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].cashSaleRowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].itemRowId;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].qty;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].rate;
	          var cell = row.insertCell(7);
	          cell.innerHTML = records[i].amt;
	  	  }
	}	

	function setTablePurchaseDetail(records)
	{
		 // $("#tblQuotationDetail").empty();
		 $("#tblPurchaseDetail").find("tr:gt(0)").remove();

	      var table = document.getElementById("tblPurchaseDetail");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].purchaseDetailRowId;
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].purchaseRowId;
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].itemRowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].qty;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].rate;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].amt;
	  	  }
	}


	function setTableSaleDetail(records)
	{
		 // $("#tblQuotationDetail").empty();
		 $("#tblSaleDetail").find("tr:gt(0)").remove();

	      var table = document.getElementById("tblSaleDetail");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].dbdRowId;
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].dbRowId;
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].itemRowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].qty;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].rate;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].amt;
	  	  }
	}

	pos=0;
	function showNext()
	{
		$('#tbl1 tr').each(function(){
		  if( $(this).position().top >= pos )
		  {
			   x = $(this).css('color');
	           if ( x == "rgb(255, 0, 0)" ) 
	           {
		           	var rowpos = $(this).position();
		           	p=rowpos.top;
					$('#divTable').animate({scrollTop: p}, 1000);
					pos = $(this).position().top + 50;
					return false; 
	               // alert($(this).css('color'));
	           }
	      }
        }); 
	}





	function replaceNow()
	{
		var hatana = $("#txtHatana").val();
		if(hatana <=0 )
		{
			msgBoxError("Error", "Invalid Hatana");
			return;
		}
		var karna = $("#txtKarna").val();
		if(karna <=0 )
		{
			msgBoxError("Error", "Invalid Karna");
			return;
		}
		// alert(hatana + ", " + karna)
		$.ajax({
				'url': base_url + '/' + controller + '/replaceNow',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'hatana': hatana
							, 'karna': karna
						},
				'success': function(data)
				{
					alert("Done...");
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});
	}
	function setTablePurchaseDetail(records)
	{
		 // $("#tblQuotationDetail").empty();
		 $("#tblPurchaseDetail").find("tr:gt(0)").remove();

	      var table = document.getElementById("tblPurchaseDetail");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].purchaseDetailRowId;
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].purchaseRowId;
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].itemRowId;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].itemName;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].qty;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].rate;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].amt;
	  	  }
	}




		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    order: [[ 2, "asc" ]],
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});

			$('#tbl1 tr').on('click', setRowPosition);
		} );

		function setRowPosition()
		{
			pos = $(this).position().top;
		}
</script>