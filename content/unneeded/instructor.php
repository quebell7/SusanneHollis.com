<?php
	
	$personID 		= (isset($_REQUEST['id']) ? $_REQUEST['id'] : '');
	
	$FirstName					= '';
	$LastName					= '';
	$streetAddress				= '';
	$city						= '';
	$state						= '';
	$postalCode					= '';
	$country					= '';
	$email						= '';
	$phoneNumber				= '';
	$gender						= '';
	$asaID						= '';
	$joinDate					= '';
	$submitType					= 'update';
	$submitDisplay				= 'Save Changes';
	$coursesTakenArray			= array();

	if($personID != ''){

		//$record = $fmpConnection->getRecordById('web_persons', $personFMPID);
	
				
		$search = $fmpConnection->newFindCommand('web_persons');	
			$search->addFindCriterion('ID',	'=='.$personID);
		$searchResults = $search->execute();
			
		//pretty_r($searchResults);
			






		if(FileMaker::isError($searchResults)) {
	
			echo 'Error: ' . $searchResults->getCode() . ': ' . $searchResults->getMessage() . '\n';
			exit;
	
		} else {
			
			$record 					= $searchResults->getRecords()[0];

			
			$personID					= $record->getField('ID');
			$FirstName					= $record->getField('FirstName');
			$LastName					= $record->getField('LastName');
			$email						= $record->getField('Email');
			$phoneNumber				= $record->getField('Phone');
			$gender						= $record->getField('Gender');
			$asaID						= $record->getField('ASANumber');
			$joinDate					= $record->getField('JoinDate');
			$expirationDate				= $record->getField('ExpirationDate');
			$personID					= $record->getField('ID');

			$streetAddress				= $record->getField('Addresses_Persons::Address1');
			$city						= $record->getField('Addresses_Persons::City');
			$state						= $record->getField('Addresses_Persons::State');
			$postalCode					= $record->getField('Addresses_Persons::PostalCode');
			$country					= $record->getField('Addresses_Persons::Country');

			$addressObject				= $record->getRelatedSet('Addresses_Persons');
			
			//newRelatedRecord('Addresses_Persons');

			if(FileMaker::isError($addressObject)){
				
				$addressAdd   = $fmpConnection->newAddCommand('web_addressesPersons');
					$addressAdd->setField('id_Parent', $personID);
				$addressAddResult = $addressAdd->execute();
											
			}

		}
		
		$FullName = ($FirstName . ' ' . $LastName);
		
		
		$coursesObject		= $record->getRelatedSet('PersonCertifications_Persons');
		if(!FileMaker::isError($coursesObject)){

			foreach($coursesObject as $relatedRec){
				
				
				
				$courseData['CourseNumber']		= $relatedRec->getField('Certifications_Persons::CourseNumber');
				$courseData['CourseName']		= $relatedRec->getField('Certifications_Persons::CourseName');
				$courseData['KnowledgeScore']	= $relatedRec->getField('PersonCertifications_Persons::KnowledgeScore');
				$courseData['SkillsScore']		= $relatedRec->getField('PersonCertifications_Persons::SkillsScore');
				$courseData['CompletionDate']	= $relatedRec->getField('PersonCertifications_Persons::CompletionDate');
				$courseData['BoatSize']			= $relatedRec->getField('PersonCertifications_Persons::BoatSize');
				$courseData['InstructorName']	= $relatedRec->getField('PersonCertifications_Persons::InstructorName');
				
				
				array_push($coursesTakenArray, $courseData);
				
				
				
			}
						
		}

	} /*
else {
		
		$FullName 			= 'New Entry';
		$submitType			= 'add';
		$submitDisplay		= 'Add Instructor';
		
	}
	
*/
	$vl_countries 		= $fmpConnection->getLayout('web_persons')->getValueListTwoFields('Countries');
	$vl_gender 			= $fmpConnection->getLayout('web_persons')->getValueListTwoFields('Gender');
	
?>

<div class="row">
	<div class="col-md-12">
		<h2>Instructor <span class="subheader">- <?php echo $FullName ?></span></h2>
	</div>
</div>

<hr />

<form action="submit_instructor.php" method="post">
	
	<input type="hidden" name="id" value="<?php echo $personFMPID ?>" />
	<input type="hidden" name="addressFMPID" value="<?php echo $addressFMPID ?>" />
	
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Contact Information</h3>
				</div>
				<div class="panel-body">
					
					
					<div class="row">	
						<div class="col-sm-12">
							<div class="form-group">
								<label for="asaID">Instructor ID</label><br/>
								<?php echo $asaID ?>
							</div>
						</div>

					</div>
					
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label for="FirstName">First Name</label>
								<input type="text" id="FirstName" class="form-control" name="FirstName" value="<?php echo $FirstName ?>" disabled />
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="LastName">Last Name</label>
								<input type="text" id="LastName" class="form-control" name="LastName" value="<?php echo $LastName ?>" disabled />
							</div>
						</div>
					</div>
				
				
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label for="phoneNumber">Phone #</label>
								<input type="text" id="phoneNumber" class="form-control" name="phoneNumber" value="<?php echo $phoneNumber ?>" disabled />
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="text" id="email" class="form-control" name="email" value="<?php echo $email ?>" disabled />
							</div>
						</div>
					</div>
					
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label for="joinDate">Join Date</label>
								<input type="text" id="joinDate" class="form-control" name="joinDate" value="<?php echo $joinDate ?>" disabled />
							</div>
						</div>

						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="expirationDate">Expiration Date</label>
								<input type="text" id="expirationDate" class="form-control" name="expirationDate" value="<?php echo $expirationDate ?>" disabled />
							</div>
						</div>
					</div>
					
					<div class="row">	
						<div class="col-sm-6">
							<label>Gender</label>
							<input type="text" class="form-control" name="country" value="<?php echo $gender ?>" disabled />
							<?php /*
							<div>
								<?php foreach($vl_gender as $key => $value){ ?>
									
									<label class="radio-inline">
										<input type="radio" name="gender" id="gender<?php echo $key ?>" value="<?php echo $value ?>"<?php echo ($value == $gender ? ' checked' : '') ?> /> <?php echo $key ?>
									</label>
									
								<?php } ?>
							</div>
							*/ ?>
						</div>
					</div>
		
					
					
				</div>
			</div>
					
		</div>

		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Instructor Address</h3>
				</div>
				<div class="panel-body">
					
					<div class="form-group">
						<label for="streetAddress" >Street Address</label>
						<input type="text" id="streetAddress" class="form-control" name="streetAddress" value="<?php echo $streetAddress ?>" disabled />
					</div>
					
					<div class="row">	
						<div class="col-sm-5">
							<div class="form-group">
								<label for="city" >City</label>
								<input type="text" id="city" class="form-control" name="city" value="<?php echo $city ?>" disabled />
							</div>
						</div>
						
						<div class="col-sm-2">
							<div class="form-group">
								<label for="state" >State</label>
								<input type="text" id="state" class="form-control" name="state" value="<?php echo $state ?>" disabled />
							</div>
						</div>
						
						<div class="col-sm-5">
							<div class="form-group">
								<label for="postalCode" >Postal Code</label>
								<input type="text" id="postalCode" class="form-control" name="postalCode" value="<?php echo $postalCode ?>" disabled />
							</div>
						</div>
					</div>
					
					<div class="row">	
						<div class="col-sm-5">
							<div class="form-group">
								<label for="country" >Country</label>
								<input type="text" id="country" class="form-control" name="country" value="<?php echo $country ?>" disabled />
								<?php /* <select id="country" class="form-control" name="country">
									<option value="">- Select -</option>
									<?php foreach ($vl_countries as $key => $i){
										echo '<option value="' . $i . '"' . ($i == $country ? ' selected' : '') . '>' . $key . '</option>';
									} ?>
								</select> */ ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Certifications</h3>
				</div>
				<div class="panel-body">
					
					<div class="row">	

						<div class="col-md-12">

							<table class="jq_dataTableResults_slim table table-striped table-bordered">
								<thead>
									<tr>
										<th>Course Number</th>
										<th>Course Name</th>
										<th>Knowledge Score</th>
										<th>Skills Score</th>
										<th>Completion Date</th>
										<th>Boat Size</th>
										<th>Instructor Name</th>
									</tr>
								</thead>
								
								<tbody>
								<?php foreach($coursesTakenArray as $thisCourse){ ?>
									<tr>
										<td><?php echo $thisCourse['CourseNumber']; ?></td>
										<td><?php echo $thisCourse['CourseName']; ?></td>
										<td><?php echo $thisCourse['KnowledgeScore']; ?></td>
										<td><?php echo $thisCourse['SkillsScore']; ?></td>
										<td><?php echo $thisCourse['CompletionDate']; ?></td>
										<td><?php echo $thisCourse['BoatSize']; ?></td>
										<td><?php echo $thisCourse['InstructorName']; ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>							
						
					
					</div>
				
			
					
				</div>
			</div>
					
		</div>

		
	</div>

	<hr />
	
	
	<?php /*
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<button type="submit" class="btn btn-default btn-block" value="<?php echo $submitType ?>"><?php echo $submitDisplay ?></button>
		</div>
	</div>
	*/ ?>
</form>
