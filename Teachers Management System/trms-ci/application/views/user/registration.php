
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>TRMS | Teachers Registration</title>
        <link href="<?php echo base_url('assets/css/styles.css')?>" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-9">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                         <?php if($this->session->flashdata('success')){?>
<p style="color:green"><?php  echo $this->session->flashdata('success');?></p>  
<?php } ?>

<!--error message -->
<?php if($this->session->flashdata('error')){?>
<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>  
<?php } ?>

                                    <div class="card-body">
                                       <?php echo form_open_multipart('user/Registration/index',['name'=>'Nameandemblems','class'=>'col-form']);?>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="firstName" name="firstName" type="text" placeholder="Enter your first name" required="">
                                                        <label for="firstName">First name</label>
                                                    </div>
                                                        <?php echo form_error('firstName','<div style="color:red">', '</div>'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="lastName" name="lastName" type="text" placeholder="Enter your last name" required="">
                                                        <label for="lastName">Last name</label>
                                                    </div>
                                                     <?php echo form_error('lastName','<div style="color:red">', '</div>'); ?>
                                                </div>
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="email" name="email" type="email" placeholder="Enter your first name" required="">
                                                        <label for="email">Email</label>
                                                    </div>
                                                     <?php echo form_error('email','<div style="color:red">', '</div>'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="contactno" name="contactno" type="text" placeholder="Enter your last name" maxlength="10" required="">
                                                        <label for="contactno">Contact No</label>
                                                    </div>
                                                     <?php echo form_error('contactno','<div style="color:red">', '</div>'); ?>
                                                </div>
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="state" name="state" type="text" placeholder="Enter your first name" required="">
                                                        <label for="state">State</label>
                                                    </div>
                                                     <?php echo form_error('state','<div style="color:red">', '</div>'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="city" name="city" type="text" placeholder="Enter your last name" required="">
                                                        <label for="city">City</label>
                                                    </div>
                                                     <?php echo form_error('city','<div style="color:red">', '</div>'); ?>
                                                </div>
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="address" name="address" type="text" placeholder="Enter your first name" required="">
                                                        <label for="address">Address</label>
                                                    </div>
                                                     <?php echo form_error('address','<div style="color:red">', '</div>'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                       
                                                        <select class="form-control" name="subject" id="subject" required="">
                        <option value="">--select Subject--</option>
                        <?php
                        foreach($sub as $row)
                        {
                        echo '<option value="'.$row->id.'">'.$row->subjectname.'</option>';

                                        }
                                        ?>
                                                        </select>
                                                       
                                                    </div>
                                                       <?php echo form_error('subject','<div style="color:red">', '</div>'); ?>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="profilephoto" name="profilephoto" type="file" placeholder="Enter your first name" required="">
                                                        <label for="profilephoto">profile Photo</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="qualification" name="qualification" type="text" placeholder="Enter your last name" required="">
                                                        <label for="qualification">Qualification</label>
                                                    </div>
                                                     <?php echo form_error('qualification','<div style="color:red">', '</div>'); ?>
                                                </div>
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="Joiningdate" name="Joiningdate" type="date" placeholder="Enter your first name" required="">
                                                        <label for="Joiningdate">Joining Date</label>
                                                    </div>
                                                     <?php echo form_error('Joiningdate','<div style="color:red">', '</div>'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="password" name="password" type="password" placeholder="Enter your last name" required="">
                                                        <label for="password">Password</label>
                                                    </div>
                                                     <?php echo form_error('password','<div style="color:red">', '</div>'); ?>
                                                </div>
                                            </div>
                                           
                                           
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                      <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit">

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="<?php echo base_url('user/Login'); ?>">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
          
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
    </body>
</html>
