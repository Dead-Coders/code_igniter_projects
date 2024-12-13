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
                        <a class="active" href="<?php echo base_url('admin/dashboard');?>"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="heading">FEATURES</li>
                    <li class="">
                        <a href="javascript:;" aria-expanded="false"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">Add Blood Group</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse" aria-expanded="false" style="height: 0px;">
                            <li>
                                <a href="<?php echo base_url('admin/Bloodgroup/add'); ?>">Add Blood Group</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/Bloodgroup/Manage'); ?>">Manage Blood Group</a>
                            </li>
                          
                        </ul>
                    </li>
                    
                           <li><a class="active" href="<?php echo base_url('admin/viewuser');?>"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">User Details</span></a></li>

                           <li><a class="active" href="<?php echo base_url('admin/report');?>"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Report</span></a></li>
                   
                </ul>
            </div>
        </nav>