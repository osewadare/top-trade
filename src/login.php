

<h6 class="h5 mb-0">Welcome!</h6>
<p class="text-muted mt-2 mb-3">Enter your email address and password to login.</p>
<form id="login" method="POST" action="login.php">
<?php $user->display_errors(); ?>
<label for="username">Username:</label>
<input type="text" id="username" name="username" placeholder="user" />
<label for="password">Password:</label>
<input type="password" id="password" name="password" placeholder="password" />
<input id="button-login" type="submit" name="login" value="Log in">
</form>

                            