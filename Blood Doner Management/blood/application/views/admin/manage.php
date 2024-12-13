
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Blood Donor Management System | Manage</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?php echo base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/vendors/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/vendors/themify-icons/css/themify-icons.css')?>" rel="stylesheet" />
    
    <link href="<?php echo base_url('assets/vendors/DataTables/datatables.min.css')?>" rel="stylesheet" />
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
           
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Manage Blood Group</div>
                    </div>
                    	<!--success message -->
<?php if($this->session->flashdata('success')){?>
<p style="color:red"><?php  echo $this->session->flashdata('success');?></p>	
<?php } ?>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php
if(count($viewdetails)):
	$cnt=1;
foreach($viewdetails as $row):
?>
              <tbody>
                <tr>
                  <td><?php echo $cnt;?></td>
              
                  <td><?php  echo $row->bloodname;?></td>
                
                  <td><?php echo anchor("admin/Bloodgroup/delete/{$row->id}",'Delete'); ?>
                         
                  </td>
                </tr>
                <?php 
                    $cnt=$cnt+1;
                    endforeach;
                    else:
                    ?>
                    <tr>
                    <td colspan="5" style="color:red; text-align:center">No Record found</td>
                    </tr>
                    <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
    <script src="<?php echo base_url('assets/vendors/DataTables/datatables.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/app.min.js')?>" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
</body>

</html>

<script type="text/javascript">
        $(function() {
            $('#example-table').DataTable({
                pageLength: 10,
                //"ajax": './assets/demo/data/table_data.json',
                /*"columns": [
                    { "data": "name" },
                    { "data": "office" },
                    { "data": "extn" },
                    { "data": "start_date" },
                    { "data": "salary" }
                ]*/
            });
        })
    </script>