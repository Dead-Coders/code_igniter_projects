<div class="main-panel ps-container ps-theme-default" data-ps-id="944ece5a-d448-39e8-aadf-2abeef99bbb4">
      <!-- Navbar -->
      
      
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            
            
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Edit Profile</h4>
                  </div>
                </div>
                <div class="card-body ">
                  <form method="POST" action=""  class="form-horizontal ajax" id="pkg_form">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">First Name</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="fname" name="fname" value="<?php echo $admin->first_name?>" class="form-control" required>
                          
                        </div>
                      </div>
                    </div>
                  

                    <div class="row">
                      
                       <label class="col-sm-2 col-form-label">Last Name</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                        
                          <input type="text" id="lname" name="lname" class="form-control" value="<?php echo $admin->last_name ?>" required>
                        </div>
                      </div>
                    </div>

                       <div class="row">
                      
                       <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                        
                          <input type="text" id="email" name="email" class="form-control" value="<?php echo $admin->admin_email ?>" required>
                        </div>
                      </div>
                    </div>

                       <div class="row">
                      


                     <div class="card-footer">
                  <input  type="button" onclick="edit_admin()" value="Update" readonly id="submit_pkg" class="btn btn-fill btn-success">
                   
                </div>


                  </form>
                </div>
                
               

              </div>
            </div>
            
          </div>
        </div>
      </div>


      <div class="content">
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
                      <label class="col-sm-2 col-form-label">Old Password</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="Password" id="old_pass" name="old_pass" class="form-control" required>
                          
                        </div>
                      </div>
                    </div>
                  

                    <div class="row">
                      
                       <label class="col-sm-2 col-form-label">New Password</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                        
                          <input type="Password" id="new_pass" name="new_pass" class="form-control" required>
                        </div>
                      </div>
                    </div>

                       <div class="row">
                      
                       <label class="col-sm-2 col-form-label">Confirm Password</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                        
                          <input type="Password" id="cnew_pass" name="cnew_pass" class="form-control" required>
                        </div>
                      </div>
                    </div>

                       <div class="row">
                      


                     <div class="card-footer">
                  <input  type="button" onclick="edit_pass()" value="Update" readonly id="update_pass" class="btn btn-fill btn-success">
                   
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

function edit_admin()
{

$(document).ready(function(){


    var f_name=$('#fname').val();
    var l_name=$('#lname').val();
    var email=$('#email').val();
  
    if(email==='')
    {
      md.showNotification('bottom','right','Email cannot be empty',2);
    }
    
    else
    {
        $.ajax({

      method:'POST',
      url:'<?php echo base_url('Admin/editProfile_Controller') ?>',
      data:{fname:f_name,lname:l_name,email:email},
      success:function(result)
      {
        if(result=='false')
        {
          md.showNotification('bottom','right','Profile update failed.',2);
        }
        else if(result=='true')
        {
          md.showNotification('bottom','right','Profile Updated',3);
        }
        
      }
    });
    }

});


}


function edit_pass()
{

$(document).ready(function(){


    var old=$('#old_pass').val();
    var n_pass=$('#new_pass').val();
    var c_new_pass=$('#cnew_pass').val();

    
  
    if(old==='')
    {
      md.showNotification('bottom','right','Old password is required',2);
    }
    else if(n_pass==='')
    {
      md.showNotification('bottom','right','New Password is required',2);
    }
    else if(c_new_pass==='')
    {
      md.showNotification('bottom','right','Confirm your password',2);
    }
    else if(n_pass!=c_new_pass)
    {
      md.showNotification('bottom','right','Passwords doesnot Matches',2);
    }
    
    else
    {
        $.ajax({

      method:'POST',
      url:'<?php echo base_url('Admin/editPassword_Controller') ?>',
      data:{old_pass:old,new_pass:n_pass},
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
        else if(result=='NotMatch')
        {
         md.showNotification('bottom','right','Wrong Old Password',2); 
       
        }
        
      }
    });
    }

});


}

    </script>