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
                    <i class="material-icons">receipt</i>
                  </div>
                  <h3 class="card-title">Logs</h3>
              
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
                          <th>Type</th>
                          <th>Operation</th>
                          <th>Remarks</th>
                          <th>Date/Time</th>
                    
                          </tr>
                      </thead>
                    
                      <tbody>
                      
                          <?php
                          if($logs->num_rows()>0)
                          {
                            foreach($logs->result() as $log)
                            {
                              ?>

                              <tr>

                                <td><?php echo $log->id ?></td>
                                <td><?php echo $log->type ?></td>
                                <td><?php echo $log->operation ?></td>
                                <td><?php echo $log->remarks ?></td>
                                <td><?php echo $log->time_stamp ?></td>
                            

                       


                              </tr>

                              <?php

                            }
                          }
                        else
                        {
                          ?>
                          <h4>No Logs</h4>
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

      function del_visitor(id)
      {
       

        $(document).ready(function(){

        $.ajax({
          method:"POST",
          url:'<?php echo base_url('Admin/delDailyVisitorController') ?>',
          data:{delid:id},
          success:function()
          {

            md.showNotification('bottom','right','Visitor Deleted Successfully',3);
            setTimeout(function(){
              location.reload();
            },3000)

            
          }
        });
    


        });
    

    }
     
    </script>
