<?php  $userid=$this->session->userdata('fname'); ?>
<nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="<?php echo base_url('assets/img/admin-avatar.png')?>" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong"><?php echo $userid;?></div><small>Administrator</small></div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="active" href="<?php echo base_url('user/dashboard');?>"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a class="active" href="<?php echo base_url('user/Profile');?>"><i class="sidebar-item-icon fa fa-user"></i>
                            <span class="nav-label">Profile</span>
                        </a>
                    </li>

                    <li>
                        <a class="active" href="<?php echo base_url('user/Changepwd');?>"><i class="sidebar-item-icon fa fa-support"></i>
                            <span class="nav-label">Change Password</span>
                        </a>
                    </li>

                    <li>
                        <a class="active" href="<?php echo base_url('user/Logout');?>"><i class="sidebar-item-icon fa fa-power-off"></i>
                            <span class="nav-label">Logout</span>
                        </a>
                    </li>
                   
                </ul>
            </div>
        </nav>