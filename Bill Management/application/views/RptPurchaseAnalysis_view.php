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
</style>


<script type="text/javascript">

	var controller='RptPurchaseAnalysis_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Pur. Analysis";

	$(document).ready(function(){
	});

	function setTable(records)
	{
	    $("#tbl1").empty();
        var table = document.getElementById("tbl1");
        if( records.length > 0 )
        {
	      ////// Setting headings of table iske liye JSON ki KEYS ko utha rahe h (like empName etc.)
			var keys = Object.keys(records[0]);
			newRowIndex = table.rows.length;
	        row = table.insertRow(newRowIndex);
	        row.className = "sticky-row";
	        var cell = row.insertCell(0);		//// Pahla col Sr. No.
			cell.innerHTML = "SN";
	        cell.style.backgroundColor="#F0F0F0";
	        cell.className = "sticky-cell clsTH";
			for(c=0;c<keys.length; c++)
			{
				var cell = row.insertCell(c+1);
				cell.innerHTML = keys[ c ];
	        	cell.style.backgroundColor="#F0F0F0";
	        	cell.className = "clsTH";
			}
	      ////// END - Setting headings of table iske liye JSON ki KEYS ko utha rahe h (like empName etc.)

	      for(i=0; i<records.length; i++)
	      {
			// build the index ------- JSON k keys ko index ki form m convert kr rahe h
	      	var index = [];
			for (var x in records[i]) {
			   index.push(x);
			}
			// END - build the index ------- JSON k keys ko index ki form m convert kr rahe h
			newRowIndex = table.rows.length;
	        row = table.insertRow(newRowIndex);
	        row.className = "tableBody";
	        var cell = row.insertCell(0);				//// Sr. No.
			cell.innerHTML = i+1;
	        cell.style.backgroundColor="#F0F0F0";
	        cell.className = "sticky-cell";

		    for(var j = 0; j < index.length; j++)
		    {
		    	// console.log(records[i][ index[j] ]);
				var cell = row.insertCell(j+1);
				cell.innerHTML = records[i][ index[j] ];
				
		    }
	  	  }

	  	}
		
		////Cloning last row
    	var $tableBody = $('#tbl1');
		$trLast = $tableBody.find("tr:last");
	    $trow = $tableBody.find("tr:last"),
	    $trNew = $trow.clone();
		$trLast.after($trNew);

		//// Set all null in last copied row
		$('table#tbl1 tr:last td').text('');
		$('table#tbl1 tr:last').css('color', 'blue');
		$('table#tbl1 tr:last td:eq(0)').html('<span style="display:none;">z</span>');	/// taki asc sort m last m rahe
		$('table#tbl1 tr:last td:eq(2)').html('<span style="display:none;">z</span>Total'); /// taki asc sort m last m rahe

		//// Calling function for col total of table
		$('.clsTH').each(function(i) {
                calculateColumn(i);
            });	
	}

	function calculateColumn(index) {
		// console.log(index);
		if( index > 2 )			/// shuru k col ka sum ni karna
        {
	        var total = 0;
	        $('#tbl1 tr:gt(0)').each(function() {
	            var value = parseFloat($('td', this).eq(index).text());
	            if (!isNaN(value)) {
	                total += value;
	            }
	        });
	        // $('table tfoot td').eq(index).text('Total: ' + total);
	        $('#tbl1').find("tr:last").find("td:eq("+index+")").text('' + total);
		}

    }

	function setRangeInTable()
	{
		var c = parseInt( $("#txtCycles").val() );
		var startDt = $("#dtFrom").val();
		y = parseInt(startDt.substring(7, 11)) + 1;
	    m = startDt.substring(3, 6);
	    if( m == "Apr") {mm = 3;} else if( m == "May") { mm = 4; } else if( m == "Jun") { mm = 5; } else if( m == "Jul") { mm = 6; } else if( m == "Aug") { mm = 7; } else if( m == "Sep") { mm = 8; } else if( m == "Oct") { mm = 9; } else if( m == "Nov") { mm = 10; } else if( m == "Dec") { mm = 11; } else if( m == "Jan") { mm = 0; } else if( m == "Feb") { mm = 1; } else if( m == "Mar") { mm = 2; }
	    d = new Date(y, mm, 1);
		d.setDate(0);
	    endDt = dateFormat(new Date(d));
		$("#tblRange").find('tr:gt(0)').remove();
	    var table = document.getElementById("tblRange");
	    for(i=1; i<=c; i++)
	    {
		    newRowIndex = table.rows.length;
	        row = table.insertRow(newRowIndex);
	        var cell = row.insertCell(0);
	        cell.innerHTML = startDt;
	        var cell = row.insertCell(1);
	        cell.innerHTML = endDt;

	        // startDt = new Date(startDt.getFullYear(), 0, 2);
	        y = parseInt(startDt.substring(7, 11)) + 1;
	        m = startDt.substring(3, 7);
	        d = startDt.substring(0, 3);
	        startDt = d + m + y;
	    	// console.log(startDt);
			y = parseInt(startDt.substring(7, 11)) + 1;
	    	if( m == "Apr") {mm = 3;} else if( m == "May") { mm = 4; } else if( m == "Jun") { mm = 5; } else if( m == "Jul") { mm = 6; } else if( m == "Aug") { mm = 7; } else if( m == "Sep") { mm = 8; } else if( m == "Oct") { mm = 9; } else if( m == "Nov") { mm = 10; } else if( m == "Dec") { mm = 11; } else if( m == "Jan") { mm = 0; } else if( m == "Feb") { mm = 1; } else if( m == "Mar") { mm = 2; }
	    	d = new Date(y, mm, 1);
			d.setDate(0);
		    endDt = dateFormat(new Date(d));

	    }
	}

	var tblRowsCount=0;
	function storeTblValues()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tblRange tr').each(function(row, tr)
	    {
        	TableData[i]=
        	{
	            "r1" : $(tr).find('td:eq(0)').text()
	            , "r2" :$(tr).find('td:eq(1)').text()
        	}   
        	i++; 
	    }); 
	    TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i;
	    // alert(tblRowsCount);
	    return TableData;
	}


	function loadData()
	{	
		setRangeInTable();
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		// console.log(JSON.stringify(TableData));
		// return;
		// $("#tbl1").find("tr:gt(0)").remove(); /* empty except 1st (head) */	
		var dtFrom = $("#dtFrom").val().trim();
		dtOk = testDate("dtFrom");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#dtFrom").focus();
			return;
		}

	////////////
		var itemGroupRowId = $("#lblItemGroupRowId").text();
		if( itemGroupRowId == "-1" )
		{
			alertPopup("Select group", 5000);
			return;
		}

		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'TableData': TableData
							, 'itemGroupRowId': itemGroupRowId
							, 'dtTo': 'dtTo'
						},
				'success': function(data)
				{
						// console.log(JSON.stringify(data));
					if(data)
					{
						setTable(data['records']) 
                  	  	alertPopup("Records Loaded... in Server Time: " + JSON.stringify( data['timeTook'] ), 5000);
						$("#tbl1 tr").on("click", highlightRow);
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
<div class="container">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Purchase Analysis (Annual)</h3>
			<?php
				echo "<label style='color: lightgrey; font-weight: normal; margin-top:10px;' id='lblItemGroupRowId'>-1</label>";
				echo "<label style='color: red; font-weight: normal; margin-top:10px; margin-left:10px;' id='lblCustomerAddress'> - </label>";
				echo "<label style='color: green; font-weight: normal; margin-top:10px; margin-left:10px;' id='lblCustomerMobile'> - </label>";
				echo "<label style='color: blue; font-weight: normal; margin-top:10px; margin-left:10px;' id='lblCustomerRemarks'> - </label>";
			?>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:15px;">
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>From:</label>";
							echo form_input('dtFrom', '01-Apr-2017', "class='form-control' placeholder='' id='dtFrom' maxlength='10'");
		              	?>
		              	<script>
							$( "#dtFrom" ).datepicker({
								dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
							});
						</script>					
		          	</div>

		          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							echo form_input('txtCycles', '3', "class='form-control' placeholder='' id='txtCycles' maxlength='1'");
		              	?>
		              					
		          	</div>
		          	
					
		          	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						<?php
							echo "<input type='text' id='txtItemGroup' class='form-control' maxlength=20 placeholder='Item Group'>";
			          	?>
			      	</div>
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
							echo "<input type='button' onclick='loadData();' value='Show Data' id='btnShow' class='btn btn-primary form-control'>";
		              	?>
		          	</div>
				</div>
			</form>
		</div>
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>

	<!-- rangeTable -->
	<div class="row" style="margin-top:20px; display: none;" >
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:280px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tblRange'>
				 <thead>
					 <tr>
					 	<th>One</th>
					 	<th>Two</th>
					 </tr>
				 </thead>
				 <tbody>

				 </tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12 sticky-table sticky-headers sticky-ltr-cells" style="border:1px solid lightgray; padding: 0;height:470px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='display:none;'>ledgerRowid</th>
					 	<th style='display:none1;'>V.Type</th>
					 	<th style='display:none1;'>Rem</th>
					 	<th>Dt</th>
					 	<th style='display:none;'>For What</th>
					 	<th>Paid</th>
					 	<th>Recd.</th>
					 	<th>Bal.</th>
					 </tr>
				 </thead>
				 <tbody>

				 </tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:10px; margin-bottom:10px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-0">
			<input type='text' class='form-control' id='txtSearch' autocomplete='off' maxlength="20" placeholder="Search Table">
		</div>
	</div>
</div>


<script type="text/javascript">


		$(document).ready( function () {
		    
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
	    $( "#txtItemGroup" ).autocomplete({
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


    $(document).ready(function(){
	  $("#txtSearch").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $(".tableBody").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	  });
	});
</script>