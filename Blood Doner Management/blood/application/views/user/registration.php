<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Blood Donor Management System | Register</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?php echo base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/vendors/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/vendors/themify-icons/css/themify-icons.css')?>" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?php echo base_url('assets/css/main.css')?>" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="<?php echo base_url('assets/css/pages/auth-light.css')?>" rel="stylesheet" />
</head>

<body class="bg-silver-300">
    <div class="content">
        <div class="brand">
          
        </div>
        <?php echo form_open('user/Registration/create',['name'=>'create']);?>
            <h2 class="login-title">Sign Up</h2><br>
             <!--success message -->
            <?php if($this->session->flashdata('success')){?>
                <p style="color:green"><?php  echo $this->session->flashdata('success');?></p>	
                <?php } ?>

                <!--error message -->
                <?php if($this->session->flashdata('error')){?>
                <p style="color:red"><?php  echo $this->session->flashdata('error');?></p>	
                <?php } ?>
            <div class="row">
               
                <div class="col-6">
                    <div class="form-group">
                        <?php echo form_input(['name'=>'first_name','id'=>'first_name','class'=>'form-control','placeholder'=>'Enter your First Name','value'=>set_value('first_name')]);?>
                         <span style="color:red;"><?php echo form_error('first_name')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?php echo form_input(['name'=>'last_name','id'=>'last_name','class'=>'form-control','placeholder'=>'Enter your Last Name','value'=>set_value('last_name')]);?>
                        <span style="color:red;"><?php echo form_error('last_name')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <select name="gender" id="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span style="color:red;"><?php echo form_error('gender')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <select name="blood" id="blood" class="form-control">
                            <option value="">Select Blood Group</option>
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
                       <?php echo form_input(['name'=>'email','id'=>'email','class'=>'form-control','placeholder'=>'Email','value'=>set_value('email')]);?>
                       <span style="color:red;"><?php echo form_error('email')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?php echo form_input(['name'=>'contact_no','id'=>'contact_no','maxlength'=>'10','class'=>'form-control','placeholder'=>'Enter your Contact No','value'=>set_value('contact_no')]);?>
                        <span style="color:red;"><?php echo form_error('contact_no')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?php echo form_input(['name'=>'state','id'=>'state','class'=>'form-control','placeholder'=>'Enter your State','value'=>set_value('state')]);?>
                        <span style="color:red;"><?php echo form_error('state')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?php echo form_input(['name'=>'city','id'=>'city','class'=>'form-control','placeholder'=>'Enter your City','value'=>set_value('city')]);?>
                        <span style="color:red;"><?php echo form_error('city')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                       <?php echo form_password(['name'=>'password','id'=>'password','class'=>'form-control','placeholder'=>'Enter your Password','value'=>set_value('password')]);?>
                       <span style="color:red;"><?php echo form_error('password')?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?php echo form_password(['name'=>'cpassword','id'=>'cpassword','class'=>'form-control','placeholder'=>'Enter your Confirm Password','value'=>set_value('cpassword')]);?>
                        <span style="color:red;"><?php echo form_error('cpassword')?></span>
                     </div>
                </div>
            </div>
           
            <div class="form-group text-left">
                <label class="ui-checkbox ui-checkbox-info">
                    <input type="checkbox" name="agree">
                   <span class="input-span"></span>I agree the terms and policy</label>
                   <span style="color:red;"><?php echo form_error('agree')?></span>
            </div>
            <div class="row">
                <div class="col-4">
            <div class="form-group">
        
            </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit">Sign up</button>
                </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        
                    </div>
                    </div>
            </div>
            <div class="social-auth-hr">
                <span>Or Sign up with</span>
            </div>
          
            <div class="text-center">Already a member?
                <a class="color-blue" href="<?php echo base_url('user/login');?>">Login here</a>
            </div>
            <?php echo form_close();?>
    </div>
    <!-- CORE PLUGINS -->
    <script src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js')?>" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?php echo base_url('assets/assets/js/app.js')?>" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
   
    <style>
        .content {
    max-width: 700px !important;
    margin: 0 auto;
}
    </style>
</body>

</html>