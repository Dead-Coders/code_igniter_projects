<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='RptItemsPurchaseAndSold_Controller';
	var base_url='<?php echo site_url();?>';

     vModuleName = "Items Purchased and Sold";

	function setTable(records, recordsPurchase, recordsQuotation, recordsCashSale)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl1").empty();
        var table = document.getElementById("tbl1");
        for(i=0; i<records.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);
          row.style.color = "green";

          var cell = row.insertCell(0);
          cell.style.display="none";
          cell.innerHTML = records[i].dbRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = records[i].dbdRowId;
          cell.style.display="none";
          var cell = row.insertCell(2);
          cell.innerHTML = records[i].itemRowId;
          // cell.style.display="none";
          var cell = row.insertCell(3);
          cell.innerHTML = dateFormat(new Date(records[i].dbDt));
          var cell = row.insertCell(4);
          cell.innerHTML = records[i].customerName;
          var cell = row.insertCell(5);
          cell.innerHTML = records[i].itemName;
          var cell = row.insertCell(6);
          cell.innerHTML = records[i].qty;
          var cell = row.insertCell(7);
          cell.innerHTML = records[i].rate;
          cell.style.color="red";
          var cell = row.insertCell(8);
          cell.innerHTML = records[i].amt;
          var cell = row.insertCell(9);
          cell.innerHTML = records[i].discountPer;
          var cell = row.insertCell(10);
          cell.innerHTML = records[i].discountAmt;
          // totalNetAmt += parseFloat(records[i].netAmt);
          var cell = row.insertCell(11);
          cell.innerHTML = records[i].pretaxAmt;
          cell.style.display="none";
          var cell = row.insertCell(12);
          cell.innerHTML = records[i].igst;
          cell.style.display="none";
          var cell = row.insertCell(13);
          cell.style.display="none";
          cell.innerHTML = records[i].igstAmt;
          var cell = row.insertCell(14);
          cell.innerHTML = records[i].cgst;
          var cell = row.insertCell(15);
          // cell.innerHTML = records[i].cgstAmt;
          cell.style.display="none";
          var cell = row.insertCell(16);
          cell.innerHTML = records[i].sgst;
          var cell = row.insertCell(17);
          // cell.innerHTML = records[i].sgstAmt;
          cell.style.display="none";
          var cell = row.insertCell(18);
          cell.innerHTML = records[i].netAmt;
          var cell = row.insertCell(19);
          cell.innerHTML = parseFloat(records[i].netAmt/records[i].qty).toFixed(2);
          cell.style.color="red";
          var cell = row.insertCell(20);
	    }

	    /////Purchase entries
        for(i=0; i<recordsPurchase.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);
          row.style.color = "blue";

          var cell = row.insertCell(0);
          cell.style.display="none";
          cell.innerHTML = recordsPurchase[i].purchaseRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = recordsPurchase[i].purchaseDetailRowId;
          cell.style.display="none";
          var cell = row.insertCell(2);
          cell.innerHTML = recordsPurchase[i].itemRowId;
          // cell.style.display="none";
          var cell = row.insertCell(3);
          cell.innerHTML = dateFormat(new Date(recordsPurchase[i].purchaseDt));
          var cell = row.insertCell(4);
          cell.innerHTML = recordsPurchase[i].customerName;
          var cell = row.insertCell(5);
          cell.innerHTML = recordsPurchase[i].itemName;
          var cell = row.insertCell(6);
          cell.innerHTML = recordsPurchase[i].qty;
          var cell = row.insertCell(7);
          cell.innerHTML = recordsPurchase[i].rate;
          cell.style.color="red";
          var cell = row.insertCell(8);
          cell.innerHTML = recordsPurchase[i].amt;
          var cell = row.insertCell(9);
          cell.innerHTML = recordsPurchase[i].discountPer;
          var cell = row.insertCell(10);
          cell.innerHTML = recordsPurchase[i].discountAmt;
          var cell = row.insertCell(11);
          cell.innerHTML = recordsPurchase[i].pretaxAmt;
          cell.style.display="none";
          var cell = row.insertCell(12);
          cell.innerHTML = recordsPurchase[i].igst;
          cell.style.display="none";
          var cell = row.insertCell(13);
          cell.style.display="none";
          cell.innerHTML = recordsPurchase[i].igstAmt;
          var cell = row.insertCell(14);
          cell.innerHTML = recordsPurchase[i].cgst;
          var cell = row.insertCell(15);
          cell.innerHTML = recordsPurchase[i].cgstAmt;
          cell.style.display="none";
          var cell = row.insertCell(16);
          cell.innerHTML = recordsPurchase[i].sgst;
          var cell = row.insertCell(17);
          cell.innerHTML = recordsPurchase[i].sgstAmt;
          cell.style.display="none";
          var cell = row.insertCell(18);
          cell.innerHTML = recordsPurchase[i].netAmt;
          var cell = row.insertCell(19);
          cell.innerHTML = parseFloat(recordsPurchase[i].netAmt/recordsPurchase[i].qty).toFixed(2);
          cell.style.color="red";
          var cell = row.insertCell(20);
          cell.innerHTML = recordsPurchase[i].sp;
          cell.style.color="blue";
	    }

	    /////Quotation entries
	    // alert(JSON.stringify(recordsQuotation));
        for(i=0; i<recordsQuotation.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);
          row.style.color = "black";

          var cell = row.insertCell(0);
          cell.style.display="none";
          cell.innerHTML = recordsQuotation[i].quotationRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = recordsQuotation[i].quotationDetailRowId;
          cell.style.display="none";
          var cell = row.insertCell(2);
          cell.innerHTML = recordsQuotation[i].itemRowId;
          // cell.style.display="none";
          var cell = row.insertCell(3);
          cell.innerHTML = dateFormat(new Date(recordsQuotation[i].quotationDt));
          var cell = row.insertCell(4);
          cell.innerHTML = recordsQuotation[i].customerName;
          var cell = row.insertCell(5);
          cell.innerHTML = recordsQuotation[i].itemName;
          var cell = row.insertCell(6);
          cell.innerHTML = recordsQuotation[i].qty;
          var cell = row.insertCell(7);
          cell.innerHTML = recordsQuotation[i].rate;
          cell.style.color="red";
          var cell = row.insertCell(8);
          cell.innerHTML = recordsQuotation[i].amt;
          var cell = row.insertCell(9);
          // cell.innerHTML = recordsPurchase[i].discountPer;
          var cell = row.insertCell(10);
          // cell.innerHTML = recordsPurchase[i].discountAmt;
          var cell = row.insertCell(11);
          // cell.innerHTML = recordsPurchase[i].pretaxAmt;
          cell.style.display="none";
          var cell = row.insertCell(12);
          // cell.innerHTML = recordsPurchase[i].igst;
          cell.style.display="none";
          var cell = row.insertCell(13);
          cell.style.display="none";
          // cell.innerHTML = recordsPurchase[i].igstAmt;
          var cell = row.insertCell(14);
          // cell.innerHTML = recordsPurchase[i].cgst;
          var cell = row.insertCell(15);
          cell.style.display="none";
          // cell.innerHTML = recordsPurchase[i].cgstAmt;
          var cell = row.insertCell(16);
          // cell.innerHTML = recordsPurchase[i].sgst;
          var cell = row.insertCell(17);
          cell.style.display="none";
          // cell.innerHTML = recordsPurchase[i].sgstAmt;
          var cell = row.insertCell(18);
          // cell.innerHTML = recordsPurchase[i].netAmt;
          var cell = row.insertCell(19);
          cell.innerHTML = parseFloat(recordsQuotation[i].amt/recordsQuotation[i].qty).toFixed(2);
          cell.style.color="red";
          var cell = row.insertCell(20);
	    }



         /////Cash Sale entries
        for(i=0; i<recordsCashSale.length; i++)
        {
          var newRowIndex = table.rows.length;
          var row = table.insertRow(newRowIndex);
          row.style.color = "grey";

          var cell = row.insertCell(0);
          cell.style.display="none";
          cell.innerHTML = recordsCashSale[i].quotationRowId;
          var cell = row.insertCell(1);
          cell.innerHTML = recordsCashSale[i].quotationDetailRowId;
          cell.style.display="none";
          var cell = row.insertCell(2);
          cell.innerHTML = recordsCashSale[i].itemRowId;
          // cell.style.display="none";
          var cell = row.insertCell(3);
          cell.innerHTML = dateFormat(new Date(recordsCashSale[i].dt));
          var cell = row.insertCell(4);
          cell.innerHTML = "CASH SALE";
          var cell = row.insertCell(5);
          cell.innerHTML = recordsCashSale[i].itemName;
          var cell = row.insertCell(6);
          cell.innerHTML = recordsCashSale[i].qty;
          var cell = row.insertCell(7);
          cell.innerHTML = recordsCashSale[i].rate;
          cell.style.color="red";
          var cell = row.insertCell(8);
          cell.innerHTML = recordsCashSale[i].amt;
          var cell = row.insertCell(9);
          // cell.innerHTML = recordsPurchase[i].discountPer;
          var cell = row.insertCell(10);
          // cell.innerHTML = recordsPurchase[i].discountAmt;
          var cell = row.insertCell(11);
          // cell.innerHTML = recordsPurchase[i].pretaxAmt;
          cell.style.display="none";
          var cell = row.insertCell(12);
          // cell.innerHTML = recordsPurchase[i].igst;
          cell.style.display="none";
          var cell = row.insertCell(13);
          cell.style.display="none";
          // cell.innerHTML = recordsPurchase[i].igstAmt;
          var cell = row.insertCell(14);
          // cell.innerHTML = recordsPurchase[i].cgst;
          var cell = row.insertCell(15);
          cell.style.display="none";
          // cell.innerHTML = recordsPurchase[i].cgstAmt;
          var cell = row.insertCell(16);
          // cell.innerHTML = recordsPurchase[i].sgst;
          var cell = row.insertCell(17);
          cell.style.display="none";
          // cell.innerHTML = recordsPurchase[i].sgstAmt;
          var cell = row.insertCell(18);
          // cell.innerHTML = recordsPurchase[i].netAmt;
          var cell = row.insertCell(19);
          cell.innerHTML = parseFloat(recordsCashSale[i].amt/recordsCashSale[i].qty).toFixed(2);
          cell.style.color="red";
          var cell = row.insertCell(20);
         }



		myDataTable.destroy();
		$(document).ready( function () {
	    myDataTable=$('#tbl1').DataTable({
		    paging: false,
		    iDisplayLength: -1,
		    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
		     ordering: false,
               footerCallback: function ( row, data, start, end, display ) {
                      var api = this.api(), data;
           
                      // Remove the formatting to get integer data for summation
                      var intVal = function ( i ) {
                          return typeof i === 'string' ?
                              i.replace(/[\$,]/g, '')*1 :
                              typeof i === 'number' ?
                                  i : 0;
                      };
           
                      // Total over all pages
                      var qtyTotal = api
                     .column( 6 )
                     .data()
                     .reduce( function (a, b) {
                         return intVal(a) + intVal(b);
                     }, 0 );

                      total = api
                          .column( 18 )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );
           
                      // // Total over this page
                      // pageTotal = api
                      //     .column( 18, { page: 'current'} )
                      //     .data()
                      //     .reduce( function (a, b) {
                      //         return intVal(a) + intVal(b);
                      //     }, 0 );
           
                      // Update footer
                      // alert(total);
                      // $( api.column( 18 ).footer() ).html(
                      //     '$'+pageTotal +' ( $'+ total +' total)'
                      // );
                      $( api.column( 6 ).footer() ).html( qtyTotal.toFixed(2) );
                      $( api.column( 18 ).footer() ).html( total.toFixed(2) );
                  }
		});
		} );

		$("#tbl1 tr").on("click", highlightRowAlag);			
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

          vType = $("#cboVoucherType").val();
          searchWhat = $("#txtSearch").val().trim();
          // alert(searchWhat);
		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dtFrom': dtFrom
							, 'dtTo': dtTo
							, 'vType': vType
                                   , 'searchWhat': searchWhat
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
            console.log( JSON.stringify( data['timeTook'] ) );
            var today = new Date();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            console.log( time );
						setTable(data['records'], data['recordsPurchase'], data['recordsQuotation'], data['recordsCashSale']);
            var today = new Date();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            console.log( time );
            alertPopup("Records Loaded... in Server Time: " + JSON.stringify( data['timeTook'] ), 6000);
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
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Items Purchase And Sold</h3>
			<form name='frm' id='frm' method='post' enctype='multipart/form-data' action="">
				<div class="row" style="margin-top:5px;">
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
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
     					    dt.setDate(dt.getDate() - 90);
   		 					$("#dtFrom").val(dateFormat(dt));
						</script>					
		          	</div>
		          	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
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
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                              <?php
                                   $vType = array();
                                   $vType['ALL'] = 'ALL';
                                   $vType['Sale'] = "Sale";
                                   $vType['Purchase'] = "Purchase";
                                   $vType['Quotation'] = "Quotation";
                                   $vType['Cash Sale'] = "Cash Sale";
                                   echo "<label style='color: black; font-weight: normal;'>Voucher Type</label>";
                                   echo form_dropdown('cboVoucherType', $vType, 'ALL',"class='form-control' id='cboVoucherType'");
                              ?>
                         </div>
                         <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                              <?php
                                   echo "<label style='color: black; font-weight: normal;'>Keyword</label>";
                                   echo '<input type="text" placeholder="Part of Party Name or Product" class="form-control" maxlength="15" id="txtSearch" />';
                              ?>
                         </div>
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
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


	<div class="row" style="margin-top:10px;" >
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>

		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div id="divTable" class="divTable col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid lightgray; padding: 10px;height:500px; overflow:auto;">
				<table class='table table-bordered table-striped table-hover' id='tbl1'>
				 <thead>
					 <tr>
					 	<th style="display: none;">dbRowId</th>
					 	<th style="display: none;">dbdRowId</th>
					 	<th style="display: none1;">itemRowId</th>
					 	<th>Date</th>
					 	<th>Party</th>
					 	<th>Item</th>
					 	<th>Qty</th>
					 	<th>Rate</th>
					 	<th>Amt</th>
					 	<th>D%</th>
					 	<th>D</th>
					 	<th style="display: none;">PreTax</th>
					 	<th style="display: none;">igst%</th>
					 	<th style="display: none;">igst</th>
					 	<th>cgst%</th>
					 	<th style="display: none;">cgst</th>
					 	<th>sgst%</th>
					 	<th style="display: none;">sgst</th>
					 	<th>Net</th>
            <th>perPc</th>
					 	<th>SP</th>
					</tr>
				 </thead>
				 <tbody>

				 </tbody>
                     <tfoot>
                           <tr>
                              <th style="display: none;"></th>
                              <th style="display: none;"></th>
                              <th style="display: none1; text-align: right;" colspan="3">Total:</th>
                              <th></th>
                              <th>0</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th style="display: none;"></th>
                              <th style="display: none;"></th>
                              <th style="display: none;"></th>
                              <th></th>
                              <th style="display: none;"></th>
                              <th></th>
                              <th style="display: none;"></th>
                              <th>0</th>
                              <th></th>
                              <th></th>
                           </tr>
                       </tfoot>
				</table>
			</div>
		</div>

		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>

	<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="margin-top:20px;">
		<?php
			echo "<label style='color: green; font-weight: normal;'>-Sale</label>";
			echo "<label style='color: blue; font-weight: normal;'>&nbsp;&nbsp;&nbsp; -Purchase</label>";
               echo "<label style='color: Black; font-weight: normal;'>&nbsp;&nbsp;&nbsp; -Quotation</label>";
               echo "<label style='color: Grey; font-weight: normal;'>&nbsp;&nbsp;&nbsp; -Cash Sale</label>";
	  	?>
  	</div>
</div>





<script type="text/javascript">
		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});
		} );

</script>