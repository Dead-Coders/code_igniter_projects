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
            <h1 class="m-0 text-dark">
              <?php 
              echo $class_name = $this->db->get_where('class_tbl',array('ID'=>$class_id))->row()->NAME . ' : '; 
              echo $current_session = $this->db->get_where('settings_tbl',array('ID'=>1))->row()->SESSION; 
              ?>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#addNew"><i class="fa fa-user"></i>&nbsp; Add New Student</button>
          </div><!-- /.col -->

      <!-- Modal -->
      <div class="modal fade" id="addNew" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="form">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">New Student Reg. Form into <?php echo $class_name .' : '.$current_session.' Session'; ?></h5>
              </div>
              <form method="POST" action="<?php echo base_url() ?>admin/action/add_new_student/<?php echo $class_id; ?>" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="exampleInputFile">FULL NAME</label>
                        <input autocomplete="off" required type="text" name="name" placeholder=""class="form-control">
                      </div>
                      <!--  -->
                      <hr>
                      <div class="form-group">
                        <label for="">PARENT</label>
                          <select class="form-control select2" name="parent" style="width: 100%;">
                            <option value="">--- --- ---</option>
                            <?php  
                          $parent = $this->db->get('parent_tbl')->result_array();
                          foreach ($parent as $row):
                            ?>
                            <option value="<?php echo $row['ID']; ?>"><?php echo $row['NAME']; ?> (<?php echo $row['EMAIL']; ?>)</option>
                            <?php  
                          endforeach;
                            ?>
                          </select>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add Student</button>
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
                      <!-- <h3 class="card-title"></h3> -->
                      <div class="card-tools">
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body mt-3">

                      <table class="table table-hover table-bordered table-striped" id="example1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>PARENT</th>
                            <th>NAME</th>
                            <th>ACTIONS</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php  
                          $count = 1;
                          $this->db->where('CLASS', $class_id);
                          $this->db->where('SESSION', $current_session);
                          $student = $this->db->get('student')->result_array();
                          foreach ($student as $row):
                          ?>
                          <tr>
                            <td><?php echo $count++; ?></td>
                            <td>
                              <?php echo $this->db->get_where('parent_tbl',array('ID'=>$row['PARENT']))->row()->NAME.' ('.$this->db->get_where('parent_tbl',array('ID'=>$row['PARENT']))->row()->EMAIL.')'; ?>
                            </td>
                            <td><?php echo $row['NAME']; ?></td>
                            <td>
                              <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addNew<?php echo $row['ID'] ?>">VIEW</button>
                            </td>
                          </tr>

                          <!-- Modal -->
      <div class="modal fade" id="addNew<?php echo $row['ID'] ?>" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="form">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">VIEW/EDIT STUDENT INFO.</h5>
              </div>
              <form method="POST" action="<?php echo base_url() ?>admin/action/edit_student/<?php echo $row['ID']; ?>/<?php echo $class_id; ?>" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="exampleInputFile">FULL NAME</label>
                        <input autocomplete="off" required type="text" value="<?php echo $row['NAME'] ?>" name="name" placeholder=""class="form-control">
                      </div>
                      <!--  -->
                      <hr>
                      <div class="form-group">
                        <label for="">PARENT</label>
                          <select class="form-control select2" name="parent" style="width: 100%;">
                            <option value="">--- --- ---</option>
                            <?php  
                          $parents = $this->db->get('parent_tbl')->result_array();
                          foreach ($parents as $parent):
                            ?>
                            <option <?php if($parent['ID']==$row['PARENT']) echo 'selected'; ?> value="<?php echo $parent['ID']; ?>"><?php echo $parent['NAME']; ?> (<?php echo $parent['EMAIL']; ?>)</option>
                            <?php  
                          endforeach;
                            ?>
                          </select>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update Student Info</button>
                  </div>
              </form>
            </div>
        </div>
      </div>

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
      $('.select2').select2();
      $("#example1").DataTable();
      $('.money').simpleMoneyFormat();
      <?php if($this->session->flashdata('completed') != ''){ ?>
        new PNotify({
            title: 'Notification',
            text: '<?php echo $this->session->flashdata('completed'); ?>',
            type: 'success'
        });
      <?php } ?>
    });
  </script>

</body>
</html>
