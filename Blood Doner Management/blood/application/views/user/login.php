
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Blood Donor Management System | Login</title>
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
        <?php echo form_open('user/Login',['name'=>'signup']);?>
            <h2 class="login-title">Log in</h2>
            <!--error message -->
            <?php if($this->session->flashdata('error')){?>
                <p style="color:red"><?php  echo $this->session->flashdata('error');?></p>	
                <?php } ?>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <?php echo form_input(['name'=>'email','id'=>'email','class'=>'form-control','placeholder'=>'Enter the email id','value'=>set_value('email')]);?>
                    <?php echo form_error('email','<div style="color:red">','<div>')?>								
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <?php echo form_password(['name'=>'password','id'=>'password','class'=>'form-control','placeholder'=>'Enter the Password','value'=>set_value('password')]);?>	
                    <?php echo form_error('password','<div style="color:red">','<div>')?>
                </div>
            </div>
           
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit">Login</button>
            </div>
            <div class="social-auth-hr">
         
            </div>
            
            <div class="text-center">Not a member?
                <a class="color-blue" href="<?php echo base_url('user/registration');?>">Create accaunt</a>
            </div>
            <hr />
            <p style="text-align:center;">
                 <a class="nav-link scrollto" href="<?php echo base_url('Welcome'); ?>">Back to Home Page</a></p>
            <?php echo form_close();?>

    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/popper.js/dist/umd/popper.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js')?>" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url('assets/vendors/jquery-validation/dist/jquery.validate.min.js')?>" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?php echo base_url('assets/js/app.js')?>" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
</body>

</html>