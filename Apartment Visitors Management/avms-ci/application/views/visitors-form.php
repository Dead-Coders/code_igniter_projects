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
    <title>AVSM Visitors Forms</title>

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
<?php include APPPATH.'views/includes/sidebar.php';?>
   
        <div class="page-container">
            <!-- HEADER DESKTOP-->
    <?php include APPPATH.'views/includes/header.php';?>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                          
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Add</strong> New Visitors
                                    </div>

 

<div class="card-body card-block">
<!---- Success Message ---->
<?php if ($this->session->flashdata('success')) { ?>
<p style="color:green; font-size:18px;"><?php echo $this->session->flashdata('success'); ?></p>
</div>
<?php } ?>

<!---- Error Message ---->
<?php if ($this->session->flashdata('error')) { ?>
<p style="color:red; font-size:18px;"><?php echo $this->session->flashdata('error');?></p>
<?php } ?> 


 <?php echo form_open('Visitor',['name'=>'visitor'])?>

<div class="row form-group">
<div class="col col-md-3">
<?php echo form_label('Visitor Name', 'visitorname'); ?>                   
</div>
<div class="col-12 col-md-9">      
<?php echo form_input(['name'=>'visname','id'=>'visname','value'=>set_value('visname'),'class'=>'form-control','placeholder'=>'Enter visitor name',]);?>
<?php echo form_error('visname','<div style="color:red">', '</div>'); ?>                                   
</div>
</div>
                                            

<div class="row form-group">
<div class="col col-md-3">
<?php echo form_label('Mobile Number', 'mobilenumber'); ?>    
</div>
<div class="col-12 col-md-9">
<?php echo form_input(['name'=>'mobilenumber','id'=>'mobilenumber','value'=>set_value('mobilenumber'),'class'=>'form-control','placeholder'=>'Enter visitor mobile number',]);?> 
<?php echo form_error('mobilenumber','<div style="color:red">', '</div>'); ?>                         
</div>
</div>
                                          
<div class="row form-group">
<div class="col col-md-3">
<?php echo form_label('Visitor Address', 'Address'); ?> 
</div>
<div class="col-12 col-md-9">
<?php echo form_textarea(['name'=>'address','rows'=>'5','cols'=>'60','id'=>'address','class'=>'form-control','placeholder'=>'Enter Visitor address','value'=>set_value('address')]);?>
<?php echo form_error('address','<div style="color:red">', '</div>'); ?>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<?php echo form_label('Apartment no.', 'apartmentno'); ?> 
</div>
<div class="col-12 col-md-9">
<?php echo form_input(['name'=>'apartment','id'=>'apartment','value'=>set_value('apartment'),'class'=>'form-control','placeholder'=>'Apartment no.',]);?> 
<?php echo form_error('apartment','<div style="color:red">', '</div>'); ?>   
</div>
</div>
                                           
<div class="row form-group">
<div class="col col-md-3">
<?php echo form_label('Floor/Wing', 'floorwing'); ?> 
</div>
<div class="col-12 col-md-9">
<?php echo form_input(['name'=>'floor','id'=>'floor','value'=>set_value('floor'),'class'=>'form-control','placeholder'=>'Floor',]);?>  
<?php echo form_error('floor','<div style="color:red">', '</div>'); ?>
</div>
</div>
                                            
<div class="row form-group">
<div class="col col-md-3">
<?php echo form_label('Whom to Meet', 'whomtomeet'); ?>
</div>
<div class="col-12 col-md-9">
<?php echo form_input(['name'=>'whomtomeet','id'=>'whomtomeet','value'=>set_value('whomtomeet'),'class'=>'form-control','placeholder'=>'Whom to Meet',]);?>   
<?php echo form_error('whomtomeet','<div style="color:red">', '</div>'); ?>
</div>
</div>
                                            
<div class="row form-group">
<div class="col col-md-3">
<?php echo form_label('Reason To Meet', 'reasontomeet'); ?>
</div>
<div class="col-12 col-md-9">
<?php echo form_input(['name'=>'reasontomeet','id'=>'reasontomeet','value'=>set_value('reasontomeet'),'class'=>'form-control','placeholder'=>'Whom to Meet',]);?>   
<?php echo form_error('reasontomeet','<div style="color:red">', '</div>'); ?>
</div>
</div>
                                            
<div class="card-footer">
<p style="text-align: center;">
<?php echo form_submit(['name'=>'submit','value'=>'submit','class'=>'btn btn-primary btn-sm']); ?>
</p>
                                        
                                    </div>
                                        </form>
                                    </div>
                                   
                                </div>
                       
                        </div>
                        
                    </div>
               
 
 <?php include APPPATH.'views/includes/footer.php';?>
   </div> </div>
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

</body>

</html>
<!-- end document-->
