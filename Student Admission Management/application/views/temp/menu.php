<div class="main-menu text-center">
	<ul>
	    <li><a href="<?= base_url('home')?>">Home</a></li>
	    <?php if($this->session->userdata('logged_in')): ?>
	    	<li><a href="<?= base_url('users/admission')?>">Admissions</a></li>
	    	<li><a href="<?= base_url('users/all_students')?>">Students Section</a></li>
	    	<li><a href="<?= base_url('users/add_admin')?>" class="reg-btn"><i class="fas fa-user-plus"></i> Register</a></li>
	    	<li><a href="<?= base_url('home/logout')?>"><i class="fa fa-power-off"></i> Logout</a></li>
	    <?php else: ?>
	    <li><a href="<?= base_url('home/login')?>" class="login-menu"><i class="fas fa-sign-in-alt"></i> Login</a></li>
	    <li><a href="#">about</a></li>
	    <?php endif;  ?>
	</ul>
</div>