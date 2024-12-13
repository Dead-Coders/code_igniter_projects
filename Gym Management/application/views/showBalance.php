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
                    <i class="material-icons">money</i>
                  </div>
                  <h3 class="card-title">Remaining Balance</h3>
                  
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
                          <th>Member No</th>
                          <th>Name</th>
                          <th>Member Type</th>
                          <th>Packages</th>
                          <th>Balance</th>
                          <th>Payment Date</th>
                          <th>Action</th>
                       
                        </tr>
                      </thead>
                      
                      <tbody>
                      
                          <?php
                          if($reps->num_rows()>0)
                          {
                            $counter=0;
                            foreach($reps->result() as $rep)
                            {
                              $counter++;
                              ?>

                              <tr>

                                <td><?php echo $counter ?></td>
                                <td><?php echo $rep->membership_no ?></td>
                                <td><?php echo $rep->member_name?></td>
                                <td><?php echo $rep->member_type ?></td>
                                <td><?php echo $rep->packages ?></td>
                                <td>$ <?php echo $rep->balance ?></td>
                                <td>  <?php echo $rep->fee_date ?></td>
                                <td> <button type="button" onclick="Pay(<?php echo $rep->id_r ?>)" class="btn btn-success btn-sm">Pay</button></td>
                              </tr>

                              <?php

                            }
                          }
                        else
                        {
                          ?>
                          <h4>NIL</h4>
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

      function Pay(id)
      {
       

        $(document).ready(function(){

       

        $.ajax({
          method:"POST",
          url:'<?php echo base_url('Admin/editBalance_Controller') ?>',
          data:{id:id},
          success:function(result)
          {
            if(result=='true')
            {

            md.showNotification('bottom','right','Payment Completed',3);
            setTimeout(function(){
              location.reload();
            },2000)

            }
            else if(result=='false')
            {

            md.showNotification('bottom','right','Payment not completed',2);

            }
            else
            {
              md.showNotification('bottom','right','Payment not completed',2);
            }


            
          }
        });
    


        });
    

    }

     
    </script>
    
