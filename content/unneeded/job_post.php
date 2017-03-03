<?php
	
	//$jobFMPID 					= isset($_GET['id']) ? $_GET['id'] : '';
	$jobID 						= isset($_GET['id']) ? $_GET['id'] : '';
	
	$facility					= '';
	$location					= '';
	$startDate					= '';
	$posted						= '';
	$ASALevel					= '';
	$contactName				= '';
	$contactPhone				= '';
	$contactEmail				= '';
	$note						= '';
	$submitType					= 'update';
	$submitDisplay				= 'Save Changes';
	
	
	if($jobID != ''){
	
	
						
		$search = $fmpConnection->newFindCommand('web_jobs');	
			$search->addFindCriterion('ID',	'=='.$jobID);
		$searchResults = $search->execute();
	
		if(!FileMaker::isError($searchResults)) {
		
			$record 					= $searchResults->getRecords()[0];
			
			$facility					= $record->getField('Facility');
			$location					= $record->getField('Location');
			$startDate					= $record->getField('StartDate');
			$posted						= $record->getField('Posted');
			$ASALevel					= $record->getField('ASALevel');
			$contactName				= $record->getField('ContactName');
			$contactPhone				= $record->getField('ContactPhone');
			$contactEmail				= $record->getField('ContactEmail');
			$note						= $record->getField('Note');
			
			$subheaderDisplay			= $facility;
			
		} else{
		
			echo 'Error: ' . $record->getCode() . ': ' . $record->getMessage() . '\n';
			exit;

		}
	
		
		
	
	
		//$record = $fmpConnection->getRecordById('web_jobs', $jobFMPID);
				

	} else {
		
		$subheaderDisplay	= 'New Entry';
		$submitType			= 'add';
		$submitDisplay		= 'Add Job';
		$posted				= $currentDate_USA;
		$contactName		= $_SESSION['contactName'];
		$contactPhone		= $_SESSION['contactPhone'];
		$contactEmail		= $_SESSION['contactEmail'];

		
		
		
	}
	
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<h2>Job Post <span class="subheader">- <?php echo $subheaderDisplay ?></span></h2>
	</div>
</div>

<hr />

<form action="submit_job_post.php" method="post">
	
	<input type="hidden" name="id" value="<?php echo $jobID ?>" />
	
	<div class="row">
		
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-info">
				
				<div class="panel-heading">
					<h3 class="panel-title">Job Details</h3>
				</div>
				
				<div class="panel-body">
					
					<div class="row">	
						<div class="col-sm-4">
							<div class="form-group">
								<label for="startDate" class="control-label">Start Date</label>
								<input type="text" id="startDate" class="form-control datepicker" name="startDate" value="<?php echo $startDate ?>" />
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<label for="posted" class="control-label">Posted</label>
								<input type="text" id="posted" class="form-control datepicker" name="posted" value="<?php echo $posted ?>" />
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<label for="ASALevel" class="control-label">Level</label>
								<input type="text" id="ASALevel" class="form-control" name="ASALevel" value="<?php echo $ASALevel ?>" />
							</div>
						</div>
					</div>
					
					
					<div class="row">	
						<div class="col-sm-7">
							<div class="form-group">
								<label for="facility" class="control-label">Facility</label>
								<input type="text" id="facility" class="form-control" name="facility" value="<?php echo $facility ?>" />
							</div>
						</div>
						
						<div class="col-sm-5">
							<div class="form-group">
								<label for="location" class="control-label">Location</label>
								<input type="text" id="location" class="form-control" name="location" value="<?php echo $location ?>" />
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<label for="contactName" class="control-label">Contact</label>
						<input type="text" id="contactName" class="form-control" name="contactName" value="<?php echo $contactName ?>" />
					</div>
					
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="contactPhone" class="control-label">Contact Phone #</label>
								<input type="text" id="contactPhone" class="form-control" name="contactPhone" value="<?php echo $contactPhone ?>" />
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="contactEmail" class="control-label">Contact Email</label>
								<input type="text" id="contactEmail" class="form-control" name="contactEmail" value="<?php echo $contactEmail ?>" />
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="note" class="control-label">Note</label>
						<textarea id="note" class="form-control" name="note"><?php echo $note ?></textarea>
					</div>
					

				</div>
			</div>
		</div>
	</div>
	
	<hr />

	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<button type="submit" class="btn btn-default btn-block" value="<?php echo $submitType ?>"><?php echo $submitDisplay ?></button>
		</div>
	</div>
</form>	