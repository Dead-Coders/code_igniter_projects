<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	vModuleName = "Change Pwd Admin";
</script>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style='border:1px solid gray; border-radius:10px; padding: 10px;box-shadow: 1px 1px 15px #888888;'>
		<h1 class="text-center" style='margin-top:0px'>Reset Password<br>(By Admin)</h1>
		<?php

			// $attributes[] = array("class"=>"form-control" );

			$this->load->helper('form');		// it will load 'form' so that we will be able to use form_open() etc.
			// echo validation_errors(); 
			echo form_open('Changepwdadmin_Controller/checkLogin');		// checklogin will be called on submit button.

			echo form_label('User ID', '');
			echo form_dropdown('txtUID',$users,"0","class='form-control' id='txtUID'");
			// echo form_input('txtUID', set_value('txtUID'),"placeholder='User ID', class='form-control' autofocus");
			echo form_error('txtUID');
			echo form_label('New Password', '');
			echo form_password('txtPassword', set_value('txtPassword'),"placeholder='New Password', class='form-control'");
			echo form_error('txtPassword');
			echo form_label('Repeat Password', '');
			echo form_password('txtRepeatPassword', set_value('txtRepeatPassword'),"placeholder='Repeat New Password', class='form-control'");
			echo form_error('txtRepeatPassword');


			echo "<br>";
			echo "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>";
			echo form_submit('btnSubmit', 'Submit',"class='btn btn-danger col-lg-8 col-md-8 col-sm-8 col-xs-12'");
			echo form_close();
		?>

	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
	</div>
