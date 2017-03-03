<?php
	
	require_once('includes/site_vars.php'); 			// site vars include	
	
	
	/*	session check...
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		//sessionLock();
	
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	
	
	$firstName 			= (isset($_REQUEST['firstName']) 	? $_REQUEST['firstName'] : '' );
	$lastName 			= (isset($_REQUEST['lastName']) 	? $_REQUEST['lastName'] : '' );
	$password 			= (isset($_REQUEST['password']) 	? $_REQUEST['password'] : '' );
	$company 			= (isset($_REQUEST['company']) 		? $_REQUEST['company'] : '' );
	$email 				= (isset($_REQUEST['email']) 		? $_REQUEST['email'] : '' );
	$phone 				= (isset($_REQUEST['phone']) 		? $_REQUEST['phone'] : '' );
	$address 			= (isset($_REQUEST['address']) 		? $_REQUEST['address'] : '' );
	$city 				= (isset($_REQUEST['city']) 		? $_REQUEST['city'] : '' );
	$state 				= (isset($_REQUEST['state']) 		? $_REQUEST['state'] : '' );
	$zip 				= (isset($_REQUEST['zip']) 			? $_REQUEST['zip'] : '' );


	$uuid				= generate_uuid();

	$add = $fmpConnection->newAddCommand('web_users');	
		$add->setField('Name_First',			$firstName); 
		$add->setField('Name_Last',				$lastName); 
		$add->setField('Account_Name',			$company); 
		$add->setField('Email',					$email); 
		$add->setField('Primary_Street1',		$phone); 
		$add->setField('Primary_City',			$address); 
		$add->setField('Primary_State_Prov1',	$city); 
		$add->setField('Cell_Phone1',			$state); 
		$add->setField('Primary_Postal_Code1',	$zip);
		$add->setField('uuid',					$uuid);
		$add->setField('password',				$password);
	$addResults 	= $add->execute();	
		
	
		
	if(!FileMaker::isError($addResults)) {
		
		$results 		= $addResults->getRecords();

		/* send confirmation email
		- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		
			$emailBody		= 'Confirm your Registration with susannehollis.com.<br><br>';	
			$emailBody		.= 'Click on this <a href="' . $siteURL . 'register3.php?q=' . $uuid . '">link</a> to complete your registration.';
		
			$emailArray['subject'] 	= 'Confirm your Registration with susannehollis.com';
			$emailArray['body'] 	= $emailBody;
			$emailArray['to'] 		= $email;
			
			$emailResult = sendEmail($emailArray);
			
			include_once('template/template.php');


	}else{
		exit;
	}


	//print_r($results);
	
	
	
		
?>