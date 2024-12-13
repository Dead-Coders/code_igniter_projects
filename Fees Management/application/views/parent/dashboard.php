<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// school info
$school_name = $this->db->get_where('settings_tbl',array('ID'=>1))->row()->NAME;
$school_address = $this->db->get_where('settings_tbl',array('ID'=>1))->row()->ADDRESS;
$school_phone = $this->db->get_where('settings_tbl',array('ID'=>1))->row()->PHONE;
$school_bank = $this->db->get_where('settings_tbl',array('ID'=>1))->row()->BANK;
$school_accname = $this->db->get_where('settings_tbl',array('ID'=>1))->row()->ACC_NAME;
$school_accnum = $this->db->get_where('settings_tbl',array('ID'=>1))->row()->ACC_NUMBER;
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
            <h1 class="m-0 text-dark">DASHBOARD</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 text-right">
            <?php echo 'Current Session: '.$current_session; ?>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                  <?php  
                  $this->db->from('student');
                  $this->db->where('SESSION', $current_session);
                  $this->db->where('PARENT', $login_id);
                  $numquery = $this->db->get();
                  echo $numquery->num_rows();
                  ?>
                </h3>
                <p>Total Wards</p>
              </div>
              <div class="icon">
                <i class="fa fa-user-circle"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- <div class="col-md-2"></div> -->
          <div class="col-md-8">
            <div class="card card-widget widget-user-2">
              <div class="widget-user-header bg-success">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="<?php echo base_url() ?>uploads/feesicon.png" alt="Logo">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username"><?php echo $school_name; ?></h3>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      PHONE <span class="float-right"><?php echo $school_phone ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      ADDRESS <span class="float-right"><?php echo $school_address ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      BANK <span class="float-right"><?php echo $school_bank ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      ACCOUNT NAME <span class="float-right"><?php echo $school_accname ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      ACCOUNT NUMBER <span class="float-right"><?php echo $school_accnum ?></span>
                    </a>
                  </li>
                </ul>
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

</body>
</html>
