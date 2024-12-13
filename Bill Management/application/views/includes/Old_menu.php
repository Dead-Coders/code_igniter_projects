<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
        var base_url='<?php echo site_url();?>';  
        var arr = new Array();
        $.ajax
        (
          {
            'url': base_url + '/Menu_Controller/getRights1',
            'type': 'POST', 
            'success': function(data)
            {
              arr = data.split(",");
              arr = arr.slice(0,arr.length-1);
                $('a.menu1').each(function(){
                    for(i=0;i<arr.length;i++)
                    {
                        if(arr[i] === $(this).text())
                        {
                            $(this).css("display","block");
                            break;
                        }
                        else
                        {
                            $(this).css("display","none");
                        }
                    }
                });
            }
          }
        );
</script>
    <div class="container">
        <nav class="nav navbar navbar-inverse navbar-fixed-top">
          <div class="navbar-header"> <!-- It is responsible to Touch Menu for small devices -->
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php  echo base_url();  ?>index.php/Search_controller">ABD : </a>
          </div>

          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

              <li class="dropdown">
                <a tabindex="0" class="menu1" style="display:none;" data-toggle="dropdown">Masters<span class="caret"></span></a>
                <!-- role="menu": fix moved by arrows (Bootstrap dropdown) -->
                <ul class="dropdown-menu" role="menu">
                  <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Donors_Controller">Donors Data</a></li>
                  <li class="divider"></li>
                </ul>
              </li>



              <li class="dropdown">
                <a tabindex="0" class="menu1" style="display:none;" data-toggle="dropdown">Reports<span class="caret"></span></a>

              </li>

              <li class="dropdown">
                <a tabindex="0" class="menu1" style="display:none;" data-toggle="dropdown">Tools<span class="caret"></span></a>

                <!-- role="menu": fix moved by arrows (Bootstrap dropdown) -->
                    <ul class="dropdown-menu" role="menu">
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/User_Controller">Create Users</a></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/Right_Controller">User Rights</a></li>
                      <li class="divider"></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/ChangePwdAdmin_controller">Reset Password</a></li>
                      <li class="divider"></li>
                      <li><a tabindex="0" class="menu1" style="display:none;" href="<?php  echo base_url();  ?>index.php/BackupData_Controller">Backup Data</a></li>
                    </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right" style="padding-right:25px;">
              <li class="dropdown">
              <a href="#" tabindex="0" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"> <?php echo $this->session->userid?> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a  tabindex="0" href="<?php  echo base_url();  ?>index.php/Login_controller/logout">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>
                  <li class="divider"></li>
                  <li><a  tabindex="0" href="<?php  echo base_url();  ?>index.php/ChangePwd_controller">Change Password</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <script>  
           /* Remove following comments to enable hover effect on menu and sub-menu.
           */
           // $('li.dropdown,li.dropdown-submenu').hover(function() {
           //    $(this).find('>ul.dropdown-menu').stop(true, true).delay(100).fadeIn('slow');
           //    }, function() {
           //      $(this).find('>ul.dropdown-menu').stop(true, true).delay(100).fadeOut('slow');
           //  });

         </script>
    </div> <!-- end of 'container' div   -->
<div class="container">