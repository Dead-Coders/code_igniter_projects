<body id="mycont">
<div  class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="ad4dab3a-0431-c2c3-e934-a67efb7d756f">
      <!-- Navbar -->

      <div class="content">
          <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">how_to_reg</i>
                  </div>
                  <h3 class="card-title">Total Members</h3>
                  
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead class="thead-dark">
                        <tr>
                          <th>#</th>
                          <th>Member No.</th>
                          <th>Name</th>
                          <th>Contact</th>
                          <th>End Date</th>
                          <th>Status</th>
                          <?php
                          if($this->session->userdata('access_level')==1)
                          {
                            ?>
                            <th class="disabled-sorting text-right">Actions</th>  

                            <?php
                          }
                          ?>
                          
                        </tr>
                      </thead>
                      
                      <tbody>
                      
                          <?php
                          if($members->num_rows()>0)
                          {
                            $counter=0;
                            foreach($members->result() as $mem)
                            {
                              $counter++;
                              ?>

                              <tr>

                                <td><?php echo $counter ?></td>
                                <td><?php echo $mem->member_no ?></td>
                                <td><a href='#' onclick="demo.showSwal('custom-html','<?php echo $mem->member_no ?>','<?php echo $mem->member_name ?>','<?php echo $mem->member_father_name ?>','<?php echo $mem->member_telephone ?>','<?php echo $mem->member_nic ?>','<?php echo $mem->member_email ?>','<?php echo $mem->member_resident ?>','<?php echo $mem->member_address ?>')"><?php echo $mem->member_name ?></a></td>
                                <td><?php echo $mem->member_telephone ?></td>
                                <td><?php echo $mem->end_date ?></td>
                                
                                <td>
                                           <!-- <div class="dropdown bootstrap-select show-tick">
                            <select id="mem_status" class="selectpicker" data-style="select-with-transition" onchange="changeStatus(<?php echo $mem->id ?>,<?php echo  "'".$mem->member_name."'" ?>,<?php echo $mem->member_no ?>,<?php echo "'".$mem->status."'" ?>)" title="<?php echo $mem->status ?>" data-size="7" tabindex="-98">
                            
                              <option value="Active">Active</option>
                              <option value="InActive">In Active </option>
                              <option value="Dormant">Dormant</option>
                              <option value="Freeze">Freeze</option> 
                                                  
                             </select>
                              </div> -->

                              <?php echo $mem->status ?>


                                </td>

                                <?php 
                                if($this->session->userdata('access_level')==1)
                                {
                                  ?>

                                  
                                  <td class="text-right">
                                    
                                    <button type="button" onclick="Move(<?php echo $mem->member_no ?>)" class="btn btn-link btn-warning btn-just-icon remove"><i class="material-icons">edit</i>

                                  
                                    <button type="button" onclick="del_member(<?php echo $mem->id ?>,'<?php echo $mem->member_name ?>')" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i>
                                  
                          </td>
                        



                                  <?php

                                }



                                ?>

                              </tr>

                              <?php

                            }
                          }
                        else
                        {
                          ?>
                          <h4>No Members</h4>
                          <?php

                        }


                           ?>
                        
                        
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
          </div>
          <!-- end row -->
        </div>
      </div>
    </div>

    <script>

      function del_member(id,name)
      {
       

        $(document).ready(function(){

       

        $.ajax({
          method:"POST",
          url:'<?php echo base_url('Admin/delMember_Controller') ?>',
          data:{delid:id,name:name},
          success:function(result)
          {
            if(result=='true')
            {

            md.showNotification('bottom','right','Member Deleted Successfully',3);
            setTimeout(function(){
              location.reload();
            },2000)

            }
            else if(result=='false')
            {

            md.showNotification('bottom','right','Member Not Deleted ! Something went wrong. Please try again later',2);

            }


            
          }
        });
    


        });
    

    }

    function Move(id)
    {
      location.href="editMemberForm/"+id;
    }

    function changeStatus(id,mem_name,mem_no,mem_prev_status)
    {

      var status=$('#mem_status').val();

      $(document).ready(function(){

        $.ajax({
          method:"POST",
          url:'<?php echo base_url('Admin/editMember_Status_Controller') ?>',
          data:{id:id,st:status,name:mem_name,no:mem_no,prev_status:mem_prev_status},
          success:function(result)
          {
            if(result=='true')
            {

            md.showNotification('bottom','right','Status Updated Successfully',3);
            setTimeout(function(){
              location.reload();
            },2000)

            }
            else if(result=='false')
            {

            md.showNotification('bottom','right','Something went wrong ! Try again ',2);

            }


            
          }
        });
    


        });

    }

     
    </script>
    
