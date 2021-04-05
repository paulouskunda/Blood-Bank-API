
<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
require_once 'includes/conn.php';
	require_once 'functions.php';

  if(isset($_POST['submit'])){
$hosp_name = mysqli_real_escape_string($db_link, $_POST['hosp_name']);
$hosp_city = mysqli_real_escape_string($db_link, $_POST['hosp_city']);
$hosp_location = mysqli_real_escape_string($db_link, $_POST['hosp_location']);
$hosp_address = mysqli_real_escape_string($db_link,$_POST['hosp_address']);
$hosp_lat = mysqli_real_escape_string($db_link,$_POST['hosp_lat']);
$hosp_long= mysqli_real_escape_string($db_link,$_POST['hosp_long']);

$hosp_data = addHospital($db_link, $hosp_name, $hosp_city, $hosp_location, $hosp_address, $hosp_lat, $hosp_long);
echo $hosp_data;

		if ($hosp_data === 'hospital_name_exits') {
			echo "<script> swal ( 'Warning',
                'hospital Already in the System',
                'warning'
              )
              </script>";
		}else if ($hosp_data === 'true') {
			echo "<script> swal ( 'Success',
                'Hospital Successfully registered in the system',
                'success'
              )
              </script>";
		}
	}
?>



S



<!doctype html>


<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Title -->
        <title>BDMS - REGISTER TO SAVE A LIFE .</title>
		
		<!-- Favicon -->
        <link rel="icon" href="img/logo2.png">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="css/nice-select.css">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="css/icofont.css">
		<!-- Slicknav -->
		<link rel="stylesheet" href="css/slicknav.min.css">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="css/owl-carousel.css">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="css/datepicker.css">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.min.css">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="css/magnific-popup.css">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">
		
    </head>
    <body>
	
		<!-- Preloader -->
        <div class="preloader">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>

                <div class="indicator"> 
                    <svg width="16px" height="12px">
                        <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                        <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <!-- End Preloader -->
		
		<!-- Get Pro Button -->
	
	
		<!-- Header Area -->
		<header class="header" >
			<!-- Topbar -->
			<div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-5 col-12">
							<!-- Contact -->
							
							<!-- End Contact -->
						</div>
						<div class="col-lg-6 col-md-7 col-12">
							<!-- Top Contact -->
							<ul class="top-contact">
								
							<!-- End Top Contact -->
						</div>
					</div>
				</div>
			</div>
			<!-- End Topbar -->
			<!-- Header Inner -->
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Start Logo -->
								<div class="logo">
									<a href="index.html"><img src="img/logo2.png" alt="#"></a>
								</div>
								<!-- End Logo -->
								<!-- Mobile Nav -->
								<div class="mobile-nav"></div>
								<!-- End Mobile Nav -->
							</div>
							<div class="col-lg-7 col-md-9 col-12">
								<!-- Main Menu -->
								<div class="main-menu">
									<nav class="navigation">
										<ul class="nav menu">
											
												
										
											
								</div>
								<!--/ End Main Menu -->
							</div>
							<div class="col-lg-2 col-12">
								<div class="get-quote">
									<a href="home.php" class="btn">BACK TO HOME</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Header Inner -->
		</header>
		<!-- End Header Area -->
		
		<!-- Error Page -->
		<section class="error-page section">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 offset-lg-3 col-12">
						<!-- Error Inner -->
						
						<div class="error-inner">
							<div class="text">
							<h1>ADD <span>HOSPITAL!</span></h1>
							</div>
							<p>NEW DONOR WELCOME </p>
						
						</div>
						<!--/ End Error Inner -->
					</div>
				</div>
			</div>
		
		<!-- End Breadcrumbs -->
				
		<!-- Start Contact Us -->
	<section class="error-page section">
			<div class="container">
				
					<div class="col-lg-6 offset-lg-3 col-12">
						<!-- Error Inner -->
						<div class="col-12">
								<div class="comments-form">
					
									<h2></h2>
									<!-- icipatala form -->
									<form class="form" method="post" action="addhospital.php">											
													<input type="text" name="hosp_name" placeholder="hospital name" required="required">
												</div>
												<div>												
													
													<input type="text" name="hosp_city" placeholder="hospital city" required="required">
												</div>
											<div>												
													
													<input type="text" name="hosp_location" placeholder="hospital location" required="required">
												</div>
												<div>												
												
													<input type="text" name="hosp_address" placeholder="hospital address" required="required">
												</div>
												<div>												
											
													<input type="text" name="hosp_lat" placeholder="hosp_lat" required="required">
												</div>
												<div>												
													
													<input type="text" name="hosp_long" placeholder="hosp_long" required="required">
												</div>
												
											<div class="col-12">
												<div class="form-group button">	
													<button type="submit" name="submit"class="btn primary"><i class="fa fa-send"></i>add</button>
												</div>
											</div>
										</div>
									</form>
									<!--/ End Contact Form -->
								</div>
							</div>
						</div>
					</div>
						<!--/ End Error Inner -->
					</div>
				</div>
			</div>
		</section>	
		<!--/ End Error Page -->
		
		<!-- Footer Area -->
		<footer id="footer" class="footer ">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								
								
								<!-- End Social -->
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer f-link">
								
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Footer Top -->
			<!-- Copyright -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-12">
							<div class="copyright-content">
								<p>© Copyright 2021  |  All Rights Reserved by <a href="" target="_blank">UI KINGS</a> </p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>
		<!--/ End Footer Area -->
		
		<!-- jquery Min JS -->
        <script src="js/jquery.min.js"></script>
		<!-- jquery Migrate JS -->
		<script src="js/jquery-migrate-3.0.0.js"></script>
		<!-- jquery Ui JS -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- Easing JS -->
        <script src="js/easing.js"></script>
		<!-- Color JS -->
		<script src="js/colors.js"></script>
		<!-- Popper JS -->
		<script src="js/popper.min.js"></script>
		<!-- Bootstrap Datepicker JS -->
		<script src="js/bootstrap-datepicker.js"></script>
		<!-- Jquery Nav JS -->
        <script src="js/jquery.nav.js"></script>
		<!-- Slicknav JS -->
		<script src="js/slicknav.min.js"></script>
		<!-- ScrollUp JS -->
        <script src="js/jquery.scrollUp.min.js"></script>
		<!-- Niceselect JS -->
		<script src="js/niceselect.js"></script>
		<!-- Tilt Jquery JS -->
		<script src="js/tilt.jquery.min.js"></script>
		<!-- Owl Carousel JS -->
        <script src="js/owl-carousel.js"></script>
		<!-- counterup JS -->
		<script src="js/jquery.counterup.min.js"></script>
		<!-- Steller JS -->
		<script src="js/steller.js"></script>
		<!-- Wow JS -->
		<script src="js/wow.min.js"></script>
		<!-- Magnific Popup JS -->
		<script src="js/jquery.magnific-popup.min.js"></script>
		<!-- Counter Up CDN JS -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Main JS -->
		<script src="js/main.js"></script>
    </body>
</html>