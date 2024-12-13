<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='EditItemsGroup_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Edit Items";


	function setTable(records)
	{
		 // alert(JSON.stringify(records));
		  
		 // setHeadings();
		  // $("#tblItems").find("tr:gt(0)").remove();
		  $("#tblItems").empty();
	      var table = document.getElementById("tblItems");
	      // alert(noOfDays);
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
	          // cell.setAttribute("contentEditable", true);
	          // cell.style.backgroundColor="#F0F0F0";
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].itemGroupRowId;
	          cell.style.display="none";
	          // cell.setAttribute("contentEditable", true);
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].itemGroupName;
	          cell.className = "clsItemGroupName";
	          cell.setAttribute("contentEditable", true);
	          // cell.className = "tdEditable";

	          var cell = row.insertCell(5);
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


		$('.clsItemGroupName').on("focus", setNameRed);


		$("#tblItems tr td").on("keyup", function(e){
	  	  	// if ( (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 && e.keyCode <= 122) ) 
	  	  	if(e.keyCode != 9)
	  	  	{
	  	  		var rowIndex = $(this).parent().index();
	  	  		$("#tblItems").find("tr:eq("+ rowIndex + ")").find("td:eq("+ 5 +")").text(1);
	  	  		// rowCount();
	  	  	}
	  	  });
			bindItemGroups();

	}



	function loadData()
	{	
		// var searchValue = $("#txtSearch").val().trim();
		var itemGroupRowId = $("#lblItemGroupRowId").text();
		// if( itemGroupRowId == "-1" )
		// {
		// 	alertPopup('Invalid group...', 4000);
		// 	return;
		// }
		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'itemGroupRowId': itemGroupRowId
							, 'dtTo': 'dtTo'
						},
				'success': function(data)
				{
					if(data)
					{
						// console.log(JSON.stringify(data));
							setTable(data['records']) 
							// alertPopup('Records loaded...', 4000);
                  	  	alertPopup("Records Loaded... in Server Time: " + JSON.stringify( data['timeTook'] ), 5000);

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
	    	if($(this).find("td:eq("+ 5 +")").text() == '1' )
		    {
	        	TableData[i]=
	        	{
		            "itemRowId" : $(tr).find('td:eq(1)').text()
		            , "itemGroupRowId" :$(tr).find('td:eq(3)').text()
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
		$.ajax({
				'url': base_url + '/' + controller + '/saveData',
				'type': 'POST',
				// 'dataType': 'json',
				'data': {
							'TableData': TableData
							, 'productCategoryRowId': 'productCategoryRowId'
						},
				'success': function(data)
				{
					// alert('Changes saved...');
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
			<h3 class="text-center" style='margin-top:-20px'>Edit Items (Group)</h3>
			<h6 class="text-center" style='color:red;'>Edit Max. 200 records at a time</h6>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:-30px;">
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;' id='lblItemGroupRowId'>-1</label>";
							echo "<input type='text' id='txtSearch' class='form-control' maxlength=20 placeholder='Search'>";
		              	?>
		          	</div>
		          	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
						<?php
							echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow' class='btn form-control' style='background-color: lightgray;'>";
		              	?>
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
					<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:0 solid lightgray; padding: 10px;height:450px; overflow:auto;">
						<table class='table table-bordered table-striped table-hover' id='tblItems'>
							<thead>
							 <tr style="background-color: #F0F0F0;">
							 	<th style='display:none1;'>S.N.</th>
							 	<th style='display:none1;'>itemRowId</th>
							 	<th>Item Name</th>
							 	<th style='display:none;'>itemGroupRowId</th>
							 	<th>Group</th>
							 	<th style='display:none;'>flag</th>
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
</div>

<script type="text/javascript">

</script>


<script type="text/javascript">
		$(document).ready( function () {
		    myDataTable = $('#tblItems').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});

			// $("#btnShow").trigger("click");
		} );

	


	$(document).ready( function () 
	{
		select = false;
		var jSonArray = '<?php echo json_encode($itemGroups); ?>';
		// alert(jSonArray);
		var jSonArray = jSonArray.replace(/(\r\n|\n|\r)/gm,", "); ///Multilinse of Address field with comma replce
		var availableTags = $.map(JSON.parse(jSonArray), function(obj){
					return{
							label: obj.itemGroupName,
							itemGroupRowId: obj.itemGroupRowId,
					}
		});

	    $( "#txtSearch" ).autocomplete({
		      source: availableTags,
		      autoFocus: true,
			  selectFirst: true,
			  open: function(event, ui) { if(select) select=false; },
			  // select: function(event, ui) { select=true; },	
		      minLength: 0,
		      select: function (event, ui) {
		      	select = true;
		      	var selectedObj = ui.item; 
			    // var itemGroupRowId = ui.item.itemGroupRowId;
			    $("#lblItemGroupRowId").text( ui.item.itemGroupRowId );
	        	}
		    }).blur(function() {
				  if( !select ) 
				  {
				  	$("#lblItemGroupRowId").text('-1');
				  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  	
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );


	function bindItemGroups()
  	{
	 	select = false;
	 	var defaultText = "";
		$( ".clsItemGroupName" ).focus(function(){ 
	  			select = false; 
	  			defaultText = $(this).text();
	  		});
		var jSonArray = '<?php echo json_encode($itemGroupsForTable); ?>';
		var availableTags = $.map(JSON.parse(jSonArray), function(obj){
					return{
							label: obj.itemGroupName,
							itemGroupRowId: obj.itemGroupRowId,
					}
		});
		// console.log(availableTags);
	    $( ".clsItemGroupName" ).autocomplete({
		      source: availableTags,
		      autoFocus: true,
			  selectFirst: true,
			  open: function(event, ui) { if(select) select=false; },
			  // select: function(event, ui) { select=true; },	
		      minLength: 0,
		      select: function (event, ui) {
		      	select = true;
		      	var selectedObj = ui.item; 
			    var itemGroupRowId = ui.item.itemGroupRowId;
			    var rowIndex = $(this).parent().index();
			    $("#tblItems").find("tr:eq(" + rowIndex + ")").find("td:eq(3)").text( itemGroupRowId );
	        	}
		    }).blur(function() {
			  	var rowIndex = $(this).parent().index();
			    var newText = $("#tblItems").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").text(); 
				  if( !select && !(defaultText == newText))
				  {
				  	$("#tblItems").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").css("color", "red");
				  	$("#tblItems").find("tr:eq(" + rowIndex + ")").find("td:eq(3)").text( '-1' );
				  }
				  else
				  {
				  	$("#tblItems").find("tr:eq(" + rowIndex + ")").find("td:eq(4)").css("color", "black");
				  }
				}).focus(function(){            
		            	$(this).autocomplete("search");
		    		});
  	}


  	function setNameRed()
	{
		$(".clsItemGroupName").parent().find("td:eq(2)").css({ color: 'black' });
		$(this).parent().find("td:eq(2)").css({ color: 'red' });
	}
</script>