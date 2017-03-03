<?php

			
			
			

	
		$search = $fmpConnection->newFindAllCommand('web_prices');	
		$searchResults = $search->execute();

		if(!FileMaker::isError($searchResults)) {
			$priceRecord			= $searchResults->getRecords()[0];
			
			$price_fpMain		= money_format('%i', $priceRecord->getField('AffiliateDues_Main'));
			$price_fpAdditional	= money_format('%i', $priceRecord->getField('AffiliateDues_Additional'));
			$price_npMain		= money_format('%i', $priceRecord->getField('AffiliateDues_NPMain'));
			$price_npAdditional	= money_format('%i', $priceRecord->getField('AffiliateDues_NPAdditional'));


		}


		$search = $fmpConnection->newFindCommand('web_affiliateRenewals');	
			$search->addFindCriterion('id_Affiliate',	'=='.$_SESSION['affiliateID']);
			$search->addSortRule('ExpirationDate', 1, FILEMAKER_SORT_DESCEND);
		$searchResults = $search->execute();
		
		
		$membershipHistory		= array();
		$currentExpirationDate	= '';
		
		if(!FileMaker::isError($searchResults)) {
			$membershipHistory 			= $searchResults->getRecords()[0];
			
			$currentExpirationDate	= $membershipHistory->getField('ExpirationDate');
		}
		


		$record = $fmpConnection->getRecordById('Affiliate Web', $_SESSION['affiliateFMPID']);	
			$chargeType					= $record->getField('BusinessType');
			$subLocationCount			= $record->getField('SubLocationCount');
		
		$renewalPrice 				= 0;
		
		if($chargeType == 'Profit'){
			$renewalPrice = $price_fpMain + ($price_fpAdditional * $subLocationCount);
		}else{
			$renewalPrice = $price_npMain + ($price_npAdditional * $subLocationCount);
		}
		$renewalPrice = money_format('%i', $renewalPrice);
		
?>

	<div class="row">
		<div class="col-md-12">
			<h2>Renew Membership</h2>
		</div>
	</div>
	
	<hr />
	
<form method="post" action="submit_renew_membership.php">
	
	<div class="row">
		<div class="col-sm-6">
			Your current membership expires on <?php echo $currentExpirationDate;?>
		</div>
		
		<div class="col-sm-6">
			
			
			
			<?php
			
				if( $chargeType == 'Profit' ){
			?>
			
				<div class="row">
					<div class="col-xs-8">
						Main Location
					</div>
					<div class="col-xs-4">
						$<?php echo $price_fpMain; ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-8">
						Additional Location (<?php echo $subLocationCount; ?>)
					</div>
					<div class="col-xs-4">
						$<?php echo $price_fpAdditional; ?>
					</div>
				</div>

				<hr>
				
				<div class="row">
					<div class="col-xs-8">
						Total Renewal Price
					</div>
					<div class="col-xs-4">
						$<?php echo $renewalPrice; ?>
					</div>
				</div>


			<?php
				
				}else{
			?>
				<div class="row">
					<div class="col-xs-8">
						Main Location
					</div>
					<div class="col-xs-4">
						$<?php echo $price_npMain; ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-8">
						Additional Location (<?php echo $subLocationCount; ?>)
					</div>
					<div class="col-xs-4">
						$<?php echo $price_npAdditional; ?>
					</div>
				</div>

				<hr>
				
				<div class="row">
					<div class="col-xs-8">
						Total Renewal Price
					</div>
					<div class="col-xs-4">
						$<?php echo $renewalPrice; ?>
					</div>
				</div>

				
				
			<?
				}
				
			?>
						
			
		
	
		</div>
		
	</div>
	<hr/>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<button type="submit" class="btn btn-default btn-block primary" name="submit" value="renew">Renew Membership	
	</div>
</form>

