<?php


	
	$_SESSION['addStudentData'] = array();
	
	
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
	
	$vl_countries 		= $fmpConnection->getLayout('web_persons')->getValueListTwoFields('Countries');
	$vl_gender 			= $fmpConnection->getLayout('web_persons')->getValueListTwoFields('Gender');
	
	
	
	
	
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
		<h2>Process Certifications</h2>
	</div>
</div>

<hr />




<form id="issueCertForm" action="submit_issue_certificate.php" method="post">

	<div class="row">
		
<?php 
	if(isset($_SESSION['message']) && $_SESSION['message'] != ''){
?>
	<div class="col-md-10  col-md-offset-1 alert alert-success alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <h3><strong> Success!</strong></h3> <?php echo $_SESSION['message']; ?>
	</div>
<?php 
		$_SESSION['message'] = '';
	} 
?>
		
		<div class="col-md-3 col-md-offset-1">
			
			<div class="form-group">
				<label for="jq_issueCertInstructor">Instructor</label>										
				<select id="jq_issueCertInstructor" class="form-control" name="instructorID">
					<option>- Select -</option>
					<?php
						
						foreach ($instructorArray as $id => $name){
							
							echo '<option value="' . $id . '">' . $name . '</option>';
						}
						
					?>
				</select>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
				<label for="course">Courses</label>
				<div id="jq_coursesTaught">
					<p class="form-control-static">Select Instructor to see courses</p>
				</div>
			</div>
		</div>
		
		<div class="col-md-2">
			<label>EVNs</label>
			<p id="jq_originalEVNs" class="hidden"><?php echo $availableEVNs; ?></p>
			<p id="jq_availableEVNs" class="form-control-static"><?php echo $availableEVNs; ?></p>
		</div>
		
		<div class="col-md-2">
			<label>101 Certification Fees</label>
			<p id="jq_originalCertificates" class="hidden"><?php echo $availableCerts; ?></p>
			<p id="jq_availableCertificates" class="form-control-static"><?php echo $availableCerts; ?></p>
		</div>
		

	</div>
	
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-primary">
				<div class="panel-heading">Enter Students</div>
				<div class="panel-body">
			
					<div class="row">
						<div class="col-md-3">
							<label>Student ID</label>
						</div>
						
						<div class="col-md-3">
							<label>Student Name</label>
						</div>
						
						<div class="col-md-4">
							<label>Student Address</label>
						</div>
					</div>
					
					
					<div id="jq_studentContainer">
						<div id="studentRow_1" class="row" count="1">
							<div class="col-md-3">
								<input type="text" id="jq_studentID_1" class="form-control jq_studentID" name="studentID[]" count="1" value="" placeholder="Enter a Student ID" />
								<p id="jq_displayStudentID_1" class="form-control-static hidden"></p>
							</div>
							
							<div class="col-md-3">
								<button type="button" id="jq_applyButton_1" class="jq_applyButton btn btn-primary btn-sm hidden" count="1">Apply</button>
								<p id="jq_studentName_1" class="form-control-static hidden"></p>
							</div>
							
							<div class="col-md-4">
								<p id="jq_studentAddress_1" class="form-control-static hidden"></p>
							</div>
							
							<div class="col-md-2">
								<button type="button" id="jq_removeButton_1" class="jq_removeStudent btn btn-danger btn-sm hidden" count="1">Remove</button>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-3 text-center">
							<p class="form-control-static">- OR -</p>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-3">
							<button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modalStudentSearch">Search for a student</button>
						</div>
						
						<div class="col-md-3">
							<button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modalStudentAdd">Add a new student</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<button type="submit" id="jq_issueCertificates" class="btn btn-primary btn-block">Process Certifications</button>
		</div>
	</div>
</form>

<div id="modalStudentSearch" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Search by Name and City</h4>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="jq_studentFirstName">First Name</label>
							<input type="text" id="jq_studentFirstName" class="form-control jq_studentSearchField" name="studentFirstName" value="" />
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">	
							<label for="jq_studentLastName">Last Name</label>
							<input type="text" id="jq_studentLastName" class="form-control jq_studentSearchField" name="studentLastName" value="" />
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label for="jq_studentCity">City</label>
							<input type="text" id="jq_studentCity" class="form-control jq_studentSearchField" name="studentCity" value="" />
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" id="jq_applyButtonSearch" class="btn btn-primary">Search & apply if found</button>
			</div>			
		</div>
	</div>
</div>



<div id="modalStudentAdd" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="jq_newStudentForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Add New Student</h4>
				</div>
				
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">Contact Information</h3>
								</div>
								<div class="panel-body">
									
									<div class="row">	
										<div class="col-sm-6">
											<div class="form-group">
												<label for="FirstName">First Name</label>
												<input type="text" id="FirstName" class="form-control" name="FirstName" value="" />
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label for="LastName">Last Name</label>
												<input type="text" id="LastName" class="form-control" name="LastName" value="" />
											</div>
										</div>
									</div>
								
								
									<div class="row">	
										<div class="col-sm-6">
											<div class="form-group">
												<label for="phoneNumber">Phone #</label>
												<input type="text" id="phoneNumber" class="form-control" name="phoneNumber" value="" />
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email">Email</label>
												<input type="text" id="email" class="form-control" name="email" value="" />
											</div>
										</div>
									</div>
									
									<div class="row">	
										<div class="col-sm-6">
											<div class="form-group">
												<label for="joinDate">Join Date</label>
												<input type="text" id="joinDate" class="form-control" name="joinDate" value="" />
											</div>
										</div>
										
										<div class="col-sm-6">
											<label>Gender</label>
											<div>
												<?php foreach($vl_gender as $key => $value){ ?>
													
													<label class="radio-inline">
														<input type="radio" name="gender" id="gender<?php echo $key ?>" value="<?php echo $value ?>" /> <?php echo $key ?>
													</label>
													
												<?php } ?>
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
									<h3 class="panel-title">Student Address</h3>
								</div>
								<div class="panel-body">
									
									<div class="form-group">
										<label for="streetAddress" >Street Address</label>
										<input type="text" id="streetAddress" class="form-control" name="streetAddress" value="" />
									</div>
									
									<div class="row">	
										<div class="col-sm-5">
											<div class="form-group">
												<label for="city" >City</label>
												<input type="text" id="city" class="form-control" name="city" value="" />
											</div>
										</div>
										
										<div class="col-sm-2">
											<div class="form-group">
												<label for="state" >State</label>
												<input type="text" id="state" class="form-control" name="state" value="" />
											</div>
										</div>
										
										<div class="col-sm-5">
											<div class="form-group">
												<label for="postalCode" >Postal Code</label>
												<input type="text" id="postalCode" class="form-control" name="postalCode" value="" />
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
														echo '<option value="' . $i . '">' . $key . '</option>';
													} ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" id="jq_addNewStudent" class="btn btn-primary">Add Student</button>
				</div>
			</form>
		</div>
	</div>
</div>