<?php
	
	require_once('includes/site_vars.php'); 			// site vars include	
	
	
	/*	session check...
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		//sessionLock();
	
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	//
	
	
	$client_username 			= (isset($_REQUEST['client_username']) 	? $_REQUEST['client_username'] : '' );
	$client_password 			= (isset($_REQUEST['client_password']) 	? $_REQUEST['client_password'] : '' );
	
	$specialCharsArray = array(	'@' => '\@', 
								'?' => '\?', 
								'#' => '\#', 
								'!' => '\!' );
								
	$client_username = strtr($client_username, $specialCharsArray);
	$client_password = strtr($client_password, $specialCharsArray);
	
	
	if($client_password == '' || $client_username == ''){
		$loginError = 'You must enter in your email address and password to login.';
		$contentFile = 'login.php';
		include_once('template/template.php');
		exit;
	}


	$search = $fmpConnection->newFindCommand('web_users');	
		$search->addFindCriterion('Email',					'='.$client_username); 
		$search->addFindCriterion('password',				'='.$client_password);
		$search->addFindCriterion('registrationVerified',	'true');
	$searchResults 	= $search->execute();	
				
	if(!FileMaker::isError($searchResults)) {
		
		$results 				= $searchResults->getRecords();
		$found 					= $searchResults->getFoundSetCount();
		$fmpID					= $results[0]->getRecordID();
		$_SESSION['contactID']	= $results[0]->getField('ID_Contact');
		
		include_once('template/template.php');
		exit;

	}else{
		
		$loginError = 'We could not find an account with the login information you entered.';
		$contentFile = 'login.php';
		include_once('template/template.php');
		exit;

	}
	
	//print_r($contactID);

//	print_r($results);
	
	
		
		
		
?>