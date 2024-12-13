<div class="row">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
		<div class="container">
      <h2><b>Welcome to Simple Sales Management System</b></h2>
      <hr>
			<div class="row">

			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="rounded-0 card-counter light">
				<i class="fa fa-th"></i>
				<span class="count-numbers"><?php $query = $this->db->query('SELECT * FROM tblcategories'); echo $query->num_rows();?></span>
				<span class="count-name">Categories</span>
			</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="rounded-0 card-counter primary">
					<i class="fa fa-bars"></i>
					<span class="count-numbers"><?php $query = $this->db->query('SELECT * FROM tblproducts'); echo $query->num_rows();?></span>
					<span class="count-name">Products</span>
				</div>
				</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="rounded-0 card-counter warning">
				<i class="fa fa-file-text-o"></i>
				<span class="count-numbers"><?php $query = $this->db->query('SELECT * FROM tblorders'); echo $query->num_rows();?></span>
				<span class="count-name">Total Orders</span>
			</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="rounded-0 card-counter success">
				<i class="fa fa-dollar"></i>
				<span class="count-numbers">$<?php $query = $this->db->query('SELECT SUM( order_total)as total FROM tblorders')->row(); echo floatval($query->total);?></span>
				<span class="count-name">Earnings</span>
			</div>
			</div>
		</div>
		</div>
			
	

</div>
