

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
                                <h6 class="h5 mb-0">Welcome!</h6>
                                <p class="text-muted mt-2 mb-3">Enter your email address and password to login.</p>
								<form id="login" method="POST" action="index.php">

                                    <input type="hidden" name="section" value="auth"/>
                                    <input type="hidden" name="action" value="login"/>

									<label for="username">Username:</label>
									<input type="text" id="username" name="username" placeholder="user" />
									<label for="password">Password:</label>
									<input type="password" id="password" name="password" placeholder="password" />
									<input id="button-login" type="submit" name="login" value="Log in">
								</form>
								
							</div>
						</div>
		</section>
</div>


<?php 
include("includes/footer.php");
?>
