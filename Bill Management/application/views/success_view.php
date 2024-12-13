<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- setTable(data['records'])  -->
	<script type="text/javascript">
		vModuleName = "Success";
		var base_url='<?php echo site_url();?>';  
	</script>

	<!-- <h3 style="margin-top:60px;">Login Successful</h3> -->
	<div class="row" style="margin-top:120px;">
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3"> </div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6"  align="center">  
			<a id="dashBoardLink" class="navbar-brand" href="<?php  echo base_url();  ?>index.php/DashBoard_Controller"><span>Wait a moment...</span> </a>
			<a href="<?php  echo base_url();  ?>index.php/RptReminders_Controller">
				<label style="color:red;cursor: pointer;" title="Click here to show detail">
					<?php
						// if( count($reminders) > 0)
						// {
						// 	echo $this->session->userRowId . "<br>";
						// 	echo $this->session->userid . "<br>";
						// }
					?>
				</label>
			</a>
			<br />
			<a href="<?php  echo base_url();  ?>index.php/Items_Controller">Items</a></li>
			<a href="<?php  echo base_url();  ?>index.php/RptReminders2_Controller">
				<label style="color:blue;cursor: pointer;" title="Click here to show detail">
					<?php
						// $cnt = count($recordsOnce) + count($recordsWeekly) + count($recordsMonthly) + count($recordsYearly);
						// if( $cnt > 0)
						// {
						// 	echo "<br>There are <span style='font-size:24pt;color:red;'>" . $cnt ."</span> Alarm(s) for today";
						// }
					?>
				</label>
			</a>
			<!-- <img  src="<?php echo base_url(); ?>bootstrap/images/logo.jpg?> " class="img-responsive"> </img> -->

		</div>
		 


		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3"> </div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			
			$("#dashBoardLink").find('span').trigger('click');
		});
	</script>