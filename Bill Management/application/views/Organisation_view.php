<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
	var controller='Organisation_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "Organisation";
	
	
	function saveData()
	{	
		orgName = $("#txtOrgName").val().trim();
		if(orgName == "")
		{
			alertPopup("Organisation name can not be blank...", 8000, 'red');
			$("#txtOrgName").focus();
			return;
		}
		add1 = $("#txtAdd1").val().trim();
		add2 = $("#txtAdd2").val().trim();
		add3 = $("#txtAdd3").val().trim();
		add4 = $("#txtAdd4").val().trim();
		electricianNo = $("#txtElectricianMobile").val().trim();
		if(electricianNo != "")
		{
			if(electricianNo.length<10 || electricianNo.length>10)///mobile no. must be 10 digit
			{
				alertPopup("Enter valid mobile no.", 8000, 'red');
				$("#txtElectricianMobile").focus();
				return;
			}
			if(isNaN(electricianNo)==true)///mobile no. must be numeric
			{
				alertPopup("Enter valid mobile no.", 8000, 'red');
				$("#txtElectricianMobile").focus();
				return;
			}
		}
		rechargeLimit = $("#txtRechargeLimit").val().trim();
		rechargeMobile = $("#txtRechargeMobile").val().trim();
		if(rechargeMobile != "")
		{
			if(rechargeMobile.length<10 || rechargeMobile.length>10)///mobile no. must be 10 digit
			{
				alertPopup("Enter valid recharge mobile no.", 8000, 'red');
				$("#txtRechargeMobile").focus();
				return;
			}
			if(isNaN(rechargeMobile)==true)///mobile no. must be numeric
			{
				alertPopup("Enter valid recharge mobile no.", 8000, 'red');
				$("#txtRechargeMobile").focus();
				return;
			}
		}

		if($("#btnSave").val() == "Save Changes")
		{
			// alert("save");
			$.ajax({
					'url': base_url + '/' + controller + '/update',
					'type': 'POST',
					// 'dataType': 'json',
					'data': {
								'orgName': orgName
								, 'add1': add1
								, 'add2': add2
								, 'add3': add3
								, 'add4': add4
								, 'electricianNo': electricianNo
								, 'rechargeLimit': rechargeLimit
								, 'rechargeMobile': rechargeMobile
							},
					'success': function(data)
					{
						alert("Changes Saved...");
						location.reload();
					},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			});
		}
	}


</script>
<div class="container">
	<div class="row">
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
			<h3 class="text-center" style='margin-top:20px'>Organization Detail</h3>
			<div class="row" style="margin-top:25px;">
				<?php 
					$orgName = "";
					$add1 = "";
					$add2 = "";
					$add3 = "";
					$add4 = "";
					$electricianNo="";
					$rechargeLimit="0";
					$rechargeMobile="";
					if( count($records) > 0 )
					{
						$orgName = $records[0]['orgName'];
						$add1 = $records[0]['add1'];
						$add2 = $records[0]['add2'];
						$add3 = $records[0]['add3'];
						$add4 = $records[0]['add4'];
						$electricianNo = $records[0]['electricianNo'];
						$rechargeLimit = $records[0]['rechargeLimit'];
						$rechargeMobile = $records[0]['rechargeMobile'];
					}
				?>
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Organisation Name:</label>";
						echo form_input('txtOrgName', $orgName, "class='form-control' autofocus id='txtOrgName' maxlength=50 autocomplete='off'");
	              	?>
	          	</div>
	          	
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="margin-top:15px;">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Address Line 1:</label>";
						echo form_input('txtAdd1', $add1, "class='form-control' id='txtAdd1' maxlength=50 autocomplete='off'");
	              	?>
	          	</div>
	          	
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="margin-top:15px;">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Address Line 2:</label>";
						echo form_input('txtAdd2', $add2, "class='form-control' id='txtAdd2' maxlength=50 autocomplete='off'");
	              	?>
	          	</div>
	          	
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="margin-top:15px;">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Address Line 3:</label>";
						echo form_input('txtAdd3', $add3, "class='form-control' id='txtAdd3' maxlength=50 autocomplete='off'");
	              	?>
	          	</div>
	          	
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" style="margin-top:15px;">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Address Line 4:</label>";
						echo form_input('txtAdd4', $add4, "class='form-control' id='txtAdd4' maxlength=50 autocomplete='off'");
	              	?>
	          	</div>

				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style="margin-top:15px;">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Electrician Mobile No.:</label>";
						echo form_input('txtElectricianMobile', $electricianNo, "class='form-control' id='txtElectricianMobile' maxlength=10 autocomplete='off'");
	              	?>
	          	</div>
	          	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style="margin-top:15px;">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Recharge Limit:</label>";
						echo form_input('txtRechargeLimit', $rechargeLimit, "class='form-control' id='txtRechargeLimit' maxlength=10 autocomplete='off'");
	              	?>
	          	</div>
	          	<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12" style="margin-top:15px;">
					<?php
						echo "<label style='color: black; font-weight: normal;'>Recharger Mobile No.:</label>";
						echo form_input('txtRechargeMobile', $rechargeMobile, "class='form-control' id='txtRechargeMobile' maxlength=10 autocomplete='off'");
	              	?>
	          	</div>
			</div>

			
			<div class="row" style="margin-top:15px;">
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<?php
						echo "<label style='color: black; font-weight: normal;'>&nbsp;	</label>";
						echo "<input type='button' onclick='saveData();' value='Save Changes' id='btnSave' class='btn btn-primary form-control'>";
	              	?>
	          	</div>
	          	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				</div>
			</div>


		</div>
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-0">
		</div>
	</div>
</div>




<script type="text/javascript">

</script>