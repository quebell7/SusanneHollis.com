<?php
	
	require_once('includes/site_vars.php'); 			// site vars include	
	
	
	/*	session check...
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		//sessionLock();
	
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	//
	
	$foundUser = false;
	
	$client_username 			= (isset($_REQUEST['client_username']) 	? $_REQUEST['client_username'] : '' );
	
	$specialCharsArray = array(	'@' => '\@', 
								'?' => '\?', 
								'#' => '\#', 
								'!' => '\!' );
								
	$client_username = strtr($client_username, $specialCharsArray);

	$search = $fmpConnection->newFindCommand('web_users');	
		$search->addFindCriterion('Email',					'='.$client_username); 
	$searchResults 	= $search->execute();	
				
	if(!FileMaker::isError($searchResults)) {
		
		$foundUser 				= true;
		$results 				= $searchResults->getRecords();
		$found 					= $searchResults->getFoundSetCount();
		$fmpID					= $results[0]->getRecordID();
		$userPassword			= $results[0]->getField('password');
		$emailTo				= $results[0]->getField('Email');
		
		/* send confirmation email
		- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		
			$emailBody		= 'Your susannehollis.com password is:<br><br>';	
			$emailBody		.= $userPassword;
		
			$emailArray['subject'] 	= 'Your susannehollis.com password';
			$emailArray['body'] 	= $emailBody;
			$emailArray['to'] 		= $emailTo;
			
			$emailResult = sendEmail($emailArray);
			

	}
	
	include_once('template/template.php');

		
		
?>