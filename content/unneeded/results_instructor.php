<?php
		
	if(sizeof($_POST) > 0){
		$instructorID 	= $_POST['instructorID'];
		$FirstName 		= $_POST['FirstName'];
		$LastName 		= $_POST['LastName'];
	} else {
		$instructorID 	= '';
		$FirstName 		= '';
		$LastName 		= '';	
	}
	
	//echo $_SESSION['affiliateID'];
	
	
	$search = $fmpConnection->newFindCommand('web_persons');
		$instructorID == '' ?: $search->addFindCriterion('ASANumber',	('==' . $instructorID));
		$FirstName == '' ?: $search->addFindCriterion('FirstName',	('==' . $FirstName));
		$LastName == '' ?: $search->addFindCriterion('LastName',	('==' . $LastName));
		$search->addFindCriterion('Instructor',	'==Yes');
		$search->addFindCriterion('AffiliatePersons_Instructors::id_Affiliate',	('==' . $_SESSION['affiliateID']));
		
	$searchResults = $search->execute();
	
	$records = array();
	
	if(FileMaker::isError($searchResults) && $searchResults->getCode() != '401') {
			
		echo "<p>Error: " . $searchResults->getMessage() . "</p>"; 
		echo $searchResults->getCode();
		die;
		
	} else if(!FileMaker::isError($searchResults)) {
		
		$records 	= $searchResults->getRecords();

	}

?>
<table class="jq_dataTableResults table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Instructor ID</th>
		</tr>
	</thead>
	
	<tbody>
	<?php foreach($records as $record){ ?>
		<tr>
			<td><a href="instructor.php?id=<?php echo $record->getField('ID') ?>"><?php echo ($record->getField('FirstName') . ' ' . $record->getField('LastName')) ?></td>
			<td><?php echo $record->getField('ASANumber') ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>