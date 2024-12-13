<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/jquery.stickytable.min.js"></script>
<link rel='stylesheet' href='<?php  echo base_url();  ?>bootstrap/css/jquery.stickytable.min.css'>

<style type="text/css">
	#dtFrom {position: relative; z-index:101;}
	#dtTo {position: relative; z-index:101;}
</style>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
    <script type="text/javascript">
      // Load the Visualization API and the line package.
      google.charts.load('current', {'packages':['bar']});
      // Set a callback to run when the Google Visualization API is loaded.
      // google.charts.setOnLoadCallback(drawChart);
      // function drawChart()
      // {

      // }
    </script>


<script type="text/javascript">

	var controller='RptCollection_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Rpt Collection";


	function setTable(records, sale, quotation, cashSaleCollection, cashSaleExp)
	{
		////Purchase
	  var purchaseTotal = 0;
      for(i=0; i<records.length; i++)
      {
      	$('#tbl1 tr').each(function(row, tr)
	    {
	    	d = new Date(records[i].purchaseDt).getDate();
	    	m = new Date(records[i].purchaseDt).getMonth()+1;
	    	y = new Date(records[i].purchaseDt).getFullYear();
	    	dt = d+"-"+m+"-"+y;
	    	// alert( dt );
	    	if( $(tr).find('td:eq(0)').text() == dt )
	    	{
	    		$(tr).find('td:eq(1)').text( records[i].netAmt );
	    		$(tr).find('td:eq(1)').css({'text-align': 'right'});
	    		purchaseTotal += parseFloat(records[i].netAmt);
	    		return false;
	    	}
		});
	  }
      	////Sale
      var saleTotal = 0;
      for(i=0; i<sale.length; i++)
      {
      	$('#tbl1 tr').each(function(row, tr)
	    {
	    	d = new Date(sale[i].dbDt).getDate();
	    	m = new Date(sale[i].dbDt).getMonth()+1;
	    	y = new Date(sale[i].dbDt).getFullYear();
	    	dt = d+"-"+m+"-"+y;
	    	// alert( dt );
	    	if( $(tr).find('td:eq(0)').text() == dt )
	    	{
	    		$(tr).find('td:eq(2)').text( sale[i].netAmt );
	    		$(tr).find('td:eq(2)').css({'text-align': 'right'});
	    		saleTotal += parseFloat(sale[i].netAmt);
	    		return false;
	    	}
		}); 
	     
  	  }

      	////Quotation
      var quotationTotal = 0;
      for(i=0; i<quotation.length; i++)
      {
      	$('#tbl1 tr').each(function(row, tr)
	    {
	    	d = new Date(quotation[i].quotationDt).getDate();
	    	m = new Date(quotation[i].quotationDt).getMonth()+1;
	    	y = new Date(quotation[i].quotationDt).getFullYear();
	    	dt = d+"-"+m+"-"+y;
	    	if( $(tr).find('td:eq(0)').text() == dt )
	    	{
	    		$(tr).find('td:eq(3)').text( quotation[i].totalAmount );
	    		$(tr).find('td:eq(3)').css({'text-align': 'right'});
	    		quotationTotal += parseFloat(quotation[i].totalAmount);
	    		return false;
	    	}
		});

  	  }


      	////Cash Sale Collection
      var cashSaleCollectionTotal = 0;
      for(i=0; i<cashSaleCollection.length; i++)
      {
      	$('#tbl1 tr').each(function(row, tr)
	    {
	    	d = new Date(cashSaleCollection[i].dt).getDate();
	    	m = new Date(cashSaleCollection[i].dt).getMonth()+1;
	    	y = new Date(cashSaleCollection[i].dt).getFullYear();
	    	dt = d+"-"+m+"-"+y;
	    	if( $(tr).find('td:eq(0)').text() == dt )
	    	{
	    		$(tr).find('td:eq(4)').text( cashSaleCollection[i].amt );
	    		$(tr).find('td:eq(4)').css({'text-align': 'right'});
	    		cashSaleCollectionTotal += parseFloat(cashSaleCollection[i].amt);
	    		return false;
	    	}
		});
	  }


      	////Cash Sale Exp.
      var cashSaleExpTotal = 0;
      for(i=0; i<cashSaleExp.length; i++)
      {
      	$('#tbl1 tr').each(function(row, tr)
	    {
	    	d = new Date(cashSaleExp[i].dt).getDate();
	    	m = new Date(cashSaleExp[i].dt).getMonth()+1;
	    	y = new Date(cashSaleExp[i].dt).getFullYear();
	    	dt = d+"-"+m+"-"+y;
	    	if( $(tr).find('td:eq(0)').text() == dt )
	    	{
	    		$(tr).find('td:eq(5)').text( cashSaleExp[i].amt );
	    		$(tr).find('td:eq(5)').css({'text-align': 'right'});
	    		cashSaleExpTotal += parseFloat(cashSaleExp[i].amt);
	    		return false;
	    	}
		});

  	  }

  	  /////Last Col of rowTot
  	  lastColTotal = 0;
  	  $('#tbl1 tr').each(function(row, tr)
	    {
	    	// if( $(tr).find('td:eq(0)').text() == dt )
	    	// {
	    		if( isNaN( parseFloat( $(tr).find('td:eq(1)').text( )) ) == true )
	    		{
	    			rowPurchase = 0;
	    		}
	    		else
	    		{
	    			rowPurchase = parseFloat( $(tr).find('td:eq(1)').text( ));
	    		}
	    		if( isNaN( parseFloat( $(tr).find('td:eq(2)').text( )) ) == true )
	    		{
	    			rowSale = 0;
	    		}
	    		else
	    		{
	    			rowSale = parseFloat( $(tr).find('td:eq(2)').text( ));
	    		}
	    		if( isNaN( parseFloat( $(tr).find('td:eq(4)').text( )) ) == true )
	    		{
	    			rowCashSale = 0;
	    		}
	    		else
	    		{
	    			rowCashSale = parseFloat( $(tr).find('td:eq(4)').text( ));
	    		}
	    		if( isNaN( parseFloat( $(tr).find('td:eq(5)').text( )) ) == true )
	    		{
	    			rowCashExp = 0;
	    		}
	    		else
	    		{
	    			rowCashExp = parseFloat( $(tr).find('td:eq(5)').text( ));
	    		}

	    		// var rowTot =  (rowSale + rowCashSale) - (rowPurchase + rowCashExp);
	    		var rowTot =  (rowSale + rowCashSale) - (rowCashExp);

	    		rowTot = rowTot.toFixed(2);
	    		// alert(rowTot);
	    		$(tr).find('td:eq(6)').text( rowTot );
	    		$(tr).find('td:eq(6)').css({'text-align': 'right', 'color': 'red'});
	    		lastColTotal += parseFloat(rowTot);
	    		// return false;
	    	// }
		});
  	  /////END - Last Col of rowTot

  	  ////Total Row Insert
  	  var table = document.getElementById("tbl1");
  	  newRowIndex = table.rows.length;
      row = table.insertRow(newRowIndex);
      var cell = row.insertCell(0);
      cell.innerHTML = "Total";
      cell.style.backgroundColor="#F0F0F0";
      cell.style.fontWeight="bold";
      cell.style.textAlign = "right";
      
      var cell = row.insertCell(1);
	  cell.innerHTML = purchaseTotal.toFixed(2);
      cell.style.backgroundColor="#F0F0F0";
      cell.style.fontWeight="bold";
      cell.style.textAlign = "right";
      
      var cell = row.insertCell(2);
	  cell.innerHTML = saleTotal.toFixed(2);
      cell.style.backgroundColor="#F0F0F0";
      cell.style.fontWeight="bold";
      cell.style.textAlign = "right";
      
      var cell = row.insertCell(3);
	  cell.innerHTML = quotationTotal.toFixed(2);
      cell.style.backgroundColor="#F0F0F0";
      cell.style.fontWeight="bold";
      cell.style.textAlign = "right";
      
      var cell = row.insertCell(4);
	  cell.innerHTML = cashSaleCollectionTotal.toFixed(2);
      cell.style.backgroundColor="#F0F0F0";
      cell.style.fontWeight="bold";
      cell.style.textAlign = "right";
      
      var cell = row.insertCell(5);
	  cell.innerHTML = cashSaleExpTotal.toFixed(2);
      cell.style.backgroundColor="#F0F0F0";
      cell.style.fontWeight="bold";
      cell.style.textAlign = "right";


      var cell = row.insertCell(6);
	  cell.innerHTML = lastColTotal.toFixed(2);
      cell.style.backgroundColor="#F0F0F0";
      cell.style.fontWeight="bold";
      cell.style.textAlign = "right";
      cell.style.color= "red";



	drawVisualization();

////////////Chart END



		$("#tbl1 tr").on("click", highlightRowAlag);
			
	}

	function drawVisualization() 
	{
			////////////Chart
		      	// Create our data table out of JSON data loaded from server.
		        var data = new google.visualization.DataTable();
	  
		      data.addColumn('string', 'Date');
		      data.addColumn('number', 'Sales');
		      // data.addColumn('number', 'Expense');

		      // for (var i = 0; i < cashSaleCollection.length; i++) {
	       //      data.addRow([dateFormat(new Date(cashSaleCollection[i].dt)), parseInt(cashSaleCollection[i].amt)]);
		      // }
		      i=0;
		      $('#tbl1 tr').each(function(row, tr){
		      	if(i>0 && i < $('#tbl1 tr').length-1 )
		      	{
		      		data.addRow([ $(tr).find('td:eq(0)').text() , parseInt( $(tr).find('td:eq(6)').text() )]);
		      	}
	            i++;
		      });
		      var options = {
		        chart: {
		          title: 'Sale + CashSale - Exp.',
		          subtitle: '.'
		        },
		        width: 900,
		        height: 480,
		        axes: {
		          x: {
		            0: {side: 'bottom'}
		          }
		        },
	        	bars: 'horizontal',
	        	// colors: ['blue']
		      };

		      var chart = new google.charts.Bar(document.getElementById('bar_chart'));
		      chart.draw(data, options);

	}

	Date.prototype.addDays = function(days) {
       var dat = new Date(this.valueOf())
       dat.setDate(dat.getDate() + days);
       return dat;
    }

	function getDates(startDate, stopDate) {
      var dateArray = new Array();
      var currentDate = startDate;
      while (currentDate <= stopDate) {
        dateArray.push(currentDate)
        currentDate = currentDate.addDays(1);
      }
      return dateArray;
    }
    var noOfDays=0;

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

		var dateArray = getDates( new Date($("#dtFrom").val().trim()), (new Date( $("#dtTo").val().trim() )) );
	      	noOfDays=0;

	    // $("#tbl1").empty();
	    $("#tbl1").find("tr:gt(0)").remove();
	    var table = document.getElementById("tbl1");
		for (i = 0; i < dateArray.length; i ++ ) 
		{
		    newRowIndex = table.rows.length;
            row = table.insertRow(newRowIndex);

		    var cell = row.insertCell(0);
		    var m = dateArray[i].getMonth()+1;
            cell.innerHTML = dateArray[i].getDate() + "-" + m + "-" + dateArray[i].getFullYear();
            // cell.style.width = "100px";
            cell.style.backgroundColor="#F0F0F0";
            cell.style.fontWeight="bold";
            cell.style.textAlign = "right";
            cell.className = " sticky-cell";

            var cell = row.insertCell(1);
	        cell.innerHTML = "";
            var cell = row.insertCell(2);
	        cell.innerHTML = "";
            var cell = row.insertCell(3);
	        cell.innerHTML = "";
            var cell = row.insertCell(4);
	        cell.innerHTML = "";
            var cell = row.insertCell(5);
	        cell.innerHTML = "";            
	        var cell = row.insertCell(6);
	        cell.innerHTML = "";

            noOfDays++;
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
							setTable(data['purchase'], data['sale'], data['quotation'], data['cashSaleCollection'], data['cashSaleExp']); 
							alertPopup('Records loaded...', 4000);
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
		});
		
	}


	var tblRowsCount;
	function storeTblValues()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tbl1 tr').each(function(row, tr)
	    {
	    	// if( $(tr).find('td:eq(3)').text() > 0 )
	    	// {
	        	TableData[i]=
	        	{
		            "qpoRowId" : $(tr).find('td:eq(2)').text()
		            , "vType" : $(tr).find('td:eq(3)').text()
		            , "vNo" :$(tr).find('td:eq(4)').text()
		            , "vDt" :$(tr).find('td:eq(5)').text()
		            , "partyRowId" :$(tr).find('td:eq(6)').text()
		            , "partyName" :$(tr).find('td:eq(7)').text()
		            , "letterNo" :$(tr).find('td:eq(8)').text()
		            , "totalAmt" :$(tr).find('td:eq(9)').text()
		            , "discountPer" :$(tr).find('td:eq(10)').text()
		            , "discountAmt" :$(tr).find('td:eq(11)').text()
		            , "vatPer" :$(tr).find('td:eq(13)').text()
		            , "vatAmt" :$(tr).find('td:eq(14)').text()
		            , "net" :$(tr).find('td:eq(15)').text()
		            , "totalQty" :$(tr).find('td:eq(16)').text()
	        	}   
	        	i++; 
	        // }
	    }); 
	    // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i-1;
	    return TableData;
	}



</script>
<div class="container-fluid">
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Collection Report</h3>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:15px;">
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
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
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12 sticky-table sticky-headers sticky-ltr-cells" style="border:1px solid lightgray; padding: 10px;height:500px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr  class="sticky-row" style="text-align: right;">
						<th class="sticky-cell" style='text-align: right;'>Date</th>
					 	<th style='text-align: right;'>Purchase</th>
					 	<th style='text-align: right;'>Sale</th>
					 	<th style='text-align: right;'>Quotation</th>
					 	<th style='text-align: right;'>Cash Sale</th>
					 	<th style='text-align: right;'>Cash Exp.</th>
					 	<th style='text-align: right;'>Net (S+CS-E)</th>
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
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="overflow: auto; margin-top: 100px;border:1px solid lightgrey;height: 500px;">
	<div id="bar_chart"></div>
</div>
</div>





<script type="text/javascript">


</script>