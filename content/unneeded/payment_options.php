<?php
	
	$expirationMonthArray 	= array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	$expirationYearArray 	= array();
	
	$yearCounter = (int)date('Y');
	
	for ($i = 0; $i <= 6; $i++) {
		array_push($expirationYearArray, $yearCounter++);	
	}
	
	
	$CardNumber					= '';
	$securityCode				= '';
	$NameOnCard					= '';
	$month						= '';
	$year						= '';
	
	
	$record = $fmpConnection->getRecordById('Affiliate Web', $_SESSION['affiliateFMPID']);
				
	if(FileMaker::isError($record)){
		
		echo 'Error: ' . $record->getCode() . ': ' . $record->getMessage() . '\n';
		exit;
		
	} else {
		
		$CardNumber				= $record->getField('CreditCards_Affiliates::CardNumber');
		$securityCode			= $record->getField('CreditCards_Affiliates::Code');
		$NameOnCard				= $record->getField('CreditCards_Affiliates::NameOnCard');
		$month					= $record->getField('CreditCards_Affiliates::Month');
		$year					= $record->getField('CreditCards_Affiliates::Year');
		
		$creditCardObject		= $record->getRelatedSet('CreditCards_Affiliates');

		if(FileMaker::isError($creditCardObject)){
			
			$addressAdd   = $fmpConnection->newAddCommand('web_creditCards');
				$addressAdd->setField('id_Affiliate', $_SESSION['affiliateID']);
			$addressAddResult = $addressAdd->execute();
										
		}
		
	}
	
	$CardNumberDisplay			= ($CardNumber == '' ? '' : ('XXXX-XXXX-XXXX-' . substr($CardNumber, -4, 4)));
	$securityCodeDisplay		= ($securityCode == '' ? '' : 'XXX');
	$expirationDateDisplay 		= ($month != '' && $year != '' ? ($month . '/' . $year) : ($month . $year));
	
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<h2>Payment Options<span class="subheader"></span></h2>
	</div>
</div>

<hr />

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		
		<div class="panel panel-default">
			<div class="panel-body">
				
				<div class="row">
					
					<div class="col-sm-5">
						<div class="form-group">
							<label class="control-label">Card Number</label>
							<p class="form-control-static"><?php echo $CardNumberDisplay ?></p>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Security Code</label>
							<p class="form-control-static"><?php echo $securityCodeDisplay ?></p>
						</div>
					</div>
					
					<div class="col-sm-3 text-right">
						<button type="button" class="jq_editCard btn btn-default" data-toggle="modal" data-target="#modalCreditCardEdit">Edit</button>
<!-- 						<button type="button" class="btn btn-danger">Remove</button> -->
					</div>
					
				</div>

				
				<div class="row">
					
					<div class="col-sm-5">
						<div class="form-group">
							<label class="control-label">Name on Card</label>
							<p class="form-control-static"><?php echo $NameOnCard ?></p>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">Expiration Date</label>
							<p class="form-control-static"><?php echo $expirationDateDisplay ?></p>
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</div>

<!--
<div class="row">
	<div class="col-sm-4 col-sm-offset-4">
		<button type="button" class="jq_editCard btn btn-default btn-block" data-toggle="modal" data-target="#modalCreditCardAdd">Add New Card</button>
	</div>
</div>
-->

<hr />

<div id="modalCreditCardEdit" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		
		<div class="modal-content">
			
			<form action="submit_payment_options.php" method="post">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Edit Card Information</h4>
				</div>
				
				<div class="modal-body">
					
					<div class="row">
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="cardNumber" class="control-label">Card Number</label>
								<input type="text" id="cardNumber" class="form-control" name="cardNumber" value="<?php echo $CardNumber ?>" />
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								<label for="securityCode" class="control-label">Security Code</label>
								<input type="text" id="securityCode" class="form-control" name="securityCode" value="<?php echo $securityCode ?>" />
							</div>
						</div>
						
					</div>
	
					
					<div class="row">
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="nameOnCard" class="control-label">Name on card</label>
								<input type="text" id="nameOnCard" class="form-control" name="nameOnCard" value="<?php echo $NameOnCard ?>" />
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
								<label for="expirationMonth" >Expiration Date</label>
								<select id="expirationMonth" class="form-control" name="expirationMonth">
									<option value=""> -- </option>
									<?php foreach ($expirationMonthArray as $i){
										echo '<option value="' . $i . '"' . ($i == $month ? ' selected' : '') . '>' . $i . '</option>';
									} ?>
								</select>
							</div>
						</div>
						
						<div class="col-sm-3">						
							<div class="form-group">
								<label for="expirationYear" >&nbsp;</label>
								<select id="expirationYear" class="form-control" name="expirationYear">
									<option value=""> ---- </option>
									<?php foreach ($expirationYearArray as $i){
										echo '<option value="' . $i . '"' . ($i == $year ? ' selected' : '') . '>' . $i . '</option>';
									} ?>
								</select>
							</div>
						</div>
						
					</div>
					
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

