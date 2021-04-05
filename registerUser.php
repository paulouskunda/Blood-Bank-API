<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

require_once 'includes/conn.php';
	require_once 'functions.php';
 
	if (isset($_POST['submit'])) {
		# code...
		$name = mysqli_real_escape_string($db_link, $_POST['name']);
		$email = mysqli_real_escape_string($db_link, $_POST['email']);
		$phone_number = mysqli_real_escape_string($db_link, $_POST['phone_number']);
		$physical_address = mysqli_real_escape_string($db_link, $_POST['physical_address']);
		$password = mysqli_real_escape_string($db_link, $_POST['password']);
		$type_of_user = mysqli_real_escape_string($db_link, $_POST['type_of_user']);
		$blood_group = mysqli_real_escape_string($db_link, $_POST['blood_group']);
		$city = mysqli_real_escape_string($db_link, $_POST['city']);
		$province = mysqli_real_escape_string($db_link, $_POST['province']);
		

		$donor_array = array('name' => $name,
							 'email' => $email, 
							 'phone_number' => $phone_number,
							 'physical_address' => $physical_address,
							 'password' => $password,
							 'type_of_user' => $type_of_user,
							 'blood_group' => $blood_group,
							 'city' => $city,
							 'province' => $province,
							);
		$acc =  addNewUser($db_link, $donor_array);
		echo $acc;
		if ($acc === 'already_created') {
			# code...
			echo "<script> swal ( 'warning',
                'user Alread Exisits',
                'warning'
              )
              </script>";
			echo "Created - Here";

		}else if ($acc === 'true') {
			# code...
			 echo "<script> swal ( 'Success',
                'user Successfully Added',
                'success'
              )
              </script>";
		}

	}
?>


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
									<a href="index.php" class="btn">BACK TO HOME</a>
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
							<h1>REGISTER <span>HERE!</span></h1>
							</div>
							<p>NEW DONOR WELCOME </p>
							<form class="form" method="post" action="registerUser.php">
									<div class="row">
										<div class="col-lg-6">
									
                                       <div class="container">
                                        <h1></h1>
                                           <p>Please fill in this form to create an account.</p>
                                                <hr>
                    <label for="Name"><b>Name</b></label>
                            <input type="text" placeholder="Enter name" name="name" id="name" required>
                                   <label for="email"><b>Email</b></label>
                                            <input type="text" placeholder="Enter Email" name="email" id="email" required>

                                    <label for="phone"><b>Phone number</b></label>
                                                <input type="phone_number" placeholder="Enter phone" name="phone_number" id="phone" required>

                         <label for="physical_address"><b>Physical address</b></label>
                                      <input type="text" placeholder="Enter physical_address" name="physical_address" id="physical_address" required>

     <label for="psw-repeat"><b>Password</b></label>
            <input type="password" placeholder="Password" name="password" id="psw" required>

                             <label for="type_of_user"><b>type_of_user</b></label>
                                     <input type="text" placeholder="type_of_user" name="type_of_user" id="type_of_user" required>
               <label for="blood_group"><b>blood group</b></label>
                               <input type="text" placeholder="blood_group" name="blood_group" id="blood_group" required>
                                    <label for="city"><b>city</b></label>
                                          <input type="text" placeholder="city" name="city" id="city" required>
                                <label for="province"><b>province</b></label>
                                       <input type="text" placeholder="province" name="province" id="province" required>
                                                                           <hr>

                                               <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
    
  </div>
                                                                     <div class="col-12">
												<div class="form-group button">	
													<button type="submit" class="btn primary" name="submit" ><i class="fa fa-send"></i>Submit</button>
												</div>
											</div>
  <div class="container signin">
    <p>Already have an account? <a href="404.html">click here</a>.</p>
  </div>
</form>
										</div>
									</div>
								</form>
								<!--/ End Form -->
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