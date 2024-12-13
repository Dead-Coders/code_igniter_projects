<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style type="text/css">
	.ui-autocomplete {
	    max-height: 200px;
	    overflow-y: auto;   /* prevent horizontal scrollbar */
	    overflow-x: hidden; /* add padding to account for vertical scrollbar */
	    z-index:1000 !important;
	}
</style>


<script type="text/javascript">

	var controller='DailyCash_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Daily Cash";
	var globalDayDiff=0;
	var globalInHand = 0;
	function setTable(records, opBal)
	{
		 // alert(JSON.stringify(records));
		 var dr=0;
		 var cr=0;
		 var bal = 0;
		  $("#tbl1").empty();
	      var table = document.getElementById("tbl1");


          ////////////// Op Bal
          var inHand = 0;
          // alert(JSON.stringify(opBal));
          for(i=0; i<opBal.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = opBal[i].rowId;
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          var date = new Date();
			  var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
	          cell.innerHTML = dateFormat(new Date(firstDay));

	          var cell = row.insertCell(2);
	          if(opBal[i].in == null)
	          {
	          	cell.innerHTML = "0";
	          	vin=0;
	          }
	          else
	          {
	          	cell.innerHTML = opBal[i].in;
	          	vin=opBal[i].in;
	          }
	          var cell = row.insertCell(3);
	          if(opBal[i].out == null)
	          {
	          	cell.innerHTML = "0";
	          	vout=0;
	          }
	          else
	          {
	          	cell.innerHTML = opBal[i].out;
	          	vout=opBal[i].out;
	          }

			  inHand = vout - vin;
	          var cell = row.insertCell(4);
	          cell.innerHTML = inHand;
	          cell.style.color = 'red';

	          var cell = row.insertCell(5);
	          cell.innerHTML = "OPENING OF THIS MONTH";

	          dayDiff = parseInt(opBal[i].out) - parseInt(opBal[i].in);
	          var cell = row.insertCell(6);
	          cell.innerHTML = dayDiff;
	          globalDayDiff=dayDiff;
	          var cell = row.insertCell(7);
	          var cell = row.insertCell(8);
	  	  }
          ////////////// Records in Range
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = records[i].rowId;
	          cell.style.display="none";

	          var cell = row.insertCell(1);
	          cell.innerHTML = dateFormat(new Date(records[i].dt));

	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].in;
	          // cell.style.textAlign = 'right';

	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].out;
	          // cell.style.textAlign = 'right';

			  inHand = parseInt(inHand) - parseInt(records[i].in) + parseInt(records[i].out);
	          var cell = row.insertCell(4);
	          cell.innerHTML = inHand;
	          cell.style.color = 'red';

	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].remarks;

	          dayDiff = parseInt(records[i].out) - parseInt(records[i].in);
	          var cell = row.insertCell(6);
	          cell.innerHTML = dayDiff;
	          globalDayDiff=dayDiff;
	          var cell = row.insertCell(7);
	          cell.innerHTML = records[i].denominationIn;
	          var cell = row.insertCell(8);
	          cell.innerHTML = records[i].denominationOut;
	  	  }
	  	  globalInHand = inHand;
	  	  ////////////// END - Records in Range


		myDataTable.destroy();
		$(document).ready( function () {
		    myDataTable=$('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			    "ordering": false
			});

			$('#divTable').scrollTop(50000);
			// console.log(rowpos)
		} );

		$("#tbl1 tr").on("click", highlightRowAlag);
				
  		// $("#tbl1").scrollTop($("#tbl1").prop("scrollHeight"));

	}

	function setTableNet(plusDues, minusDues, purchaseSum, paymentsSum, upiCollection)
	{
		 // alert(JSON.stringify(plusDues));
		 // alert(JSON.stringify(minusDues));
		 // return;
		 var plusSum = 0;
		 var minusSum = 0;
		  $("#tblNet").find("tr:gt(0)").remove();
	      var table = document.getElementById("tblNet");

          for(i=0; i<plusDues.length; i++)
	      {
	      	plusSum += parseInt(plusDues[i].balance);
	      }

	      for(i=0; i<minusDues.length; i++)
	      {
	      	minusSum += parseInt(minusDues[i].balance);
	      }
	      
	      newRowIndex = table.rows.length;
          row = table.insertRow(newRowIndex);
          var cell = row.insertCell(0);
          cell.innerHTML = "IN Hand";
          var cell = row.insertCell(1);
          cell.innerHTML = globalInHand;

          newRowIndex = table.rows.length;
          row = table.insertRow(newRowIndex);
          var cell = row.insertCell(0);
          cell.innerHTML = "PLUS sum";
          var cell = row.insertCell(1);
          cell.innerHTML = plusSum;

          newRowIndex = table.rows.length;
          row = table.insertRow(newRowIndex);
          var cell = row.insertCell(0);
          cell.innerHTML = "MINUS sum";
          var cell = row.insertCell(1);
          cell.innerHTML = minusSum;

          net = parseInt(globalInHand) + parseInt(plusSum) + parseInt(minusSum);
          newRowIndex = table.rows.length;
          row = table.insertRow(newRowIndex);
          var cell = row.insertCell(0);
          cell.innerHTML = "NET";
          var cell = row.insertCell(1);
          cell.innerHTML = net;

          if( purchaseSum.length>0 )
          {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = "Purchase (Cur.Date)";
	          var cell = row.insertCell(1);
	          cell.innerHTML = purchaseSum[0].amt;
	      }
	      if( paymentsSum.length>0 )
          {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);
	          var cell = row.insertCell(0);
	          cell.innerHTML = "Payments (Cur.Date)";
	          var cell = row.insertCell(1);
	          cell.innerHTML = paymentsSum[0].amt;
	      }
	      if( upiCollection.length>0 )
          {
          	// inHand = $("#tbl1").find("tr:last").find("td:eq(4)").text();
          	if( upiCollection[0].amt == null )
          	{
	          $("#lblUpiCollection").text("UPI Collection (Today): " + 0);
	          $("#lblTotalCollection").text("Total Collection (Today): " +eval(parseFloat(globalDayDiff) + 0));

          	}
          	else
          	{
	          $("#lblUpiCollection").text("UPI Collection (Today): " + upiCollection[0].amt);
	          $("#lblTotalCollection").text("Total Collection (Today): " +eval(parseFloat(globalDayDiff) + parseFloat(upiCollection[0].amt)));
	        }
	      }
	}



	function saveData()
	{
		///Denomination
		var deno = "";
		$('#tblCalc tr').each(function(row, tr)
	    {
	    	if( $(tr).find('td:eq(1)').text() > 0 )
	    	{
	    		deno += $(tr).find('td:eq(0)').text() + "x" + $(tr).find('td:eq(1)').text() + "=" + $(tr).find('td:eq(2)').text() + ", ";
	        }
	     
	    }); 
		// alert(deno  );
		// return;

		dt = $("#txtDate").val().trim();
		dtOk = testDate("txtDate");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#txtDate").focus();
			return;
		}

		
		amt = parseFloat($("#txtAmt").val());
		remarks = $("#txtRemarks").val().trim();
		
		inOutMode = $("#cboMode").val();
		if(inOutMode == "-1" )
		{
			alertPopup("Select mode...", 4000, 'red');
			$("#cboMode").focus();
			return;
		}

		if($("#btnSave").text() == "Save")
		{
			$.ajax({
				'url': base_url + '/' + controller + '/insert',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dt': dt
							, 'amt': amt
							, 'remarks': remarks
							, 'inOutMode': inOutMode
							, 'deno': deno
						},
				'success': function(data)
				{
					$("#txtAmt").val("0");
					$("#txtRemarks").val("");
					$("#cboMode").val("-1");
					setTable(data['records'], data['opBal']);
					// console.log(data['purchaseSum']);
					setTableNet(data['plusDues'], data['minusDues'], data['purchaseSum'], data['paymentsSum'], data['upiCollection'])
					alertPopup("Record saved...", 3000);
				},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
			});
		}
	}

</script>
<div class="container-fluid" style="width:95%;">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Daily Cash</h3>
				<div class="row" style="margin-top:25px;">
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							echo form_input('txtDate', '', "class='form-control' id='txtDate' style='' maxlength=10 autocomplete='off' placeholder='date'");
			          	?>
			          	<script>
							$( "#txtDate" ).datepicker({
								dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
							});
							// Set the 1st of this month
							$("#txtDate").val(dateFormat(new Date()));
						</script>	
			      	</div>
			      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							echo '<input type="number"  step="1" value="0" class="form-control" maxlength="15" id="txtAmt"  placeholder="Amt."/>';
			          	?>
			      	</div>
			      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
			      		<?php
							$modes = array();
							$modes['-1'] = '--- Select ---';
							$modes['IN'] = "IN";
							$modes['OUT'] = "OUT";
							// echo "<label style='color: black; font-weight: normal;'>Mode:</label>";
							echo form_dropdown('cboMode', $modes, '-1',"class='form-control' id='cboMode'");
			          	?>      	
			        </div>
			      	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>Remarks:</label>";
							echo form_input('txtRemarks', '', "class='form-control' id='txtRemarks' style='' maxlength=190 autocomplete='on' placeholder='Remarks'");
			          	?>
			      	</div>
			      	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
						<?php
							// echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
			          	?>
			          	<button id="btnSave" class="btn btn-primary btn-block" onclick="saveData();">Save</button>
			      	</div>
					<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
						<span id="spanInWords" style="color: green;">0</span>
					</div>
				</div>
				
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-0">
		</div>
	</div>


	<div class="row" style="margin-top:20px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:470px; overflow:auto;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='display:none;'>rowid</th>
					 	<th>Date</th>
					 	<th>Morning In</th>
					 	<th>Evening Out</th>
					 	<th>In Hand</th>
					 	<th>Remarks</th>
					 	<th>Day Diff.</th>
					 	<th>Deno In</th>
					 	<th>Deno Out</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
					 	 $inHand = 0;
					 	// print_r($opBal);
					 	foreach ($opBal as $row) ///Op Bal of this month
						{
							echo "<tr>";						//onClick="editThis(this);
						 	echo "<td style='display:none;'>000</td>";
						 	echo "<td>".date('01-m-Y')."</td>";
						 	echo "<td>".$row['in']."</td>";
						 	echo "<td>".$row['out']."</td>";
						 	$inHand = $row['out'] - $row['in'];
						 	echo "<td style='color:red;'>".$inHand."</td>";
						 	echo "<td>OPENING OF THIS MONTH</td>";
						 	$dayDiff = $row['out'] - $row['in'];
						 	echo "<td>".$dayDiff."</td>";
						 	echo "<td></td>";
						 	echo "<td></td>";
							echo "</tr>";
						}
						foreach ($records as $row) 
						{
						 	$rowId = $row['rowId'];
						 	echo "<tr>";						//onClick="editThis(this);
						 	echo "<td style='display:none;'>".$row['rowId']."</td>";
						 	$vdt = strtotime($row['dt']);
							$vdt = date('d-M-Y', $vdt);
						 	echo "<td>".$vdt."</td>";
						 	echo "<td>".$row['in']."</td>";
						 	echo "<td>".$row['out']."</td>";
						 	$inHand = $inHand - $row['in'] + $row['out'];
						 	// echo $inHand . " # ";
						 	echo "<td style='color:red;'>".$inHand."</td>";
						 	echo "<td>".$row['remarks']."</td>";
						 	$dayDiff = $row['out'] - $row['in'];
						 	echo "<td>".$dayDiff."</td>";
						 	echo "<td>".$row['denominationIn']."</td>";
						 	echo "<td>".$row['denominationOut']."</td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>

		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<div id="divTable" style="border:1px solid lightgray; padding: 10px;height:470px; overflow:auto;">
				<table class='table table-bordered' id='tblCalc'>
				 <thead>
					 <tr>
					 	<th>Note</th>
					 	<th>Count</th>
					 	<th>Value</th>
					 </tr>
				 </thead>
				 <tbody>
				 	<tr>
				 		<td class="clsNote">2000</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">500</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">200</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">100</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">50</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">20</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">10</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">5</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">2</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td class="clsNote">1</td>
				 		<td class="clsCount" contenteditable="true">0</td>
				 		<td class="clsValue">0</td>
				 	</tr>
				 	<tr>
				 		<td colspan="2">TOTAL</td>
				 		<td id="idTotal" style="color: red;">0</td>
				 	</tr>

				 </tbody>
				</table>
			</div>
			
		</div>
	</div>

	<div class="row" style="margin-top:0px;" >
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<?php
					echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
					echo "<input type='button' onclick='loadData();' value='Load All' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
		      	?>
	      	</div>
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="margin-top: 20px;">
					<label id='lblUpiCollection' style='color: red; font-weight: normal;'>UPI Collection (Today): <?php echo $upiCollection[0]['amt'] ?> </label>
					<label id='lblTotalCollection' style='color: blue; font-weight: normal; font-size: 12pt;'>Total Collection (Today): <?php echo $dayDiff + $upiCollection[0]['amt'] ?> </label>
			</div>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:170px; overflow:auto;">
				<table class='table table-hover' id='tblNet'>
					<tr>
					 	<th>Desc</th>
					 	<th>Amt</th>
					</tr>
					<?php 
					 	$plusSum = 0;
						foreach ($plusDues as $item) {
						    $plusSum += $item['balance'];
						}
						$minusSum = 0;
						foreach ($minusDues as $item) {
						    $minusSum += $item['balance'];
						}
						// echo $sum;
							echo "<tr>";						
						 	echo "<td>IN HAND</td>";
						 	echo "<td>".$inHand."</td>";
							echo "</tr>";

							echo "<tr>";						
						 	echo "<td>PLUS SUM</td>";
						 	echo "<td>".$plusSum."</td>";
							echo "</tr>";

							echo "<tr>";						
						 	echo "<td>MINUS SUM</td>";
						 	echo "<td>".$minusSum."</td>";
							echo "</tr>";

							$net = $inHand + $plusSum + $minusSum;
							echo "<tr>";						
						 	echo "<td>NET</td>";
						 	echo "<td>".$net."</td>";
							echo "</tr>";

							echo "<tr>";						
						 	echo "<td>Purchase (Cur.Date)</td>";
						 	// echo "<td>". print_r($purchaseSum)."</td>";
						 	if(count($purchaseSum) > 0 )
						 	{
						 		echo "<td>".$purchaseSum[0]['amt']."</td>";
						 	}
						 	else
						 	{
						 		echo "<td></td>";
						 	}
							echo "</tr>";

							echo "<tr>";						
						 	echo "<td>Payments (Cur.Date)</td>";
						 	// echo "<td>". print_r($purchaseSum)."</td>";
						 	if(count($paymentsSum) > 0 )
						 	{
						 		echo "<td>".$paymentsSum[0]['amt']."</td>";
						 	}
						 	else
						 	{
						 		echo "<td></td>";
						 	}
							echo "</tr>";
					?>
				</table>
			</div>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
				echo "<input type='button' onclick='exportData();' value='Export Data' id='exportData' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				$this->load->helper('form');
				echo form_open('Backupdata_Controller/dbbackup');
				
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
				echo "<input type='submit' value='Data Backup' id='btnBackupData' class='btn btn-danger col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
				echo "<br />";
				echo "<br />";
				// echo "<input type='button' onclick='importData();' value='Excel' id='btnImport' class='btn btn-danger form-control'>";
				echo form_close();
			?>
		</div>



	</div>
	<div class="row">
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
					echo form_input('txtDateDelete', '', "class='form-control' id='txtDateDelete' style='' maxlength=11 autocomplete='off' placeholder='date'");
	          	?>
	          	<script>
					$( "#txtDateDelete" ).datepicker({
						dateFormat: "dd-M-yy",changeMonth: true,changeYear: true,yearRange: "2010:2050"
					});
					// Set the 1st of this month
					// $("#txtDateDelete").val(dateFormat(new Date()));
				</script>	
	      	</div>
			<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<?php
					echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
					echo "<input type='button' onclick='deleteOldData();' value='Delete Old Data' id='btnLoadAll' class='btn btn-block btn-danger' onclick='deleteOldData();'>";
		      	?>
			</div>
		</div>
</div>

<!-- delete -->
<script type="text/javascript">
	function deleteOldData()
	{	
		dt = $("#txtDateDelete").val().trim();
		dtOk = testDate("txtDateDelete");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#txtDateDelete").focus();
			return;
		}
		$.ajax({
				'url': base_url + '/' + controller + '/deleteOldData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dt': dt
							, 'dtFrom': 'dtFrom'
							, 'dtTo': 'dtTo'
						},
				'success': function(data)
				{
					if(data == "This Date Not Found")
					{
						msgBoxError("Error","This date not in database...");
					}
					else
					{
						alert("Done... Page will be reloaded...");
						location.reload();
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



<script type="text/javascript">
	function loadData()
	{	
		$.ajax({
				'url': base_url + '/' + controller + '/showDataAll',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'customerRowId': 'customerRowId'
							, 'dtFrom': 'dtFrom'
							, 'dtTo': 'dtTo'
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
							setTable( data['records'], data['opBal']={} ); 
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
		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			    ordering: false
			});

			var rowpos = $('#tbl1 tr:last').position();
			$('#divTable').scrollTop(rowpos.top);
			// console.log(rowpos)

			$("#tbl1 tr").off();
			$("#tbl1 tr").on("click", highlightRowAlag);

			$(".clsCount").on("keyup", calculateNotes)

			$("#txtAmt").on("keyup", function(){
				var netInWords = number2text( parseFloat( $("#txtAmt").val() ) ) ;
			  	$("#spanInWords").text( netInWords );
			  });

		} );



		function calculateNotes()
		{
			var note = $(this).prev().text();
			var noteCount = $(this).text();
			var noteValue = note * noteCount 
			// alert(note + "  " + noteCount);
			$(this).next().text(noteValue);

			var sum = 0;
			// iterate through each td based on class and add the values
			$(".clsValue").each(function() {

			    var value = $(this).text();
			    // add only if the value is number
			    if(!isNaN(value) && value.length != 0) {
			        sum += parseFloat(value);
			    }
			});
			$("#idTotal").text(sum);
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
		             "rowId" : $(tr).find('td:eq(0)').text()
		            , "dt" :$(tr).find('td:eq(1)').text()
		            , "in" :$(tr).find('td:eq(2)').text()
		            , "out" :$(tr).find('td:eq(3)').text()
		            , "inHand" :$(tr).find('td:eq(4)').text()
		            , "remarks" :$(tr).find('td:eq(5)').text()
	        	}   
	        	i++; 
	        // }
	    }); 
	    // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i-1;
	    return TableData;
	}


	function exportData()
	{	
		// alert();
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		// alert(JSON.stringify(TableData));
		// return;

		

		$.ajax({
				'url': base_url + '/' + controller + '/exportData',
				'type': 'POST',
				// 'dataType': 'json',
				'data': {
							'TableData': TableData
						},
				'success': function(data)
				{
					if(data)
					{
						window.location.href=data;
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

<script type="text/javascript">
	
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

</script>