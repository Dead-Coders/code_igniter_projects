<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="description" content="Apartment Visitor Management System in CodeIgniter">
    <meta name="author" content="Anuj Kumar">
    <meta name="keywords" content="PHPGurukul | Programming Blog">
    <!-- Title Page-->
    <title>AVSM Visitors Details</title>
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
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
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
                                        <strong>Visitor</strong>  Details
                                    </div>
                                    <div class="card-body card-block">
                                        


<table border="1" class="table table-bordered mg-b-0">
                                            <tr>
    <th>Visitor Name</th>
    <td><?php  echo $vd->VisitorName;?></td>
 
    <th>Mobile Number</th>
    <td><?php  echo $vd->MobileNumber;?></td>
  </tr>
  <tr>
    <th>Address</th>
    <td><?php  echo $vd->Address;?></td>
  
    <th>Apartment no</th>
    <td><?php  echo $vd->Apartment;?></td>
  </tr>
  <tr>
    <tr>
    <th>Floor</th>
    <td><?php  echo $vd->Floor;?></td>
    <th>Whom to Meet</th>
    <td><?php  echo $vd->WhomtoMeet;?></td>
    <tr>
    <th>Reason to Meet</th>
    <td><?php  echo $vd->ReasontoMeet;?></td>
    <th>Vistor Entring Time</th>
    <td><?php  echo $vd->EnterDate;?></td>
  </tr>


<?php if($vd->remark==""){ ?>
 <?php echo form_open('Visitor/Outing',['name'=>'updatvinfo'])?>
 <?php echo form_hidden('visitorid',$vd->ID);?>
         <tr>
    <th>Outing Remark :</th>
    <td colspan="3">
<?php echo form_textarea(['name'=>'remark','rows'=>'5','cols'=>'60','id'=>'remark','class'=>'form-control','placeholder'=>'Enter Outing Remark','value'=>set_value('remark')]);?>
<?php echo form_error('remark','<div style="color:red">', '</div>'); ?>
  </tr>                               
 <tr align="center">
    <td colspan="4">
<?php echo form_submit(['name'=>'submit','value'=>'Update','class'=>'btn btn-primary btn-sm']); ?>
    </td>
  </tr>
                                        </form>
               <?php } else { ?>

<tr>
    <th>Outing Remark </th>
    <td><?php echo $vd->remark; ?></td>
<th>Out Time</th>
<td><?php echo $vd->outtime; ?>  </td> 
<?php } ?>
</tr>
</table>                        
                                    </div>
                                   
                                </div>
                       
                        </div>
                            </div>
    
 <?php include APPPATH.'views/includes/footer.php';?>
                </div>
                </div>
            </div>
        </div>


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
