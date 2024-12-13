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

  <?php  

  $class_name = $this->db->get_where('class_tbl',array('ID'=>$class_id))->row()->NAME; 
  $class_fees = $this->db->get_where('class_tbl',array('ID'=>$class_id))->row()->FEES; 
  $student_name = $this->db->get_where('student', array('ID'=>$student_id))->row()->NAME;

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $student_name; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6 text-right">
          <?php echo 'Current Session: '.$current_session; ?>
          </div><!-- /.col -->
          <div class="col-md-12" style="margin-top: 10px;">
            <div class="callout callout-success">
              <h5>Payable amount for the session: <?php echo '$'.number_format($class_fees); ?></h5>
            </div>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?php  

        $this->db->where('SESSION', $current_session);
        $this->db->where('CLASS_ID', $class_id);
        $term = $this->db->get('term_tbl')->result_array();

        foreach ($term as $row):
          $term_id = $row['ID'];
          $total_fees = $row['FEES'];

          $this->db->select('SUM(AMOUNT_PAID) as amt');
          $this->db->where('STUDENT', $student_id);
          $this->db->where('SESSION', $current_session);
          $this->db->where('CLASS', $class_id);
          $this->db->where('TERM', $term_id);
          $q=$this->db->get('all_payments_tbl');
          $r=$q->row();
          $amount_paid=$r->amt;
          

          $pending_amount = $total_fees - $amount_paid;
        ?>
        <div class="card card-primary card-outline collapsed-card">
          <div class="card-header">
            <h3 class="card-title">
              <?php
              echo 'Expected Payment for '.$row['NAME'].' is $'.number_format($total_fees).'. Paid $'.number_format($amount_paid).'. Balance: $'.number_format($pending_amount);
              ?>
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-expand"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="display: none;">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-success">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fa fa-dollar"></i>
                      Payment History
                    </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive">
                    <table id="example2" class="table table-hover table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Amount</th>
                          <th>Payment Date</th>
                          <th>Expiration Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php  
                          $count = 1;
                          $this->db->where('STUDENT',$student_id);
                          $this->db->where('CLASS', $class_id);
                          $this->db->where('TERM', $row['ID']);
                          $this->db->order_by('ID', 'DESC');
                          $payments = $this->db->get('all_payments_tbl')->result_array();
                          foreach ($payments as $row):
                        ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td>$ <?php echo number_format($row['AMOUNT_PAID']) ?></td>
                          <td><?php echo date("d",strtotime($row['CREATION_DATE'])).'/'. date("F",strtotime($row['CREATION_DATE'])).'/'. date("Y",strtotime($row['CREATION_DATE'])) ?></td>
                          <td><?php echo date("d",strtotime($row['EXPIRE_DATE'])).'/'. date("F",strtotime($row['EXPIRE_DATE'])).'/'. date("Y",strtotime($row['EXPIRE_DATE'])) ?></td>
                        </tr>
                        <?php  
                          endforeach;
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <?php  
        endforeach;
        ?>
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
  $('#example2').DataTable();
  $('.money').simpleMoneyFormat();
</script>

</body>
</html>
