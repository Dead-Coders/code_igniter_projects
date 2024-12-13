<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row" id="errView">
	<div class="col-lg-4 col-sm-4 ">
	</div>

	<div class="col-lg-4 col-sm-4 alert alert-danger  alert-dismissabl text-center fade in">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
			&times;
		</button>

		<?php echo $errMsg; ?>
	</div>

	<div class="col-lg-4 col-sm-4">
	</div>
</div>

<script type="text/javascript">
	    $('#errView').fadeTo(5000, 500).slideUp(1000, function()
	    {
	    	$('#errView').alert('close');
	    });
</script>