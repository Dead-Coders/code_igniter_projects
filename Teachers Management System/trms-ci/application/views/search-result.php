<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>TRMS Home Page</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?php echo base_url('css/styles.css');?>" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container">
                <a class="navbar-brand" href="<?php echo site_url('Home');?>">Teachers Record Management System</a>
                <a class="btn btn-primary" href="<?php echo site_url('user/Login');?>">Teacher SIgn in</a>
                   <a class="btn btn-primary" href="<?php echo site_url('admin/Login');?>">Admin</a>
            </div>
        </nav>
        <!-- Masthead-->
  

                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <h2 align="center">Search Results</h2>
                        <hr />
               <table class="table table-striped">
    <thead>
        <?php if(count($search)):
            ?>
      <tr>
        <th>Pic</th>
        <th>Firstname</th>
        <th>Email</th>
        <th>Contact No</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Subject</th>
        <th>Qualification</th>
        <th>Joining Date</th>
        <th>Reg. Date</th>
      </tr>
    </thead>
    <tbody>
        <?php 
         foreach($search as $row){ ?>
      <tr>
        <th> <img src="<?php echo base_url().'uploads/files/'.$row['profilephoto']; ?>" width="200" height="150" style="border:solid 1px #000"></th>
        <td><?php echo htmlentities($row['firstName']." ".$row['lastName'])?></td>
        <td><?php echo htmlentities($row['email'])?></td>
        <td><?php echo htmlentities($row['contactno'])?></td>
                <td><?php echo htmlentities($row['address'])?></td>
        <td><?php echo htmlentities($row['city'])?></td>
        <td><?php echo htmlentities($row['state'])?></td>
                <td><?php echo htmlentities($row['subjectname'])?></td>
        <td><?php echo htmlentities($row['qualification'])?></td>
        <td><?php echo htmlentities($row['Joiningdate'])?></td>
        <td><?php echo htmlentities($row['create_date'])?></td>

      </tr>
<?php } else:?>
<tr>
    <td colspan="9" style="color:red; text-align:center; font-size:32px;">No Record found</td>
</tr>
<?php endif;?>
    </tbody>
  </table>
                    </div>
                </div>
  

      

     
        <footer class="footer bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                   
                        <p class="text-muted small mb-4 mb-lg-0">&copy; Teachers Record Management System</p>
                    </div>
                    <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item me-4">
                                <a href="#!"><i class="bi-facebook fs-3"></i></a>
                            </li>
                            <li class="list-inline-item me-4">
                                <a href="#!"><i class="bi-twitter fs-3"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!"><i class="bi-instagram fs-3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="<?php echo base_url('js/scripts.js');?>"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
