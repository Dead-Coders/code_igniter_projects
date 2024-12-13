<a href="<?=base_url('dashboard')?>" class="logo">
    <span class="logo-mini"><b>OES</b></span>
    <span class="logo-lg"><b>O</b>nline <b>E</b>xam <b>S</b>ystem </span>
</a>

<nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <img src="<?=base_url()?>assets/dist/img/usersys-min.png" class="user-image" alt="User Image">
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">Hi, <?=$user->first_name?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- The user image in the menu -->
                    <li class="user-header">
                        <img src="<?=base_url()?>assets/dist/img/usersys-min.png" class="img-circle" alt="User Image">
                        <p>
                            <?=$user->first_name.' '.$user->last_name?>
                            <small>Member Since <?=date('M, Y', $user->created_on)?></small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="<?=base_url()?>users/edit/<?=$user->id?>" class="btn btn-warning btn-flat">
                                <?=$this->ion_auth->is_admin() ? "Edit Profile" : "Change Password" ?>
                            </a>
                        </div>
                        <div class="pull-right">
                            <a href="#" id="logout" class="btn btn-danger btn-flat">Logout</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>