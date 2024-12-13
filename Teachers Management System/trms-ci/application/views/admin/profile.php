
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
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
                        <h1 class="mt-4">Admin Profile</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Admin Profile Details</li>
                        </ol>
                       <div class="row">
                            <div class="col-xl-12">
                               
                                <div class="card">
                                    <div class="card-body">
                                        <?php echo form_open_multipart('user/Users/update',['name'=>'profile','class'=>'col-form']);?>
                                            <div class="row">
                                                   <div class="col-md-12">

 <table class="table table-striped">
                                  <tr>
                                      <th>Admin Name </th>
                                      <td><?php echo $adminresult->name; ?></td>
                                  </tr>
                                    <tr>
                                      <th>Admin Email </th>
                                      <td><?php echo $adminresult->email; ?></td>
                                  </tr>

                                    <tr>
                                      <th>Admin Contact No </th>
                                      <td> <?php echo $adminresult->contact; ?></td>
                                  </tr>

                                    <tr>
                                      <th>Registration Date </th>
                                      <td>  <?php echo $adminresult->create_date;?></td>
                                  </tr>
                              </table>


   
                                                    </div>
                                                    
                                                     

                                                 
                                                      
                               </div>
   <br>
   
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
<style>
img {
  border: 1px solid #555;
  width: 150px;
  height: 150px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function() {
    $("#profilephoto").change(function() {
        alert('hello');
        var extension = $(this).val().split('.').pop().toLowerCase();
        var validFileExtensions = ['jpeg', 'jpg', 'png', 'pdf'];
        if($.inArray(extension, validFileExtensions) == -1) {
            $('#spnmsg').text("Failed!! Please upload jpg, jpeg, png, pdf file only.").show();
            $(this).replaceWith($(this).val('').clone(true));
            $('#submit').prop('disabled', true);
        } else {
            // Check and restrict the file size to 32 KB.
            if($(this).get(0).files[0].size > (2097152)) {
                $('#spnmsg').text("Failed!! Max allowed file size is 2 MB").show();
                $(this).replaceWith($(this).val('').clone(true));
                $('#submit').prop('disabled', true);
            } else {
                $('#spnmsg').text('').hide();
                $('#submit').prop('disabled', false);
            }
        }
    });
});
</script>

