<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/mylibrary.js"></script>
<script type="text/javascript">

  vModuleName = "Login";

  function validate_form()
  {
   var userName = $("#txtUID").val();
   if(userName == "")
   {
     myAlert("Username required...");
     $("#txtUID").focus();
     return false;
   }
   var password = $("#txtPassword").val();
   if(password == "")
   {
     myAlert("Password required...");
     $("#txtPassword").focus();
     return false;
   }
  }
</script>
<link href='//fonts.googleapis.com/css?family=Satisfy|Dosis' rel='stylesheet'>
<!-- <link rel="stylesheet" href="css/style.css"> -->
<link rel='stylesheet' href='<?php  echo base_url();  ?>bootstrap/css/loginstyle.css'>
<!-- Pen Title-->
<div class="pen-title">
  <h3 style="font-family: 'Dosis';font-size: 42px; color: #1bcaff; ">
    <?php
      if( count($orgInfo) > 0)
      {
        echo $orgInfo[0]['orgName'];
      }
    ?>
  </h3>
  <h4 style="font-family: 'Satisfy';font-size: 39px; color: #666666;">Billing System</h4>
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle">
  </div>
  <div class="form">
    <h2>Login Panel</h2>
    <?php
      $this->load->helper('form');   
      // echo validation_errors(); 
      $attributes = array('onsubmit' => 'return validate_form(this)');//
      echo form_open('Login_controller/checkLogin', $attributes); 
      if(isset($_POST['txtUID']))
      {
    ?>
        <input type="text" id="txtUID" name="txtUID" value=<?php echo $_POST['txtUID'] ?> maxlength="20" placeholder="Username" autofocus />
        <input type="password" id="txtPassword" name="txtPassword" value=<?php echo $_POST['txtPassword'] ?> maxlength="20" placeholder="Password"/>
      <?php
      }
      else
      {
      ?>
        <input type="text" id="txtUID" name="txtUID" maxlength="20" placeholder="Username" value="" autofocus style="background-color: #fff;" />
        <input type="password" id="txtPassword" name="txtPassword" maxlength="20" placeholder="Password" value="" style="background-color: #fff;" />
      <?php
      }
      ?>
        <input type="submit" value="Login" required style="margin-top: 30px;margin-bottom: -10px; background-color: #666666; color: #ffffff; font-size: 16px;" />
    </form>
  </div>
  <div class="cta"><a href="#" style="color:grey;">Developed by <span style="color:black;">Imperial Technologies</span></a></div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/index.js"></script>

<!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
    <button onclick="funny();">Session</button>
</div>

<script type="text/javascript">
  function funny()
  {
    var userName='<?php echo $this->session->userid ?>';
    alert(userName);
  }
</script>   -->