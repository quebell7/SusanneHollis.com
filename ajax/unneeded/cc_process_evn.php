<?php
	
	include_once('../includes/site_vars.php');


	
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
			$priceArray['evnPrice'] = $result->getField('Affiliate_EVNPrice');
			
		}
		
		$evnPerItemPrice		= $priceArray['evnPrice'];
		$cert101PerItemPrice	= $priceArray['cert101Price'];
	
	/*	
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */




	
	$affiliateID 		= (isset($_SESSION['affiliateID']) ? $_SESSION['affiliateID'] : '');
	
	if($affiliateID == ''){
		exit;
	}
	
	if(!isset($_REQUEST['validationNumber']) || $_REQUEST['validationNumber'] ==''){
		exit;
	}
	
	$description 			= 'EVN Purchase';
	$perItemPrice			= $evnPerItemPrice;
	
	$numberOfValidations 	= $_REQUEST['validationNumber'];
	$orderTotal				= $numberOfValidations * $perItemPrice;

	$search = $fmpConnection->newFindCommand('Affiliate Web');	
		$search->addFindCriterion('ID',	'=='.$affiliateID);
	$searchResults = $search->execute();


	if(FileMaker::isError($searchResults)) {			
		echo  $searchResults->getMessage();
		exit;				
	}




	$record 	= $searchResults->getRecords()[0];

	//$affiliateID			= $record->getField('AffiliateID');
	$cardNumber				= $record->getField('CreditCards_Affiliates::CardNumber');
	$cardCVC				= $record->getField('CreditCards_Affiliates::Code');
	$NameOnCard				= $record->getField('CreditCards_Affiliates::NameOnCard');
	$expMonth				= $record->getField('CreditCards_Affiliates::Month');
	$expYear				= $record->getField('CreditCards_Affiliates::Year');

	
	
	$customerID		= $affiliateID;
	$chargeAmount	= $orderTotal;
	
	
	
	$post_values = array(

		"x_login"			=> $authorize_login,
		"x_tran_key"		=> $authorize_tran_key,

		"x_cust_id"			=> $customerID,
		"x_version"			=> "3.1",
		"x_delim_data"		=> "TRUE",
		"x_delim_char"		=> "|",
		"x_relay_response"	=> "FALSE",
	
		"x_type"			=> "AUTH_CAPTURE",
		"x_method"			=> "CC",
		"x_card_code"		=> $cardCVC,
		"x_card_num"		=> $cardNumber,
		"x_exp_date"		=> $expMonth.$expYear,
	
		"x_amount"			=> $chargeAmount,
		"x_description"		=> $description,
		
/*
		"x_last_name"		=> $billingLastName,
		"x_first_name"		=> $billingFirstName,
		"x_company"			=> $billingCompanyName,
		"x_address"			=> $billingAddress,
		"x_city"			=> $billingCity,
		"x_state"			=> $billingState,
		"x_zip"				=> $billingZip,
		"x_phone"			=> $billingPhone,
		"x_country"			=> $billingCountry,
		"x_invoice_num"		=> $invoiceNo
*/
		
	);








	
	$post_string = "";
	foreach( $post_values as $key => $value )
		{ $post_string .= "$key=" . urlencode( $value ) . "&"; }
	$post_string = rtrim( $post_string, "& " );
	
	
	$request = curl_init($authorize_url); 								// initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); 					// set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); 			// Returns response data instead of TRUE(1)
		curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); 	// use HTTP POST to send form data
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); 		// uncomment this line if you get no gateway response.
		$post_response = curl_exec($request); 						// execute curl post and store results in $post_response
	curl_close ($request); // close curl object
	
	$response_array = explode($post_values["x_delim_char"],$post_response);
	

	//pretty_r($response_array);
	
	$message 				= '';
	$aimResponceCode 		= $response_array[0];	//	1 = 1 = Approved; 2 = Declined; 3 = Error
	$aimResponceText 		= $response_array[3];
	$aimResponceAuthCode 	= $response_array[4];
	$aimResponceAmount 		= $response_array[9];
	$aimResponceCardNumber 	= $response_array[50];
	$aimResponceCardType	= $response_array[51];
	
	
	$returnToUser	= "$aimResponceText";
	if($aimResponceCode == 1){
		$returnToUser	.= "<br/>$numberOfValidations EVN's totaling $$aimResponceAmount.";
	}
	
	$responce = "Responce Code: ".$aimResponceCode."\n";
	$responce .= "aimResponceText: ".$aimResponceText."\n";
	$responce .= "Responce Auth Code: ".$aimResponceAuthCode."\n";
	$responce .= "Responce Card Number: ".$aimResponceCardNumber."\n";
	$responce .= "Responce Card Type: ".$aimResponceCardType."\n";
	$responce .= "Responce Amount: ".$aimResponceAmount."\n";

	//echo $currentDate_USA;


	if($aimResponceCode == 1){
	
		$paymentAdd   = $fmpConnection->newAddCommand('web_cc_transactions');
			//$paymentAdd->setField('DataDump',			print_r($response_array));
			$paymentAdd->setField('Amount',				$aimResponceAmount);
			$paymentAdd->setField('id_Affiliate',		$affiliateID);
			//$paymentAdd->setField('id_Affiliate',		$affiliateID);
			$paymentAdd->setField('TransactionNumber',	$aimResponceAuthCode);
			$paymentAdd->setField('TransactionDate',	$currentDate_USA);
			$paymentAdd->setField('DataDump',			$post_response);
		$paymentAddResult = $paymentAdd->execute();
	
	
		//	 ADD EVN's to the system here

		$add = $fmpConnection->newAddCommand('web_evns');
			$add->setField('id_Affiliate',	$_SESSION['affiliateID']);
			$add->setField('Purchased',		$numberOfValidations);
			$add->setField('Price',			$perItemPrice);
		$addResults = $add->execute();


		
		if(FileMaker::isError($paymentAddResult)) {			
			echo  $paymentAddResult->getMessage();
			exit;				
		}
	
	
	
	
	
	}
	
	
	

	echo  $returnToUser;


?>