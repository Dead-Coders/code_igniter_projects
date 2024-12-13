<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	vModuleName = "Change Pwd";
</script>
<div style="margin-top:40px;">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style='border:1px solid gray; border-radius:10px; padding: 10px;box-shadow: 1px 1px 15px #888888;'>
		<h2 class="text-center" style='margin-top:0px'>Change Password</h2>
		<?php

			// $attributes[] = array("class"=>"form-control" );

			$this->load->helper('form');		// it will load 'form' so that we will be able to use form_open() etc.
			// echo validation_errors(); 
			echo form_open('Changepwd_Controller/checkLogin');		// checklogin will be called on submit button.

			echo form_label('Old Password', '');
			echo form_input('txtOldPassword', set_value('txtOldPassword'),"placeholder='', class='form-control' autofocus");
			echo form_error('txtOldPassword');
			echo form_label('New Password', '');
			echo form_password('txtPassword', set_value('txtPassword'),"placeholder='', class='form-control'");
			echo form_error('txtPassword');
			echo form_label('Repeat Password', '');
			echo form_password('txtRepeatPassword', set_value('txtRepeatPassword'),"placeholder='', class='form-control'");
			echo form_error('txtRepeatPassword');


			echo "<br>";
			// echo "<div class='row'>";
			echo "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>";
			echo "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>";
			echo form_submit('btnSubmit', 'Submit',"class='btn btn-danger col-lg-12'");
			echo "</div><div class='col-lg-0  col-md-0 col-sm-0 col-xs-0'></div>";
			echo "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>";
			echo "<input type='reset' value='Clear' class='btn btn-success col-lg-12'>";
			echo "</div><div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'></div>";
			// echo "</div>";
			echo form_close();
		?>

	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
	</div>
</div>