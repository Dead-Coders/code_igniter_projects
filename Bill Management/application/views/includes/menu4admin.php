<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
        var totalReminders = 0;
        var base_url='<?php echo site_url();?>';  


        $(document).ready( function () {
          <?php
            $php_array = $mr;
            $js_array = json_encode($php_array);
            echo "var javascript_array = ". $js_array . ";\n";
          ?>
          
          totalReminders = '<?php echo count($notifications); ?>';
          // alert(totalReminders);
          $("#spanNotificationAsli").text(totalReminders);
          if( totalReminders > 0 )
          {
            $("#spanNotificationAsli").animate({opacity: '0.2', width: '50px'}, 1000);
            $("#spanNotificationAsli").animate({opacity: '1', width: '35px'}, 1000);
            $("#spanNotificationAsli").animate({opacity: '0.2', width: '50px'}, 1000);
            $("#spanNotificationAsli").animate({opacity: '1', width: '35px'}, 1000);
            $("#spanNotificationAsli").animate({opacity: '0.2', width: '50px'}, 1000);
            $("#spanNotificationAsli").animate({opacity: '1', width: '35px'}, 1000);
          }
          $('a.menu1').each(function(){
              for(i=0;i<javascript_array.length;i++)
              {
                  if(javascript_array[i]['menuoption'] === $(this).text())
                  {
                      $(this).css("display","block");
                      break;
                  }
                  else
                  {
                      $(this).css("display","none");
                  }
              }
          });
          // alert(javascript_array[0]['menuoption']);
          $("#txtMenuEval").keypress(function(e) {
              if(e.which == 13) {
                var result = eval($('#txtMenuEval').val());
                result = parseFloat(result);
                  $('#txtMenuEvalResult').val( result.toFixed(2) );
                  // $('#txtEvalResult').text().toFixed(2);

              }
          });

          $("#txtMenuEval").focus(function () {
             $(this).select();
          });
          $.unblockUI();
        }); 
</script>
    <div class="container">
        <nav class="nav navbar navbar-inverse navbar-fixed-top">
          <div class="navbar-header"> <!-- It is responsible to Touch Menu for small devices -->
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php  echo base_url();  ?>index.php/DashBoard_Controller"><span class="glyphicon glyphicon-home"></span></a>
          </div>

          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

              <li class="dropdown">
                <a tabindex="0" class="menu1" style="display:none;" data-toggle="dropdown">Masters<span class="caret"></span></a>
                <!-- role="menu": fix moved by arrows (Bootstrap dropdown) -->
                <ul class="dropdown-menu" role="menu">
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Organisation_Controller">Organisation</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Customers_Controller">Customers</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/ItemGroups_Controller">Item Groups</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Items_Controller">Items</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/EditItems_Controller">Edit Items</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/EditItemsGroup_Controller">Edit Items (Group)</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/ItemsOpeningBalance_Controller">Items Opening Balance</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Stages_Controller">Stages</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/StageItems_Controller">Stage Items</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a tabindex="0" class="menu1" style="display:none;" data-toggle="dropdown">Transactions<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Quotation_Controller">Quotation</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Order_Controller">Order</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/OrdersStatus_Controller">Order Status</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Purchase_Controller">Purchase</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Sale_Controller">Sale</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/SalesReturn_Controller">Sales Return</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/CashSale_Controller">Cash Sale</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/PaymentReceipt_Controller">Payment/Receipt</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Journal_Controller">Journal</a></li>
                  
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Receipt_Controller">Receipt</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Payment_Controller">Payment</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Dates_Controller">Dates</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Reminders_Controller">Reminders</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Requirement_Controller">Requirement</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/SendSms_Controller">Send SMS</a></li>
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Complaint_Controller">Complaint</a></li>   
                  <li><a tabindex="0" class="menu1" style="display:none;color:red;" href="<?php  echo base_url();  ?>index.php/Recharge_Controller">Recharge</a></li>        
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Replacement_Controller">Replacement</a></li>          
                </ul>
              </li>

              
              <li class="dropdown">
                <a tabindex="0" class="menu1" style="display:none;" data-toggle="dropdown">Reports<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptLedger_Controller">Ledger</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptLedger2_Controller">Ledger 2</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptLedgerItem_Controller">Item Ledger</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptCollection_Controller">Collection Report</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptDayBook_Controller">Day Book</a></li>
                      <li class="divider"></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptSale_Controller">Sale Report</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptPurchase_Controller">Purchase Report</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptPurchaseAnalysis_Controller">Purchase Analysis</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptItemsPurchaseAndSold_Controller">Items Purchase And Sold</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;color:red;" href="<?php  echo base_url();  ?>index.php/RptPurchaseLog_Controller">Purchase Log</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptSaleFrequence_Controller">Sale Frequency</a></li>

                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptDues_Controller">Dues</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptReminders_Controller">Reminders</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptOrders_Controller">Orders Log</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptDirectBills_Controller">Direct Bills Log</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptReminders2_Controller">Reminders (Alarms)</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/RptSearch_Controller">Search</a></li>
                    </ul>
              </li>

              <li class="dropdown">
                <a tabindex="0" class="menu1" style="display:none;" data-toggle="dropdown">Tools<span class="caret"></span></a>

                <!-- role="menu": fix moved by arrows (Bootstrap dropdown) -->
                    <ul class="dropdown-menu" role="menu">
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/User_Controller">Create Users</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Right_Controller">User Rights</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Changepwdadmin_Controller">Reset Password</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Backupdata_Controller">Backup Data</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/AdminRights_Controller">Admin Rights</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/NotificationHierarchy_Controller">Notification Hierarchy</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Query_Controller">Query Analyzer</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Duplicates_Controller">Duplicates</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/DuplicateCustomers_Controller">Duplicate Customers</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/AddressBook_Controller">Address Book</a></li>
                      <li class="divider"></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Conclusions_Controller">Conclusions</a></li>
                      <li class="divider"></li>
                      <li><a tabindex="0" class="menu1" style="display:none; color:red;" href="<?php  echo base_url();  ?>index.php/ToDo_Controller">To Do List</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/DailyCash_Controller">Daily Cash</a></li>
                    </ul>
              </li> 
                <?php
                    //echo form_input('txtEval', '', "class='form-control' id='txtEval' style='background-color:yellow;' maxlength=100 autocomplete='off'");
                ?>

            </ul>

            <ul class="nav navbar-nav navbar-right" style="padding-right:25px;">
              <li class="dropdown">
              <a href="#" tabindex="0" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-user"> <?php echo $this->session->userid ?> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  
                  <li><a  tabindex="0" href="<?php  echo base_url();  ?>index.php/Changepwd_Controller">Change Password</a></li>
                  <li class="divider"></li>
                  <li><a  tabindex="0" href="<?php  echo base_url();  ?>index.php/Login_controller/logout">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>
                  
                </ul>
              </li>
            </ul>

            
            <ul class="nav navbar-nav navbar-right" style="padding-right:25px;">
              <li class="dropdown">
              <input type="text" class="form-control" style="margin-top: 10px; width: 80px;" id='txtMenuEvalResult' disabled="yes">
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right" style="padding-right:25px;">
              <li class="dropdown">
              <input type="text" class="form-control" style="margin-top: 10px;" id='txtMenuEval' maxlength=100 placeholder="Calculator">
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right" style="padding-right:25px;">
              <!-- <li class="dropdown">
                <a  tabindex="0" href="<?php  echo base_url();  ?>index.php/Sale_Controller"><span style="padding: 5px 10px;" class="label label-primary">SV</span></a>
              </li>
              <li class="dropdown" >
                <a tabindex="0" href="<?php  echo base_url();  ?>index.php/Purchase_Controller"><span style="padding: 5px 10px;" class="label label-success">PV</span></a>
              </li> -->
              <li class="dropdown">
                <a  tabindex="0" href="<?php  echo base_url();  ?>index.php/PaymentReceipt_Controller"><span style="padding: 5px 10px;" class="label label-success">Payment Receipt</span></a>
              </li>
              <li class="dropdown">
                <a  tabindex="0" href="<?php  echo base_url();  ?>index.php/RptDues_Controller"><span style="padding: 5px 10px;" class="label label-default">Dues</span></a>
              </li>
              <li class="dropdown">
                <a  tabindex="0" href="<?php  echo base_url();  ?>index.php/DailyCash_Controller"><span style="padding: 5px 10px;" class="label label-primary">DailyCash</span></a>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right" style="padding-right:5px;">
              <li class="dropdown">
              <a href="#"><span style="padding: 5px 10px;" id="spanNotificationAsli" class="label label-danger glyphicon glyphicon-bell" onclick="notificationPadhLiya();"> 0</span></a>
              </li>
            </ul>

          </div>
        </nav>
        <script>  
          var notificationCount = 0;


         </script>
    </div> <!-- end of 'container' div   -->


<script type="text/javascript">

</script>

<script type="text/javascript">
   function notificationPadhLiya()
          {
            rowIndex = $(this).parent().parent().index();
            colIndex = $(this).parent().index();
            notificationRowId = $(this).closest('tr').children('td:eq(0)').text();
            notificationType = $(this).closest('tr').children('td:eq(4)').text();
            // alert(notificationRowId);
            var controller='Login_controller';
            var base_url='<?php echo site_url();?>';
            $.ajax({
                    'url': base_url + '/' + controller + '/notificationPadhLiya',
                    'type': 'POST',
                    'dataType': 'json',
                    'data': {
                                'dtFrom': 'ff'
                                , 'dtTo': 'gg'
                                , 'notificationRowId': notificationRowId
                                , 'notificationType': notificationType
                            },
                    'success': function(data)
                    {
                      if(data)
                      {
                        $("#spanNotificationAsli").text(data['notifications'].length);

                        $("#tblNotification").empty();
                        var table = document.getElementById("tblNotification");
                        for(i=0; i<data['notifications'].length; i++)
                        {
                            newRowIndex = table.rows.length;
                            row = table.insertRow(newRowIndex);

                            if(data['notifications'][i].notificationType == "Reminder")
                            {
                              colour = "blue";
                            }
                            else
                            {
                              colour = "red";
                            }

                            var cell = row.insertCell(0);
                            cell.style.display="none";
                            cell.innerHTML = data['notifications'][i].rowId;
                            var cell = row.insertCell(1);
                            cell.style.color = colour;
                            cell.style.textAlign = "left";
                            cell.innerHTML = dateFormat(new Date(data['notifications'][i].dt));
                            var cell = row.insertCell(2);
                            cell.style.color = colour;
                            cell.style.textAlign = "left";
                            cell.innerHTML = data['notifications'][i].remarks;
                            var cell = row.insertCell(3);
                            cell.style.color = colour;
                            cell.style.textAlign = "left";
                            cell.innerHTML = data['notifications'][i].repeat;
                            var cell = row.insertCell(4);
                            cell.style.color = colour;
                            cell.style.textAlign = "left";
                            cell.innerHTML = data['notifications'][i].notificationType;
                            var cell = row.insertCell(5);
                            cell.innerHTML = '<span class="label label-danger" style="cursor:hand;">Delete</span>';
                            cell.className = "padhLiya";
                            cell.style.textAlign = "left";
                            // alert();
                        }

                        $("#modalNotification").css("display","block");
                        $('.padhLiya').bind('click', notificationPadhLiya);
                      }

                    }
                });
                // $("#modalNotification").css("display","block");
          }


          function checkBalMenu()
          {
            $.ajax({
              'url': base_url + '/RptDues_Controller/checkBal',
              'type': 'POST',
              'data': {'Ta': 'Ta'},
              'success': function(data)
              {
                if(data)
                {
                  // alert(data);
                  $("#btnCheckBalanceMenu").val(data);
                }
              }
            });

  }
</script>

            
            

<div class="container1">