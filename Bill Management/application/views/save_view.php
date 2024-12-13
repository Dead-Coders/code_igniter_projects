<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row" id="saveView">
	<div class="col-lg-4 col-sm-4 ">
	</div>

	<div class="col-lg-4 col-sm-4 alert alert-success alert-dismissabl text-center fade in">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
			&times;
		</button>

		<?php echo $saveMsg; ?>
	</div>

	<div class="col-lg-4 col-sm-4">
	</div>
</div>

<script type="text/javascript">
	    $('#saveView').fadeTo(5000, 500).slideUp(1000, function()
	    {
	    	$('#saveView').alert('close');
	    });
</script>