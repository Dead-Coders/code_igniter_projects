<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary rounded-0">
			<div class="panel-heading rounded-0">
				<h3 class="panel-title">List of Categories <small class="label label-danger"><?=DB::num_rows(TABLE_CATEGORIES) ?></small> 
				</h3>

			</div>
			<div class="panel-body rounded-0">
			<?php $this->load->view('alert') ?>
			<button type="button" class="btn btn-primary btn-sm pull-left" style="border-radius:0%;" onclick="edit_category(0)">Add New</button>
			<br/><br/>
				<table class="table table-striped table-bordered table-hover" id="datatable">
					<colgroup>
						<col width="5%">
						<col width="55%">
						<col width="20%">
						<col width="20%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center p-1">#</th>
							<th class="text-center p-1">Name</th>
							<th class="text-center p-1">Last Updated</th>
							<th class="text-center p-1">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php if($categories): ?>
						<?php $count = 1; ?>
					<?php foreach($categories as $row): ?>
						<tr>
							<td class="px-2 py-1 align-middle text-center"><?=$count++ ?></td>
							<td class="px-2 py-1 align-middle" id="name-<?=$row->category_id ?>"><?=ucfirst($row->category_name) ?></td>
							<td class="px-2 py-1 align-middle"><?= date("M d, Y h:i A", strtotime($row->updated_at)) ?></td>
							<td class="px-2 py-1 align-middle text-center">
								<div class="btn-group rounded-0">
									<button type="button" class="btn btn-primary btn-sm dropdown-toggle waves-effect" style="border-radius:0%;" data-toggle="dropdown" aria-expanded="true"> More <span class="caret"></span> </button>
									<ul class="dropdown-menu">
										<li><a href="javascript:void(0);" onclick="edit_category('<?=$row->category_id ?>')">Edit</a></li>
										<li><a href="<?=site_url('categories/delete/'.$row->category_id)?>" onclick="return confirm('Are you sure?')">Delete</a></li>
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


<div class="modal fade" id="modal" data-backdrop="static">
	<div class="modal-dialog">
		<?=form_open('categories/manage') ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Category Form</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="">Category Name</label>
					<input type="text" name="category_name" id="name" class="form-control form-control-sm rounded-0" value="<?=set_value('name') ?>" required>
				</div>
			</div>
			<input type="hidden" name="category_id" id="category_id">
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary btn-sm rounded-0" style="border-radius:0%;">Save</button>
				<button type="button" class="btn btn-secondary btn-sm rounded-0" style="border-radius:0%;" data-dismiss="modal">Close</button>
			</div>
		</div>
		<?=form_close() ?>
	</div>
</div>