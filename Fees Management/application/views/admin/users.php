<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<body class="hold-transition sidebar-mini">
<div class="wrapper">
<?php include 'inc/head.php'; ?>
  <!-- Navbar -->
  <?php include 'inc/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'inc/aside.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-12">
              <div class="row mt-5">
                <div class="col-md-12">
                  <div class="card">
                    <!-- <div class="card-header card-info"> -->
                      <!-- <h3 class="card-title"></h3> -->
                      <!-- <div class="card-tools">
                          
                      </div>
                    </div> -->
                    <!-- /.card-header -->
                    <div class="card-body mt-3">

                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" href="#courses" role="tab" data-toggle="tab">ALL USERS</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#add" role="tab" data-toggle="tab">ADD USER</a>
                        </li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active table-responsive" id="courses">

                          <table class="table table-hover table-bordered table-striped" id="example1">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>FULL NAME</th>
                                <th>EMAIL</th>
                                <th>PRIVILLEGE</th>
                                <th>ACTIONS</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php  
                              $count = 1;
                              $this->db->order_by('creation_date', 'ASC');
                              $users = $this->db->get('users_tbl')->result_array();
                              foreach ($users as $row):
                              ?>
                              <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['NAME']; ?></td>
                                <td><?php echo $row['EMAIL']; ?></td>
                                <td><?php echo strtoupper($row['PRIV']); ?></td>
                                <td>
                                  <a href="<?php echo base_url() ?>admin/sub_action/del_user/<?php echo $row['ID']; ?>" class="btn btn-sm btn-block btn-danger btn-flat">Delete User</a>
                                </td>
                              </tr>
                              <?php  
                              endforeach;
                              ?>
                            </tbody>
                          </table>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="add">

                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <form role="form" method="POST" action="<?php echo base_url() ?>admin/action/new_user" enctype="multipart/form-data">
                                <div class="card-body">
                                  <div class="form-group">
                                    <label>FULL NAME</label>
                                      <input required autocomplete="off" value="<?php ?>" type="text" name="name" class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label>EMAIL</label>
                                      <input required autocomplete="off" type="email" value="<?php  ?>" name="email" class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label>PASSWORD</label>
                                      <input required autocomplete="off" type="password" value="<?php  ?>" name="pwd" class="form-control">
                                  </div>
                                  <div class="form-group">
                                    <label>PRIVILLEGE</label>
                                      <select required name="priv" class="form-control">
                                        <option value="">SELECT USER PRIVILLEGE</option>
                                        <option value="standard">STANDARD</option>
                                        <option value="admin">ADMIN</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                    <button type="submit" class="btn btn-primary">ADD NEW USER</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <div class="col-md-2"></div>
                          </div>

                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include 'inc/footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php include 'inc/rscript.php'; ?>
<script>
  $(function () {
    $("#example1").DataTable();

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
