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
                    <i class="material-icons">delete</i>
                  </div>
                  <h3 class="card-title">Bins</h3>
              
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
                            <th>Bill No</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Package</th>
                            <th>Amount</th>
                            <th>Balance</th>
                            <th>Cashier</th>
                            <th>Payment Type</th>
                            <th>Date</th>
                            <th>Remarks</th>
                    
                      </tr>
                      </thead>
                    
                      <tbody>
                      
                          <?php
                          if($bins->num_rows()>0)
                          {
                            $counter=0;
                            foreach($bins->result() as $bin)
                            {
                              $counter++;
                              ?>

                              <tr>

                                <td><?php echo $counter ?></td>
                                <td><?php echo $bin->report_id ?></td>
                                <td><?php echo $bin->member_name ?></td>
                                <td><?php echo $bin->member_type ?></td>
                                <td><?php echo $bin->packages ?></td>
                                <td>$ <?php echo $bin->total_amount ?></td>
                                <td><?php echo $bin->balance ?></td>
                                <td><?php echo $bin->cashier ?></td>
                                <td><?php echo $bin->payment_type ?></td>
                                <td><?php echo $bin->fee_date ?></td>
                                <td><?php echo $bin->remarks ?></td>
                            

                       


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
