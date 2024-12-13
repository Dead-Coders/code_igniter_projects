<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary rounded-0">
			<div class="panel-heading">
				<h3 class="panel-title">Orders <small class="label label-danger"><?=DB::num_rows(TABLE_ORDERS) ?></small> 
				</h3>

			</div>
			<div class="panel-body">
				<?php $this->load->view('alert') ?>
				<a href="<?=site_url('orders/create') ?>" class="btn btn-primary btn-sm pull-left" style="border-radius:0%;">New Order</a>
				<br/><br/>
				<table class="table table-striped table-bordered table-hover" id="datatable">
					<thead>
						<tr>
							<th class="p-1 text-center">#</th>
							<th class="p-1 text-center">Order Number</th>
							<th class="p-1 text-center">Customer Name</th>
							<th class="p-1 text-center">Total Amount</th>
							<th class="p-1 text-center">Created On</th>
							<th class="p-1 text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if($orders): ?>
							<?php $count = 1; ?>
							<?php foreach($orders as $row): ?>
								<tr>
									<td class="px-2 py-1 align-middle text-center"><?=$count++ ?></td>
									<td class="px-2 py-1 align-middle" id="order_number-<?=$row->order_id ?>"><?=$row->order_number ?></td>
									<td class="px-2 py-1 align-middle" id="customer_name-<?=$row->order_id ?>"><?=ucwords($row->customer_name) ?></td>
									<td class="px-2 py-1 align-middle text-right" id="order_total-<?=$row->order_id ?>">$<?=number_format($row->order_total,2) ?></td>
									<td class="px-2 py-1 align-middle"><?= date("M d, Y h:i A", strtotime($row->created_at)) ?></td>
									<td class="px-2 py-1 align-middle text-center">
										<div class="btn-group">
											<button type="button" class="btn btn-primary btn-sm rounded-0 dropdown-toggle waves-effect" style="border-radius:0%;" data-toggle="dropdown" aria-expanded="true"> More <span class="caret"></span> </button>
											<ul class="dropdown-menu">
												<li><a href="<?=site_url('orders/print_order/'.$row->order_id) ?>" target="_blank">Print</a></li>
												<li><a href="<?=site_url('orders/delete/'.$row->order_id)?>" onclick="return confirm('Are you sure?')">Delete</a></li>
											</ul>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
