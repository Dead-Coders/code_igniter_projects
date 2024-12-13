<header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
     <?php echo form_open('Search',['name'=>'search'])?>
                                <?php echo form_input(['name'=>'searchdata','id'=>'searchdata','class'=>'au-input au-input--xl','placeholder'=>'Search by names &amp; mobile number...','required'=>'true']);?>
                          <?php echo form_submit(['name'=>'submit','value'=>'Search','class'=>'btn btn-primary btn-md']); ?>

                         
                            <?php echo form_close();?>
                            <div class="header-button">
                                <div class="noti-wrap">
                        
                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="<?php echo base_url('assets/images/icon/avatar-01.jpg');?>" alt="Admin" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="<?php echo site_url('AdminProfile'); ?>">Admin</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
 <img src="<?php echo base_url('assets/images/icon/avatar-01.jpg');?>" alt="John Doe" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="<?php echo site_url('Dashboard'); ?>">Admin</a>
                                                    </h5>
                                                   
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="<?php echo site_url('AdminProfile'); ?>">
                                                        <i class="zmdi zmdi-account"></i>Admin Profile</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="<?php echo site_url('ChangePassword'); ?>">
                                                        <i class="zmdi zmdi-settings"></i>Change Password</a>
                                                </div>
                                               
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="<?php echo site_url('Logout'); ?>">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>