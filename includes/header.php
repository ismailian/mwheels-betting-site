<header class="header">
	<!--Main-Menu Area Start-->
	<div class="mainmenu-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<nav class="navbar navbar-expand-lg navbar-light">
						<a class="navbar-brand" href="index.php">
							<img src="assets/images/logos.png" alt="" width="140px">
						</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="main_menu" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse fixed-height" id="main_menu">
							<ul class="navbar-nav ml-auto">
								<li class="nav-item">
									<a class="nav-link">
										Balance : <span id="my_balance" style="color:#fff;"><?= (User::get(Sessioneer::user()->id, ['balance'])->balance); ?></span>
										<div class="mr-hover-effect"></div>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link">
										Credits : <span id="my_balance" style="color:#fff;"><?= (User::get(Sessioneer::user()->id, ['credit'])->credit); ?></span>
										<div class="mr-hover-effect"></div>
									</a>
								</li>
							</ul>
							<!-- <a href="#" class="mybtn1"> Log out</a> -->
							<?php if (Sessioneer::user_role() === "admin" || Sessioneer::user_role() === "agent") : ?>
								<a href="admin/" class="">
									<button class="mybtn1" type="submit" name="board">Dashboard</button>
								</a>
							<?php endif; ?>
							<a href="#" class="">
								<form action="" method="POST">
									<button class="mybtn1" type="submit" name="logout"> Log out</button>
								</form>
							</a>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!--Main-Menu Area Start-->
</header>