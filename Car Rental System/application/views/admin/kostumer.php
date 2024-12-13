<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Customer Details</h1>
    <a href="<?php echo base_url().'admin/kostumer_add'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add Customers</a>
</div>
    
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>Gender</th>
                        <th>Contact | ID Card</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $no=1;
                foreach($kostumer as $k){
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $k->kostumer_nama ?></td>
                        <td><?php echo $k->kostumer_jk ?></td>
                        <td><?php echo '<i class="fas fa-phone-volume"></i> '.$k->kostumer_hp.'<br><i class="fas fa-id-card-alt"></i> '.$k->kostumer_ktp; ?></td>
                        <td><?php echo $k->kostumer_alamat ?></td>
                        <td>
                            <a class="btn btn-success btn-sm" href="<?php echo base_url().'admin/kostumer_edit/'.$k->kostumer_id; ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-danger btn-sm btn-hapus" href="<?php echo base_url().'admin/kostumer_hapus/'.$k->kostumer_id; ?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$('.btn-hapus').on("click", function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
      title: "Are you sure you want to delete data?",
      text: "Data cannot be recovered once it is deleted!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes, Delete',
      cancelButtonText: "No, Cancel",
      confirmButtonClass: "btn-danger",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm) {
      if (isConfirm) {
        swal("Removed!", "Customer data has been removed", "success");
        setTimeout(function(){ window.location.replace = url; }, 2000);
        //window.location.replace(url);
      } else {
        swal("Cancelled", "The request has been cancelled!", "error");
      }
    });
});
</script>