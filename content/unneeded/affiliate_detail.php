<?php
	
	
	
	/*	evn & 101 cert prices
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		
		$evnPerItemPrice		= 12.00;
		$cert101PerItemPrice	= 39.00;
				
		$search = $fmpConnection->newFindAllCommand('web_prices');	
		$searchResults = $search->execute();
			
		$priceArray  = array();
	
		if(!FileMaker::isError($searchResults)) {
			$result 	= $searchResults->getRecords()[0];
			
			$priceArray['cert101Price'] = $result->getField('Affiliate_CertPrice');
			$priceArray['evnPrice'] 	= $result->getField('Affiliate_EVNPrice');
			
		}
		
		$evnPerItemPrice		= $priceArray['evnPrice'];
		$cert101PerItemPrice	= $priceArray['cert101Price'];
	
	/*	
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

	
	
	$record = $fmpConnection->getRecordById('Affiliate Web', $_SESSION['affiliateFMPID']);	
	
	if(FileMaker::isError($record)) {

		echo 'Error: ' . $record->getCode() . ': ' . $record->getMessage() . '\n';
		exit;

	} else {
		
		$businessType					= $record->getField('BusinessType');
		$name							= $record->getField('Name');
		$streetAddress					= $record->getField('Addresses_Affiliates::Address1');
		$city							= $record->getField('Addresses_Affiliates::City');
		$state							= $record->getField('Addresses_Affiliates::State');
		$postalCode						= $record->getField('Addresses_Affiliates::PostalCode');
		$country						= $record->getField('Addresses_Affiliates::Country');
		$email							= $record->getField('Email');
		$contactPhone					= $record->getField('Phone_Contact');
		$alternatePhone					= $record->getField('Phone_Alt');
		$fax							= $record->getField('Phone_Fax');
		$website						= $record->getField('WebAddress');
		$affiliateSince					= $record->getField('DateJoined');
		$lastRenewed					= $record->getField('LastRenewalDate');
		$contactName					= $record->getField('ContactName');
		$ASAAgreementExpirationDate		= $record->getField('ASAAgreementExpirationDate');
		$InsuranceExpirationDate		= $record->getField('InsuranceExpirationDate');
		
		
		/* Job Posting data
		- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
			$_SESSION['contactName'] 		= $record->getfield('ContactName');
			$_SESSION['contactPhone'] 		= $record->getfield('Phone_Contact');
			$_SESSION['contactEmail'] 		= $record->getfield('Email');
		/* 
		- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		
		$coursesObject					= $record->getRelatedSet('AffiliateCertifications_Affiliates');
					
		$coursesTaughtArray	= array();
		if(!FileMaker::isError($coursesObject)){

			foreach($coursesObject as $relatedRec){
				array_push($coursesTaughtArray, $relatedRec->getField('Certifications_Affiliates::DisplayName'));
			}
						
		}
		
		
				
		$renewalObject					= $record->getRelatedSet('AffiliateRenewals_Affiliates');
					
		$renewalArray	= array();
		if(!FileMaker::isError($renewalObject)){


			$renewalArray['ExpirationDate'] = $renewalObject[0]->getField('AffiliateRenewals_Affiliates::ExpirationDate');
			$renewalArray['RenewalDate'] = $renewalObject[0]->getField('AffiliateRenewals_Affiliates::RenewalDate');
			$renewalArray['Months'] = $renewalObject[0]->getField('AffiliateRenewals_Affiliates::Months');

						
		}


	}
	
	
	$vl_businessType 	= $fmpConnection->getLayout('Affiliate Web')->getValueListTwoFields('Affiliate Business Types');
	$vl_countries 		= $fmpConnection->getLayout('Affiliate Web')->getValueListTwoFields('Countries');
	

?>



<div class="row">
	<div class="col-sm-12 col-md-8">
		<h2>Affiliate <span class="subheader">- <?php echo $name ?></span></h2>
	</div>
	<div class="col-sm-12 col-md-4">
		
		<div class="row">
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary btn-sm jq_clearResult" data-toggle="modal" data-target="#modalPurchaseValidation">Purchase EVN's</button>
			</div>
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary btn-sm jq_clearResult" data-toggle="modal" data-target="#modalPurchaseCert101">Purchase 101 Certification Fees</button>
			</div>

		</div>
		
		
		<div id="purchaseResults"></div>
	</div>

</div>

<hr />

<form action="submit_affiliate_detail.php" method="post">

	<div class="row">
		<div class="col-md-6">

			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Affiliate Information</h3>
				</div>
				<div class="panel-body">
					
					
					
					<div class="row">	
						<div class="col-sm-7">
					
							<div class="form-group">
								<label for="name" class="control-label">Name</label>
								<input type="text" id="name" class="form-control" name="name" value="<?php echo $name ?>" />
							</div>
							
						</div>
						
						<div class="col-sm-5">
							<div class="form-group">
								<label for="businessType" class="control-label">Business Type</label>
								<select id="businessType" class="form-control" name="businessType">
									<option value="">- Select -</option>
									<?php foreach ($vl_businessType as $key => $i){
										echo '<option value="' . $i . '"' . ($i == $businessType ? ' selected' : '') . '>' . $key . '</option>';
									} ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label for="affiliateSince" class="control-label">Affiliate Since</label>
								<br><?php echo $affiliateSince ?>

							</div>
							
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="lastRenewed" class="control-label">Last Renewed</label>
								<br><?php echo $renewalArray['RenewalDate'] ?>
							</div>
							
						</div>
						
					</div>
					
					
					
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">ASA Agreement Expiration</label>
								<p class="form-control-static"><?php echo $ASAAgreementExpirationDate ?></p>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Insurance Expiration</label>
								<p class="form-control-static"><?php echo $InsuranceExpirationDate ?></p>
							</div>
						</div>
					</div>
					
					
					
					
					
					
					
					
				</div>
			</div>
			
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Affiliate Contact</h3>
				</div>
				<div class="panel-body">
					
					
					<div class="form-group">
						<label for="contactName" class="control-label">Contact Name</label>
						<input type="text" id="contactName" class="form-control" name="contactName" value="<?php echo $contactName ?>" />
					</div>
					
					
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label for="email" class="control-label">Email</label>
								<input type="text" id="email" class="form-control" name="email" value="<?php echo $email ?>" />
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="website" class="control-label">Website</label>
								<input type="text" id="website" class="form-control" name="website" value="<?php echo $website ?>" />
							</div>
						</div>
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
								<label for="alternatePhone" class="control-label">Alternate Phone #</label>
								<input type="text" id="alternatePhone" class="form-control" name="alternatePhone" value="<?php echo $alternatePhone ?>" />
							</div>
						</div>
					</div>
					
					
					<div class="row">	
						<div class="col-sm-6">
							
						</div>
						
						<div class="col-sm-6">
							
						</div>
					</div>
					
					
					<div class="row">	
						<div class="col-sm-6">
							<div class="form-group">
								<label for="fax" class="control-label">Fax #</label>
								<input type="text" id="fax" class="form-control" name="fax" value="<?php echo $fax ?>" />
							</div>
						</div>
						
						<div class="col-sm-6">
							
						</div>
					</div>
					
				</div>
			</div>
		
		</div>
		
		
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Affiliate Address</h3>
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
			
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Courses Taught</h3>
				</div>
				<div class="panel-body">
					
					
					
					
					<ul class="list-group">
						
						<?php
							
							foreach($coursesTaughtArray as $i){
								echo '<li class="list-group-item">' . $i . '</li>';
							}
							
						?>

					</ul>
					
					
					
			
				</div>
			</div>
			
			
		</div>
		
	</div>
	
	<hr />
	
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<button type="submit" class="btn btn-default btn-block" value="update">Save Changes</button>
		</div>
	</div>
	
</form>


<div id="modalPurchaseCert101" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		
		<div class="modal-content">
			
			<form id="jq_purchaseCert101Form">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Purchase 101 Certification Fees</h4>
				</div>
				
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class=" col-sm-6 text-right">
								<label for="cert101Number" >Number of 101 Certification Fees to Purchase</label> 
								<div class="">($<?php echo $cert101PerItemPrice; ?> each)</div>
							</div>
							<div class=" col-sm-6">
								
								<div class="row">
									<div class=" col-sm-6">
										<input type="text" id="cert101Number" class="form-control " name="cert101Number" value="" perItemPrice="<?php echo $cert101PerItemPrice; ?>"/>
									</div>
									<div class=" col-sm-6">
										<span id="cert101TotalPrice" class="text-right"></span>
									</div>
								</div>
								
							</div>

						</div>
												
						<div class="row hidden" id="cert101_processBar">
							<br>
							<div class="col-sm-10 col-sm-offset-1 progress">
							  <div class="progress-bar progress-bar-striped active" role="progressbar"
							  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
							    processing...
							  </div>
							</div>
						</div>

						
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" id="jq_purchaseCert101" readyToProcess="true" class="btn btn-primary">Complete Purchase</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modalPurchaseValidation" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		
		<div class="modal-content">
			
			<form id="jq_purchaseValidationForm">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Purchase Validation</h4>
				</div>
				
				<div class="modal-body">
					<div class="form-group">
						
						
						<div class="row">
							<div class=" col-sm-6 text-right">
								<label for="validationNumber" >Number of EVN's to Purchase</label> 
								<div class="">($<?php echo $evnPerItemPrice; ?> each)</div>
							</div>
							<div class=" col-sm-6">
								
								<div class="row">
									<div class=" col-sm-6">
										<input type="text" id="validationNumber" class="form-control " name="validationNumber" value="" perItemPrice="<?php echo $evnPerItemPrice; ?>" />
									</div>
									<div class=" col-sm-6">
										<span id="evnTotalPrice" class="text-right"></span>
									</div>
								</div>
							</div>

						</div>
						
						<div class="row hidden" id="evn_processBar">
							
							<br>
							
							<div class="col-sm-10 col-sm-offset-1 progress">
							  <div class="progress-bar progress-bar-striped active" role="progressbar"
							  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
							    processing...
							  </div>
							</div>
						</div>
						
						
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" id="jq_purchaseValidation" readyToProcess="true" class="btn btn-primary">Complete Purchase</button>
				</div>
			</form>
		</div>
	</div>
</div>