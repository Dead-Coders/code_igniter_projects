<?php $this->load->view('public/partials/view_public_header.php'); ?>
<div class="banner">
	<div class="container">
		<script src="<?= base_url('assets/js/responsiveslides.min.js'); ?>"></script>
		<script>
		$(function () {
		$("#slider").responsiveSlides({
			auto: true,
			nav: true,
			speed: 500,
		namespace: "callbacks",
		pager: true,
		});
		});
		</script>
		<div  id="top" class="callbacks_container">
			<ul class="rslides" id="slider">
				<li>
					
					<div class="banner-text">
						<h3>Find your vehicles today!   </h3>
						<p>VSMS offers a 7-day, 250-mile Buy Back Guarantee. Contact us today to learn more about it!</p>
						
					</div>
					
				</li>
				<li>
					
					<div class="banner-text">
						<h3>No Haggle Pricing  </h3>
						<p>No need to brush up on your bargaining skill! We believe in offering a low price instead of making you negotiate for it. After all, everyone deserves the same great no-haggle pricing. Each low price is yours for the taking.</p>
						
					</div>
					
				</li>
				<li>
					<div class="banner-text">
						<h3>Home Services Bring the Cars to You</h3>
						<p>For your convenience, our dealers have expanded the ways you can shop for a new or used car from the comfort of home</p>
						
					</div>
					
				</li>
			</ul>
		</div>
	</div>
</div>
<!--content-->
<div class="container">
	<div class="cont">
		<div class="content">
			<div class="content-top-bottom">
				<h2>Featured Vehicles</h2>
				<?php foreach($featured as $feature) : ?>
					<div class="col-md-4 men">
						<a href="<?php echo base_url('pages/show') . '/' . $feature['vehicle_id']; ?> " class="b-link-stripe b-animate-go  thickbox">
							<img style="height: 260px;" class="img-responsive" src="<?= base_url('uploads'); ?>/<?php echo $feature['image']; ?>" alt="">
							<div class="b-wrapper">
								<h3 class="b-animate b-from-top top-in   b-delay03 ">
								<span><?php echo $feature['model_name']; ?></span>
								</h3>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
				<div class="clearfix"> </div>
			</div>
			<div class="content-top">
				<h1>Top 4 New Vehicles</h1>
				
				<div class="grid-in">
					{vehicles}
						<div class="col-md-3 grid-top simpleCart_shelfItem">
							<a href="<?= base_url(); ?>pages/show/{vehicle_id}" class="b-link-stripe b-animate-go  thickbox">
							<img class="img-responsive" src="<?= base_url('uploads/'); ?>/{image}" alt="">
								<div class="b-wrapper">
									<h3 class="b-animate b-from-left    b-delay03 ">
									<span>{model_name}</span>
									
									</h3>
								</div>
							</a>
							
							<p><a href="<?= base_url(); ?>pages/show/{vehicle_id}">{model_name}</a></p>
						</div>
					{/vehicles}
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
		
	</div>
	
</div>
<?php $this->load->view('public/partials/view_public_footer.php'); ?>