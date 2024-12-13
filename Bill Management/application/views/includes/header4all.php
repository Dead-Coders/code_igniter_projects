<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Billing System</title>
	<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/jquery.json-2.4.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/jquery.blockUI.js"></script>
	<link rel='stylesheet' href='<?php  echo base_url(); ?>bootstrap/css/bootstrap.css'>
	<link rel='stylesheet' href='<?php  echo base_url(); ?>bootstrap/css/global.css'>
	<link href="<?php echo base_url(); ?>bootstrap/images/diamond.png" rel="shortcut icon" type="image/x-icon" />


	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/submenu/dist/css/bootstrap-submenu.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/submenu/docs.min.css">

	<script src="<?php echo base_url(); ?>bootstrap/submenu/dist/js/bootstrap-submenu.min.js" defer></script>
	<script src="<?php echo base_url(); ?>bootstrap/submenu/docs.js" defer></script>


	<!-- DataTables CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/datatable/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/datatable/dataTables.tableTools.min.css">
	<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>bootstrap/datatable/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>bootstrap/datatable/dataTables.tableTools.min.js"></script>

	<!--Checkbox Tree-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/checktree/css/jquery-checktree.css">


	<!-- UI like dialog date picker (like alert) -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/ui/jquery-ui.css" />
	<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>bootstrap/ui/jquery-ui.js"></script>
	<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>bootstrap/ui/jquery-ui.min.js"></script>

	<!-- Key Selection -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/keyselection/style.css" />
	<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>bootstrap/keyselection/key.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bootstrap/css/printstyle.css" />

	<!-- My Java Script Library -->
	<script type="text/javascript">
		var global_base_url='<?php echo base_url();?>';
	</script>
	<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/mylibrary.js"></script>

	<style>
		/*table row selection*/
		.highlight
		{
			background-color: #337ab7 !important;
			color: white;
			/*font-weight: bold;*/
		}
		.highlightAlag
		{
			/*background-color: #337ab7 !important;*/
			/*color: white;*/
			font-weight: bold;
		}

		/*.ui-dialog .ui-dialog-titlebar .msgBoxTitleColor { background: yellow; }*/
	</style>


<script>
		
onerror = myError;
function myError(msg, url, line)
{
	alert(msg + "\n" + url + "\n" + line);
	return true;
}


</script>


</head>

<body style="padding-top:85px;">
	<script type="text/javascript">
		// $.blockUI({ css: { 
  //           border: 'none', 
  //           padding: '15px', 
  //           backgroundColor: '#000', 
  //           '-webkit-border-radius': '10px', 
  //           '-moz-border-radius': '10px', 
  //           opacity: .5, 
  //           color: '#fff',
  //       } });
  //'<h3>Loading..., Pls. wait...<h3>'
  		var tm = new Date();
  		tm = '<h3>Loading... Pls. wait...<h3><span style="color:yellow;">' + tm.getHours() + ":" + tm.getMinutes()+ ":" + tm.getSeconds() + '</span>'  ;
        $.blockUI({ 
            message: tm, 
            css: { 
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#000', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px', 
	            opacity: .5, 
	            color: '#fff',
	        }
        }); 
	</script>