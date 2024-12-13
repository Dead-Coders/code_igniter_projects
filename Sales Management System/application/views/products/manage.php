<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">List of Products  <small class="label label-danger"><?= number_format(DB::num_rows(TABLE_PRODUCTS)) ?></small> 
					
				</h3>
			</div>
			<div class="panel-body">
				<?php $this->load->view('alert') ?>
				<button type="button" class="btn btn-primary rounded-0 btn-sm pull-left" style="border-radius:0%;" onclick="edit_product(0)">Add New</button>
				<br/><br/>
				<table class="table table-striped table-bordered table-hover" id="datatable">
					<colgroup>
						<col width="10%">
						<col width="35%">
						<col width="20%">
						<col width="20%">
						<col width="15%">
					</colgroup>
					<thead>
						<tr>
							<th class="align-middle text-center p-1">#</th>
							<th class="align-middle text-center p-1">Product Name</th>
							<th class="align-middle text-center p-1">Price</th>
							<th class="align-middle text-center p-1">Category</th>
							<th class="align-middle text-center p-1">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if($products): ?>
							<?php $count = 1; ?>
							<?php foreach($products as $row): ?>
								<tr>
									<td class="align-middle px-1 py-2 text-center"><?=$count++ ?></td>
									<td class="align-middle px-1 py-2" id="product_name-<?=$row->product_id ?>"><?=ucfirst($row->product_name) ?></td>
									<td class="align-middle px-1 py-2 text-right" id="product_price-<?=$row->product_id ?>">$<?=number_format($row->product_price,2) ?></td>
									<td class="align-middle px-1 py-2 text-center">
										<span id="category_id-<?=$row->product_id ?>" style="display:none;"><?=$row->category_id ?></span>
										<small class="label label-light text-black border rounded-pill" ><?=ucfirst($row->category_name) ?></small>
									</td>
									
									<td class="align-middle px-1 py-2 text-center">
										<div class="btn-group">
											<button type="button" class="btn btn-primary btn-sm dropdown-toggle waves-effect" style="border-radius:0%;" data-toggle="dropdown" aria-expanded="true"> More <span class="caret"></span> </button>
											<ul class="dropdown-menu">
												<li><a href="javascript:void(0);" onclick="edit_product('<?=$row->product_id ?>')">Edit</a></li>
												<li><a href="<?=site_url('products/delete/'.$row->product_id)?>" onclick="return confirm('Are you sure?')">Delete</a></li>
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


<div class="modal fade" id="modal">
	<div class="modal-dialog">
		<?=form_open('products/manage') ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Product Form</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="">Product Name</label>
					<input type="text" name="product_name" id="product_name" class="form-control rounded-0" value="<?=set_value('product_name') ?>" required>
				</div>

				<div class="form-group">
					<label for="">Price</label>
					<input type="text" name="product_price" id="product_price" class="form-control rounded-0" value="<?=set_value('product_price') ?>" required>
				</div>

				<div class="form-group">
					<label>Category</label>
					<select name="category_id" id="category_id" class="form-control rounded-0" required>
						<option value="">--Please Select--</option>
						<?php foreach(DB::get(TABLE_CATEGORIES) as $row): ?>
							<option value="<?=$row->category_id ?>"><?=ucfirst($row->category_name) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<input type="hidden" name="product_id" id="product_id">
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary btn-sm rounded-0" style="border-radius:0%;">Save</button>
				<button type="button" class="btn btn-secondary rounded-0 btn-sm" data-dismiss="modal" style="border-radius:0%;">Close</button>
			</div>
		</div>
		<?=form_close() ?>
	</div>
</div>