<?php
 
	require_once('includes/site_vars.php'); 			// site vars include	
	
	echo $fmpConnection->getContainerData($_GET['url']);
 
?>
