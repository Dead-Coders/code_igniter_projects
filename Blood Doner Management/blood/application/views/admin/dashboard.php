
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Blood Donor Management System | Dashboard</title>
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
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?php echo htmlentities($totalusercount);?></h2>
                                <div class="m-b-5">TOTAL USERS </div><i class="ti-user widget-stat-icon"></i>
                               
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?php echo htmlentities($totalbloodgroupcount); ?></h2>
                                <div class="m-b-5">TOTAL BLOOD GROUP</div><i class="    fa fa-plus-square widget-stat-icon"></i>
                               
                            </div>
                        </div>
                    </div>
                   
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
    <script src="<?php echo base_url('assets/js/app.min.js')?>" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
</body>

</html>