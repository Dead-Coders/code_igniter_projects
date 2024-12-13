<div class="main-panel ps-container ps-theme-default" data-ps-id="944ece5a-d448-39e8-aadf-2abeef99bbb4">
      <!-- Navbar -->
      
      
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            
            
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary  card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Add Member</h4>
                  </div>
                </div>
                <div class="card-body ">
                  <form method="POST" action="#" class="form-horizontal" id="member_frm">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Membership No*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" name="mem_no" id="mem_no" class="form-control" required>
                          
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Name*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="mem_name" name="mem_name" class="form-control" required>
                        </div>
                      </div>

                       <label class="col-sm-2 col-form-label">Father/Husband Name*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" name="mem_father" id="mem_father" class="form-control" required>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Date of Birth*</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" name="mem_dob" id="mem_dob" class="form-control" placeholder="DD/MM/YYYY" required>
                        </div>
                      </div>

                       <label class="col-sm-2 col-form-label">Identity Card No.*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" name="mem_cnic" id="mem_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x" required>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Select Gender*</label>
                      <div class="col-lg-5 col-md-6 col-sm-3">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" name="mem_gender" id="mem_gender" data-style="select-with-transition" title="Select" data-size="7" tabindex="-98" required>
                            
                            <option value="Male">Male </option>
                            <option value="Female">Female</option>
                            
                          </select>
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group" style="margin-left: 20px">
                      <br>
                        <p class="form-control-static">If you suffer from any of the following disease given below please mark it and let your trainer know about it before commencing your fittness regime:
                        </p>

                    </div>
                  
                  </div>

                    <div class="row" >
                      <label class="col-sm-2 col-form-label label-checkbox">Diseases</label>
                      <div class="col-sm-10 checkbox-radios">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="BP" value="BP"> Blood Pressure
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>

                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="HD" value="HD"> Heart Disease
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>

                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="DB" value="DB"> Diabetes
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>

                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="AS" value="AS"> Asthma
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>

                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="HP" value="HP"> Hepatitas 
                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>

                        </div>

                        <div class="col-sm-10">
                        <div class="form-group bmd-form-group">
                         
                          <input type="text" name="mem_any_other_disease" id="mem_any_other_disease" class="form-control" placeholder="Any Other Disease? Mention Here">
                        </div>
                      </div>

                    
                      </div>

                    </div><!----Disease Section END ----->

                    <div class="row">
                      <h4 class="col-sm-12" align="center"> <button disabled="true" class="btn btn-fill btn-primary btn-lg btn-round">Residential Info<div class="ripple-container"></div></button></h4>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Resident of*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" name="mem_residence" id="mem_residence" class="form-control" placeholder="Name of City" required>
                          
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Address*</label>
                      <div class="col-sm-10">
                        <div class="form-group bmd-form-group">
                          <input type="text" name="mem_add" id="mem_address"  class="form-control" required>
                          
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Cell No*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="number" name="mem_tel" id="mem_tel" class="form-control" placeholder="03xx-xxxxxxx" required>
                          
                        </div>
                      </div>
                      <label class="col-sm-1 col-form-label">Fax No</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="number" name="mem_fax" id="mem_fax" class="form-control">
                          
                        </div>
                      </div>

                    <label class="col-sm-1 col-form-label">Email</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="email" name="mem_email" id="mem_email" class="form-control" placeholder="email@email.com" required>
                          
                        </div>
                      </div>
                    </div>


                    
                    <br>
                       <div class="row">
                      
                    
                      <h4 class="col-sm-12" align="center"> <button disabled="true" class="btn btn-fill btn-primary btn-lg btn-round">Workout Plan<div class="ripple-container"></div></button></h4>
                    </div>
                    <br>


                    <div class="row">
                       <label class="col-sm-2 col-form-label label-checkbox">Packages*</label>
                      <div class="col-sm-10 checkbox-radios">

                        <?php

                        if($pkgs->num_rows()>0)
                        {
                          ?>
                          <div class="form-check">
                            <div id="id_pkgs">
                            <?php

                            foreach($pkgs->result() as $pkg)
                            {
                              ?>


                            <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="<?php echo $pkg->name ?>" value="<?php echo $pkg->price ?>"><?php echo $pkg->name  ?>
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
                      <label class="col-sm-2 col-form-label">Package Duration*</label>
                      <div class="col-lg-3 col-sm-3">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="mem_pkgs_months" name="mem_pkgs_months" data-style="select-with-transition" data-size="7" tabindex="-98" onchange="updateSubtotal()" required>
                              <option value="0" selected>Select</option>
                            <?php
                            if($m_pkgs->num_rows()>0)
                            {
                              foreach($m_pkgs->result() as $mpkg)
                              {
                              ?>
                              <option val2="<?php echo $mpkg->duration ?>" value="<?php echo $mpkg->price ?>"><?php echo $mpkg->duration?> Month/s</option>


                              <?php
                            }

                            }

                            ?>
                           
                          </select>
                        </div>
                    </div>
                      <label class="col-sm-2 col-form-label">Time*</label>
                      <div class="col-lg-3  col-sm-3">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" name="mem_timing" id="mem_timing" data-style="select-with-transition"  title="Select" data-size="7" tabindex="-98" required>
                            
                            <option value="Morning">Morning</option>
                            <option value="Evening">Evening</option>
                            
                            
                          </select>
                        </div>
                    </div>

                  </div>
                  <br>
                  <br>
                   <div class="row">
                      <h4 class="col-sm-12" align="center"> <button disabled="true" class="btn btn-fill btn-primary btn-lg btn-round">Office Use Only<div class="ripple-container"></div></button></h4>
                    </div>
                     
                    <br>
                    <div class="row">
                      
                       <label class="col-sm-2 col-form-label">Registration Fee*</label>
                      <div class="col-sm-2">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="mem_reg_fee" name="mem_reg_fee" data-style="select-with-transition" data-size="5" tabindex="-98" onchange="updateSubtotal()" required>
                            
                            <option  selected value="0">0</option>
                            <option value="75">75</option>
                            
                            
                          </select>
                        </div>
                    </div>



                       <label class="col-sm-2 col-form-label">Monthly</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="mem_monthly_price"  value="0" name="mem_monthly_price" class="form-control">
                          $
                          <input type="text" id="temp_workout" name="temp_workout" class="form-control" hidden value="0" readonly="true">
                        </div>
                      </div>

                      <label class="col-sm-1 col-form-label">Discount</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input value="0" type="text" onchange="updateSubtotal()" id="mem_discount_price" name="mem_discount_price" class="form-control">$
                          
                        </div>
                      </div>

                    </div>

                       <div class="row">
                       <label class="col-sm-2 col-form-label">Subtotal*</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="mem_subtotal_price" name="mem_subtotal_price" class="form-control"  value="0">$
                           <input type="text" id="temp_subtotal" name="temp_subtotal" class="form-control" hidden required>
                          
                        </div>
                      </div>

                      <label class="col-sm-1 col-form-label">Tax</label>
                      <div class="col-sm-1">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="mem_tax" name="mem_tax" value="4" class="form-control" value="0">%
                          <input type="text" id="temp_tax" name="temp_tax" value="0" class="form-control" hidden>
                          
                        </div>
                      </div>
                       <label class="col-sm-1 col-form-label">Grand Total</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input value="0" type="text" id="mem_grand_total" name="mem_grand_total" class="form-control" readonly>$
                          
                        </div>
                      </div>


                    </div>


                     <div class="row">

                      <label class="col-sm-2 col-form-label">Amount to pay*</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="mem_amount_pay" name="mem_amount_pay" onchange="calculateRem()" class="form-control">$
                          
                        </div>
                      </div>
                      <label class="col-sm-2 col-form-label">Remaining Balance</label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="mem_remain_price" name="mem_remain_price" class="form-control">$
                          
                        </div>
                      </div>

                        <label class="col-sm-1 col-form-label">Date of Issue: </label>
                      <div class="col-sm-2">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="mem_date" name="mem_date" value="<?php
                          $date=date('Y-m-d');
                          echo $date;


                           ?>" class="form-control"  value="">
                          
                        </div>
                      </div>

                    

                    </div>

                    <div class="row">

                      <label class="col-sm-2 col-form-label">Payment Type*</label>
                      <div class="col-sm-2">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="mem_payment_type" name="mem_payment_type" data-style="select-with-transition" data-size="5" tabindex="-98" required>
                            
                            <option value="Cash" selected>Cash</option>
                            <option value="Card">Credit Card</option>
                            <option value="Cheque">Cheque</option>                           
                            
                          </select>
                        </div>
                    </div>


                    </div>



                     <div class="card-footer">
                  <input type="button" onclick="add_member()" value="Submit" class="btn btn-success">



                  </form>
                </div>
                
               

              </div>
            </div>
            
          </div>
        </div>
      </div>
     
    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>

    <script>
      function add_member()
      {

        $(document).ready(function(){

          var membership_no=$('#mem_no').val();
         var member_name=$('#mem_name').val();
       var mem_father=$('#mem_father').val();
       var mem_dob=$('#mem_dob').val();
       var mem_cnic=$('#mem_cnic').val();
       var gender=$('#mem_gender').val();
        var mem_res=$('#mem_residence').val();
        var mem_add=$('#mem_address').val();
        var mem_tel=$('#mem_tel').val();
        var mem_email=$('#mem_email').val();
        var time=$('#mem_timing').val();
        var other_disease=$('#mem_any_other_disease').val();
        var month=$('#mem_pkgs_months').val();
        var fee=$('#mem_subtotal_price').val();
          var paid=$('#mem_amount_pay').val();
        var rem=$('#mem_remain_price').val();
        var date=$('#mem_date').val();
        var ptype=$('#mem_payment_type').val();
        var disc=$('#mem_discount_price').val();
        var tax=$('#temp_tax').val();
        
          var packages="";
        var d_pkgs=document.getElementById('id_pkgs');
        var inputs=d_pkgs.getElementsByTagName('input');
        var len=inputs.length;
        for(var i=0;i<len;i++)
        {
             if(inputs[i].type=='checkbox' && inputs[i].checked==true)
                  {
                 packages+=inputs[i].name+"\n";
              }
        }
         var HD="";
        var DB="";
        var BP="";
        var AS="";
        var HP="";
        var _hp=document.getElementById('HP');
        var _hd=document.getElementById('HD');
        var _as=document.getElementById('AS');
        var _db=document.getElementById('DB');
        var _bp=document.getElementById('BP');
          if(_hp.checked)
        {
          HP="hepatitas";
        }
        if(_hd.checked)
        {
          HD="heartdisease";
        }
        if(_as.checked)
        {
          AS="asthama";
        }
        if(_db.checked)
        {
          DB="diabetes";
        }
        if(_bp.checked)
        {
          BP="bloodpressure";
        }
        if(membership_no=='')
        {
          md.showNotification('bottom','right','Membership #No is required',2);
        }
        else if(member_name=='')
        {
          md.showNotification('bottom','right','Member Name is required',2);
        }
        else if(mem_father=='')
        {
          md.showNotification('bottom','right','Member Husbands/Father Name is required',2);
        }
        else if(mem_dob=='')
        {
          md.showNotification('bottom','right','Member DOB is required',2);
        }
        else if(mem_cnic=='')
        {
          md.showNotification('bottom','right','Member Identity Card No. is required',2);
        }
        else if(gender=='')
        {
          md.showNotification('bottom','right','Specify gender of Member',2);
        }
        else if(mem_res=='')
        {
          md.showNotification('bottom','right','Residence Info is required',2);
        }
        else if(mem_add=='')
        {
          md.showNotification('bottom','right','Address is required ',2);
        }
        else if(mem_tel=='')
        {
          md.showNotification('bottom','right','Member Contact #No is required',2);
        }
        else if(mem_email=='')
        {
          md.showNotification('bottom','right','Member email is required',2);
        }
        else if(time=='')
        {
          md.showNotification('bottom','right','Specify shift',2);
        }
        else if(month=='' || month=='0')
        {
          md.showNotification('bottom','right','Specify Months ',2);
        }
        else if(paid=='')
        {
         md.showNotification('bottom','right','Enter amount to pay ',2); 
        }
      else 
        {
          $.ajax({
      method:'POST',
      url:'<?php echo base_url('Admin/addMember_Controller') ?>',
      data:{name:member_name,no:membership_no,father:mem_father,dob:mem_dob,cnic:mem_cnic,gender:gender,res:mem_res,address:mem_add,telephone:mem_tel,email:mem_email,time:time,other_disease:other_disease,fee:fee,payment:paid,remaining:rem,date:date,ptype:ptype,HP:HP,DB:DB,AS:AS,HD:HD,BP:BP,disc:disc,pkgs:packages,monthly:month,tax:tax},
      success:function(result)
      {
        if(result=='true')
        {
          md.showNotification('bottom','right','Member Added Successfully',3);
          document.getElementById("member_frm").reset();
        }
        else if(result=='false')
        {
          md.showNotification('bottom','right','Something went wrong. Try again',2);
        }
        else if(result=='mno')
        {
         md.showNotification('bottom','right','Membership No is already in use',2); 
        }
        else
        {
          md.showNotification('bottom','right',result,2); 
        }

      }
         });  
        }

      });
    }








    </script>