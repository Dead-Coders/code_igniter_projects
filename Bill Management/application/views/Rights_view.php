<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style type="text/css">
	label{color:black;}
</style>
<script type="text/javascript">
	var controller='Right_Controller';
	var base_url='<?php echo site_url();?>';

	vModuleName = "User Rights";

	function loaddata()
	{	
		var str="";
		$('#tree input:checked').each(function() {
			str = $(this).val() + "," + str;
		});

		//////User for Address Book
		var users4ab="";
		$('#divUsers4ab input:checked').each(function() {
			users4ab = $(this).val() + "," + users4ab;
		});
		users4ab = users4ab.substring(0, users4ab.length-1);
		// alert(users4ab);
		// return;
		//////END - User for Address Book


		var OcboUsers = document.getElementById("cboUsers");
		var uid = OcboUsers.options[OcboUsers.selectedIndex].value;
		if(uid==-1)
		{
			myAlert('Please Select User');
			return;	
		}
		if(str=="")
		{
			myAlert('Please Select Atleast one right');
			return;
		}

		arr = str.split(",");
		arr = arr.slice(0,arr.length-1);
		str = arr.reverse().join(",");
		$.ajax
		(
			{
				'url': base_url + '/' + controller + '/insertRights',
				'type': 'POST', 
				'data': {'uid' : uid, 'rights' : str, 'users4ab' : users4ab},
				'success': function(data){
					myAlert("Rights Saved...!!!");
				},
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
			}
		);

	 	blankcontrol();
	}

	function blankcontrol()
	{
		document.getElementById("cboUsers").selectedIndex = "0";
		$('#tree input:checked').each(function() {
			$(this).removeAttr('checked');
		});		 
	}
	$(document).ready(function(){
		$("#cboUsers").change(function(){
			$.ajax({
	        'url': base_url + '/Menu_Controller/getRights',
	        'data': {'uid':$("#cboUsers").val()},
	        'type': 'POST', 
	        'success': function(data)
	        {
				arr = data.split(",");
				arr = arr.slice(0,arr.length-1);
				arr = arr.reverse();
	            $('input[type="checkbox"]').each(function(){
					for(j=0;j<arr.length;j++)
					{
						if($(this).val() === arr[j])
						{
							$(this).prop("checked",true);
							break;
						}
						else
						{
							$(this).removeAttr("checked");
						}
					}
	            });
	        },
					'error': function(jqXHR, exception)
					{
						document.write(jqXHR.responseText);
					}
	      });
		});
	});
</script>


<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style='border:1px solid lightgray; border-radius:10px; padding: 10px;'>
		<h1 class="text-center" style='margin-top:0px'>User Rights</h1>
		<?php
			$attributes[] = array("class"=>"form-control" );
			$this->load->helper('form');
			echo validation_errors(); 
			echo form_open('Right_Controller/insertRights', "onsubmit='return(false);'");
			$arr = array();
			foreach ($users as $row)
			{
        		$arr[$row['rowid']]= $row['uid'];
			}
			$temp["-1"] = "--- SELECT USER ---";
			$users = $temp+$arr;
			echo form_dropdown('uid',$users,"-1","class='form-control' id='cboUsers'");
		?>
		<br/>
	</div>
</div>
<br>
<br>
	<ul id="tree">
		<div class="row" style="position:relative;">

			<div class="col-lg-4 col-sm-4 col-md-4" style="border-right:1px solid lightgray;border-bottom:1px solid lightgray; height:300px;overflow:auto">
				<li>
					<label>
						<input type="checkbox" class="rights_menu" value="Masters"/>
						<b>Masters</b>
					</label>
					<ul>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Organisation" />
									Organisation
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Customers" />
									Customers
							</label>
						</li>
					</ul>
				</li>
			</div>


			<div class="col-lg-4 col-sm-4 col-md-4" style="border-right:1px solid lightgray;border-bottom:1px solid lightgray;height:300px;overflow:auto">
				<li>
					<label>
						<input type="checkbox" class="rights_menu" value="Transactions"/>
						<b>Transactions</b>
					</label>
					<ul>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Credit Entry" />
									Credit Entry
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Cash Receipt" />
									Cash Receipt
							</label>
						</li>


					</ul>
				</li>
			</div>



			<div class="col-lg-4 col-sm-4 col-md-4" style="border-right:1px solid lightgray;border-bottom:1px solid lightgray;height:300px;overflow:auto">
				<li>
					<label>
						<input type="checkbox" class="rights_menu" value="Reports"/>
						<b>Reports</b>
					</label>
					<ul>
						
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Ledger" />
									Ledger
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Dues" />
									Dues
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Reminders" />
									Reminders
							</label>
						</li>

					</ul>
				</li>
			</div>
			<div class="col-lg-4 col-sm-4 col-md-4" style="border-right:1px solid lightgray;border-bottom:1px solid lightgray;height:300px;overflow:auto">
				<li>
					<label>
						<input type="checkbox" class="rights_menu" value="Tools" />
						<b>Tools</b>
					</label>
					<ul>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Create Users" />
								Create Users
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="User Rights" />
								User Rights
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Reset Password" />
								Reset Password
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" class="rights_menu" value="Backup Data" />
								Backup Data
							</label>
						</li>
					</ul>
				</li>
			</div>

		</div>
	</ul>
	</div>
	<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>bootstrap/checktree/js/jquery-checktree.js"></script>
	<script>
		$('#tree').checktree();
	</script>
	<br/>
	<div class="row" style="margin-bottom:15px;">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
		<?php
			echo "<div class='col-lg-1 col-md-1 col-sm-1'></div>";
			echo "<input type='button' onclick='loaddata();' value='Save' id='btnSave' class='btn btn-danger col-lg-10 col-md-10 col-sm-10'>";
			// echo "<div class='col-lg-2 col-md-2 col-sm-2'></div>";
		 // 	echo "<input type='button' value='Cancel' onclick='blankcontrol();' class='btn btn-success col-lg-4 col-md-4 col-sm-4'>";
		 	echo "<div class='col-lg-1 col-md-1 col-sm-1'></div>";
			echo form_close();
		?>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-0">
		</div>
	</div>