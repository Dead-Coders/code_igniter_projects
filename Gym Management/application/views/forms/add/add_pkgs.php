<div class="main-panel ps-container ps-theme-default" data-ps-id="944ece5a-d448-39e8-aadf-2abeef99bbb4">
      <!-- Navbar -->
      
      
      <div class="content" id="pkgs_add_form">
        <div class="container-fluid">
          <div class="row">
            
            
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary card-header-text">
                  <div class="card-text">
                    <h4 class="card-title">Add Package/Items</h4>
                  </div>
                </div>
                <div class="card-body ">
                  <form method="POST" action="" name="pkg_form"  class="form-horizontal ajax" id="pkg_form" enctype="multipart/form-data" >
                    <div class="row">
                      <label class="col-sm-2 col-form-label"> Package/Item Name</label>
                      <div class="col-sm-3">
                        <div class="form-group bmd-form-group">
                          <input type="text" id="name" name="name" class="form-control" required>
                          
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

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Type</label>
                      <div class="col-lg-3 col-sm-3">
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="pkg_type" onchange="changeDropDown()" name="pkg_type" data-style="select-with-transition"  title="Select" data-size="7" tabindex="-98">
                           
                           <option value="" selected>Select</option>
                           <option value="Daily">Daily</option>
                           <option value="Monthly">Monthly</option>
                           <option value="TM">Therapy/Massage</option>
                           <option value="Workout">Workout Plan</option>
                           <option value="Juice">Juice Bar</option>

                          </select>
                        </div>
                    </div>

                    </div>

                  
                    <div  class="row">
                      

                       <label class="col-sm-2 col-form-label" id="duration_label"></label>
                           <div class="col-lg-3 col-sm-3" id="duration" style="display: none">
                           
                          <div class="dropdown bootstrap-select show-tick">
                            <select class="selectpicker" id="duration1" name="duration1" data-style="select-with-transition"  title="Select" data-size="7" tabindex="-98">
                           
                           <option value="" selected>Select Months</option>
                           <option value="1">1</option>
                           <option value="2">2</option>
                           <option value="3">3</option>
                           <option value="4">4</option>
                           <option value="5">5</option> 
                           <option value="6">6</option> 
                           <option value="7">7</option> 
                           <option value="8">8</option> 
                           <option value="9">8</option> 
                           <option value="10">9</option> 
                           <option value="11">11</option>
                           <option value="12">12</option>  


                          </select>
                        </div>
                      </div>


                     
                  </div>
             


                     <div class="card-footer">
                  <input  type="button" onclick="add_package()" value="Submit" readonly id="submit_pkg" class="btn btn-fill btn-success">
                   
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


 function changeDropDown()

  {

       var selectedValue=document.getElementById('pkg_type').value; 
       if(selectedValue=='Monthly')
       {

        document.getElementById('duration_label').innerHTML="Months";
        document.getElementById('duration_label').style.display="show";
        document.getElementById('duration').style.display="";        

       }
        if(selectedValue=='Juice')
       {
        document.getElementById('duration').style.display="none";
     
         document.getElementById('duration_label').innerHTML="";



       }
        if(selectedValue=='TM')
       {
       

        document.getElementById('duration').style.display="none";
        document.getElementById('duration_label').innerHTML="";
      
       }
        if(selectedValue=='Daily')
       {

        document.getElementById('duration').style.display="none";
        document.getElementById('duration_label').innerHTML="";
       }

       if(selectedValue=='Workout')
       {

        document.getElementById('duration').style.display="none";
        document.getElementById('duration_label').innerHTML="";
       }


   }


function add_package()
{

$(document).ready(function(){


    var name=$('#name').val();
    var price=$('#price').val();
    var type=$('#pkg_type').val();
    var duration=$('#duration1').val();

    var chk=checkItems(name,price,duration);

 if(chk==true)
    {
        $.ajax({

             method:'POST',
             url:'<?php echo base_url('Admin/addPackages_controller') ?>',
              data:{duration:duration,price:price,name:name,type:type},
               success:function()
              {
                 md.showNotification('bottom','right','Package/Item Added Successfully',3);
                 document.getElementById('duration').style.display="none";
                document.getElementById("pkg_form").reset();

              }
            });
    }
    

});


}

function checkItems(name,price,duration)
{
  var abc=document.getElementById('pkg_type').value;

  if(price=='')
  {
    md.showNotification('bottom','right','Price is required',2);
    return false;
  }

  if(abc=='Monthly')
  {
    if(duration=='')
    {
      md.showNotification('bottom','right','Months Duration is required',2);
      return false;
    }
    else 
    {
      return true;
    }
  }
  else if(abc=='Juice')
  {
    
    return true;

  }
  else if(abc=='TM')
  {
    if(name=='')
    {
      md.showNotification('bottom','right','Name is required',2);
      return false;
    }
    else
    {
      return true;
    }
  }
  else if(abc=='Daily')
  {
    if(name=='')
    {
       md.showNotification('bottom','right','Name is required',2);
      return false;
    }

    else
    {
      return true;
    }
  }
  else if(abc=='Workout')
  {
    if(name=='')
    {

     md.showNotification('bottom','right','Name is required',2);
      return false; 
    }
    else
    {
      return true;
    }
  }

}

    </script>