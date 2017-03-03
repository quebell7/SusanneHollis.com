<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title><?php echo $pageTitle; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="css/bootstrap-slider.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--     <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet"> -->
    <!-- Custom styles for this template -->
    
    
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link href="css/isolutions.css" rel="stylesheet">

  </head>

  <body>

    <!-- Fixed navbar -->

	<?php
		include_once($path . '/../template/navigation.php');
	?>    
    
    <div class="container">

		
	<?php
		include_once($path . '/../content/' . $contentFile);
	?>  
  
	

    </div> <!-- /container -->

	<?php
		include_once($path . '/../template/footer.php');
	?>   
  
  
  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    
    <script src="js/bootstrap.min.js"></script>
    
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/validator.min.js"></script>
    
    
<!--     <script src="js/docs.min.js"></script> -->
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--     <script src="js/ie10-viewport-bug-workaround.js"></script> -->
    
    <!-- jQuery Mobile JS -->
<!--     <script src="js/jquery.mobile.custom.min.js"></script> -->
    <script src="js/jquery.validate.js"></script>

    <script src="js/isolutions.js"></script>
    
  </body>
</html>
