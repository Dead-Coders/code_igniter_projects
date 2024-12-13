
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Blood Donor Management System | Profile</title>
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
        <?php include APPPATH.'views/user/include/header.php';?>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <?php include APPPATH.'views/user/include/sidebar.php';?>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">Update Profile</h1>
               
            </div>
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox">
                            	<!--success message -->
<?php if($this->session->flashdata('success')){?>
<p style="color:green"><?php  echo $this->session->flashdata('success');?></p>	
<?php } ?>

<!--error message -->
<?php if($this->session->flashdata('error')){?>
<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>	
<?php } ?>	
                            <div class="ibox-body">
                            <?php echo form_open('user/Profile/updateprofile',['name'=>'signup']);?>
                                    <div class="row">
                                    <div class="col-6">
                    <div class="form-group">
                    <label>First Name</label>
                        <?php echo form_input(['name'=>'first_name','id'=>'first_name','class'=>'form-control','placeholder'=>'Enter your First Name','value'=>set_value('fromdate',$profile->first_name)]);?>
                         <span style="color:red;"><?php echo form_error('first_name')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                    <label>Last Name</label>
                        <?php echo form_input(['name'=>'last_name','id'=>'last_name','class'=>'form-control','placeholder'=>'Enter your Last Name','value'=>set_value('fromdate',$profile->last_name)]);?>
                        <span style="color:red;"><?php echo form_error('last_name')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                    <label>Genderl</label>
                        <select name="gender" id="gender" class="form-control">
                        <option value="<?php echo $profile->gender; ?>"><?php echo $profile->gender; ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span style="color:red;"><?php echo form_error('gender')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                    <label>Blood Group</label>
                        <select name="blood" id="blood" class="form-control">
                        <option value="<?php echo $profile->id; ?>"><?php echo $profile->bloodname; ?></option>
                            <?php
                        foreach($sub as $row)
                        {
                        echo '<option value="'.$row->id.'">'.$row->bloodname.'</option>';
                        }
                       ?>
                        </select>
                        <span style="color:red;"><?php echo form_error('blood')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                    <label>Email</label>
                        <label>Email</label>
                       <?php echo form_input(['name'=>'email','id'=>'email','class'=>'form-control','placeholder'=>'Email','value'=>set_value('email',$profile->email)]);?>
                       <span style="color:red;"><?php echo form_error('email')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                    <label>Contact No</label>
                        <?php echo form_input(['name'=>'contact_no','id'=>'contact_no','maxlength'=>'10','class'=>'form-control','placeholder'=>'Enter your Contact No','value'=>set_value('contact_no',$profile->contact_no)]);?>
                        <span style="color:red;"><?php echo form_error('contact_no')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                    <label>State</label>
                        <?php echo form_input(['name'=>'state','id'=>'state','class'=>'form-control','placeholder'=>'Enter your State','value'=>set_value('state',$profile->state)]);?>
                        <span style="color:red;"><?php echo form_error('state')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                    <label>City</label>
                        <?php echo form_input(['name'=>'city','id'=>'city','class'=>'form-control','placeholder'=>'Enter your City','value'=>set_value('city',$profile->city)]);?>
                        <span style="color:red;"><?php echo form_error('city')?></span>
                    </div>
                </div>
                
            </div>
                                    <div class="form-group">
                                    <?php echo form_submit(['name'=>'submit','id'=>'submit','class'=>'btn btn-primary','value'=>'update']);?>
                                    </div>
                                    <?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                    
                </div>
             
                
            </div>
            <!-- END PAGE CONTENT-->
            <?php include APPPATH.'views/user/include/footer.php';?>
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