<?php
	
	require_once('../includes/site_vars.php');
	
	//sessionLock();
	
	$FirstName 		= $_GET['FirstName'];
	$LastName 		= $_GET['LastName'];
	$City 			= $_GET['City'];
	
	$search = $fmpConnection->newFindCommand('web_persons');
		$search->addFindCriterion('FirstName',					('==' . $FirstName));
		$search->addFindCriterion('LastName',					('==' . $LastName));
		$search->addFindCriterion('Addresses_Persons::City',	('==' . $City));
	$searchResults = $search->execute();	
	
	$records = array();
	
	if(FileMaker::isError($searchResults) && $searchResults->getCode() != '401') {
			
		echo "<p>Error: " . $searchResults->getMessage() . "</p>"; 
		echo $searchResults->getCode();
		die;
	
	} else if(FileMaker::isError($searchResults) && $searchResults->getCode() == '401') {
		
		//echo ('{"studentID": "", "ASANumber": "", "fullName": "", "address": ""}');
		echo ('{"error": true, "message":"No students found."}');

	} else if(!FileMaker::isError($searchResults)) {
		
		$found = $searchResults->getFoundSetCount();
		
		if($found > 1){
			echo ('{"error": true, "message":"Multiple students found with this criteria. \r\nPlease call the ASA office to find the correct Student ID."}');
		}else{
			
			$record 	= $searchResults->getRecords()[0];
		
			echo ('{"error": false, "studentID": "' . $record->getField('ID') . '", "ASANumber": "' . $record->getField('ASANumber') . '", "fullName": "' . $record->getField('FirstName') . ' ' . $record->getField('LastName') . '", "address": "' . $record->getField('Addresses_Persons::Address1') . ' ' . $record->getField('Addresses_Persons::City') . ', ' . $record->getField('Addresses_Persons::State') . '"}');
			
		}
		
		
		

	}
	
?>