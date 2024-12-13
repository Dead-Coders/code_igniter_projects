<div class="container">
   <div class="row">
      <div class="col">
         <h3 class="page-header">Category Management</h3>
      </div>
   </div>

   <div class="row mt-3">
      <div class="col">
         <button type="buton" class="btn btn-success btn-sm" onclick="add_category()">
            <i class="fas fa-plus"></i> Add
         </button>

         <button class="btn btn-outline-secondary btn-sm" onclick="reload_table()">
               <i class="fas fa-sync-alt"></i> Reload
         </button>
      </div>
   </div>


  <br>

   <div class="table-responsive">
      <table id="tableCategory" class="table table-striped table-bordered"  cellspacing="0" width="100%">
         <thead>
         <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Slug</th>
            <th>Active</th>
            <th>Action</th>
         </tr>
         </thead>
         <tbody>
         
         </tbody>
      </table>
   </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Edit Category</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="modal-body">
            <form action="#" class="form-horizontal" id="form">
            
               <input type="hidden" name="id" id="id">

               <div class="form-group row">
                  <label for="title" class="col-sm-3 col-form-label">Category Name</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" id="category_name" name="category_name">
                  </div>
               </div> 

               <div class="form-group row">
                  <label for="Active" class="col-sm-3 col-form-label">Active</label>
                  <div class="col-sm-9">
                     <select class="form-control" id="is_active" name="is_active">
                        <option value="Y">Yes</option> 
                        <option value="N">No</option>
                     </select>
                  </div>
               </div>

            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="save()" id="btn_save">Save</button>
         </div>
      </div>
   </div>
</div>
