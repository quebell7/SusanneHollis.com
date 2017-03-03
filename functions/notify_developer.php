<?php
	
		
	/* send developer error email
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	
		if(!function_exists('notifyDeveloper')){
			
			function notifyDeveloper($databaseActionResults){
	
		
				require_once('/includes/email_vars.php');
				
				$toEmailAddress	= $developerEmailAddress;
				$toFullName 	= '';
					
				$emailSubject	= 'Update Error: Code ' . $databaseActionResults->getCode() . ' : ' . $databaseActionResults->getMessage();
				$emailBody		= ''. print_r($databaseActionResults, true) . '';

				$mail	= new PHPMailer(true); 										// the true param means it will throw exceptions on errors, which we need to catch
				$mail->MailerDebug	= true;
				$mail->IsSMTP(); 													// telling the class to use SMTP
			
				try {	$mail->Host			= $smtpHost; 							// SMTP server
						$mail->SMTPDebug	= 1;									// enables SMTP debug information (for testing), set to 2 for development
						$mail->SMTPAuth		= true;									// enable SMTP authentication
						$mail->Host			= $smtpHost;							// sets the SMTP server
						$mail->Port			= $smtpPort;							// set the SMTP port for the GMAIL server
						$mail->Username   	= $smtpFrom;							// SMTP account username
						$mail->Password   	= $smtpPassword;						// SMTP account password
					  		  
						$mail->AddReplyTo($smtpFrom, '');
						$mail->AddAddress($toEmailAddress, $toFullName);
						$mail->AddAddress($adminEmailAddress, '');
						$mail->SetFrom($smtpFrom, '');
			
						$mail->Subject		= $emailSubject;
						$mail->Body			= $emailBody;							// optional - MsgHTML will create an alternate automatically
						//	$mail->MsgHTML($emailBody);
						
						//print_r($mail);
						
						//$mail->Send();		//	uncomment to turn on
				
				} catch (phpmailerException $e) {
					echo $e->errorMessage(); 										//	Pretty error messages from PHPMailer
				} catch (Exception $e) {
					 echo $e->getMessage(); 										//	Boring error messages from anything else!
				};
			
			}
		}

	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	
?>