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
	var controller='Recharge_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Recharge";

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
	          cell.innerHTML = records[i].rechargeRowId;

	          var cell = row.insertCell(1);
	          cell.innerHTML = records[i].device;
	          var cell = row.insertCell(2);
	          cell.innerHTML = records[i].op;
	           var cell = row.insertCell(3);
	          cell.innerHTML = records[i].opName;
	          var cell = row.insertCell(4);
	          cell.innerHTML = records[i].id;
	          var cell = row.insertCell(5);
	          cell.innerHTML = records[i].amt;
	          var cell = row.insertCell(6);
	          cell.innerHTML = records[i].status;
	          var cell = row.insertCell(7);
	          cell.innerHTML = "<button class='clsStatus btn btn-success form-control'>Status</button>";
	          var cell = row.insertCell(8);
	          cell.innerHTML = records[i].createdStamp;
	          var cell = row.insertCell(9);
	          cell.innerHTML = records[i].previousBalance;
	          var cell = row.insertCell(10);
	          cell.innerHTML = records[i].tag;
	  	  }


		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
            ordering: false
		});
		} );

		$("#tbl1 tr").on("click", highlightRow);
		$(".clsStatus").on('click', getRechargeStatus);
			
	}
	
	
	function saveData()
	{	
		// $("#lblBal").text("123.4567|234");
		// var previousBalance= ($("#lblBal").text().substr(3, $("#lblBal").text().lastIndexOf('|')));
		var previousBalance= $("#lblBal").text();
		// console.log(previousBalance);
		// return; 

		// $('#myModal').modal('show');
		// if(vgSureRecharge == "No")
		// {
		// 	vgSureRecharge="";
		// 	return;
		// }

		// alert("Sure h");
		// return;

		device = $("#cboDevice").val();
		if(device == "-1")
		{
			msgBoxError("Error", "Select device...");
			return;
		}
		if(device == "Mobile")
		{
    		op = $("#cboOperator").val();
    		if(op == "-1")
    		{
    			msgBoxError("Error", "Select operator...");
    			return;
    		}
    		opName = $("#cboOperator option:selected").text();
		}
		else if(device == "TV")
		{
    		op = $("#cboOperatorTv").val();
    		if(op == "-1")
    		{
    			msgBoxError("Error", "Select operator...");
    			return;
    		}
    		opName = $("#cboOperatorTv option:selected").text();
		}
		
		deviceId = $("#txtId").val().trim();
		if(deviceId == "")
		{
			msgBoxError("Error", "Type Device Id / Mob No...");
			return;
		}
		amt = $("#txtAmt").val();
		if(amt <= 0)
		{
			msgBoxError("Error", "Invalid Amt.");
			return;
		}
		tag = $("#txtTag").val().trim();

	

		if($("#btnSave").val() == "Recharge Now")
		{
			// alert("save");
			$.ajax({
					'url': base_url + '/' + controller + '/insert',
					'type': 'POST',
					'dataType': 'json',
					'data': {
								'device': device
								, 'op': op
								, 'opName': opName
								, 'deviceId': deviceId
								, 'amt': amt
								, 'previousBalance': previousBalance
								, 'tag': tag
							},
					'success': function(data)
					{
						if(data)
						{
							
							setTable(data['records']) ///loading records in tbl1
							alertPopup('Record saved...', 4000);
							blankControls();
							// var balance='<?php echo $balance ?>';
							var x = data['balance'];
							console.log(data['balance']);
		                	$("#lblBal").text(" "+ x.substr(2, (x.lastIndexOf('|')-2) ).replace(/\,/g,'') ); //replace to remove comma
			                // $("#lblBal").text(" "+ balance );
							$("#txtDevice").focus();
							// location.reload();
							
						}
							
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
						// msgBoxDone("Done...", "Records loaded...")
						alertPopup('Records loaded...', 4000);
						blankControls();
						$("#txtItemName").focus();
					}
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
	}
</script>
<div class="container-fluid" style="width:95%;">
	<div class="row">
		<!-- <div class="col-lg-4 col-sm-4 col-md-4 col-xs-0">
		</div> -->
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div class="row" style="margin-top:2px;">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<?php
						echo form_input('txtTag', '', "class='form-control' id='txtTag' style='' maxlength=20");
	              	?>
				</div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<h4 class="text-center">Recharge</h4>
				</div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
				</div>
			</div>
			<div class="row" style="margin-top:25px;">
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<?php
					   // print_r($balance);
						$device = array();
						$device['-1'] = '--- Select ---';
						$device['Mobile'] = "Mobile";
						$device['TV'] = "TV";
						echo "<label style='color: black; font-weight: normal;'>Device: </label>";
						echo form_dropdown('cboDevice', $device, '-1', "class='form-control' id='cboDevice'");
	              	?>
	          	</div>
	          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" id="divMobile" style="display:none;">
					<?php
						$operator = array();
						$operator['-1'] = '--- Select ---';
						$operator['1'] = "Airtel";
						$operator['2'] = "Vodafone";
						$operator['4'] = "BSNL STV";
						$operator['10'] = "Idea";
						$operator['26'] = "Jio";
						$operator['5'] = "BSNL";
						$operator['6'] = "BSNL Recharge";

						echo "<label style='color: black; font-weight: normal;'>Operator: </label>";
						echo form_dropdown('cboOperator', $operator, '-1', "class='form-control' id='cboOperator'");
	              	?>
	          	</div>
	          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" id="divTv" style="display:none;">
					<?php
						$TVs = array();
						$TVs['-1'] = '--- Select ---';
						$TVs['34'] = "Airtel DTH";
						$TVs['35'] = "Dish TV";
						$TVs['31'] = "Tata Sky";
						$TVs['33'] = "Videocon D2H";

						echo "<label style='color: black; font-weight: normal;'>Operator: </label>";
						echo form_dropdown('cboOperatorTv', $TVs, '-1', "class='form-control' id='cboOperatorTv'");
	              	?>
	          	</div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Mob. No./ TV.ID:</label>";
						echo form_input('txtId', '', "class='form-control' id='txtId' style='color:red; font-size:20pt;letter-spacing:3px;' maxlength=20 autocomplete='off'");
	              	?>
	          	</div>
	          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Amt.:</label>";
						echo "<label style='color: black; font-weight: normal; color:red;' id='lblBal'></label>";
						echo '<input type="number" value="" name="txtAmt" class="form-control" maxlength="4" id="txtAmt" />';
	              	?>
	          	</div>
	          	<div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
	          	</div>
	          	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
						echo "<input type='button' onclick='setSureValues();' data-toggle='modal' data-target='#myModal' value='Recharge Now' id='btnSave' class='btn btn-primary form-control'>";
	              	?>
	          	</div>
			</div>

			<div class="row" style="margin-top:1px;">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					
				</div>
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
				</div>
				
			</div>
		</div>
	</div>


	<div class="row" style="margin-top:40px;" >
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:400px; overflow:auto;">
				<table class='table table-hover' id='tbl1'>
				 <thead>
					 <tr>
						<th style='width:0px;display:none1;'>rowid</th>
					 	<th>Device</th>
					 	<th>Op.</th>
					 	<th>Op Name</th>
					 	<th>ID</th>
					 	<th>Amt</th>
					 	<th>Status</th>
					 	<th>Get Status</th>
					 	<th>Stamp</th>
					 	<th>Prev. Bal.</th>
					 	<th>Tag</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php 
					 	// print_r($records)
						foreach ($records as $row) 
						{
						 	$rowId = $row['rechargeRowId'];
						 	echo "<tr>";						
						 	echo "<td style='width:0px;display:none1;'>".$row['rechargeRowId']."</td>";
						 	echo "<td>".$row['device']."</td>";
						 	echo "<td>".$row['op']."</td>";
						 	echo "<td>".$row['opName']."</td>";
						 	echo "<td>".$row['id']."</td>";
						 	echo "<td>".$row['amt']."</td>";
						 	echo "<td>".$row['status']."</td>";
						 	echo "<td><button class='clsStatus btn btn-success form-control'>Status</button></td>";
						 	echo "<td>".$row['createdStamp']."</td>";
						 	echo "<td>".$row['previousBalance']."</td>";
						 	echo "<td>".$row['tag']."</td>";
							echo "</tr>";
						}
					 ?>
				 </tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:20px;" >
		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<input type='button' onclick='checkBal()' value='Check Balance' id='btnCheckBalance' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<?php
				echo "<input type='button' onclick='loadAllRecords();' value='Load All Records' id='btnLoadAll' class='btn form-control' style='background-color: lightgray;'>";
	      	?>
		</div>
		
	</div>
</div>

<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Recharge:</h4>
        </div>
        <div class="modal-body">
          <p id="divSure">Are you sure <br /> Delete this record..?</p>
        </div>
        <div class="modal-footer">
        	<div class="row">
        		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
	          		<button type="button" onclick="saveData();" class="btn btn-danger btn-block" data-dismiss="modal">Continue</button>
	          	</div>
        		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
	          		<button type="button" class="btn btn-default btn-block" data-dismiss="modal">No</button>
	          	</div>
      		</div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
	function setSureValues()
	{
		if( $("#cboDevice").val() == "Mobile" )
		{
			$("#divSure").html( "<span style='color:red; font-size:24pt;'>" + $("#cboDevice").val() + "</span><br />" );
			$("#divSure").html( $("#divSure").html() + "<span style='color:green; font-size:24pt;'>" + $("#cboOperator option:selected").text() + "</span><br />" );
			$("#divSure").html( $("#divSure").html() + "<span style='color:blue; font-size:24pt;'>" + $("#txtId").val() + "</span><br />" );
			$("#divSure").html( $("#divSure").html() + "<span style='color:red; font-size:36pt;'>Rs. " + $("#txtAmt").val() + "</span><br />" );
		}
		else if( $("#cboDevice").val() == "TV" )
		{
			$("#divSure").html( "<span style='color:red; font-size:24pt;'>" + $("#cboDevice").val() + "</span><br />" );
			$("#divSure").html( $("#divSure").html() + "<span style='color:green; font-size:24pt;'>" + $("#cboOperatorTv option:selected").text() + "</span><br />" );
			$("#divSure").html( $("#divSure").html() + "<span style='color:blue; font-size:24pt;'>" + $("#txtId").val() + "</span><br />" );
			$("#divSure").html( $("#divSure").html() + "<span style='color:red; font-size:36pt;'>Rs. " + $("#txtAmt").val() + "</span><br />" );
		}
	}
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
					// var parser, xmlDoc;
     //                var text = data;
					// parser = new DOMParser();
     //                xmlDoc = parser.parseFromString(text,"text/xml");
                    
     //                var x = xmlDoc.getElementsByTagName("string")[0].childNodes[0].nodeValue;
     				var x = data;
     				// console.log(x);
					// $("#lblBal").val(" "+ x );
                	$("#lblBal").text(" "+ x.substr(2, (x.lastIndexOf('|')-2) ).replace(/\,/g,'') ); //replace to remove comma
				}
			},
				'error': function(jqXHR, exception)
		          {
		            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
		            $("#modalAjaxErrorMsg").modal('toggle');
		          }
		});

	}	

	function getRechargeStatus()
	{
		rowIndex = $(this).parent().parent().index();
		rowId = $(this).closest('tr').children('td:eq(0)').text();
		$.ajax({
			'url': base_url + '/' + controller + '/getStatus',
			'type': 'POST',
			'dataType': 'json',
			'data': {'rowId': rowId},
			'success': function(data)
			{
				if(data)
				{
					setTable(data['records']);
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
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			    ordering: false
			});

			$(".clsStatus").on('click', getRechargeStatus);
			$("#cboDevice").on('change', setOperators);
            
            	var balance='<?php echo $balance ?>';
                // alert(balance);
                //$("#lblBal").text().substr(3, $("#lblBal").text().lastIndexOf('|'))
                // $("#lblBal").text(" "+ balance );
                $("#lblBal").text(" "+ balance.substr(2, (balance.lastIndexOf('|')-2) ).replace(/\,/g,'') ); //replace to remove comma
		} );
		
	function setOperators()
	{
		// console.log($("#cboDevice").val());
	    var d = $("#cboDevice").val();
	    if(d == "-1")
	    {
	        $('#divMobile').css("display", "none");
	        $('#divTv').css("display", "none");
	       
	        $('#divMobile').val("-1");
	        $('#divTv').val("-1");
	    }
	    else if(d == "Mobile")
	    {
	        $('#divMobile').css("display", "block");
	        $('#divTv').css("display", "none");
	        $('#divMobile').val("-1");
	        $('#divTv').val("-1");
	    }
	    else if(d == "TV")
	    {
	        $('#divMobile').css("display", "none");
	        $('#divTv').css("display", "block");
	        $('#divMobile').val("-1");
	        $('#divTv').val("-1");
	    }
	}



	$(document).ready( function () 
	{
		select = false;
		var jSonArray = '<?php echo json_encode($puraneNo); ?>';
		// alert(jSonArray);
		var jSonArray = jSonArray.replace(/(\r\n|\n|\r)/gm,", "); ///Multilinse of Address field with comma replce
		var availableTags = $.map(JSON.parse(jSonArray), function(obj){
					return{
							label: obj.id,
							customerRowId: obj.id,
					}
		});

	    $( "#txtId" ).autocomplete({
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
			    $("#txtId").val( ui.item.id );
	        	}
		    }).blur(function() {
				  
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
    } );




	$(document).ready( function () 
	{
		select = false;
		var jSonArray = '<?php echo json_encode($tagList); ?>';
		var jSonArray = jSonArray.replace(/(\r\n|\n|\r)/gm,", "); ///Multilinse of Address field with comma replce
		var availableTags = $.map(JSON.parse(jSonArray), function(obj){
					return{
							label: obj.tag,
							device: obj.device,
							op: obj.op,
							deviceId: obj.id,
							amt: obj.amt
					}
			});
		// console.log(availableTags);
		    $(function() {
	        $( "#txtTag" ).autocomplete({
	  			open: function(event, ui) { if(select) select=false; },
	            source: function(request, response) {
	                
	                var aryResponse = [];
	                var arySplitRequest = request.term.split(" ");
	                // alert(JSON.stringify(arySplitRequest));
	                for( i = 0; i < availableTags.length; i++ ) {
	                    var intCount = 0;
	                    for( j = 0; j < arySplitRequest.length; j++ ) {
	                        regexp = new RegExp(arySplitRequest[j], 'i');
	                        var test = JSON.stringify(availableTags[i].label.toLowerCase()).match(regexp);

	                        
	                        if( test ) {
	                            intCount++;
	                        } else if( !test ) {
	                        intCount = arySplitRequest.length + 1;
	                        }
	                        if ( intCount == arySplitRequest.length ) {
	                            aryResponse.push( availableTags[i] );
	                        }
	                    };
	                }
	                response(aryResponse);
	            },
	  			selectFirst: true,
      			minLength: 0,
	            select: function (event, ui) {
			      	select = true;
				    var selectedObj = ui.item; 
		    		$("#cboDevice").val( ui.item.device );
		    		$("#cboDevice").trigger("change");
		    		$("#txtId").val( ui.item.deviceId );
		    		$("#txtAmt").val( ui.item.amt );

		    		if( ui.item.device == "Mobile" )
		    		{
		    			// console.log(ui.item.op + " " + ui.item.device);
      					$("#cboOperator").val( ui.item.op );
		    		}
		    		else
		    		{
		    			// console.log(ui.item.op + " " + ui.item.device);
      					$("#cboOperatorTv").val( ui.item.op );
		    		}
		    		// console.log(ui.item.op);
	        	}

	        }).blur(function() {
				  if( !select ) 
				  {
				  	// $("#lblItemId").text('-1');
				  	// $("#tbl1").find("tr:eq(" + rowIndex + ")").find("td:eq(1)").css("color", "red");
				  }
				  	if( $("#lblItemId").text() == '-1' )
				  	{
				  	}
				  	else
				  	{
				  	}
				}).focus(function(){            
			            $(this).autocomplete("search");
			        });
	    });
    } );
    
    $(function() {
    	$("#txtTag").click(function() {
           $(this).select();
        });
    });
</script>