
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
                        <h1 class="mt-4"><?php echo $uresult->firstName;?>'s Profile</h1>
                       
                       
                        <div class="card mb-4">
                        
                            <div class="card-body">
                                <table class="table table-striped">
                                  <tr>
                                      <th>First Name </th>
                                      <td>  <?php echo $uresult->firstName;?></td>
                                      <th>Last Name</th>
                                      <td> <?php echo $uresult->lastName;?></td>
                                  </tr>
                                   <tr>
                                      <th>Email</th>
                                      <td> <?php echo $uresult->email;?></td>
                                      <th>Contact No</th>
                                      <td> <?php echo $uresult->contactno;?></td>
                                  </tr>
                                   <tr>
                                      <th>State</th>
                                      <td> <?php echo $uresult->state;?></td>
                                      <th>City</th>
                                      <td> <?php echo $uresult->city;?></td>
                                  </tr>
                                 
                                    <tr>
                                      <th>Qualification</th>
                                      <td> <?php echo $uresult->qualification;?></td>
                                      <th>Joining date</th>
                                      <td> <?php echo $uresult->Joiningdate;?></td>
                                  </tr>

                                    <tr>
                                      <th>Address</th>
                                      <td> <?php echo $uresult->address;?></td>
                                      <th>Profilephoto</th>
                                       <td>   
                                        <?php if($uresult->profilephoto){?>
                                        <img src="<?php echo base_url().'uploads/files/'.$uresult->profilephoto ?>" width="200" height="150"> 
                                        <?php }?>

                                      </td>
                                  </tr>


                                  
                                 
                                
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
<style>
    img {
  border: 1px solid #555;
}
</style>