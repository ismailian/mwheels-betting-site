<?php require_once('./App.php'); ?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="forntEnd-Developer" content="Mamunur Rashid">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MTL Wheels - New Generation of Gambling</title>
	<!-- favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.html" type="image/x-icon">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Plugin css -->
	<link rel="stylesheet" href="assets/css/plugin.css">

	<!-- stylesheet -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
	<link rel="stylesheet" href="assets/css/wheels.css">
</head>

<body class="index2" style="height:100vh">
	<!-- preloader area start -->
	<div class="preloader" id="preloader">
		<div class="loader loader-1">
			<div class="loader-outter"></div>
			<div class="loader-inner"></div>
		</div>
	</div>
	<!-- preloader area end -->

	<!-- Header Area Start  -->

	<?php include 'includes/header.php'; ?>

	<!-- Header Area End  -->

	<!-- Hero Area Start -->
	<div class="hero-area">
		<section class="features">
			
			<!-- <img src="assets/images/spin.gif" class="spinnytl"> -->
			<!-- <img src="assets/images/spin.gif" class="spinnytr"> -->

			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8 col-md-10">
						<div class="section-heading">
							<!--<img src="assets/images/logos.png" width="200px">-->
							<br />
							<h5 class="subtitle">

								Welcome back <span style="color: #fff !important;"><?= (Sessioneer::user()->username) ?></span>
								<br /><span style="-webkit-text-fill-color: #fff;"> <?= (Settings::info(['text'])->text) ?> </span>

							</h5>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="feature-box">
							<div class="feature-box-inner">
								<div class="row justify-content-center">

									<!-- Daily Numbers include -->
									<?php include "includes/dailywin.php"; ?>

									<!-- Playground include -->
									<?php include "includes/types.php"; ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- Hero Area End -->

	<!-- Footer Area Start -->

	<?php include 'includes/footer.php'; ?>

	<!-- Footer Area End -->

	<!-- Back to Top Start -->
	<div class="bottomtotop">
		<i class="fas fa-chevron-right"></i>
	</div>
	<!-- Back to Top End -->

	<!-- jquery -->
	<script src="assets/js/jquery.js"></script>
	<!-- popper -->
	<script src="assets/js/popper.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- plugin js-->
	<script src="assets/js/plugin.js"></script>

	<!-- MpusemoverParallax JS-->
	<script src="assets/js/TweenMax.js"></script>
	<script src="assets/js/mousemoveparallax.js"></script>
	<!-- main -->
	<script src="assets/js/main.js"></script>
</body>

</html>