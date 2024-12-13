<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default rounded-0">
			<div class="panel-body">
				<?=form_open('orders/create',['id'=>'order-form']) ?>
				<div class="form-group">
					<input type="text" name='customer_name' class="form-control rounded-0" required placeholder="Customer Name">
				</div>
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Product's Name</th>
								<th>Quantity</th>
								<th>Action</th>
							</tr>
						</thead>
						
						<tbody id="tbody">
							<tr id="1">
								<td>
									<select name='products[]' class="form-control" required="required">
										<?php foreach(DB::get(TABLE_PRODUCTS) as $row): ?>
											<option value="<?=$row->product_id ?>"><?=ucfirst($row->product_name) ?> - <?=$row->product_price ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>
									<input type="text" name='qty[]' class="form-control inputqty" required value="1">
								</td>
								<td>
									<button type="button" class="btn btn-danger" style="border-radius:0%;" onclick="remove_tr(1)" id="b">Delete</button>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td class="text-center">
									<button type="button" class="btn btn-info btn-sm" style="border-radius:0%;margin-bottom:.5em" onclick="add_tr()">Add Row</button>
								</td>
							</tr>
						</tfoot>
					</table>
					<div class="text-right">
						<button type="submit" class="btn btn-primary btn-sm rounded-0" form="order-form" style="border-radius:0%;">Submit</button>
					</div>
					<?=form_close() ?>
			</div>
		</div>
		
	</div>
</div>
<script>
	var tr = "<?=$tr ?>";
</script>