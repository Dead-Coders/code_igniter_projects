<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='ItemsOpeningBalance_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Items- Op. Bal";


	function setTable(records)
	{
		  $("#tblItems").empty();
	      var table = document.getElementById("tblItems");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);


	          var cell = row.insertCell(0);
	          cell.innerHTML = i+1;
	          cell.style.backgroundColor="#F0F0F0";
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].itemRowId;
	          cell.style.backgroundColor="#F0F0F0";
	          // cell.style.display="none";
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].itemName;
	          cell.setAttribute("contentEditable", true);
	          // cell.style.backgroundColor="#F0F0F0";
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].openingBalance;
	          cell.setAttribute("contentEditable", true);
	          var cell = row.insertCell(4);
	          cell.innerHTML = "0";
	          cell.style.display="none";
	        
	  	  }

		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tblItems').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

		});
		} );


		///////Following function to add select TD text on FOCUS
			  	$("#tblItems tr td").on("focus", function(){
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


		$("#tblItems tr td").on("keyup", function(e){
	  	  	// if ( (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 && e.keyCode <= 122) ) 
	  	  	if(e.keyCode != 9)
	  	  	{
	  	  		var rowIndex = $(this).parent().index();
	  	  		$("#tblItems").find("tr:eq("+ rowIndex + ")").find("td:eq("+ 4 +")").text(1);
	  	  		rowCount();
	  	  	}
	  	  });
	}

	function loadData()
	{	
		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'productCategoryRowId': 'productCategoryRowId'
							, 'dtTo': 'dtTo'
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

	var tblRowsCount=0;
	function storeTblValues()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tblItems tr').each(function(row, tr)
	    {
	    	if($(this).find("td:eq("+ 4 +")").text() == '1' )
		    {
	        	TableData[i]=
	        	{
		            "itemRowId" : $(tr).find('td:eq(1)').text()
		            , "itemName" :$(tr).find('td:eq(2)').text()
		            , "openingBalance" :$(tr).find('td:eq(3)').text()
	        	}   
	        	i++; 
	        }
	    }); 
	    // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i;
	    // alert(tblRowsCount);
	    return TableData;
	}

	function saveData()
	{	
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		// alert(JSON.stringify(TableData));
		// return;

		// alert(tblRowsCount);
		// return;

		$.ajax({
				'url': base_url + '/' + controller + '/saveData',
				'type': 'POST',
				// 'dataType': 'json',
				'data': {
							'TableData': TableData
							
						},
				'success': function(data)
				{
					alert('Changes saved...');
					location.reload();
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
		
	}
	

</script>
<div class="container">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h4 class="text-center" style='margin-top:-20px'>Items Opening Balance</h4>
			<h4 class="text-center" style='color:red;'>Edit Max. 200 records at a time. (due to php limit of 1000 vars at a time)</h4>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:1px;">
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow' class='btn form-control' style='background-color: lightgray;'>";
		              	?>
		          	</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		          	</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		          	</div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='saveData();' value='Save Changes' id='btnSave' class='btn btn-success form-control'>";
				      	?>
		          	</div>
				</div>

				<div class="row" style="margin-top:20px;" >
					<style>
					    table, th, td{border:1px solid gray; padding: 7px;}
					</style>
					<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:0 solid lightgray; padding: 10px;height:500px; overflow:auto;">
						<table class='table table-bordered table-striped table-hover' id='tblItems'>
							<thead>
							 <tr style="background-color: #F0F0F0;">
							 	<th style='display:none1;'>S.N.</th>
							 	<th style='display:none1;'>itemRowId</th>
							 	<th>Item</th>
							 	<th>Opening Balance</th>
							 	<th style='display:none;'>Flag</th>
							 </tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-9 col-sm-9 col-md-9 col-xs-0">
		</div>

		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">

		</div>
	</div>
</div>





<script type="text/javascript">
		$(document).ready( function () {
		    myDataTable = $('#tblItems').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});

			$("#btnShow").trigger("click");
		} );

	function rowCount()
	{
		var c=0;
		$("#tblItems tr").each(function(i, v){
		    if($(this).find("td:eq("+ 4 +")").text() == '1' )
		    {
		    	c++;
		    }	
		});
		// alert(c);
		if(c>=200)
		{
			alert("Enough changes done for this time...");
		}
	}

</script>