
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>TRMS | Teacher Profile</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/styles.css')?>" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
      <?php include APPPATH.'views/user/include/header.php';?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
               <?php include APPPATH.'views/user/include/sidebar.php';?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">User Profile</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                       <div class="row">
                            <div class="col-xl-12">
                                 <?php if($this->session->flashdata('success')){?>
<p style="color:green"><?php  echo $this->session->flashdata('success');?></p>  
<?php } ?>

<!--error message -->
<?php if($this->session->flashdata('error')){?>
<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>  
<?php } ?>
                                <div class="card">
                                    <div class="card-body">
                                        <?php echo form_open_multipart('user/Users/update',['name'=>'profile','class'=>'col-form']);?>
                                            <div class="row">
                                                   <div class="col-md-4">
                                                      <label for="firstName">FirstName:</label>
      <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $uresult->firstName; ?>">
                                                    </div>
                                                    
                                                      <div class="col-md-4">
                                                          <label for="lastName">LastName:</label>
      <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $uresult->lastName; ?>">
                                                    </div>

                                                       <div class="col-md-4">
                                                          <label for="email">Email:</label>
      <input type="text" class="form-control" id="email" name="email"value="<?php echo $uresult->email; ?>">
                                                    </div>
                                                       <div class="col-md-4">
                                                          <label for="contactno">Contact No:</label>
      <input type="text" class="form-control" id="contactno" name="contactno" value="<?php echo $uresult->contactno; ?>">
                                                    </div>
                                                       <div class="col-md-4">
                                                          <label for="state">State:</label>
      <input type="text" class="form-control" id="state" name="state" value="<?php echo $uresult->state; ?>">
                                                    </div>
                                                       <div class="col-md-4">
                                                          <label for="city">City:</label>
      <input type="text" class="form-control" id="city" name="city" value="<?php echo $uresult->city; ?>">
                                                    </div>
                                                      
                                                       <div class="col-md-4">
                                                          <label for="subject">Subject:</label>
      <select class="form-control" id="subject" name="subject">

      <option value="<?php echo $uresult->subject; ?>"><?php echo $uresult->subjectname; ?></option>
                            

                                        <?php
                                        foreach($sub as $row)
                                        {
                                        echo '<option value="'.$row->id.'">'.$row->subjectname.'</option>';
                                        }
                                        ?>
                                        </select>
                                                    </div>
                                                     <div class="col-md-4">
                                                          <label for="qualification">Qualification:</label>
      <input type="text" class="form-control" id="qualification" name="qualification" value="<?php echo $uresult->qualification; ?>">
                                                    </div>
                                                       <div class="col-md-4">
                                                          <label for="profilephoto">Profile Photo:</label>
      <input type="file" class="form-control" id="profilephoto" name="profilephoto">
        <input type="hidden"  id="photo" name="photo" value="<?php echo $uresult->profilephoto; ?>">
           <?php if($uresult->profilephoto){?>
                <img src="<?php echo base_url().'uploads/files/'.$uresult->profilephoto ?>" width="200" height="150"> 
                <?php }?>
<span id="spnmsg"></span>
                
            </div>
                                                      
                                                       <div class="col-md-4">
                                                          <label for="Joiningdate">Joining date:</label>
      <input type="text" class="form-control" id="Joiningdate" name="Joiningdate" value="<?php echo $uresult->Joiningdate; ?>">
                                                    </div>

                                                      <div class="col-md-8">
                                                          <label for="address">Address:</label>
      <textarea class="form-control" id="address" name="address"><?php echo $uresult->address; ?></textarea> 
                                                    </div>
                               </div>
   <br>
   

   <input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit">
  </form>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                       
                    </div>
                </main>
              
                 <?php include APPPATH.'views/user/include/footer.php';?>
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
        //alert('hello');
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

