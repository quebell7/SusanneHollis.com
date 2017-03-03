<?php 
	
	require_once('../includes/site_vars.php');
	
	// Session Check
	//sessionLock();
	
	
	$tempID		= (isset($_POST['id']) ? $_POST['id'] : '');
	$formData 	= (isset($_POST['formData']) ? urldecode($_POST['formData']) : array());
	
	if(!isset($_SESSION['addStudentData'])){
		$_SESSION['addStudentData'] = array();
	}
	
	$_SESSION['addStudentData'][$tempID] = $formData;
		
?>