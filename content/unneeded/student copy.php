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

	
	if($personID != ''){
	
		$search = $fmpConnection->newFindCommand('web_persons');	
			$search->addFindCriterion('ID',	'=='.$personID);
		$searchResults = $search->execute();
				
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
			$personID					= $record->getField('ID');

			$streetAddress				= $record->getField('Addresses_Persons::Address1');
			$city						= $record->getField('Addresses_Persons::City');
			$state						= $record->getField('Addresses_Persons::State');
			$postalCode					= $record->getField('Addresses_Persons::PostalCode');
			$country					= $record->getField('Addresses_Persons::Country');

			$addressObject				= $record->getRelatedSet('Addresses_Persons');
			

			if(FileMaker::isError($addressObject)){
				
				$addressAdd   = $fmpConnection->newAddCommand('web_addressesPersons');
					$addressAdd->setField('id_Parent', $personID);
				$addressAddResult = $addressAdd->execute();
											
			}

		
			$coursesObject		= $record->getRelatedSet('PersonCertifications_Persons');
			$coursesTakenArray	= array();
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

			
			
			
			
		}
		
		$FullName = ($FirstName . ' ' . $LastName);
		
	}
	
	$vl_countries 		= $fmpConnection->getLayout('web_persons')->getValueListTwoFields('Countries');
	$vl_gender 			= $fmpConnection->getLayout('web_persons')->getValueListTwoFields('Gender');
	
	
	
	
	
	$record = $fmpConnection->getRecordById('Affiliate Web', $_SESSION['affiliateFMPID']);	
	
	if(FileMaker::isError($record)) {

		echo 'Error: ' . $record->getCode() . ': ' . $record->getMessage() . '\n';
		exit;

	} else {
				
		$coursesObject					= $record->getRelatedSet('AffiliateCertifications_Affiliates');
					
		$coursesTaughtArray	= array();
		if(!FileMaker::isError($coursesObject)){

			foreach($coursesObject as $relatedRec){
				
				$coursesTaughtArray[$relatedRec->getField('AffiliateCertifications_Affiliates::id_Certification')] = $relatedRec->getField('Certifications_Affiliates::DisplayName');
				
			}
						
		}
	}
	
	
	
	
	$search = $fmpConnection->newFindCommand('web_persons');
		$search->addFindCriterion('Instructor',	'==Yes');
		$search->addFindCriterion('AffiliatePersons_Instructors::id_Affiliate',	('==' . $_SESSION['affiliateID']));
		
	$searchResults = $search->execute();
	
	$instructorArray = array();
	
	if(FileMaker::isError($searchResults) && $searchResults->getCode() != '401') {
			
		echo "<p>Error: " . $searchResults->getMessage() . "</p>"; 
		echo $searchResults->getCode();
		die;
		
	} else if(!FileMaker::isError($searchResults)) {
		
		$records 	= $searchResults->getRecords();
		
		foreach($records as $record){
			$instructorArray[$record->getField('ID')] = ($record->getField('FirstName') . ' ' . $record->getField('LastName'));
		}

	}
	
	
	
	
	
	
		
	
	$availableEVNs		= 0;

	$search = $fmpConnection->newFindCommand('web_evns');
		$search->addFindCriterion('id_Affiliate',	'==' . $_SESSION['affiliateID']);
		$search->addFindCriterion('Remaining',		'>0');
	$searchResults = $search->execute();

	if(!FileMaker::isError($searchResults)) {
		
		$records 	= $searchResults->getRecords();
		
		foreach($records as $record){
			$availableEVNs = $availableEVNs + $record->getField('Remaining') ;
		}

	}
	
	
	
	$availableCerts		= 0;

	$search = $fmpConnection->newFindCommand('web_certFees');
		$search->addFindCriterion('id_Affiliate',	'==' . $_SESSION['affiliateID']);
		$search->addFindCriterion('Remaining',		'>0');
	$searchResults = $search->execute();

	if(!FileMaker::isError($searchResults)) {
		
		$records 	= $searchResults->getRecords();
		
		foreach($records as $record){
			$availableCerts = $availableCerts + $record->getField('Remaining') ;
		}

	}	
	

	
	
	
?>

<div class="row">
	<div class="col-md-12">
		<h2>Student <span class="subheader">- <?php echo $FullName ?></span></h2>
	</div>
</div>

<hr />


<form id="myform" action="submit_student.php" method="post">
	
	<input type="hidden" name="id" value="<?php echo $personID ?>" />
	
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
								<label for="asaID">Student ID</label><br/>
								<?php echo $asaID ?>
							</div>
						</div>
						
					</div>

					
					
					
					
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label for="FirstName">First Name</label>
								<input type="text" id="FirstName" class="form-control" name="FirstName" value="<?php echo $FirstName ?>" />
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="LastName">Last Name</label>
								<input type="text" id="LastName" class="form-control" name="LastName" value="<?php echo $LastName ?>" />
							</div>
						</div>
					</div>
				
				
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label for="phoneNumber">Phone #</label>
								<input type="text" id="phoneNumber" class="form-control" name="phoneNumber" value="<?php echo $phoneNumber ?>" />
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="text" id="email" class="form-control" name="email" value="<?php echo $email ?>" />
							</div>
						</div>
					</div>
					
					<div class="row">
							
						<div class="col-sm-6">
							<label>Gender</label>
							<div>
								<?php foreach($vl_gender as $key => $value){ ?>
									
									<label class="radio-inline">
										<input type="radio" name="gender" id="gender<?php echo $key ?>" value="<?php echo $value ?>"<?php echo ($value == $gender ? ' checked' : '') ?> /> <?php echo $key ?>
									</label>
									
								<?php } ?>
							</div>
						</div>
						
												
						<div class="col-sm-6">
							<div class="form-group">
								<label for="joinDate">Join Date</label>
								<input type="text" id="joinDate" class="form-control" name="joinDate" value="<?php echo $joinDate ?>" />
							</div>
						</div>
					</div>
					
<!--
					<div class="row">	
						<div class="col-sm-6">
							<label>Gender</label>
							<div>
								<?php foreach($vl_gender as $key => $value){ ?>
									
									<label class="radio-inline">
										<input type="radio" name="gender" id="gender<?php echo $key ?>" value="<?php echo $value ?>"<?php echo ($value == $gender ? ' checked' : '') ?> /> <?php echo $key ?>
									</label>
									
								<?php } ?>
							</div>
						</div>
					</div>
-->
					
				</div>
			</div>	
		</div>

		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Student Address</h3>
				</div>
				<div class="panel-body">
					
					<div class="form-group">
						<label for="streetAddress" >Street Address</label>
						<input type="text" id="streetAddress" class="form-control" name="streetAddress" value="<?php echo $streetAddress ?>" />
					</div>
					
					<div class="row">	
						<div class="col-sm-5">
							<div class="form-group">
								<label for="city" >City</label>
								<input type="text" id="city" class="form-control" name="city" value="<?php echo $city ?>" />
							</div>
						</div>
						
						<div class="col-sm-2">
							<div class="form-group">
								<label for="state" >State</label>
								<input type="text" id="state" class="form-control" name="state" value="<?php echo $state ?>" />
							</div>
						</div>
						
						<div class="col-sm-5">
							<div class="form-group">
								<label for="postalCode" >Postal Code</label>
								<input type="text" id="postalCode" class="form-control" name="postalCode" value="<?php echo $postalCode ?>" />
							</div>
						</div>
					</div>
					
					<div class="row">	
						<div class="col-sm-5">
							<div class="form-group">
								<label for="country" >Country</label>
								<select id="country" class="form-control" name="country">
									<option value="">- Select -</option>
									<?php foreach ($vl_countries as $key => $i){
										echo '<option value="' . $i . '"' . ($i == $country ? ' selected' : '') . '>' . $key . '</option>';
									} ?>
								</select>
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
					
					<br />
					
					<div class="row">	
						
						<div class="col-md-3">
							<div class="form-group">
								<label for="course">Course</label>										
								<select id="course" class="form-control" name="courseID">
									<option value="">- Select -</option>
									<?php
										
										foreach ($coursesTaughtArray as $courseID => $courseName){
											
											echo '<option value="' . $courseID . '">' . $courseName . '</option>';
										}
										
									?>
								</select>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label for="instructor">Instructor</label>										
								<select id="instructor" class="form-control" name="instructorID">
									<option value="">- Select -</option>
									<?php
										
										foreach ($instructorArray as $id => $name){
											
											echo '<option value="' . $id . '">' . $name . '</option>';
										}
										
									?>
								</select>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label>
<!-- 								<button type="submit" id="jq_issueSingleCert" class="btn btn-primary btn-md btn-block" name="submit" value="issueCert">Issue Certification</button> -->
								<button id="jq_issueSingleCertificate" class="btn btn-primary btn-md btn-block">Process Certification</button>

							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Available EVN's</label>
								<div><?php echo $availableEVNs;?></div>
								<p id="jq_originalEVNs" class="hidden"><?php echo $availableEVNs; ?></p>

							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>Available 101 Certification Fees</label>
								<div><?php echo $availableCerts;?></div>
								<p id="jq_originalCertificates" class="hidden"><?php echo $availableCerts; ?></p>
							</div>
						</div>
						
					</div>
				
			
					
				</div>
			</div>
					
		</div>

		
	</div>

	
	
	<hr />

	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<button type="submit" class="btn btn-default btn-block" name="submit" value="<?php echo $submitType ?>"><?php echo $submitDisplay ?></button>
		</div>
	</div>
	
</form>

<form id="fooForm" action="submit_student2.php" method="post">
									<button id="jq_foo" class="btn btn-primary btn-md btn-block">Process Certification</button>

</form>
