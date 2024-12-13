<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!--=== CSS ===-->

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('tool/css/bootstrap.min.css'); ?>">
    <!-- Font-awesome css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('tool/css/all.css'); ?>">
    <!-- Owl-carousel css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('tool/css/owl.carousel.min.css'); ?>">
    <!-- My css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('tool/css/style.css'); ?>">
    
    <!-- jQuery min js -->
    <script type="text/javascript" src="<?= base_url('tool/js/jquery-3.2.1.slim.min.js'); ?>"></script>

    <title>Student Admission System</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('tool/img/favicon.png'); ?>">
</head>

<body>

    <!--=== Header ===-->
    <?php $this->load->view('temp/header') ?>
    <div>
        <?php 
        if($this->session->flashdata('login_success'))
        {
            print '<div class = "success-msg">';
            print '<div class = "container">'.$this->session->flashdata('login_success').'</div>';
            print '</div>';
        }
        ?>
    </div>
    <!--=== Slider ===-->
    <?php $this->load->view('temp/slider') ?>

    
    <!--=== Services ===-->
    <?php $this->load->view('temp/services') ?>

    <!--=== Students ===-->
    <div class="container">
        <div class="section-title">Our students</div>
        <p class="text-center">
            <?php
            $this->load->model('user_model');
            $total_students = count($this->user_model->get_students());
            print "We have total ".$total_students." regular students"; 
            ?>
        </p>
        
        <div class="row">
            <div class="owl-carousel student-slider">
                <?php foreach ($students_slider as $student): ?>
                    <div class="col-lg-12">
                        <div class="single-slider">
                            <div class="slide-image"><?php print '<img src="'.strip_tags($student->profile_image).'" width="120" height = "120">'; ?></div>
                            <p><a href="#" class="text-info"><?= $student->s_name ?></a></p>
                            <p><?= $student->email ?></p>
                            <p><?=$student->address ?></p>
                        </div>
                    </div>
               <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!--=== Footer ===-->
    <?php $this->load->view('temp/footer') ?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="<?= base_url('tool/js/popper-1.12.9.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('tool/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('tool/js/all.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('tool/js/owl.carousel.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('tool/js/main.js'); ?>"></script>
</body>

</html>

