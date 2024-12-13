
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Blood Donor Management System | Report</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?php echo base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/vendors/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/vendors/themify-icons/css/themify-icons.css')?>" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <!-- THEME STYLES-->
    <link href="<?php echo base_url('assets/css/main.min.css')?>" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <?php include APPPATH.'views/admin/include/header.php';?>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <?php include APPPATH.'views/admin/include/sidebar.php';?>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">Report</h1>
               
            </div>
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox">
                           <div class="ibox-body">
                            <?php echo form_open('admin/Report',['name'=>'report']);?>
                            <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>From Date</label>
                                          <input type="date" name="fromdate" value="" id="fromdate" class="form-control" data-date-format="yyyy-mm-dd" required=""/>
                                         <span style="color:red;"><?php echo form_error('fromdate')?></span>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>To Date</label>
                                            <input type="date" name="todate" value="" id="todate" required="" class="form-control" data-date-format="yyyy-mm-dd"/>
                                            <span style="color:red;"><?php echo form_error('todate')?></span>
                                        </div>
                                     </div>
                                   
                                    <div class="form-group">
                                    <?php echo form_submit(['name'=>'submit','id'=>'submit','class'=>'btn btn-primary','value'=>'submit']);?>
                                    </div>
                                    <?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                </div>
                    
                <?php 
                if(Isset($_POST['submit'])){?>
                <div class="row">
                    <div class="col-md-12">
                    <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                    <?php
$fdate=$_POST['fromdate'];
$tdate=$_POST['todate'];
$fromdate = date("d-m-Y", strtotime($fdate));
$todate = date("d-m-Y", strtotime($tdate));
?>
<h4 align="center" style="color:blue">Report from <?php echo $fromdate?> to <?php echo $todate?></h4>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Contact No</th>
                                    <th>State</th>
                                    <th>Blood Group</th>
                                </tr>
                            </thead>
                            
                            <?php
count($reportdetails);
if(count($reportdetails)) :
$cnt=1; 
foreach ($reportdetails as $row) :
?>  
              
<tr>
<td><?php echo $cnt;?></td>
<td><?php  echo $row->first_name;?>&nbsp;&nbsp;<?php  echo $row->last_name;?></td>
<td><?php  echo $row->gender;?>
<td><?php  echo $row->email;?></td>
<td><?php  echo $row->contact_no;?></td>
<td><?php  echo $row->state;?></td>
<td><?php  echo $row->bloodname;?></td>
</tr>
 <?php 
$cnt++;
endforeach;
else : ?>

<tr>
<td colspan="6" style="text-align:center">No Record found</td>
</tr>
<?php
endif;
?>  
                        </table>
                    </div>
                </div>
                    </div>
                </div>
                    <?php } ?>
              
                  

            <!-- END PAGE CONTENT-->
            <?php include APPPATH.'views/admin/include/footer.php';?>
        </div>
    </div>
  
    <!-- CORE PLUGINS-->
    <script src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/popper.js/dist/umd/popper.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/metisMenu/dist/metisMenu.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js')?>" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <!-- CORE SCRIPTS-->
    <script src="<?php echo base_url('assets/js/app.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/DataTables/datatables.min.js')?>" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <!-- <script type="text/javascript">
        $(function() {
            $('#example-table').DataTable({
                pageLength: 10,
                
            });
        })
    </script> -->
</body>

</html>