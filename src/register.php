<?php
include("includes/header.php");
?>

<div id="main-wrapper" class="container">
	<div class="row justify-content-center">
		<div class="col-xl-10">
			<div class="card border-0">
				<div class="card-body p-0">
					<div class="row no-gutters">
						<div class="col-lg-6">
							<div class="p-5">

								<div class="mb-5">
									<h3 class="h4 font-weight-bold text-theme">Top Trade</h3>
								</div>

								<h6 class="h5 mb-0">Become an Artisan</h6>
								<p class="text-muted mt-2 mb-3">Join the fastest growing of Artisans.</p>

								<form method="POST" action="register.php">

									<?php $user->display_info(); ?>
									<?php $user->display_errors(); ?>

									<label for="firstName">First Name:</label>
									<input type="text" id="firstName" name="firstName" placeholder="" />

									<label for="lastName">Last Name:</label>
									<input type="text" id="lasttName" name="lastName" placeholder="" />

									<label for="email">E-mail:</label>
									<input type="email" id="email" name="email" placeholder="email" />

									<label for="email">Phone:</label>
									<input type="text" id="phoneNumber" name="phoneNumber" placeholder="070* *** *****" />

									<label for="email">Address:</label>
									<input type="text" id="address" name="address" placeholder="" />

									<label for="password">Password:</label>
									<input type="password" id="password" name="password" placeholder="password" />

									<label for="confirm">Confirm Password:</label>
									<input type="password" id="confirm" name="confirm" placeholder="repeat password" />
									<input id="button-register" type="submit" name="register" value="Register">

								</form>

							</div>
						</div>
						</section>
					</div>

					<?php
					include("includes/footer.php");
					?>