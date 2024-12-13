<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Apartment Visitor Management System in CodeIgniter">
    <meta name="author" content="Anuj Kumar">
    <meta name="keywords" content="PHPGurukul | Programming Blog">

    <!-- Title Page-->
    <title>AVSM Admin Profile</title>

<?php echo link_tag('assets/css/font-face.css'); ?>
<?php echo link_tag('assets/vendor/font-awesome-4.7/css/font-awesome.min.css'); ?>
<?php echo link_tag('assets/vendor/font-awesome-5/css/fontawesome-all.min.css'); ?>
<?php echo link_tag('assets/vendor/mdi-font/css/material-design-iconic-font.min.css'); ?>
<!-- Bootstrap CSS-->
<?php echo link_tag('assets/vendor/bootstrap-4.1/bootstrap.min.css'); ?>
<!-- Vendor CSS-->
<?php echo link_tag('assets/vendor/animsition/animsition.min.css'); ?>
<?php echo link_tag('assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css'); ?>
<?php echo link_tag('assets/vendor/wow/animate.css'); ?>
<?php echo link_tag('assets/vendor/css-hamburgers/hamburgers.min.css'); ?>
<?php echo link_tag('assets/vendor/select2/select2.min.css'); ?>
<?php echo link_tag('assets/vendor/perfect-scrollbar/perfect-scrollbar.css'); ?>
<!-- Main CSS-->
<?php echo link_tag('assets/css/theme.css'); ?>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <?php include_once('includes/sidebar.php');?>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php include_once('includes/header.php');?>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                          
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Update</strong> Admin Profile
                                    </div>
                                    <div class="card-body card-block">
<!--success message -->
<?php if($this->session->flashdata('success')){?>
<p style="color:red"><?php  echo $this->session->flashdata('success');?></p>    
<?php } ?>

<!--error message -->
<?php if($this->session->flashdata('error')){?>
<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>  
<?php } ?>
                                        
 <?php echo form_open('AdminProfile/Update',['name'=>'adminprofile'])?>

                                            <div class="row form-group">
                                                <div class="col col-md-3">
<?php echo form_label('Admin Name', 'adminname'); ?>
                                                </div>
                                                <div class="col-12 col-md-9">
<?php echo form_input(['name'=>'fullname','id'=>'fullname','class'=>'form-control','value'=>set_value('fullname',$profile->AdminName)]);?>
<?php echo form_error('fullname','<div style="color:red">','<div>')?>
                                                    
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
<?php echo form_label('Email Id', 'emailid'); ?>
                                                </div>
                                                <div class="col-12 col-md-9">
<?php echo form_input(['name'=>'emailid','id'=>'emailid','class'=>'form-control','value'=>set_value('emailid',$profile->Email)]);?>
<?php echo form_error('emailid','<div style="color:red">','<div>')?>
                                                    
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
<?php echo form_label('Mobile Number', 'mobilenumber'); ?>
                                                </div>
                                                <div class="col-12 col-md-9">
<?php echo form_input(['name'=>'mobilenumber','id'=>'mobilenumber','class'=>'form-control','value'=>set_value('mobilenumber',$profile->MobileNumber)]);?>
<?php echo form_error('mobilenumber','<div style="color:red">','<div>')?>
                                                    
                                                </div>
                                            </div>
                                          
                                            <div class="row form-group">
                                                <div class="col col-md-3">
<?php echo form_label('User Name', 'username'); ?>
                                                </div>
                                                <div class="col-12 col-md-9">
<?php echo form_input(['name'=>'username','id'=>'username','class'=>'form-control','value'=>set_value('username',$profile->UserName),'readonly'=>'ture']);?>
<?php echo form_error('username','<div style="color:red">','<div>')?>

                                                </div>
                                            </div>
                                             <div class="row form-group">
                                                <div class="col col-md-3">
<?php echo form_label('Registration Date', 'regdate'); ?>
                                                </div>
                                                <div class="col-12 col-md-9">
<?php echo form_input(['name'=>'regdate','id'=>'regdate','class'=>'form-control','value'=>set_value('regdate',$profile->AdminRegdate),'readonly'=>'ture']);?>
                                                    
                                                </div>
                                            </div>
                                                                                        
                                
                                          <div class="card-footer">
                                        <p style="text-align: center;"><?php echo form_submit(['name'=>'submit','value'=>'Update','class'=>'btn btn-primary btn-sm']); ?></p>
                                        
                                    </div>
                                        </form>
                                    </div>
                                   
                                </div>
                       
                     
                        
      
<?php include_once('includes/footer.php');?>
              </div>
                </div>
            </div>
        </div>
   </div>
    </div>
      <!-- Jquery JS-->
    <script src="<?php echo base_url('assets/vendor/jquery-3.2.1.min.js'); ?>"></script>
    <!-- Bootstrap JS-->
    <script src="<?php echo base_url('assets/vendor/bootstrap-4.1/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap-4.1/bootstrap.min.js'); ?>"></script>
    <!-- Vendor JS       -->
    <script src="<?php echo base_url('assets/vendor/slick/slick.min.js'); ?>">
    </script>
    <script src="<?php echo base_url('assets/vendor/wow/wow.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/animsition/animsition.min.js'); ?>"></script>
    <script src="<?php echo base_url('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js'); ?>">
    </script>
    <script src="<?php echo base_url('assets/vendor/counter-up/jquery.waypoints.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/counter-up/jquery.counterup.min.js'); ?>">
    </script>
    <script src="<?php echo base_url('assets/vendor/circle-progress/circle-progress.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/chartjs/Chart.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/select2/select2.min.js'); ?>">
    </script>
    <!-- Main JS-->
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->