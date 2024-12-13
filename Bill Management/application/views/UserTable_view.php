<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="row" id="container">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-0">
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style='border:1px solid lightgray; padding: 10px; overflow:scroll;'>
			<table class='table table-hover' id='tbl1'>
			 <!-- <caption></caption> -->
			 <thead>
			 <tr>
				<th  width="50" class="text-center">Edit</th>
				<th  width="50" class="text-center">Delete</th>
				<th style='display:none;'>rowid</th>
				<th>User Name</th>
				<th style='display:none;'>Mobile</th>
				<th style='display:none;'>Password</th>
				<th style='display:none;'>AB Access</th>
			 </tr>
			 </thead>
			 <tbody>
			 <?php 

				if($errorfound=="no") ////When Saved Or Updated Successfully
				{
					echo "<script> blankcontrol(); </script>";
					echo "<script> document.getElementById('btnSave').value = 'Save'; </script>";
				}
				else 
				{
					// echo $errorfound;
				}
			 foreach ($records as $row) 
			 {
			 	$rw = $row['rowid'];
			 	$uid = $row['uid'];
			 	$mobile = $row['mobile'];
			 	$pwd = $row['pwd'];
			 	echo "<tr>";
				echo '<td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onClick="editThis('.$rw.', \''.$uid.'\', \''.$mobile.'\',\''.$pwd.'\');" onmouseover="this.style.color=\'green\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-pencil"></span></td>
					   <td style="color: lightgray;cursor: pointer;cursor: hand;" class="text-center" onclick="delrowid('.$rw.');" data-toggle="modal" data-target="#myModal"  onmouseover="this.style.color=\'red\';"  onmouseout="this.style.color=\'lightgray\';"><span class="glyphicon glyphicon-remove"></span></td>';
			 	echo "<td style='width:0px;display:none;'>".$row['rowid']."</td>";
			 	echo "<td>".$row['uid']."</td>";
			 	echo "<td style='display:none;'>".$row['mobile']."</td>";
			 	echo "<td style='display:none;'>".$row['pwd']."</td>";
			 	echo "<td style='display:none;'>".$row['abAccess']."</td>";
				echo "</tr>";
			 }
			 ?>
			 </tbody>
			</table>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-0">
		</div>

		<!-- Modal -->
		  <div class="modal" id="myModal" role="dialog">
		    <div class="modal-dialog modal-sm">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">JKT: ERP</h4>
		        </div>
		        <div class="modal-body">
		          <p>Are you sure <br /> Delete this record..?</p>
		        </div>
		        <div class="modal-footer">
		          <button type="button" onclick="delrow(globalrowid);" class="btn btn-danger" data-dismiss="modal">Yes</button>
		          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		        </div>
		      </div>
		    </div>
		  </div>

	</div>


	<script type="text/javascript">
		var globalrowid;
		function editThis(rowid, uid, mobile, pwd)
		{
			var base_url='<?php echo site_url();?>';
			globalrowid = rowid;
			
			document.getElementById("txtUID").value=uid;
			// $.ajax({
			// 		'url': base_url + '/User_Controller/getPassword',
			// 		'type': 'POST',
			// 		'data': {'uid':uid,'pwd' : pwd},
			// 		'success': function(data){
			// 			alert(data);
			// 			$("#txtPassword").val(data);
			// 		}
			// });
			$("#txtMobile").val(mobile);
			document.getElementById("txtPassword").value=pwd;
			// alert(pwd);
			document.getElementById("btnSave").value="Update";		
		}

		function delrowid(rowid)
		{
			globalrowid = rowid;
		}
		function delrow(rowid)
		{
			var controller='User_Controller';
			var base_url='<?php echo site_url();?>';
			// var rowid = document.getElementById("txtPrefix").value;
			$.ajax({
					'url': base_url + '/' + controller + '/deleteUser',
					'type': 'POST',
					'data': {'rowid' : rowid},
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
	</script>

	 <!-- JQuery -->
	<script>
		$(document).ready( function () {
		    $('#tbl1').DataTable({
			    paging: true,
			    iDisplayLength: 5,
			    aLengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
			});
		} );

	</script>

