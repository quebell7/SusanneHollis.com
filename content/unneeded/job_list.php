<?php
	
	
	
	$search = $fmpConnection->newFindCommand('web_jobs');
		$search->addFindCriterion('id_Affiliate',	'==' . $_SESSION['affiliateID']);
	$searchResults = $search->execute();	
	
	$records = array();
		
	//pretty_r($_SESSION['affiliateID']);
	
	

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
			<th></th>
			<th>Facility</th>
			<th>Location</th>
			<th>Contact</th>
		</tr>
	</thead>
	
	<tbody>
	<?php foreach($records as $record){ ?>
		<tr>
			<td><a href="job_post.php?id=<?php echo $record->getField('ID') ?>">View</a></td>
			<td><?php echo $record->getField('Facility') ?></a></td>
			<td><?php echo $record->getField('Location') ?></td>
			<td><?php echo $record->getField('ContactName') ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>