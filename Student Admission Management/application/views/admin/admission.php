<br>
<div class="section-title">Student Admission form</div>
<?= form_open_multipart('users/admission')?>
<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
			<label>Student Name</label>
			<?= form_input(['name' => 's_name', 'value' => set_value('s_name'), 'class'=>'form-control'])?>
			<div class="text-danger"><?= form_error('s_name')?></div>
		</div>

		<div class="form-group">
			<label>Guardian's Name</label>
			<?= form_input(['name' => 'g_name', 'value' => set_value('g_name'), 'class'=>'form-control'])?>
			<div class="text-danger"><?= form_error('g_name')?></div>
		</div>

		<div class="form-group">
			<label>Contact</label>
			<?= form_input(['name' => 'contact', 'value' => set_value('contact'), 'class'=>'form-control'])?>
			<div class="text-danger"><?= form_error('contact')?></div>
		</div>

		<div class="form-group">
			<label>Email</label>
			<?= form_input(['name' => 'email', 'value' => set_value('email'), 'class'=>'form-control'])?>
			<div class="text-danger"><?= form_error('email')?></div>
		</div>

		<div class="form-group">
			<label>Residential Address</label>
			<?= form_textarea(['name' => 'address', 'value' => set_value('address'), 'class'=>'form-control', 'rows'=>'5'])?>
			<div class="text-danger"><?= form_error('address')?></div>
		</div>

		
	</div>
	<div class="col-lg-6">

	<div class="form-group">
			<label>Year</label>
			<?php 
				$options = array(
					"" 	=> "Please Select...",
					"1"	=> "First Year",
					"2"	=> "Second Year",
					"3"	=> "Third Year",
				);
			 ?>
			<?= form_dropdown('year', $options, set_value('year'), array('class'=>'form-control'))?>
			<div class="text-danger"><?= form_error('class')?></div>
		</div>

		<div class="form-group">
			<label>Program</label>
			<?php 
				$options = array(
					"" 	=> "Please Select...",
					"1"	=> "BA",
					"2"	=> "BSc",
					"3"	=> "BBA",
					"4"	=> "BIT",
					"5"	=> "MIT",
					"6"	=> "MSc",
					"7"	=> "MMT",
					"8"	=> "MITM",
					"9" => "MSITM"
				);
			 ?>
			 <?= form_dropdown('division', $options, set_value('division'), array('class'=>'form-control'))?>
			<div class="text-danger"><?= form_error('division')?></div>
		</div>

		<div class="form-group">
			<label>Blood Group</label>
			<?= form_input(['name' => 'b_group', 'value' => set_value('b_group'), 'class'=>'form-control'])?>
			<div class="text-danger"><?= form_error('b_group')?></div>
		</div>

		<div class="form-group">
			<label>Shift</label>
			<?php
				$options = array(
					" "	=> "Please Select...",
					"1" => "Morning",
					"2" => "Evening"
				);
			?>
			<?= form_dropdown('shift', $options, set_value('shift'), array('class'=>'form-control'))?>
			<div class="text-danger"><?= form_error('shift')?></div>
		</div>

		<div class="form-group">
			<label>Gender</label>
			<div class="radio">
				<?= form_radio('gender', 'M', set_radio('gender', 'M'))?> Male
			</div>
			<div class="radio">
				<?= form_radio('gender', 'F', set_radio('gender', 'F'))?> Female
			</div>
			<div class="text-danger"><?= form_error('gender')?></div>
		</div>

		<div class="form-group">
			<label>Profile Image</label>
			<?= form_upload(['name'=>'userfile', 'class'=>'form-control', 'value' => ''])?>
             <div class="text-secondary">* Upload PNG, JPG format. Image should not be more than 400KB</div>
            <div class="text-danger">
	            <?php 
		            if (isset($upload_errors))
		            {
		            	print $upload_errors;
		            }
		            else
		            {
		            	print form_error('userfile');
		            }  
	            ?>	
            </div>
		</div>
		
		<div class="form-group">
			<?= form_submit(['name'=> 'submit', 'value'=> 'Add Student', 'class'=>'btn btn-primary'])?>
		</div>
		
	</div>
	
</div>

<?= form_close()?>
<br>