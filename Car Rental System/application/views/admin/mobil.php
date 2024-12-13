<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rental Car Details</h1>
    <a href="<?php echo base_url().'admin/mobil_add'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add Car Details</a>
</div>
    
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Color</th>
                        <th>Production Year</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $no=1;
                foreach($mobil as $m){
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $m->mobil_merk ?></td>
                        <td><?php echo $m->mobil_plat ?></td>
                        <td><?php echo $m->mobil_warna ?></td>
                        <td><?php echo $m->mobil_tahun ?></td>
                        <td>
                        <?php
                        if($m->mobil_status == 1){
                            echo 'Available';
                        } else {
                            echo 'Not Available';
                        }
                        ?>
                        </td>
                        <td>
                            <a class="btn btn-success btn-sm" href="<?php echo base_url().'admin/mobil_edit/'.$m->mobil_id; ?>">
                                <i class="fas fa-edit"></i> 
                            </a>
                            <a class="btn btn-danger btn-sm btn-hapus" href="<?php echo base_url().'admin/mobil_hapus/'.$m->mobil_id; ?>">
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
      text: "Data cannot be recovered after being deleted!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes, delete!',
      cancelButtonText: "No, cancel!",
      confirmButtonClass: "btn-danger",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm) {
      if (isConfirm) {
        swal("Deleted!", "Car data has been deleted!", "success");
        setTimeout(function(){ window.location.replace = url; }, 2000);
        //window.location.replace(url);
      } else {
        swal("Canceled", "Car data is safe. :)", "error");
      }
    });
});
</script>