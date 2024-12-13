 <body id="mycont">
<div  class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="ad4dab3a-0431-c2c3-e934-a67efb7d756f">
      <!-- Navbar -->

      <div class="content">
          <div class="container-fluid">
          <div class="row">
            <div class="col-md-14">
              <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">timeline</i>
                  </div>
                  <h3 class="card-title">Sales Reports</h3>
              
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <div class="row">
                      <div class="col-md-6">
                      <label>From:</label> 
                            <input type="date" id="from_date" data-date-format="yyyy-mm-dd" autocomplete="off" id="userdate" class="form-control datepicker">
                      </div>

                      <div class="col-md-6">
                        <div >
                      
                     
                          <label>To:</label> 
                             <input type="date" id="to_date" data-date-format="yyyy-mm-dd" autocomplete="off" id="userdate" class="form-control datepicker">
                        

                       
                           <button type="button" onclick="filter()" class="btn">Filter</button> 
                           
                         
                           <button type="button" onclick="rep_gen()" class="btn btn-danger">Download [PDF]</button> 
                           
                    
                          

                        </div>
                      </div>
                    </div>
                    <table id="datatables" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead class="thead-dark">
                         
                          
                            

                        <tr>
                          <th style="width:5px">#</th>
                          <th>Name</th>
                          <th>Type</th>
                          <th>Packages</th>
                          <th>Tax Applied</th>
                          <th>Total Amount</th>
                          <th>Paid Amount</th>
                          <th>Remaining Balance</th>
                 
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
                    
                      <tbody id="report_rows">
                      
                          <?php
                          if($reports->num_rows()>0)
                          {
                            foreach($reports->result() as $rep)
                            {
                              ?>

                              <tr>

                                <td style="width:5px"><?php echo $rep->id_r ?></td>
                                <td><?php echo $rep->member_name ?></td>
                                <td><?php echo $rep->member_type ?></td>
                                <td><?php echo $rep->packages ?></td>
                                <td>$ <?php echo $rep->tax ?></td>
                                <td>$ <?php echo $rep->fee+$rep->tax ?></td>
                                <td>$ <?php echo $rep->total_amount ?></td>
                                <td><?php echo $rep->balance ?></td>

                      <?php 
                      if($this->session->userdata('access_level')==1)
                      {

                      ?>
                                  <td class="text-right">
                                              <button type="button" onClick="modal_trigger(<?php echo $rep->id_r ?>)" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i>
                                  
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
                          <h4>No Reports</h4>
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

      function modal_trigger(id)
      {
        document.getElementById('report_id').value=id;
        $('#myModal').modal('show');
      }

      function add_bin()
      {
      
         $(document).ready(function(){

            var id=document.getElementById('report_id').value;
        var reason=document.getElementById('myreason').value;
         


                   $.ajax({
                  method:"POST",
                  url:'<?php echo base_url('Admin/addBin_Controller') ?>',
                  data:{id:id,reason:reason},
                 success:function(result)
                  {
                      if(result=='true')
                      {
                          md.showNotification('bottom','right','Report Deleted',3);
                      }
                      else if(result=='false')
                      {
                        md.showNotification('bottom','right','Error deleting report',2);
                      }
                      else
                      {
                        md.showNotification('bottom','right',result,2);
                      }
  
                  }
                  });
    
            

   
        });



      }

      function rep_gen()
      {
        var fromm=document.getElementById('from_date').value;
        var too=document.getElementById('to_date').value;


                 $(document).ready(function(){


            if(too=='' && fromm=='')
            {
               $.ajax({
                  method:"POST",
                  url:'<?php echo base_url('PDF/generate_report') ?>',
                  data:{fromm:'',too:''},
                 success:function(result)
                  {
                  }
                });


            }
           else if(fromm=='')
            {
              md.showNotification('bottom','right','Select From Date',2);

            }
            else if(too=='')
            {
               md.showNotification('bottom','right','Select To Date',2);
            }
            else
            {

                   $.ajax({
                  method:"POST",
                  url:'<?php echo base_url('PDF/generate_report') ?>',
                  data:{fromm:fromm,too:too},
                 success:function(result)
                  {
                  }
                });
    
            }

   
        });


    }

      function filter()
      {
          var fromm=document.getElementById('from_date').value;
          var too=document.getElementById('to_date').value;

           $(document).ready(function(){


            if(too=='' && fromm=='')
            {
             location.reload();
            }
           else if(fromm=='')
            {
              md.showNotification('bottom','right','Select From Date',2);

            }
            else if(too=='')
            {
               md.showNotification('bottom','right','Select To Date',2);
            }
            else
            {

                   $.ajax({
                  method:"POST",
                  url:'<?php echo base_url('Admin/Reports_filter') ?>',
                  data:{fromm:fromm,too:too},
                 success:function(result)
                  {


                      $('#report_rows').html('');
                       $('#report_rows').html(result);
  
                  }
                  });
    
            }

   
        });

        


      }
    
    
    </script>
