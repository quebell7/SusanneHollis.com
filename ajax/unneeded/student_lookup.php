<?php 
	
	require_once('../includes/site_vars.php');
	
	// Session Check
	//sessionLock();
	
	$studentID 		= $_POST['studentID'];
	
	$search = $fmpConnection->newFindCommand('web_persons');
		$search->addFindCriterion('ASANumber',	('==' . $studentID));	
	$searchResults = $search->execute();	
	
	$records = array();
	
	if(FileMaker::isError($searchResults) && $searchResults->getCode() != '401') {
			
		echo "<p>Error: " . $searchResults->getMessage() . "</p>"; 
		echo $searchResults->getCode();
		die;
	
	} else if(FileMaker::isError($searchResults) && $searchResults->getCode() == '401') {
		
		echo ('{"error": true, "message":"No students found."}');
		
	} else if(!FileMaker::isError($searchResults)) {
		
		$record 	= $searchResults->getRecords()[0];
		
		echo ('{"error": false, "studentID": "' . $record->getField('ID') . '", "ASANumber": "' . $record->getField('ASANumber') . '", "fullName": "' . $record->getField('FirstName') . ' ' . $record->getField('LastName') . '", "address": "' . $record->getField('Addresses_Persons::Address1') . ' ' . $record->getField('Addresses_Persons::City') . ', ' . $record->getField('Addresses_Persons::State') . '"}');

	}
	
?>