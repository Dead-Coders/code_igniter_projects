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
                  <h3 class="card-title">Daily Visitors</h3>
                  <?php 
                  if($this->session->userdata('access_level')==1)
                  {
                    ?>

                    <a href="<?php echo base_url()."Admin/addVisitorForm" ?>" class="pull-right btn btn-primary btn-round" title="Add Visitor"><i class="material-icons">person_add</i><div class="ripple-container"></div></a>

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
                          <th>Visitor ID</th>
                          <th>Visitor Name</th>
                          <th>Contact</th>
                          <th>Address</th>
                          <th>Date</th>

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
                          if($daily_vis->num_rows()>0)
                          {
                            foreach($daily_vis->result() as $vis)
                            {
                              ?>

                              <tr>

                                <td><?php echo $vis->user_id ?></td>
                                <td><?php echo $vis->user_name ?></td>
                                <td><?php echo $vis->user_cellnumber ?></td>
                                <td><?php echo $vis->user_address ?></td>
                                <td><?php echo $vis->time_stamp ?></td>


                                <?php 
                                if($this->session->userdata('access_level')==1)
                                {
                                  ?>
                                    <td class="text-right">
                                    
                                    <button type="button" onclick="Move(<?php echo $vis->user_id ?>)" class="btn btn-link btn-warning btn-just-icon remove"><i class="material-icons">edit</i>

                                  
                                    <button type="button" onclick="del_visitor(<?php echo $vis->user_id ?>,'<?php echo $vis->user_name ?>')" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i>
                                  
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

      function del_visitor(id,name)
      {
       
        if(confirm("Are you sure you want to remove user ?"))
        {


        $(document).ready(function(){

        $.ajax({
          method:"POST",
          url:'<?php echo base_url('Admin/delDailyVisitorController') ?>',
          data:{delid:id,name:name},
          success:function(result)
          {
            if(result=='true')
            {

            md.showNotification('bottom','right','Visitor Deleted Successfully',3);
            setTimeout(function(){
              location.reload();
            },3000)

            }
            else if(result=='false')
            {

            md.showNotification('bottom','right','Visitor Not Deleted ! Something went wrong. Please try again later',2);

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
      location.href="editDailyVisitorForm/"+id;
    }
     
    </script>
    }
