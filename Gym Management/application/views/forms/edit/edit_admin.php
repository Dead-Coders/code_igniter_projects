<div class="main-panel ps-container ps-theme-default" data-ps-id="944ece5a-d448-39e8-aadf-2abeef99bbb4">
      <!-- Navbar -->
      
      
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            
            
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Edit Admin</h4>
                  </div>
                </div>
                <div class="card-body ">
                  <form method="POST" action=""  class="form-horizontal ajax" id="admin_form">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">First Name*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="ad_fname" name="ad_fname" value="<?php echo $admin->first_name ?>" class="form-control" required>
                          
                        </div>
                      </div>
                          <label class="col-sm-2 col-form-label">Last Name*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="ad_lname" name="ad_lname" value="<?php echo $admin->last_name ?>" class="form-control" required>
                          
                        </div>
                      </div>

                    </div>
                      <div class="row">
                      <label class="col-sm-2 col-form-label">Email*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="ad_email" name="ad_email" value="<?php echo $admin->admin_email ?>" class="form-control" required>
                          
                        </div>
                      </div>
                    </div>
                  
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Access Level</label>
                      <div class="col-lg-3 col-sm-3">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="ad_level" name="ad_level" data-style="select-with-transition"  title="Select" data-size="7" tabindex="-98">
                              <?php
                              if($admin->access_level==1)
                              {
                                ?>
                                <option value="1" selected>Admin (Full)</option>
                                <option value="2">Receptionist (Moderate)</option>
                              <?php
                              }
                              else if($admin->access_level==2)
                              {
                                ?>
                                <option value="2" selected>Receptionist (Moderate)</option>
                                <option value="1">Admin (Full)</option>
                              <?php
                              }


                               ?>
                           
                          </select>
                        </div>
                    </div>
                          <label class="col-sm-2 col-form-label">Shift*</label>
                      <div class="col-lg-3 col-sm-3">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="ad_shift" name="ad_shift" data-style="select-with-transition"  title="Select" data-size="7" tabindex="-98">

                              <?php
                              if($admin->shift=="Morning" || $admin->shift=="morning")
                              {
                                ?>
                                <option selected value="Morning">Morning</option>
                                <option value="Evening">Evening</option>
                                <?php
                              }
                              else if($admin->shift=="evening" || $admin->shift=="Evening")
                              {
                                ?>
                                <option selected value="Evening">Evening</option>
                                <option value="Morning">Morning</option>

                                <?php

                              }

                              ?>
                           
                          </select>
                        </div>
                    </div>

                  </div>

                     <div class="card-footer">
                  <input  type="button" onclick="edit_admin(<?php echo $admin->admin_id ?>)" value="Submit" readonly id="submit_vis" class="btn btn-fill btn-success">
                   
                </div>


                  </form>
                </div>
                
               

              </div>
            </div>
            
          </div>
        </div>
      </div>

            <div class="content" style="margin-top: -120px">
        <div class="container-fluid">
          <div class="row">
            
            
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Update Password</h4>
                  </div>
                </div>
                <div class="card-body ">
                  <form method="POST" action=""  class="form-horizontal ajax" id="pkg_form">

                  

                    <div class="row">
                      
                       <label class="col-sm-2 col-form-label">New Password</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                        
                          <input type="text" id="new_pass" name="new_pass" class="form-control" required>
                        </div>
                      </div>
                    </div>

                       <div class="row">
                      


                     <div class="card-footer">
                  <input  type="button" onclick="edit_pass(<?php echo $admin->admin_id ?>)" value="Update" readonly id="update_pass" class="btn btn-fill btn-success">
                   
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

function edit_admin(id)
{

$(document).ready(function(){



    var f_name=$('#ad_fname').val();
    var l_name=$('#ad_lname').val();
    var email=$('#ad_email').val();
   
    var level=$('#ad_level').val();
    var shift=$('#ad_shift').val();


    if(f_name=='')
    {
       md.showNotification('bottom','right','First name is required',2);
    }
    else if(l_name=='')
    {
       md.showNotification('bottom','right','Last name is required',2);
    }
    else if(email=='')
    {
       md.showNotification('bottom','right','Email is required',2);
    }
    else if(level=='' || level=='0')
    {
       md.showNotification('bottom','right','Specify Access Level',2);
    }
    else if(shift=='' || shift=='0')
    {
     md.showNotification('bottom','right','Specify Shift',2); 
    }
    else 
    {


        $.ajax({

      method:'POST',
      url:'<?php echo base_url('Admin/editAdmin_Controller') ?>',
      data:{id:id,fname:f_name,lname:l_name,email:email,level:level,shift:shift},
      success:function(result)
      {
        if(result=='true')
        {
          md.showNotification('bottom','right','Admin details updated',3);
           setTimeout(function(){
              location.href="<?php echo base_url()."Admin/showAdmins" ?>";
            },2000);
        }
        else if(result=='false')
        {
          md.showNotification('bottom','right','Something went wrong ! Please try again',2);
        }
      
       
      }

    });
        

    }

});


}

function edit_pass(id)
{
  $(document).ready(function(){


   var new_pass=$('#new_pass').val();

    
  
    if(new_pass==='')
    {
      md.showNotification('bottom','right','Old password is required',2);
    }
    else
    {
        $.ajax({

      method:'POST',
      url:'<?php echo base_url('Admin/editAdminPass_Controller') ?>',
      data:{id:id,pass:new_pass},
      success:function(result)
      {
        if(result=='false')
        {
          md.showNotification('bottom','right','Password update failed. Please try again',2);
        }
        else if(result=='true')
        {
          md.showNotification('bottom','right','Password Updated',3);
        }
       
        
      }
    });
    }

});
}

    </script>