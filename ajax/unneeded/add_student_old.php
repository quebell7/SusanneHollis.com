<?php 
	
	require_once('../includes/site_vars.php');
	
	// Session Check
	//sessionLock();
	
	$FirstName 	= (isset($_POST['FirstName']) 			? $_POST['FirstName'] 		: '');
	$LastName 	= (isset($_POST['LastName']) 			? $_POST['LastName'] 		: '');
	
	$personsData = array(	'FirstName'						=> $FirstName,
							'LastName'						=> $LastName,
							'Email'							=> (isset($_POST['email']) 				? $_POST['email'] 			: ''),
							'Phone'							=> (isset($_POST['phoneNumber']) 		? $_POST['phoneNumber'] 	: ''),
							'Gender'						=> (isset($_POST['gender']) 			? $_POST['gender'] 			: ''),
							'JoinDate'						=> (isset($_POST['joinDate']) 			? $_POST['joinDate'] 		: '')
						);
						
						
	$addressData = array(	'Address1'						=> (isset($_POST['streetAddress']) 		? $_POST['streetAddress'] 	: ''),
							'City'							=> (isset($_POST['city']) 				? $_POST['city'] 			: ''),
							'State'							=> (isset($_POST['state']) 				? $_POST['state'] 			: ''),
							'PostalCode'					=> (isset($_POST['postalCode']) 		? $_POST['postalCode'] 		: ''),
							'Country'						=> (isset($_POST['country']) 			? $_POST['country'] 		: '')
						);
					
	
	$newAdd   = $fmpConnection->newAddCommand('web_persons', $personsData);
		$result = $newAdd->execute();
			
	if(!FileMaker::isError($result)){
		
		$record 			= $result->getRecords()[0];
		$personID			= $record->getField('ID');
		$asaID				= $record->getField('ASANumber');
		
		$addressData['id_Parent'] = $personID;
		
		$addressAdd   = $fmpConnection->newAddCommand('web_addressesPersons', $addressData);
			$addressAddResult = $addressAdd->execute();
		
		
		echo ('{"personID": "' . $personID . '", "asaID": "' . $asaID . '", "fullName": "' . $FirstName . ' ' . $LastName . '"}');
		
	}
	
?>