<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to CodeIgniter</title>
</head>
<body>
<div id="container">
  <h1>Welcome to CodeIgniter!</h1>
  <?php echo form_open('welcome');?> <?php echo $this->ckeditor->editor('description',@$default_value);?> <?php echo form_error('description','<p class="error">'); ?>
  <input type="submit" name="submit" value="Save" id="save" class="save" />
  <?php echo form_close();?>
  <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>
</body>
</html>
