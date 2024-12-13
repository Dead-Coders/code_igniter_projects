
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>TRMS | Admin Add Subjects</title>
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
                        <h1 class="mt-4">Add Subject</h1>
             
                       <div class="row">
                            <div class="col-xl-6">
                                <?php if($this->session->flashdata('success')){?>
<p style="color:green"><?php  echo $this->session->flashdata('success');?></p>  
<?php } ?>

<!--error message -->
<?php if($this->session->flashdata('error')){?>
<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>  
<?php } ?>
                                <div class="card mb-4">
                                    <div class="card-body">
                                         <?php echo form_open('admin/Subject/Add',['name'=>'AddSubject']);?>
    <div class="mb-3 mt-3">
      <label for="currentpassword">Subject Name</label>
      <input type="text" class="form-control" id="subjectname" name="subjectname" value="<?php echo set_value('subjectname');?>">
        <?php echo form_error('subjectname','<p style="color:red">','<p>')?>
    </div>




   <input type="submit" name="submit" id="submit" value="submit" class="btn btn-primary">
    
  </form>
                                    </div>
                                </div>
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
    </body>
</html>
