<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript">
	var controller='Backupdata_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Backup";

	function importData()
	{	
		// alert("DDD");
		$.ajax({
				'url': base_url + '/' + controller + '/frmExcel',
				'type': 'POST',
				'data': {'bankaccount' : 1},
				'success': function(data){
					if(data){
						alert(data);
					}
				}
		});
	}
	function backupData()
	{	
		// alert("FFF");
		$.ajax({
				'url': base_url + '/' + controller + '/dbbackup',
				'type': 'POST',
				'data': {'bankaccount' : 1},
				'success': function(data){
					if(data){
						alert(data);
					}
				}
		});
	}


</script>

	<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
		<?php
			echo "Codeigniter version: " . CI_VERSION;
			echo '<br />Current PHP version: ' . phpversion();
		?>
	<div id="divVersion"></div>
	
		<script type="text/javascript">
			if (typeof jQuery != 'undefined') {  
			    // jQuery is loaded => print the version
			    // alert(jQuery.fn.jquery);
			    $("#divVersion").text("jQuery Version: " + jQuery.fn.jquery);
			    $(function () {
				    $.get("<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css", function (data) {
				        var version = data.match(/v[.\d]+[.\d]/);
				        // alert(version);
				        $("#divVersion").append("<br/>Bootstrap Version: " + version);
				    });
				});
			}
		</script>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style='border:1px solid lightgray; border-radius:10px; padding: 10px;'>
		<h1 class="text-center" style='margin-top:0px'>Backup Data</h1>
		<?php

			$this->load->helper('form');
			echo form_open('Backupdata_Controller/dbbackup');
			
			echo "<input type='submit' value='Click Here For Data Backup' id='btnBackupData' class='btn btn-danger col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
			echo "<br />";
			echo "<br />";
			// echo "<input type='button' onclick='importData();' value='Excel' id='btnImport' class='btn btn-danger form-control'>";
			echo form_close();
		?>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0" style="display: none;">
		<button onclick="createTable();">Session</button>
		<button onclick="doEmail();">Demo Email</button>
		<button onclick="alterDb();">Alter DB</button>
		<button onclick="deleteOldPdfs();">Delete Old PDFs (Before 90 days)</button>
		<button onclick="copyItems();">Copy items (for too any data test)</button>
	</div>
	</div>
	<hr>

	<div class="row"  style="margin:10px; padding: 10px;">
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style='margin-top: 10px; padding-right: 1px; padding-left: 1px;'>
			<label class='jktLabel'>EAN 12 Digits</label>
			<input type='text' class='form-control' id='txtEanCodeP2' maxlength='12' autocomplete='off'>
		</div>
		<div class="col-lg-1 col-sm-1 col-md-1 col-xs-12" style='margin-top: 10px; padding-left: 1px;'>
			<label class='jktLabel'>13th Digit</label>
			<input type='text' class='form-control' id='txtEanCodeP3' maxlength='10' disabled="yes">
		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12" style='margin-top: 10px; padding-left: 1px;'>
			<label class='jktLabel'>&nbsp;</label>
			<button class="btn btn-block btn-primary" onclick="generateBarCode();">Generate BarCode</button>
		</div>
	</div>

		<br />
	  <div class="table-responsive"  style="background: lightpink; margin:10px; padding: 10px;">
	   <table class="table table-bordered table-striped">
	    <tr>
	     <td><b>IP Address</b></td>
	     <td><?php echo $ip_address; ?></td>
	    </tr>
	    <tr>
	     <td><b>Operating System</b></td>
	     <td><?php echo $os; ?></td>
	    </tr>
	    <tr>
	     <td><b>Browser Details</b></td>
	     <td><?php echo $browser . ' - ' . $browser_version; ?></td>
	    </tr>
	   </table>
	  </div>


	  <div class="container" style="background: lightgrey; display: none;">  
           <div class="container" style="width:700px;">
			   <h4 align="center">Upload File without using Form Submit in Ajax (See SbErp Products for this)</h4>
		  </div>
      </div>  
      <div class="container" style="background: lightgrey;display: none;">  
           <div class="container" style="width:700px;">
           		<input type="file" id="avatar">
			   <button onclick="uploadImage();">Upload File without using Form Submit in Ajax(not working)</button>
		  </div>
      </div>  
      <div class="container text-center" style="background: lightyellow;display: none;" >  
		<h4 align="center">MySql Table to 2D array(PHP,JS)</h4>
		<button id='btnTableToArray' onclick='tableToArray();'>Bring and Show</button>
		<div class="text-left" style="border:1px solid lightgray; padding: 10px;height:300px; overflow:auto;">
			<table id="tblSql" class="table table-bordered">
				<tr>
					<th>SN</th>
					<th>purchaseDetailRowId</th>
					<th>itemRowId</th>
					<th>itemName</th>
					<th>customerRowId</th>
					<th>customerName</th>
				</tr>
			</table>
		</div>
      </div>  

<script type="text/javascript">
	// function uploadImage()
	// {
	// 	// // alert();
	// 	// var link = $("#avatar").val();
	// 	// console.log(link);
	// 	// var dataJson = { id: "hello", link: link };
	// 	// $.ajax({
	// 	// 	'url': base_url + '/' + controller + '/uploadImage',
	// 	// 	'type': 'POST',
	// 	// 	'data': dataJson,
	// 	// 	// 'dataType': 'json',
	// 	// 	'success': function(data){
	// 	// 		if(data){
	// 	// 			// setMySqlTable(data['records']);
	// 	// 			alert(JSON.stringify(data));

	// 	// 		}
	// 	// 	},
	// 	// 	'error': function(jqXHR, exception)
	// 	// 	{
	// 	// 		document.write(jqXHR.responseText);
	// 	// 	}
	// 	// });
	// }

	// function tableToArray()
	// {
	// 	$.ajax({
	// 		'url': base_url + '/' + controller + '/tableToArray',
	// 		'type': 'POST',
	// 		'data': {'bankaccount' : 1},
	// 		'dataType': 'json',
	// 		'success': function(data){
	// 			if(data){
	// 				setMySqlTable(data['records']);
	// 				// alert(JSON.stringify(data));

	// 			}
	// 		},
	// 		'error': function(jqXHR, exception)
	// 		{
	// 			document.write(jqXHR.responseText);
	// 		}
	// 	});
	// }
	// function setMySqlTable(records)
	// {
	// 	$("#tblSql").find("tr:gt(0)").remove();
	//       var table = document.getElementById("tblSql");
	// 		// alert(JSON.stringify(records));
	// 		// alert(records.length);
	//       for(i=0; i<records.length; i++)
	//       {
	//           newRowIndex = table.rows.length;
	//           row = table.insertRow(newRowIndex);

	//           var cell = row.insertCell(0);
	//           cell.innerHTML = i+1;
	//           var cell = row.insertCell(1);
	//           cell.innerHTML = records[i].purchaseDetailRowId;
	//           var cell = row.insertCell(2);
	//           cell.innerHTML = records[i].itemRowId;
	//           var cell = row.insertCell(3);
	//           cell.innerHTML = records[i].itemName;
	//           var cell = row.insertCell(4);
	//           cell.innerHTML = records[i].customerRowId;
	//           var cell = row.insertCell(5);
	//           cell.innerHTML = records[i].customerName;
	//       }
	// }
</script>

<script type="text/javascript">
	// function createTable()
	// {
	// 	$.ajax({
	// 		'url': base_url + '/' + controller + '/createTable',
	// 		'type': 'POST',
	// 		'data': {'bankaccount' : 1},
	// 		'success': function(data){
	// 			if(data){
	// 				alert(data);
	// 			}
	// 		}
	// 	});
	// }


	// function doEmail()
	// {
	//    // alert();
	// 	$.ajax({
	// 		'url': base_url + '/' + controller + '/doEmail',
	// 		'type': 'POST',
	// 		'data': {'bankaccount' : 1},
	// 		'success': function(data){
	// 			//if(data){
	// 				alert("done");
	// 			//}
	// 		}
	// 	});
	// }

	// function alterDb()
	// {
	//    // alert();
	// 	$.ajax({
	// 		'url': base_url + '/' + controller + '/alterDb',
	// 		'type': 'POST',
	// 		'data': {'bankaccount' : 1},
	// 		'success': function(data){
	// 				alert("done");
	// 		}
	// 	});
	// }

	// function deleteOldPdfs()
	// {
	//    // alert();
	// 	$.ajax({
	// 		'url': base_url + '/' + controller + '/deleteOldPdfs',
	// 		'type': 'POST',
	// 		'data': {'bankaccount' : 1},
	// 		'success': function(data){
	// 				alert("done..." + data);
	// 		}
	// 	});
	// }


	// function copyItems()
	// {
	//    // alert();
	// 	$.ajax({
	// 		'url': base_url + '/' + controller + '/copyItems',
	// 		'type': 'POST',
	// 		'data': {'bankaccount' : 1},
	// 		'success': function(data){
	// 				alert("done...");
	// 		}
	// 	});
	// }
</script>


<!-- bar code -->
<script type="text/javascript">
	$(document).ready(function() {
		$("#txtEanCodeP2").keyup(function(){
			if($("#txtEanCodeP2").val().length == 12)
			{
				res = 0;
				vBarcode = $("#txtEanCodeP2").val();
				res = mod10CheckDigit(vBarcode);
				$("#txtEanCodeP3").val(res);
			}
		});
	});

	function generateBarCode()
	{
		bCode = $("#txtEanCodeP2").val() + $("#txtEanCodeP3").val();
		if(bCode.length < 13)
		{
			alertPopup("Invalid...", 4000, "red", "white");
			return;
		}
		
	      $.ajax({
	          'url': base_url + '/' + controller + '/generateLabels',
	          'type': 'POST',
	          // 'dataType': 'json',
	          'data': {		
	          				'bCode': bCode
	              		},
	          'success': function(data)
	          {
				window.open(data, '_blank');
	          },
	          'error': function(jqXHR, exception)
	          {
	            $("#paraAjaxErrorMsg").html( jqXHR.responseText );
	            $("#modalAjaxErrorMsg").modal('toggle');
	          }
	      });
	}


	function mod10CheckDigit(Barcode)
	{
		// alert((Barcode.length));
		totalOdd = 0;
		totalEven = 0;
		for(i=0; i<= Barcode.length-1; i=i+2)
		{
			totalOdd = totalOdd + parseInt(Barcode.substring(i, i+1));
		}
		// alert('total odd: ' + totalOdd);
		for(i=1; i<= Barcode.length; i=i+2)
		{
			totalEven = totalEven + parseInt(Barcode.substring(i, i+1));
		}
		// alert('total even: ' + totalEven);
		totalEven = totalEven * 3;
		// alert('total even*3: ' + totalEven);
		total = totalOdd + totalEven;
		// alert('total is: ' + total);
		x = Right(total,1)
		// alert('right: ' + x);
		if(x==0)
		{
			return(10 - 10);
		}
		else
		{
			return(10 - x);
		}
	}
	function Right(str, n)
	{
	    if (n <= 0)
	       return parseInt(0);
	    else if (n > String(str).length)
	    {
	       return parseInt(str);
	    }
	    else 
	    {
	       var iLen = String(str).length;
	       return parseInt(String(str).substring(iLen, iLen - n));
	    }
	}
</script>
