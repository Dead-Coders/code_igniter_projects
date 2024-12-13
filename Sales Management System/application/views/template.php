<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Simple Sales Management System in CodeIgniter</title>
	<meta name="author" content="Olaiya Segun Paul 08175020329 vadeshayo@gmail.com">
	<meta name="description" content="Basic Inventory app for devcenter">
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/bootstrap-theme.css">
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/datatables.min.css">
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/styles.css">
</head>

<body>
	<nav class="navbar navbar-inverse rounded-0" role="navigation">
		<div class="container-fluid">
			<!-- product and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=site_url() ?>">Simple Sales Management System</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li><a href="<?=site_url('home') ?>">Home</a></li>
					<?php if(Auth::is_loggedin()): ?>
						<li><a href="<?=site_url('categories') ?>">Categories</a></li>
						<li><a href="<?=site_url('products') ?>">Products</a></li>
						<li><a href="<?=site_url('orders') ?>">Orders</a></li>
						<li><a href="<?=site_url('authentication/logout') ?>">Logout</a></li>
					<?php else: ?>
						<li><a href="<?=site_url('authentication')  ?>">Login</a></li>
					<?php endif; ?>
					
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>

	<div class="container">
		<?php isset($page) ? $this->load->view($page) : $this->load->view('home') ?>
	</div>
</body>
<script src="<?=base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?=base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url() ?>assets/js/datatables.min.js"></script>
<script>
	$(document).ready(function(){
		$('#datatable').dataTable();
		
	})

	function edit_category(id){
		if(id == 0){
			$('#name').val();
		}else{
			var name = $('#name-'+id).html();
			$('#category_id').val(id);
			$('#name').val(name);
		}
		$('#modal').modal();
	}

	function edit_product(id){
		if(id == 0){
			$('#product_name').val();
			$('#product_price').val();
			$('#category_id').val();
		}else{
			var product_name 	= $('#product_name-'+id).html();
			var product_price 	= $('#product_price-'+id).html();
			var category_id 	= $('#category_id-'+id).html();
			console.log(category_id);
			$('#product_id').val(id);
			$('#product_name').val(product_name);
			$('#product_price').val(product_price);
			$('#category_id').val(category_id).trigger('change');
		}
		$('#modal').modal();
	}

	function edit_order(id){
		if(id == 0){
			$('#product_name').val();
			$('#product_price').val();
			$('#category_id').val();
		}else{
			var product_name 	= $('#product_name-'+id).html();
			var product_price 	= $('#product_price-'+id).html();
			var category_id 	= $('#category_id-'+id).html();
			console.log(category_id);
			$('#product_id').val(id);
			$('#product_name').val(product_name);
			$('#product_price').val(product_price);
			$('#category_id').val(category_id);
		}
		$('#modal').modal();
	}

	function add_tr()
	{
		$('#tbody').append(tr);
	}

	function remove_tr(id)
	{
		$('#b').parents('tr').remove();
	}

	


</script>
</html>