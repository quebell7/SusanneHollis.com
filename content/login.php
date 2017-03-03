<div class="page-header">
  <h1>Login to view our prices <small></small></h1>
</div>

<div class="row">

	<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 text-center">

	<?php
		if(isset($loginError) && $loginError != ''){
	?>
		<br><br>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<?php echo $loginError;?>
		</div>

	<?php
		}
	?>
		<form class="form-signin" action="login_check.php" method="post">
			<h3 class="form-signin-heading">Login</h3>
			
			<div class="form-group">
				<label for="inputEmail" class="sr-only">Email</label>
				<input type="text" id="inputEmail" name="client_username" class="form-control" placeholder="Email Address" required="" autofocus="">
			</div>
			
			<div class="form-group">
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" name="client_password" class="form-control" placeholder="Password" required="">
			</div>
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		</form>
		
		<br/><br/>
		
		<h4>If you would like to register click <a href="register.php">here</a>.</h4>

		<h4><a href="forgot_password.php">Forgot your password?</a></h4>

		
		</div> 
	</div>
