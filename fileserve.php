<?php

	require_once('includes/site_vars.php');
	
	require_once('includes/pdf_file_array.php');
	
	// Session Check
	sessionLock();
	
	$fileSelect 	= (isset($_POST['fileSelect']) 	? (int)$_POST['fileSelect'] 	: '');
	$submit 		= (isset($_POST['submit']) 		? $_POST['submit'] 	: '');
	
	if($submit == 'download'){
		
		$file = 'pdf_files/' . $downloadFilesArray[$fileSelect];
		
		if (file_exists($file)) {
			
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    
		    exit;
		    
		}
	}

?>