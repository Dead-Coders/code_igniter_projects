<div class="main-panel ps-container ps-theme-default" data-ps-id="944ece5a-d448-39e8-aadf-2abeef99bbb4">
      <!-- Navbar -->
      
      
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            
            
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-rose card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Add Package</h4>
                  </div>
                </div>
                <div class="card-body ">
                  <form method="POST" action=""  class="form-horizontal ajax" id="pkg_form">
                    <div class="row">
                      <label class="col-sm-2 col-form-label"> Months Duration</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="duration" name="duration" class="form-control" required>
                          
                        </div>
                      </div>
                    </div>
                  

                    <div class="row">
                      
                       <label class="col-sm-2 col-form-label">Price</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="price" name="price" class="form-control" required>
                        </div>
                      </div>
                    </div>

                     <div class="card-footer">
                  <input  type="button" onclick="add_package()" value="Submit" readonly id="submit_pkg" class="btn btn-fill btn-rose">
                   
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

function add_package()
{

$(document).ready(function(){


    var duration=$('#duration').val();
    var price=$('#price').val();
   
    if(duration==='')
    {
      md.showNotification('bottom','right','Months duration is required',2);
    }
    else if(price==='')
    {
      md.showNotification('bottom','right','Package Price is required',2);
    }

    else
    {
        $.ajax({

      method:'POST',
      url:'<?php echo base_url('Admin/addMonthlyPackage_Controller') ?>',
      data:{duration:duration,price:price},
      success:function()
      {
        md.showNotification('bottom','right','Package Added Successfully',3);
       document.getElementById("pkg_form").reset();
      }
    });
    }

});


}

    </script>