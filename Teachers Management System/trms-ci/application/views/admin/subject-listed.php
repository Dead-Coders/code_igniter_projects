
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>TRMS | Listed Subjects</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/styles.css')?>" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
      <?php include APPPATH.'views/admin/include/header.php';?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
               <?php include APPPATH.'views/admin/include/sidebar.php';?>
            </div>
             <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Listed Subject</h1>
                       
                       
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                           Subject Details
                            </div>

                              <?php if($this->session->flashdata('success')){?>
<p style="color:green"><?php  echo $this->session->flashdata('success');?></p>  
<?php } ?>

                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr> <th>Sr.No</th>
                                            <th>Subject Name</th>
                                            <th>Listed Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                   <tbody>
                                <?php
                                if(count($sresult)) {
                                $cnt=1;
                                foreach ($sresult as $row){
                                ?>
                                <tr>
<td><?php echo htmlentities($cnt);?></td>
<td><?php echo htmlentities($row->subjectname)?> </td> 
<td><?php echo htmlentities($row->postingDate)?> </td> 
<td>
<?php echo anchor("admin/Subject/delete/{$row->id}",'Delete',array('class' => 'btn btn-primary btn-sm')); ?>
</td>

                                </tr>
                                <?php
                                $cnt++;
                                } // end foreach
                                } else { ?>
                                <tr>
                                <td colspan="7">No Record found</td>
                                </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
              
              
                 <?php include APPPATH.'views/admin/include/footer.php';?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/demo/chart-area-demo.js')?>"></script>
        <script src="<?php echo base_url('assets/demo/chart-bar-demo.js')?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/js/datatables-simple-demo.js')?>"></script>

   <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/js/datatables-simple-demo.js')?>"></script>

    </body>
</html>
