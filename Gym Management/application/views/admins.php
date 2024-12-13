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
                    <i class="material-icons">people</i>
                  </div>
                  <h3 class="card-title">Admins</h3>
                  <?php 
                  if($this->session->userdata('access_level')==1)
                  {
                    ?>

                    <a href="<?php echo base_url()."Admin/addAdmin_Form" ?>" class="pull-right btn btn-success btn-round" title="Add Admin"><i class="material-icons">person_add</i><div class="ripple-container"></div></a>

                    <?php
                  }
                  ?>

                  
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead class="thead-dark">
                        <tr>
                          <th>Admin ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Shift</th>
                          <th>Access Level</th>

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
                          if($admins->num_rows()>0)
                          {
                            foreach($admins->result() as $ad)
                            {
                              ?>

                              <tr>

                                <td><?php echo $ad->admin_id ?></td>
                                <td><?php echo $ad->first_name." ".$ad->last_name ?></td>
                                <td><?php echo $ad->admin_email ?></td>
                                <td><?php echo $ad->shift ?></td>
                                <td><?php if($ad->access_level==1)
                                {
                                  echo "Full";
                                }
                                else if($ad->access_level==2)
                                {
                                  echo "Moderate";
                                } ?></td>


                                <?php 
                                if($this->session->userdata('access_level')==1)
                                {
                                  ?>
                                    <td class="text-right">
                                    
                                    <button type="button" onclick="Move(<?php echo $ad->admin_id ?>)" class="btn btn-link btn-warning btn-just-icon remove"><i class="material-icons">edit</i>

                                  
                                    <button type="button" onclick="del_admin(<?php echo $ad->admin_id ?>,'<?php echo $ad->first_name." ".$ad->last_name  ?>')" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i>
                                  
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
                          <h4>No Visitors</h4>
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

      function del_admin(id,name)
      {
       
        if(confirm("Are you sure you want to remove user ?"))
        {


        $(document).ready(function(){

        $.ajax({
          method:"POST",
          url:'<?php echo base_url('Admin/delAdmin_Controller') ?>',
          data:{delid:id,name:name},
          success:function(result)
          {
            if(result=='true')
            {

            md.showNotification('bottom','right','Admin Deleted Successfully',3);
            setTimeout(function(){
              location.reload();
            },2500)

            }
            else if(result=='false')
            {

            md.showNotification('bottom','right','Something went wrong ! Please try again',2);

            }
      
          }
        });
    
    });
    

        }
        else
        {

        }

    }
    function Move(id)
    {
      location.href="<?php echo base_url()."Admin/editAdmin_Form/" ?>"+id;
    }
     
    </script>
    }
