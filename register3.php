<?php
	
	require_once('includes/site_vars.php'); 			// site vars include	
	
	
	/*	session check...
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		//sessionLock();
	
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	//include_once('template/template.php');
	
	
	$uuid 			= (isset($_REQUEST['q']) 	? $_REQUEST['q'] : '' );

	$search = $fmpConnection->newFindCommand('web_users');	
		$search->addFindCriterion('uuid',			$uuid); 
	$searchResults 	= $search->execute();	
				
	if(!FileMaker::isError($searchResults)) {
		
		$results 				= $searchResults->getRecords();
		$found 					= $searchResults->getFoundSetCount();
		$fmpID					= $results[0]->getRecordID();
		$_SESSION['contactID']	= $results[0]->getField('ID_Contact');
		
		$edit   = $fmpConnection->newEditCommand('web_users', $fmpID);
			$edit->setField('registrationVerified',			'true');
		$edit->execute();
	
		if(!FileMaker::isError($edit)) {
			
			/* send confirmation email
			- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
			
				$emailBody		= 'A new registration has been confirmed for susannehollis.com.';	
			
				$emailArray['subject'] 	= 'susannehollis.com Registration confirmed.';
				$emailArray['body'] 	= $emailBody;
				$emailArray['to'] 		= 'mh@susannehollis.com';
				
				$emailResult = sendEmail($emailArray);

			
			
			include_once('template/template.php');
			exit;
					
		}else{
			exit;
		}
		
	
		
		
	}else{
		exit;
	}

		
		
		
?>