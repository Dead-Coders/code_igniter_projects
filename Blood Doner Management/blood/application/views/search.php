<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Blood Donor Management System</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
 
  <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css');?>" rel="stylesheet">



  <!-- Template Main CSS File -->
  <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="<?php echo base_url('welcome');?>">BDMS</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="<?php echo base_url('user/login'); ?>">User Login</a></li>
          <li><a class="nav-link scrollto" href="<?php echo base_url('admin/login');?>">Admin Login</a></li>
          <li><a class="getstarted scrollto" href="#contact">Search Data</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>Blood Donor Management System</h1>
 
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="<?php echo base_url('assets/img/hero-img.png');?>" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

  
    <section id="contact" class="contact">
      <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="section-title">
          <h2>Search Blood Donor Now</h2>
        </div>

        <div class="row">
 <div class="col-lg-12">
            <?php echo form_open('welcome',['class'=>'php-email-form']);?>
              <div class="row">
                <div class="form-group col-md-6">
                  
                  <input type="text" name="searchdata" class="form-control" autocomplete="off" 
                  id="name" placeholder="Please Enter Blood Group/State Name" required="">
                </div>
                <div class="form-group col-md-6">
                  
                  <input type="submit" name="submit" id="submit" value="Search Now" class="btn btn-primary">
                </div>
              </div>
            </form>
            <?php if(Isset($_POST['submit'])){ ?>
          
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact No</th>
                  <th>bloodgroup</th>
                  <th>State</th>
                 
                </tr>
              </thead>
              <tbody>
              <?php
count($searchresult);
if(count($searchresult)) :
$cnt=1; 
foreach ($searchresult as $row) :
?>  
              
                <tr>
                  <td><?php echo $cnt;?></td>
            
                  <td><?php  echo $row->first_name;?>  <?php  echo $row->last_name;?></td>
                <td><?php  echo $row->email;?><br>
                <td><?php  echo $row->contact_no;?></td>
                <td><?php  echo $row->bloodname;?></td>
                <td><?php  echo $row->state;?></td>


                  </td>
                </tr>
              <?php 
              $cnt++;
              endforeach;
              else : ?>

              <tr>
              <td colspan="6" style="text-align:center">No Record found</td>
              </tr>
              <?php
              endif;
              ?>  
              </tbody>
            </table> 
            <?php } ?>    
             </div>

        </div>

      </div>
    </section>
   </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>Blood Donar Management System</span></strong>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="<?php echo base_url('assets/js/main.js');?>"></script>

</body>

</html>