

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
              
      <div class="modal-header">
        <h3 class="modal-title">Reason</h3>
        
      </div>
      <form action="<?php echo base_url('Admin/addBin_Controller'); ?>" method="POST" class="form-horizontal">
 
      <!-- Modal body -->
      <div class="modal-body">

        <input id="report_id" type="text" class="form-control" hidden="" />
          <input id="myreason" type="text" class="form-control" required />
         
      </div>
      <div class="modal-footer">
         <input type="button" name="submit" onClick="add_bin()" class="btn btn-danger" value="Delete">
          <button style="margin-left: 5px" type="button" class="btn btn-success"  data-dismiss="modal">Close</button>
        
      </div>
  </form>
    </div>
  </div>
</div>