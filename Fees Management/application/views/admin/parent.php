<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'inc/head.php'; ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include 'inc/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'inc/aside.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $page_title; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#addNew"><i class="fa fa-user"></i>&nbsp; Add New Parent</button>
          </div><!-- /.col -->

      <!-- Modal -->
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="form">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Add Parents Form</h5>
              </div>
              <form method="POST" action="<?php echo base_url() ?>admin/action/add_new_parent" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="exampleInputFile">FULL NAME</label>
                          <input autocomplete="off" required type="text" name="name" placeholder=""class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">PHONE NUMBER</label>
                          <input autocomplete="off" required type="tel" name="phone" placeholder=""class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">ADDRESS</label>
                          <input autocomplete="off" required type="text" name="address" placeholder="" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">PARENT PASSPORT / PHOTO</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="photo">
                            <label class="custom-file-label" for="">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <label for="exampleInputFile">LOGIN EMAIL</label>
                          <input autocomplete="off" required type="email" name="email" placeholder="" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">LOGIN PASSWORD</label>
                          <input autocomplete="off" required type="password" name="password" placeholder="" class="form-control">
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add Parent</button>
                  </div>
              </form>
            </div>
        </div>
      </div>

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-info">
                      <!-- -->
                      <div class="card-tools">
                          
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body mt-3">

                      <table class="table table-bordered table-hover table-striped" id="example1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>PHOTO</th>
                            <th>NAME</th>
                            <th>PHONE</th>
                            <th>EMAIL</th>
                            <th>ADDRESS</th>
                            <!-- <th>ACTION</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          <?php  
                          $count = 1;
                          $parent = $this->db->get('parent_tbl')->result_array();
                          foreach ($parent as $row):
                          ?>
                          <tr>
                            <td><?php echo $count++; ?></td>
                            <td><img width="40" height="40" src="<?php echo base_url() ?>uploads/parents/<?php echo $row['ID'] ?>.png"></td>
                            <td><?php echo $row['NAME']; ?></td>
                            <td><?php echo $row['PHONE']; ?></td>
                            <td><?php echo $row['EMAIL']; ?></td>
                            <td><?php echo $row['ADDRESS']; ?></td>
                            <!-- <td>
                              <a href="" class="btn btn-sm btn-block btn-info btn-flat">View</a>
                            </td> -->
                          </tr>
                          <?php  
                          endforeach;
                          ?>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php include 'inc/footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php include 'inc/rscript.php'; ?>

  <script>
    $(function () {
      $("#example1").DataTable();
      $('.money').simpleMoneyFormat();
      <?php if($this->session->flashdata('completed') != ''){ ?>
        new PNotify({
            title: 'Notification',
            text: '<?php echo $this->session->flashdata('completed'); ?>',
            type: 'success'
        });
      <?php } ?>

      <?php if($this->session->flashdata('user_exist') != ''){ ?>
        new PNotify({
            title: 'Error',
            text: '<?php echo $this->session->flashdata('user_exist'); ?>',
            type: 'error'
        });
      <?php } ?>
    });
  </script>

</body>
</html>
