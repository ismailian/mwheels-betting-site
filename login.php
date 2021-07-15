<?php require_once('./App.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login - MTL Wheels</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/plugin.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
		<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/images/backback.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
				<form class="login100-form validate-form" method="POST" action="">
					<div class="login100-form-avatar">
						<img src="assets/images/logos.png" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						Welcome to MTL Wheels
					</span>

					<?php if (Sessioneer::message()) : ?>
						<?= Sessioneer::message(true); ?>
					<?php endif; ?>

					<div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
						<input class="input100" type="text" name="username" placeholder="Username or Email" autocomplete="off" value="admin">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password" autocomplete="off" value="admin">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button type="submit" name="login" class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center w-full p-t-25 p-b-230">
						<!-- <a href="#" class="txt1">
							Forgot Username / Password?
						</a> -->
					</div>
				</form>
			</div>
		</div>
	</div>




	<!--===============================================================================================-->
	<script src="assets/js/jquery.js"></script>
	<!--===============================================================================================-->
	<script src="assets/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="assets/js/maine.js"></script>

</body>

</html>