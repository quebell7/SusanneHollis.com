
<?php 
	if($foundUser){
?>

	<div class="page-header">
	  <h1>We found you!</h1>
	</div>     
	      
	
		<div class="col-xs-12">
			<p>Check your email for your password.</p>
			
	 	</div>
	
	 	<div class="col-xs-12">
			<h4><a href="login.php">Login Now</a></h4>
	 	</div>


	
	<div class="row">
		<hr>
	</div>
	
<?php		
	}
?>

<?php 
	if(!$foundUser){
?>

	<div class="page-header">
	  <h1>We couldn't find you.</h1>
	</div>     
	      
	
		<div class="col-xs-12">
			<p>The email address you entered was not in our system.</p>
	 	</div>
	<div class="col-xs-12">
			<h4>If you would like to register click <a href="register.php">here</a>.</h4>

	 	</div>

	</div>
	
	<div class="row">
		<hr>
	</div>
				

<?php		
	}
?>