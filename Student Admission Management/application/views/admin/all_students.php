<br>
<!--=== Success msg ===-->
<?php 
    if($this->session->flashdata('success'))
    {
        print '<div class= "success-msg">'.$this->session->flashdata('success').'</div>';
    }
?>
	<div class="section-title">All students list</div>
	<table class="table table-responsive-lg">
  <thead class="thead-light">
    <tr>
    </tr>
  </thead>


  <tbody>
  	<?php foreach($students as $student): ?>
    <tr>
      <td><?php print '<img src="'.strip_tags($student->profile_image).'" width="120" height = "120">'; ?></td>
      <td>
        <p><b>ID:</b> SAMS_<?= strip_tags($student->id)?></p>

        <h6><b>Student Name:</b> <a href = "<?= base_url('users/student_details/'.$student->id.'')?>" class="text-info"><?= strip_tags($student->s_name)?></a></h6>

        <p><b>Gurdian Name:</b> <?= strip_tags($student->g_name)?></p>
        
        <p><b>Contact:</b> <?= strip_tags($student->contact)?></p>
      </td>
      <td>
        <div class="action-btn">
          <a href="<?= base_url('users/student_details/'.$student->id.'')?>" class="text-primary"><button class="btn btn-primary btn-sm">Details</button></a><br>
          <a href="<?= base_url('users/student_edit/'.$student->id.'')?>" class="text-success"><button class="btn btn-success btn-sm">Update</button></a><br>
          <a href="<?= base_url('users/student_delete/'.$student->id.'')?>" class="text-danger delete" data-confirm="Are you sure to delete this student?"><button class="btn btn-danger btn-sm">Remove</button></a>
        </div>
      </td>
    </tr>
	<?php endforeach; ?>
  </tbody>
</table>
</div>