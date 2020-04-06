<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?php echo $description; ?>">

	<!-- Title -->
	<title><?php echo $title; ?></title>

	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="32x32"
		  href="<?php echo base_url(); ?>assets/img/favicon/favicon-32x32.png">
	<!--Bootstrap css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<!--Font Awesome css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
	<!--Magnific css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/magnific-popup.css">
	<!--Owl-Carousel css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.theme.default.min.css">
	<!--Animate css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.min.css">
	<!--Select2 css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.min.css">
	<!--Slicknav css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/slicknav.min.css">
	<!--Bootstrap-Datepicker css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css">
	<!--Jquery UI css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css">
	<!--Perfect-Scrollbar css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/perfect-scrollbar.min.css">
	<!--Site Main Style css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
	<!--Responsive css-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

	<script src="https://maps.googleapis.com/maps/api/js?key=#&libraries=places&language=el"></script>
</head>

<body>
	<div class="side-nav-screen-hold" style="display:none"></div>
	<div class="side-nav side-nav-container-closed" id="bs-example-navbar-collapse-1">
		<?php if ($this->session->userdata('user_id')) { ?>
			<div class="d-flex bottom-menu-btns">
				<a href="<?php echo site_url('users/dashboard'); ?>" class="post-jobs col-sm-6">Dashboard</a>
				<a href="<?php echo site_url('users/logout'); ?>" class="post-jobs col-sm-6"><i class="fa fa-sign-out"></i>&nbsp;Logout</a>
			</div>
		<?php } else if ($this->session->userdata('employer_id')) { ?>
			<div class="d-flex bottom-menu-btns">
				<a href="<?php echo site_url('employers/dashboard'); ?>" class="post-jobs col-sm-6">Dashboard</a>
				<a href="<?php echo site_url('employers/logout'); ?>" class="post-jobs col-sm-6"><i class="fa fa-sign-out"></i>&nbsp;Logout</a>
			</div>
		<?php } ?>
		<?php if (!$this->session->userdata('user_id') && !$this->session->userdata('employer_id')) { ?>
			<div class="d-flex bottom-menu-btns">
				<a href="<?php echo site_url('users/signup'); ?>" class="post-jobs col-sm-6"><i class="fa fa-user"></i>&nbsp; Sign up</a>
				<a href="<?php echo site_url('users/login'); ?>" class="post-jobs col-sm-6"><i class="fa fa-lock"></i>&nbsp; Login</a>
			</div>
		<?php } ?>

		<ul class="nav navbar-nav navbar-right">
			<li class="mobile-menu-links <?php if($title == "Weelancer") echo 'active'; ?>">
				<a href="<?php echo site_url(); ?>">Home</a>
			</li>

			<li class="mobile-menu-links <?php if($title == "Browse Jobs") echo 'active'; ?>">
				<a href="<?php echo site_url('jobs/jobslist'); ?>">Browse Jobs</a>
			</li>

			<li class="mobile-menu-links <?php if($title == "About Us") echo 'active'; ?>">
				<a href="<?php echo site_url('about'); ?>">About Us</a>
			</li>

			<li class="mobile-menu-links <?php if($title == "Contact Us") echo 'active'; ?>">
				<a href="<?php echo site_url('contact'); ?>">Contact Us</a>
			</li>
		</ul>
	</div>

	<!-- Header Area Start -->
	<header class="jobguru-header-area stick-top forsticky">
		<div class="menu-animation">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-2">
						<div class="site-logo">
							<a href="<?php echo site_url(); ?>">
								<img src="<?php echo base_url(); ?>assets/img/weelancer_logo_w.png" alt="Weelancer" class="non-stick-logo"/>
								<img src="<?php echo base_url(); ?>assets/img/weelancer_logo_b.png" alt="Weelancer" class="stick-logo"/>
							</a>
						</div>
						<!-- Responsive Menu Start -->
						<div class="jobguru-responsive-menu toggle-sidebar">
							<div class="slicknav_menu"><a href="#" aria-haspopup="true" role="button" tabindex="0"
														  class="slicknav_btn slicknav_collapsed"
														  style="outline: none;"><span
										class="slicknav_menutxt">MENU</span><span class="slicknav_icon"><span
											class="slicknav_icon-bar"></span><span
											class="slicknav_icon-bar"></span><span
											class="slicknav_icon-bar"></span></span></a>
							</div>
						</div>
						<!-- Responsive Menu Start -->
					</div>
					<div class="col-lg-6">
						<div class="header-menu">
							<nav id="navigation">
								<ul id="jobguru_navigation">
									<li <?php if($title == "Weelancer") echo 'class="current_page"'; ?>>
										<a href="<?php echo site_url(); ?>">home</a>
									</li>

									<li <?php if($title == "Browse Jobs") echo 'class="current_page"'; ?>>
										<a href="<?php echo site_url('jobs/jobslist'); ?>">browse jobs</a>
									</li>

									<li <?php if($title == "About Us") echo 'class="current_page"'; ?>>
										<a href="<?php echo site_url('about'); ?>">about us</a>
									</li>

									<li <?php if($title == "Contact Us") echo 'class="current_page"'; ?>>
										<a href="<?php echo site_url('contact'); ?>">contact us</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="header-right-menu">
							<ul>
								<?php if ($this->session->userdata('user_id')) { ?>
									<li><a href="<?php echo site_url('users/dashboard'); ?>" class="post-jobs">Dashboard</a></li>
								<?php } else if ($this->session->userdata('employer_id')) { ?>
									<li><a href="<?php echo site_url('employers/dashboard'); ?>" class="post-jobs">Dashboard</a></li>
								<?php } ?>

								<?php if (!$this->session->userdata('user_id') && !$this->session->userdata('employer_id')) { ?>
									<li><a href="<?php echo site_url('users/signup'); ?>"><i class="fa fa-user"></i>sign up</a></li>
									<li><a href="<?php echo site_url('users/login'); ?>"><i class="fa fa-lock"></i>login</a></li>
								<?php } else if ($this->session->userdata('user_id')) { ?>
									<li><a href="<?php echo site_url('users/logout'); ?>"><i class="fa fa-sign-out"></i>logout</a></li>
								<?php } else if ($this->session->userdata('employer_id')) { ?>
									<li><a href="<?php echo site_url('employers/logout'); ?>"><i class="fa fa-sign-out"></i>logout</a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Header Area End -->
