<?php
	

		$search = $fmpConnection->newFindCommand('web_affiliateRenewals');	
			$search->addFindCriterion('id_Affiliate',	'=='.$_SESSION['affiliateID']);
			$search->addSortRule('ExpirationDate', 1, FILEMAKER_SORT_DESCEND);
		$searchResults = $search->execute();
		
		
		$membershipHistory	= array();
		if(!FileMaker::isError($searchResults)) {
			$membershipHistory 			= $searchResults->getRecords();
		}
		

?>
<?php 
	if(isset($_SESSION['message']) && $_SESSION['message'] != ''){
		
		
?>
	<div class="col-md-10  col-md-offset-1 alert alert-<?php echo $_SESSION['messageStyle'];?> alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <?php echo $_SESSION['message']; ?>
	</div>
<?php 
		$_SESSION['message'] 		= '';
		$_SESSION['messageStyle'] 	= '';
	} 
?>

<div class="row">
	<div class="col-md-12">
		<h2>View Membership</h2>
	</div>
</div>

<hr />

		




<?php
		
		
		
		
	foreach($membershipHistory as $thisRecord){
	
	
		$transAmount	= '';
		$transDate		= '';
		$transCardType	= '';
		$transCardNum	= '';

		
		$search = $fmpConnection->newFindCommand('web_cc_transactions');	
			$search->addFindCriterion('id',	'=='.$thisRecord->getField('id_Transaction'));
		$searchResults = $search->execute();
		
		$showTransData = false;

		if(!FileMaker::isError($searchResults)) {
			
			$ccTransactionData 			= $searchResults->getRecords()[0];
			
			$showTransData 	= true;

			$transAmount	= $ccTransactionData->getField('Amount');
			$transDate		= $ccTransactionData->getField('TransactionDate');
			$transDataArray	= explode('|', $ccTransactionData->getField('DataDump'));
			$transCardType	= $transDataArray[51];
			$transCardNum	= $transDataArray[50];
			
		}
?>
	<div class="panel panel-info">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?php echo $thisRecord->getField('RenewalDate'); ?> - <?php echo $thisRecord->getField('ExpirationDate'); ?></h3>
	  </div>
	  <div class="panel-body">

			<div class="row">
				
				<div class="col-xs-12 col-sm-3">
					<label>Start Date</label>
				</div>
			
				<div class="col-xs-12 col-sm-3">
					<?php echo $thisRecord->getField('RenewalDate'); ?>
				</div>
				
				<div class="col-xs-12 col-sm-3">
					<label>Expiration Date</label>
				</div>
			
				<div class="col-xs-12 col-sm-3">
					<?php echo $thisRecord->getField('ExpirationDate'); ?>
				</div>
				
				
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-3">
					<label>Type</label>
				</div>
			
				<div class="col-xs-12 col-sm-9">
					<?php echo $thisRecord->getField('Type'); ?>
				</div>
			</div>
			
			
			<?php if($showTransData){ ?>
				
				<hr/>
				
				<div class="row">
					<div class="col-xs-6 col-sm-3">
						<label>Charge Amount</label>
					</div>
				
					<div class="col-xs-6 col-sm-3">
						$<?php echo $transAmount; ?>
					</div>
					
					<div class="col-xs-6 col-sm-3">
						<label>Charge Date</label>
					</div>
				
					<div class="col-xs-6 col-sm-3">
						<?php echo $transDate; ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-6 col-sm-3">
						<label>Card Type</label>
					</div>
				
					<div class="col-xs-6 col-sm-3">
						<?php echo $transCardType; ?>
					</div>
					
					<div class="col-xs-6 col-sm-3">
						<label>Card #</label>
					</div>
				
					<div class="col-xs-6 col-sm-3">
						<?php echo $transCardNum; ?>
					</div>
				</div>

		<?php } ?>


	  </div>
	</div>
<?php
	}
?>