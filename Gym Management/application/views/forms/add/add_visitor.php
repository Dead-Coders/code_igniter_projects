<div class="main-panel ps-container ps-theme-default" data-ps-id="944ece5a-d448-39e8-aadf-2abeef99bbb4">
      <!-- Navbar -->
      
      
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            
            
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Add Daily Visitor</h4>
                  </div>
                </div>
                <div class="card-body ">
                  <form method="POST" action=""  class="form-horizontal ajax" id="visitor_form">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Mr/Mrs Name*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_name" name="vis_name" class="form-control" required>
                          
                        </div>
                      </div>
                    </div>
                  

                    <div class="row">
                      
                       <label class="col-sm-2 col-form-label">Identity Card No.*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_cnic" name="vis_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x" required>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Select Gender*</label>
                      <div class="col-lg-5 col-md-6 col-sm-3">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="vis_gender" name="vis_gender" data-style="select-with-transition" title="Select" data-size="7" tabindex="-98" required>
                            
                            <option value="Male">Male </option>
                            <option value="Female">Female</option>
                            
                          </select>
                        </div>
                    </div>
                  </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Address*</label>
                      <div class="col-sm-8">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_address" name="vis_address" class="form-control" placeholder="..............." required>
                          
                        </div>
                      </div>
                    </div>
                    

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Cell No*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_tel" name="vis_tel" class="form-control" placeholder="03xx-xxxxxxx" required>
                        </div>
                      </div>
                    </div>


                    
                    <br>
                       <div class="row">
                      
                    
                      <h4 class="col-sm-12" align="center"> <button disabled="true" class="btn btn-fill btn-primary btn-lg btn-round">Massage/Therapies<div class="ripple-container"></div></button></h4>
                    </div>
                    <br>


                    <div class="row">
                      <input id="temp_pkg" name="temp_pkg" type="text" value="0" hidden>
                       <label class="col-sm-2 col-form-label label-checkbox">Packages:</label>
                      <div class="col-sm-10 checkbox-radios">

                        <?php

                        if($daily_pkgs->num_rows()>0)
                        {
                          ?>
                          <div class="form-check">
                            <div id="daily_pkgs">
                            <?php

                            foreach($daily_pkgs->result() as $pkg)
                            {
                              ?>
                            <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" onchange="calculateGrandTotal()" name="<?php echo $pkg->name ?>" value="<?php echo $pkg->price ?>"><?php echo $pkg->name  ?>
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>


                              <?php

                            }


                            ?>


                          <?php

                        }
                        else
                        {
                          ?>

                          <h4>No Packages were found</h4>
                          <?php

                        }

                        ?>
                         </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Massage/Therapy</label>
                      <div class="col-lg-3 col-sm-3">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="vis_therapy_pkgs" name="vis_therapy_pkgs" data-style="select-with-transition"  title="Select" data-size="7" tabindex="-98" onchange="changeTherapy();calculateGrandTotal()">
                            <?php
                            if($therapy_pkgs->num_rows()>0)
                            {
                              foreach($therapy_pkgs->result() as $mpkg)
                              {
                              ?>
                              <option value="<?php echo $mpkg->price?>"><?php echo  $mpkg->name.".Minutes.".$mpkg->price." $ " ?></option>


                              <?php
                            }

                            }

                            ?>
                           
                          </select>
                        </div>
                    </div>

                    <label class="col-sm-2 col-form-label">Therapy/Massage Price</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" value="0" id="vis_therapy_price" name="vis_therapy_price" class="form-control">$
                          
                        </div>
                      </div>
                    


                  </div>
                  
                 

                  <div class="row">

                        <label class="col-sm-2 col-form-label">Subtotal*</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_subtotal" name="vis_Subtotal" value="0" onchange="calculateGrandTotal()" class="form-control" required="">$
                          
                        </div>
                      </div>


                    <label class="col-sm-1 col-form-label">Tax*</label>
                      <div class="col-sm-1">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_tax" name="vis_tax" value="6" onchange="calculateGrandTotal()" class="form-control">%
                          <input type="text" id="tax_price" name="tax_price" value="0" class="form-control" hidden>
                        </div>
                      </div>




                       <label class="col-sm-1 col-form-label">Grand Total</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_grandtotal" name="vis_grandtotal" value="0" class="form-control" required="">$
                          
                        </div>
                      </div>
                    


                  </div>

                    <div class="row">


                       <label class="col-sm-2 col-form-label">Payment*</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_payment" name="vis_payment" onchange="calcRem()" class="form-control" required="">$
                          
                        </div>
                      </div>

                       <label class="col-sm-2 col-form-label">Remaining Balance</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_rem_balance" name="vis_rem_balance" class="form-control" readonly>$
                          
                        </div>
                      </div>

                    


                    </div>

                    <div class="row">
                        <label class="col-sm-2 col-form-label">Payment Type*</label>
                      <div class="col-sm-2">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="vis_payment_type" name="vis_payment_type" data-style="select-with-transition" data-size="5" tabindex="-98" required>
                            
                            <option value="Cash" selected>Cash</option>
                            <option value="Card">Credit Card</option>
                            <option value="Cheque">Cheque</option>                           
                            
                          </select>
                        </div>
                    </div>

                    </div>

                     <div class="card-footer">
                  <input  type="button" onclick="add_visitor()" value="Submit" readonly id="submit_vis" class="btn btn-fill btn-success">
                   
                </div>


                  </form>
                </div>
                
               

              </div>
            </div>
            
          </div>
        </div>
      </div>
     
    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
    <script>

function add_visitor()
{

$(document).ready(function(){


    var namee=$('#vis_name').val();
    var cnicc=$('#vis_cnic').val();
    var tell=$('#vis_tel').val();
    var addd=$('#vis_address').val();
    var bal=$('#vis_rem_balance').val();
    var payment=$('#vis_payment').val();
    var fee=$('#vis_subtotal').val();
    var tax=$('#tax_price').val();
    var p_type=$('#vis_payment_type').val();
    

    
    var selectedPkgs="";
    var d_pkgs=document.getElementById('daily_pkgs');
    var inputs=d_pkgs.getElementsByTagName('input');
    var len=inputs.length;

    for(var i=0;i<len;i++)
    {
      if(inputs[i].type=='checkbox' && inputs[i].checked==true)
      {
        selectedPkgs+=inputs[i].name+"\n";
      }
    }
 
    

   
    if(namee==='')
    {
      md.showNotification('bottom','right','Name field is empty',2);
    }
    else if(cnicc==='')
    {
      md.showNotification('bottom','right','Cnic field is empty',2);
    }
    else if(tell==='')
    {
      md.showNotification('bottom','right','Cell No field is empty',2);
    }
    else if(addd==='')
    {
      md.showNotification('bottom','right','Address field is empty',2);
    }

    else if(payment==='')
    {
      md.showNotification('bottom','right','Payment Field Cannot be empty',2);
    }

    else
    {
        $.ajax({

      method:'POST',
      url:'<?php echo base_url('Admin/addDailyVisitorController') ?>',
      data:{name:namee,cnic:cnicc,tel:tell,address:addd,balance:bal,ppayment:payment,ttax:tax,payment_type:p_type,pkgs:selectedPkgs,fee:fee},
      success:function(result)
      {
        if(result=='true')
        {
          md.showNotification('bottom','right','Visitor Added Successfully',3);
          document.getElementById("visitor_form").reset();
        }
        else if(result=='false')
        {
          md.showNotification('bottom','right','Visitor Not Added ! Something Went wrong. Please try again.',2);
        }
      
       
      }
    });
        
    }

 
  





});


}

    </script>