<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PRINT ORDER</title>
	<meta name="author" content="Olaiya Segun Paul 08175020329 vadeshayo@gmail.com">
	<meta name="description" content="Basic Inventory app for devcenter">
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/bootstrap-theme.css">
</head>

<body onload="window.print()">
	<div class="container">
		<div class="row">
			<h4><b>Customer Name: <?=$order->customer_name ?></b></h4>
			<p>Date Ordered : <?=$order->created_at ?></p>
			<p>Order Number : <b> <?=$order->order_number ?></b></p>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
						<th>Product Name</th>
						<th>Quantity</th>
						<th>Product Price</th>
						<th>Product Total</th>
						</tr>
					</thead>
					<tbody>
					<?php $products = json_decode($order->order_details) ?>
					<?php for($i = 0; $i<count($products); $i++): ?>
						<tr>
						<?php 
						
						$where = ['product_id'=>$products[$i]->product_id];
							$product_name = DB::get_cell(TABLE_PRODUCTS, $where, 'product_name');
						 ?>
							<td><?=$product_name ?></td>
							<td><?=$products[$i]->qty ?></td>
							<td>$<?=number_format($products[$i]->product_price,2) ?></td>
							<td>$<?=number_format($products[$i]->product_price*$products[$i]->qty,2) ?></td>
						</tr>
					<?php endfor; ?>

					<tr>
						<td><strong>Order Total</strong></td>
						<td colspan="2"><span class="label label-success" style="font-size: 95%;">$ <?=number_format($order->order_total, 2) ?></span></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
	<script src="<?=base_url() ?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url() ?>assets/js/bootstrap.min.js"></script>
	</html>