<?php
	
	require_once('includes/site_vars.php'); 		
	
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title><?php echo $pageTitle . ': Affiliate Login'; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style="background-color: #ffffff;">

    <div class="container">

		<div class="row">
		
			<div class="col-xs-12 text-center">
	
				<img src="images/ASA-Blue-Transparent-300.png" alt="logo1" class="img-responsive" width="" height="" style="margin-left: auto; margin-right: auto;" />
	
				<form class="form-signin" action="login_check.php" method="post">
					<h3 class="form-signin-heading">Affiliate Login</h3>
					
					<?php if(isset($message)) { ?>
					<div class="panel panel-danger"> 
						<div class="panel-heading"> 
							<h3 class="panel-title"><?php echo (isset($messageTite) ? $messageTite : 'Login Issue') ; ?></h3> 
						</div> 
						<div class="panel-body"> <?php echo $message; ?> </div> 
					</div>
					<?php } ?>
					<div class="form-group">
						<label for="inputEmail" class="sr-only">Username</label>
						<input type="text" id="inputEmail" name="client_username" class="form-control" placeholder="Username" required autofocus>
					</div>
					
					<div class="form-group">
						<label for="inputPassword" class="sr-only">Password</label>
						<input type="password" id="inputPassword" name="client_password" class="form-control" placeholder="Password" required>
					</div>
					
					<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
					
					
				</form>
				
				<p>
				  If you are an ASA Affiliate please click login above to access affiliate portal.
			  </p>
	 		</div> 
 		</div>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
