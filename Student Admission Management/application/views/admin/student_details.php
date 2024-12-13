<br>
<!--=== Success msg ===-->
<?php 
    if($this->session->flashdata('success'))
    {
        print '<div class= "success-msg">'.$this->session->flashdata('success').'</div>';
    }
?>

<div class="section-title">Student Details</div>
<div class="student-details">
	<div class="row">
	<div class="col-lg-3">
		<div class="div-img">
			<?php print '<img src="'.strip_tags($student_details->profile_image).'" width="200" height = "200">'; ?>
		</div>
	</div>
	<div class="col-lg-7">
		<div class="student-info">
			<p><b>Student Id: </b>SAMS_<?= strip_tags($student_details->id)?></p>
		<p><b>Student name: </b><a href="#" class="text-info"><?= strip_tags($student_details->s_name)?></a></p>
		<p><b>Guardian's name: </b><?= strip_tags($student_details->g_name)?></p>
		<p><b>Contact: </b><?= strip_tags($student_details->contact)?></p>
		<p><b>E-mail: </b><?= strip_tags($student_details->email)?></p>
		<p><b>Address: </b><?= strip_tags($student_details->address)?></p>
		<p>
			<b>Year: </b>
			<?php
			if($student_details->year == 1)
			{
				print "First Year Student";
			}
			elseif ($student_details->year == 2) {
				print "Second Year Student";
			}
			elseif ($student_details->year == 3) {
				print "Third Year Student";
			}
			?>
		</p>
		<p>
			<b>Program: </b>
			<?php
			if($student_details->division == 1)
			{
				print "Bachelor of Arts";
			}
			elseif ($student_details->division == 2) {
				print "Bachelor of Science";
			}
			elseif ($student_details->division == 3) {
				print "Bachelor of Business Administration";
			}
			elseif ($student_details->division == 4) {
				print "Bachelor of Information Technology";
			}
			elseif ($student_details->division == 5) {
				print "Master of Information Technology";
			}
			elseif ($student_details->division == 6) {
				print "Master of Science";
			}
			elseif ($student_details->division == 7) {
				print "Master in Management and Digital Technologies";
			}
			elseif ($student_details->division == 8) {
				print "Executive Master of IT Management";
			}
			elseif ($student_details->division == 9) {
				print "Master of Science in Information Technology Management";
			}
			?>
		</p>
		<p>
			<b>Shift: </b> 
			<?php
			if($student_details->shift == 1)
			{
				print "Morning";
			}
			elseif ($student_details->shift == 2) {
				print "Evening";
			}
			?>
		</p>
		<p>
			<b>Gender: </b>
			<?php
			if ($student_details->gender == "M") {
				print "Male";
			}
			elseif ($student_details->gender == "F") {
				print "Female";
			}
			?>
		</p>
		<p>
			<b>Admission Date: </b>
			<?= date("d-M'y, h:i A", strtotime($student_details->dateTime))?>
		</p>
		</div>
	</div>
</div>
</div>
<br>

