<div class="main-panel ps-container ps-theme-default" data-ps-id="944ece5a-d448-39e8-aadf-2abeef99bbb4">
      <!-- Navbar -->
      
      
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Edit Daily Visitor</h4>
                  </div>
                </div>
                <div class="card-body ">
                  <form method="POST" action=""  class="form-horizontal ajax" id="visitor_form">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Name*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_name" name="vis_name" value="<?php echo $visitor->user_name ?>" class="form-control" required>
                          
                        </div>
                      </div>
                    </div>
                  

                    <div class="row">
                      
                       <label class="col-sm-2 col-form-label">Identity Card No.*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_cnic" name="vis_cnic" class="form-control" value="<?php echo $visitor->user_nic?>" required>
                        </div>
                      </div>
                    </div>
                    

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Address*</label>
                      <div class="col-sm-8">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_address" name="vis_address" class="form-control" value="<?php echo $visitor->user_address ?>" required>
                          
                        </div>
                      </div>
                    </div>
                    

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Cell No*</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="vis_tel" name="vis_tel" class="form-control" placeholder="xxxxxxxxxx" value="<?php echo $visitor->user_cellnumber ?>" required>
                        </div>
                      </div>
                    </div>


                     <div class="card-footer">
                  <input  type="button" onclick="edit_visitor()" value="Submit" readonly id="submit_vis" class="btn btn-fill btn-success">
                   
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

function edit_visitor()
{

$(document).ready(function(){


    var namee=$('#vis_name').val();
    var cnicc=$('#vis_cnic').val();
    var tell=$('#vis_tel').val();
    var addd=$('#vis_address').val();
  
    
   
    if(namee==='')
    {
      md.showNotification('bottom','right','Name field is empty',2);
    }
    else if(cnicc==='')
    {
      md.showNotification('bottom','right','Identity Card No. field is empty',2);
    }
    else if(tell==='')
    {
      md.showNotification('bottom','right','Cell No field is empty',2);
    }
    else if(addd==='')
    {
      md.showNotification('bottom','right','Address field is empty',2);
    }
   
    else
    {
        $.ajax({

      method:'POST',
      url:'<?php echo base_url('Admin/editDailyVisitorController') ?>',
      data:{id:'<?php echo $visitor->user_id ?>',name:namee,cnic:cnicc,tel:tell,address:addd},
      success:function(result)
      {

        if(result=='true')
        {
           md.showNotification('bottom','right','Visitor updated successfully',3);
           setTimeout(function(){
              location.href="<?php echo base_url()."Admin/showDailyVisitors" ?>";
            },2000);
        }
        else if(result=='false')
        {
          md.showNotification('bottom','right','Visitor not updated ! Something went wrong. Please try again later.',2);
        }
    
      }
    });
    }

 
  





});


}

    </script>