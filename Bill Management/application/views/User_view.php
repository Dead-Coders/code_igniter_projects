<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	var controller='User_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Users";

	function loaddata()
	{	
		var uid = $("#txtUID").val().trim();
		if(uid == "")
		{
			alertPopup("Enter User name  ...", 8000);
			$("#txtUID").focus();
			return false;
		}

		var pwd = document.getElementById("txtPassword").value;
		var pwd = $("#txtPassword").val().trim();
		if(pwd == "")
		{
			alertPopup("Enter password...", 8000);
			$("#txtPassword").focus();
			return false;
		}
		if(document.getElementById("btnSave").value == "Save")
		{
			// alert("DD");
			$.ajax({
					'url': base_url + '/' + controller + '/insertUser',
					'type': 'POST',
					'data': {'uid':uid, 
					// 'mobile':mobile,
					'password':pwd
		
					},
					'success': function(data){
						var container = $('#container');
						if(data){
							container.html(data);
						}
					},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
		}
		else if(document.getElementById("btnSave").value == "Update")
		{
			// alert("ajax");
			// var uid = document.getElementById("txtUID").value;
			// var password = document.getElementById("txtPassword").value;
			$.ajax({
					'url': base_url + '/' + controller + '/updateUser',
					'type': 'POST',
					'data': {'rowid' : globalrowid, 
					'uid':uid, 
					// 'mobile':mobile,
					'password':pwd
					 },
					'success': function(data){
						var container = $('#container');
						if(data){
							container.html(data);
						}
					},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
		}	
	}
	function blankcontrol()
	{
		document.getElementById('txtUID').value="";
		// document.getElementById('txtMobile').value="";
		document.getElementById('txtPassword').value="";
		document.getElementById('btnSave').value="Save";
		document.getElementById('txtUID').focus();
	}
</script>
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style='border:1px solid lightgray; border-radius:10px; padding: 10px;'>
		<h1 class="text-center" style='margin-top:0px'>Users</h1>
		<?php

			$attributes[] = array("class"=>"form-control" );

			$this->load->helper('form');		// it will load 'form' so that we will be able to use form_open() etc.
			echo validation_errors(); 
			echo form_open('User_Controller/insertUser', "onsubmit='return(false);'");
			echo form_input('uid', '', "placeholder='User Name' required class='form-control' maxlength='10' autofocus id='txtUID' style='margin-bottom:15px;' autocomplete='off'");
			// echo form_input('mobile', '', "placeholder='Mobile#' class='form-control' maxlength='10' autofocus id='txtMobile' style='margin-bottom:15px;' autocomplete='off'");
			echo "<br>";
			echo form_password('password', '', "placeholder='Password' required class='form-control' maxlength='20' autofocus id='txtPassword' autocomplete='off' style='margin-bottom:15px;'");
			// $types = array();
			// $types['-1'] = '--- Select ---';
			// $types['C'] = "Complete Address book";
			// $types['L'] = "Limited Address book";
			// echo "<label style='color: black; font-weight: normal;'>Access to: <span style='color: red;'>*</span></label>";
			// echo form_dropdown('cboAccess', $types, '-1', "class='form-control' id='cboAccess'");
			echo "<br />";
			echo "<div class='col-lg-1 col-md-1 col-sm-1 col-xs-0'></div>";
			// echo form_submit('btnSubmit', 'Save',"class='btn btn-success col-lg-3 col-md-3 col-sm-3 col-xs-4'");
			echo "<input type='button' onclick='loaddata();' value='Save' id='btnSave' class='btn btn-danger col-lg-10 col-md-10 col-sm-10 col-xs-12'>";
			// echo "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-0'></div>";
			// echo "<input type='reset' value='Cancel' onclick='blankcontrol();' class=' btn btn-warning col-lg-4 col-md-4 col-sm-4 col-xs-12'>";
			echo "<div class='col-lg-1 col-md-1 col-sm-1 col-xs-0'></div>";
			echo form_close();
		?>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
	</div>
</div>
	<hr>
	<div id="containerTT"></div>