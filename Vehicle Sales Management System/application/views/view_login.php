<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VSMS</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/build/css/login.css'); ?>">
</head>

<body>
    <div class="loginPage">    
        <header><center><img src="./assets/images/vmlg.png" width="160" alt=""></center><hr>
            
            <h2><b>Login Panel</b></h2>
        </header>
        <?php echo validation_errors(); ?>
        
        <?php echo form_open('login/checklogin'); ?>
            <input placeholder="Email" type="email" name="email">
            <input placeholder="Password" type="password" name="password">
            <section class="links">
                <button class="button"><span>LOGIN</span></button>
                <br><br>
            </section>
        </form>
    </div>
</body>
</html>