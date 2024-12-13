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

	#txtDate {position: relative; z-index:101;}
	#txtDueDate {position: relative; z-index:101;}
</style>
<script type="text/javascript">
	var controller='SendSms_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Send SMS";
	
	function setTable(records)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl1").empty();
		  // $("#tbl1").find("tr:gt(0)").remove();
	      var table = document.getElementById("tbl1");
	      for(i=0; i<records.length; i++)
	      {
	          newRowIndex = table.rows.length;
	          row = table.insertRow(newRowIndex);

	          var cell = row.insertCell(0);
	          // cell.style.display="none";
	          cell.innerHTML = records[i].smsRowId;
	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].customerRowId;
	          cell.style.display="none";
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].customerName;
	          var cell = row.insertCell(3);
	          cell.innerHTML = records[i].smsData;
	  	  }



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
	
	function sendSms()
	{	
		customerRowId = $("#lblCustomerId").text();
		customerName = $("#txtCustomerName").val().trim();
		if(customerName == "" )
		{
			msgBoxError("Error", "Invalid customer name...");
			// alertPopup("Invalid customer name...", 5000, 'red');
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
		smsData = $("#txtSms").val().trim();
		if(smsData == "" )
		{
			msgBoxError("Error", "No text to send...");
			return;
		}

		if($("#btnSendSms").val() == "Send SMS")
		{
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					// 'dataType': 'json',
					'data': {
								'customerRowId': customerRowId
								, 'customerName': customerName
								, 'mobile1': mobile1
								, 'address': address
								, 'customerRemarks': customerRemarks
								, 'smsData': smsData
							},
					'success': function(data)
					{
						alert("Msg sent...");
						location.reload();
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
						setTable(data['records']);
						alertPopup('Records loaded...', 4000);
						// blankControls();
						// $("#txtBookName").focus();
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
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<h3 class="text-center" style='margin-top:-7px;'>Send SMS</h3>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-right">
			<label style='font-size: 16pt;margin-top: -20px;' id='lblNewOrOld'><span id='spanNewOrOld' class='label label-danger'>New Customer</span></label>
		</div>
	</div>
	 
	<div class="row" style="background-color: #F0F0F0; padding-top: 10px; padding-bottom: 10px;" >
		
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Customer Name:</label>";
				echo "<label style='color: lightgrey; font-weight: normal;' id='lblCustomerId'></label>";
				// <h4>Example <span class="label label-default">New</span></h4>
				echo form_input('txtCustomerName', '', "class='form-control' id='txtCustomerName' style='' maxlength=70 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Mobile No.:</label>";
				echo form_input('txtMobile', '', "class='form-control' id='txtMobile' style='' maxlength=10 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Address:</label>";
				echo form_input('txtAddress', '', "class='form-control' id='txtAddress' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
		<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>Customer Remarks:</label>";
				echo form_input('txtCustomerRemarks', '', "class='form-control' id='txtCustomerRemarks' style='' maxlength=100 autocomplete='off'");
          	?>
      	</div>
	</div>

	<div class="row" style="background-color: #c6F6F0; padding-top: 10px; padding-bottom: 10px;margin-top: 20px;" >
		<div class="col-lg-7 col-sm-7 col-md-7 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>SMS:</label>";
				echo form_textarea('txtSms', "\n\nRegards,\nSEACO TECH\n1234569900", "class='form-control' style='resize:none;height:100px;' id='txtSms'  maxlength=319");
          	?>
      	</div>
		<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
				echo "<input type='button' onclick='sendSms();' value='Send SMS' id='btnSendSms' class='btn form-control btn-primary' >";
	      	?>
		</div>
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			<?php
				echo "<label style='color: black; font-weight: normal;'>&nbsp;</label>";
				echo "<input type='button' onclick='checkBal();' value='Check Balance' id='btnCheckBalance' class='btn btn-information col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
			?>
		</div>

	</div>

	<div class="row"  style="margin-top: 25px;">
		<div id="tbl11" class="divTable tblScroll" style="border:1px solid lightgray; height:300px; overflow:auto;">
			<table class='table table-hover' id='tbl1'>
			 <thead>
				 <tr>
					<th style='display:none1;'>rowId#</th>
				 	<th style='display:none;'>customerRowId</th>
				 	<th>Customer Name</th>
				 	<th>SMS</th>
				 </tr>
			 </thead>
			 <tbody>
				 <?php 
					foreach ($records as $row) 
					{
					 	$rowId = $row['smsRowId'];
					 	echo "<tr>";						//
					 	echo "<td style='width:0px;display:none1;'>".$row['smsRowId']."</td>";
					 	echo "<td style='display:none;'>".$row['customerRowId']."</td>";
					 	echo "<td>".$row['customerName']."</td>";
					 	echo "<td>".$row['smsData']."</td>";
						echo "</tr>";
					}
				 ?>
			 </tbody>
			</table>
		</div>
	</div>

	<div class="row" style="margin-top:20px;margin-bottom:20px;" >
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-0">
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<input type='button' onclick='loadAllRecords();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>

	</div>


	<hr size="15px" color="red" />


	<div class="row" style="margin-top:20px;margin-bottom:20px;" >
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-0">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-0">
				<?php
					echo "<input type='button' onclick='loadAllMobiles();' value='Load All Mobiles (AddressBook, Cust, Recharge)' id='btnLoadAllMobiles' class='btn form-control btn-danger'>";
		      	?>
			</div>
			
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-0" style="margin-top: 40px;">
				<?php
					echo "<input type='button' onclick='exportDataMobile();' value='Export only Mobile No.' id='btnExportAll' class='btn form-control' style='background-color: lightgray;'>";
				?>
			</div>
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-0">
			<div id="divMobilesOnly" class="divTable tblScroll" style="border:1px solid lightgray; height:300px; overflow:auto;">
				<table class='table table-hover' id='tblMobilesOnly'>
				 <thead>
					 <tr>
					 	<th>Mob. No.</th>
					 </tr>
				 </thead>
				 <tbody>
				 	<tr>
					 	<td>Mob. No.</td>
					</tr>
				 </tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-0">
		</div>
		
	</div>

</div> <!-- CONTAINER CLOSE -->


		  

<script type="text/javascript">
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
							remarks: obj.remarks
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
					    $("#txtMobile").val( '' );
					    $("#txtAddress").val( '' );
					    $("#txtCustomerRemarks").val( '' );

				  	}
				  	else
				  	{
				  		$("#spanNewOrOld").text("Old Customer");
				  		$("#spanNewOrOld").removeClass("label-danger");
				  		$("#spanNewOrOld").addClass("label-success");
				        $("#spanNewOrOld").animate({opacity: '0.2'}, 1000);
				        $("#spanNewOrOld").animate({opacity: '1'}, 1000);
				  	}
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );

  </script>


  <script type="text/javascript">
	function checkBal()
	{
		$.ajax({
			'url': base_url + '/' + controller + '/checkBal',
			'type': 'POST',
			'data': {'Ta': 'Ta'},
			'success': function(data)
			{
				if(data)
				{
					// alert(data);
					$("#btnCheckBalance").val("Check Balance ("+ data +")");
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
		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    ordering: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});

			myDataTableMobiles = $('#tblMobilesOnly').DataTable({
			    paging: false,
				order: [[ 0, "asc" ]],
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
		} );


		function loadAllMobiles()
		{
			$.ajax({
				'url': base_url + '/' + controller + '/loadAllMobiles',
				'type': 'POST',
				'dataType': 'json',
				'success': function(data)
				{
					// alert(JSON.stringify(data));
					if(data)
					{
						// setTableMobiles(data);
						setTableMobiles(data['ab'], data['cust'], data['recharge']);
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

		function setTableMobiles(ab, cust, recharge)
		{
			$("#tblMobilesOnly").empty();
			  // $("#tbl1").find("tr:gt(0)").remove();
		      var table = document.getElementById("tblMobilesOnly");
		      ////AddressBook Data
		      for(i=0; i<ab.length; i++)
		      {
		      	if( isNaN(ab[i].mobile) == false && parseInt(ab[i].mobile)>999999999 )
		      	{
		          newRowIndex = table.rows.length;
		          row = table.insertRow(newRowIndex);

		          var cell = row.insertCell(0);
		          cell.innerHTML = ab[i].mobile;
		        }
		  	  }

		  	  //// Customer Data
		  	  for(i=0; i<cust.length; i++)
		      {
		      	if( isNaN(cust[i].mobile1) == false && parseInt(cust[i].mobile1)>999999999 )
		      	{
		          newRowIndex = table.rows.length;
		          row = table.insertRow(newRowIndex);

		          var cell = row.insertCell(0);
		          cell.innerHTML = cust[i].mobile1;
		        }
		  	  }

		  	  //// Recharge Data
		  	  for(i=0; i<recharge.length; i++)
		      {
		      	if( isNaN(recharge[i].id) == false && parseInt(recharge[i].id)>999999999 )
		      	{
		          newRowIndex = table.rows.length;
		          row = table.insertRow(newRowIndex);

		          var cell = row.insertCell(0);
		          cell.innerHTML = recharge[i].id;
		        }
		  	  }



			myDataTableMobiles.destroy();
			$(document).ready( function () {
			    myDataTableMobiles=$('#tblMobilesOnly').DataTable({
				    paging: false,
				    order: [[ 0, "asc" ]],
				    iDisplayLength: -1,
				    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
				});


				///////// Marking Duplicate
				found = 0;
				x="";
				$('#tblMobilesOnly tbody tr').each(function(row, tr)
			    {
			    	// alert();
			    	if(row >=0 )
			    	{
			    		x = $(this).find('td:eq(0)').text().toUpperCase().trim();
			    		y = $(this).next().find('td:eq(0)').text().toUpperCase().trim();
			    		
				    	if( x == y )
				    	{
				    		$(this).css({'color':'blue'});
				    		$(this).next().css({'color':'red'});
				    		found++;
				    		$(this).remove();
				    	}
			    	}
			    });
			    // alert(x);
			    // alert(found + " Duplicates found " + $('#tblMobilesOnly tbody tr').length);
			    // alert( $('#tblMobilesOnly tbody tr').length);

			    
			}); ////Doc ready ends here

		}

	function storeTblValuesMobile()
	{
	    var TableData = new Array();
	    var i=0;
	    $('#tblMobilesOnly tr').each(function(row, tr)
	    {
	    	// if( $(tr).find('td:eq(5)').text().length > 0 && $(tr).find('td:eq(5)').text() > 1 )
	    	{
	        	TableData[i]=
	        	{
		            "mobile" :$(tr).find('td:eq(0)').text().substr(0, 10)
	        	}   
	        	i++; 
	        }
	    }); 
	    // TableData.shift();  // NOT first row will be heading - so remove COZ its dataTable
	    tblRowsCount = i-1;
	    return TableData;
	}
	function exportDataMobile()
	{	
		// alert();
		var TableData;
		TableData = storeTblValuesMobile();
		TableData = JSON.stringify(TableData);
		// alert(JSON.stringify(TableData));
		// return;
		if(tblRowsCount == 0)
		{
			alertPopup("No data...", 8000);
			return;
		}


		$.ajax({
				'url': base_url + '/' + controller + '/exportDataMobile',
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
						document.write(jqXHR.responseText);
					}
		});
		
	}	

  </script>