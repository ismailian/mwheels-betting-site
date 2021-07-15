<?php require_once('./App.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="forntEnd-Developer" content="Mamunur Rashid">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= (Type::info(2, ['name'])->name) ?> - MTL Wheels</title>
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

<body class="index2">
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

	<!-- Breadcrumb Area Start -->
	<section class="breadcrumb-area bc-contact">
		<img class="bc-img" src="assets/images/breadcrumb/bonus.png" alt="">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="title">
						<?= (Type::info(2, ['name'])->name) ?>
					</h4>
					<ul class="breadcrumb-list">
						<li>
							<a href="/">
								<i class="fas fa-home"></i>
								<i class="fas fa-chevron-right"></i>
								Back to home
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Area End -->

	<!-- Contact Area End -->
	<section class="contact">
		<div class="containers">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="section-heading">
						<h5 class="subtitle">
							Choose a wheel
						</h5>
						<h2 class="title">
							and try your luck
						</h2>
						<h5 class="subtitle">
							Prize<span style="-webkit-text-fill-color: #fff;">
								<?php echo (Type::info(2)->prize) ?>
							</span> each wheel
						</h5>
						<h5 class="subtitle">
							Cost<span style="-webkit-text-fill-color: #fff;">
								<?php echo (Type::info(2)->amount) ?>
							</span> each number
						</h5>
						<h5 class="subtitle">
							Odds<span style="-webkit-text-fill-color: #fff;"> 8:1 </span>
						</h5>
					</div>
				</div>
			</div>

			<?php include("includes/wheels.php"); ?>

		</div>
	</section>

	<!-- Contact Area End -->

	<!-- Footer Area Start -->

	<?php include 'includes/footer.php'; ?>

	<!-- Footer Area End -->

	<!-- Back to Top Start -->
	<div class="bottomtotop">
		<i class="fas fa-chevron-right"></i>
	</div>
	<!-- Back to Top End -->

	<!-- Modal -->

	<div id="myModal" class="modal fade" aria-modal="true" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-confirm">
			<div class="modal-content">
				<div class="modal-header justify-content-center">
					<div class="icon-box">
						<i class="fas fa-check"></i>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body text-center">
					<h4>Are you sure ?</h4>
					<p>Please confirm that you choose spot <span id="spot"></span></p>
					<button id="autofill" class="btn btn-primary" data-dismiss="modal"><span>Autofill</span><i class="fas fa-exchange-alt"></i></button>
					<button id="refund" class="btn btn-success" data-dismiss="modal"><span>Refund</span> <i class="fas fa-undo"></i></button>
					<button id="cancel" class="btn btn-danger" data-dismiss="modal"><span>Cancel</span> <i class="fas fa-check"></i></button>
					<p class="nb">NB : refund and autofilled will be given of wheel is not filled</p>
					<p class="nb">- if you select autofill you will randomly be placed on another wheel of wheel does not fill up</p>
				</div>
			</div>
		</div>
	</div>

	<script>
		localStorage.setItem("type", 2);
	</script>
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
	<script src="assets/js/wheelnav.min.js"></script>
	<script src="assets/js/raphael.min.js"></script>
	<script src="assets/js/script.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script>
	<script src="assets/js/highstakes.js"></script>


</body>

</html>