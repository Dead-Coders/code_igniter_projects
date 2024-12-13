<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/sol/sol.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/sol/sol.css">

<script type="text/javascript">
	var controller='RptPurchaseLog_Controller';
	var base_url='<?php echo site_url();?>';

     vModuleName = "Items Purchased and Sold";

	function setTable(recordsPurchase)
	{
		 // alert(JSON.stringify(records));
		  $("#tbl1").empty();
        var table = document.getElementById("tbl1");
        
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
             
                        
                        $( api.column( 6 ).footer() ).html( qtyTotal.toFixed(2) );
                        $( api.column( 18 ).footer() ).html( total.toFixed(2) );
                    }
  		});
  		} );

  		$("#tbl1 tr").on("click", highlightRowAlag);			
}

	function loadData()
	{	
    var arr = [];
    $(".clsId").each(function(index, elem){
        // arr.push("span" +index+ "_" + $(this).text());
        arr.push($(this).text());
    });
    // return arr.join("|");
    // alert(arr.join(","));
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

		var dtTo = $("#dtTo").val().trim();
		dtOk = testDate("dtTo");
		if(dtOk == false)
		{
			alertPopup("Invalid date...", 5000);
			$("#dtTo").focus();
			return;
		}

          // searchWhat = $("#txtSearch").val().trim();
          // alert(searchWhat);
		$.ajax({
				'url': base_url + '/' + controller + '/showData',
				'type': 'POST',
				'dataType': 'json',
				'data': {
							'dtFrom': dtFrom
							, 'dtTo': dtTo
              , 'arr': arr.toString()
						},
				'success': function(data)
				{
					if(data)
					{
						// alert(JSON.stringify(data));
						setTable(data['recordsPurchase']);
						alertPopup('Records loaded...', 4000);
					}
				},
        'error': function(jqXHR, exception)
        {
          document.write(jqXHR.responseText);
        }
		});
		
	}




</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<h3 class="text-center" style='margin-top:-20px'>Purchase Log</h3>
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
             					    dt.setDate(dt.getDate() - 850);
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
					
           <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                <?php
                     // echo "<label style='color: black; font-weight: normal;'>Keyword</label>";
                     // echo '<input type="text" placeholder="Part of Party Name or Product" class="form-control" maxlength="15" id="txtSearch" />';
                ?>
                <select id="my-select" class="" name="character" multiple="multiple" style="margin-top: 23px; height: 37px;">
                  
              </select>
              <div id="my-div" data-sol-name="character"></div>
           </div>
           
					<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12"">
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
                 </tr>
             </tfoot>
				</table>
			</div>
		</div>

		<div class="col-lg-0 col-sm-0 col-md-0 col-xs-0">
		</div>
	</div>

	<div id="divSelectedItems" class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="margin-top:20px;color:grey;">
		
  </div>
</div>





<script type="text/javascript">
		$(document).ready( function () {
		    myDataTable = $('#tbl1').DataTable({
			    paging: false,
			    iDisplayLength: -1,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],

			});

    $(function() {
        // initialize sol
        var jSonArray = '<?php echo json_encode($itemList); ?>';
        var jSonArray = jSonArray.replace(/(\r\n|\n|\r)/gm,", "); ///Multilinse of Address field with comma replce
        var availableTags = $.map(JSON.parse(jSonArray), function(obj){
              return{
                  label: obj.itemName,
                  value: obj.itemRowId,
                  type: "option"
              }
          });

        
        $('#my-select').searchableOptionList({
            maxHeight: '250px',
            data: [
                {
                    "type": "optiongroup",
                    "label": "Select Items...",
                    "children": availableTags
                    // [
                        // { "type": "option", "value": "Peter",  "label": "Peter Griffin"},
                        // { "type": "option", "value": "Lois",   "label": "Lois Griffin"},
                        // { "type": "option", "value": "Chris",  "label": "Chris Griffin"},
                        // { "type": "option", "value": "Meg",    "label": "Meg Griffin"},
                        // { "type": "option", "value": "Stewie", "label": "Stewie Griffin"}
                    // ]
                },
                // {
                //     "type": "optiongroup",
                //     "label": "Peter's Friends",
                //     "children": [
                //         { "type": "option", "value": "Cleveland", "label": "Cleveland Brown"},
                //         { "type": "option", "value": "Joe",       "label": "Joe Swanson"},
                //         { "type": "option", "value": "Quagmire",  "label": "Glenn Quagmire"}
                //     ]
                // },
                // { "type": "option", "value": "Evil Monkey", "label": "Evil Monkey"},
                // { "type": "option", "value": "Herbert",     "label": "John Herbert"}
            ]
        });

		} );



    ////// selected items ki position change kr rahe h, drop down k upar achha nahi lag raha
    $('#divSelectedItems').append( $('#sol-current-selection') );
} );
</script>