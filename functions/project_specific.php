<?php



	/*	generate_uuid
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		
		function generate_uuid() {
			return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
				mt_rand( 0, 0xffff ),
				mt_rand( 0, 0x0fff ) | 0x4000,
				mt_rand( 0, 0x3fff ) | 0x8000,
				mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
			);
		}

		
		
	/*	
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */



	/* send confirmation email
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
		if(!function_exists('sendEmail')){
	
			function sendEmail($emailArray){
	
				global $fmpConnection;
	
				require_once(dirname(__FILE__).'/../includes/email_vars.php');

				$mail	= new PHPMailer(true); 										// the true param means it will throw exceptions on errors, which we need to catch
				$mail->MailerDebug	= false;
				$mail->IsSMTP(); 													// telling the class to use SMTP
			
				try {	$mail->Host			= $smtpHost; 							// SMTP server
						$mail->SMTPDebug	= 1;									// enables SMTP debug information (for testing), set to 2 for development
						$mail->SMTPAuth		= true;									// enable SMTP authentication
						$mail->Host			= $smtpHost;							// sets the SMTP server
						$mail->Port			= $smtpPort;							// set the SMTP port for the GMAIL server
						$mail->Username   	= $smtpFrom;							// SMTP account username
						$mail->Password   	= $smtpPassword;						// SMTP account password
						//$mail->SMTPSecure 	= 'ssl';                 // sets the prefix to the servier
						//$mail->SMTPSecure 	= 'tls';                 // sets the prefix to the servier
					  	
					  		  
						$mail->AddReplyTo($smtpFrom, '');
						$mail->AddAddress($emailArray['to'],'');
						$mail->SetFrom($smtpFrom, '');
			
						$mail->Subject		= $emailArray['subject'];
						$mail->Body			= $emailArray['body'];							// optional - MsgHTML will create an alternate automatically
						$mail->MsgHTML($emailArray['body']);
						
						//print_r($mail);
						
						$mail->Send();
				
				} catch (phpmailerException $e) {
					echo $e->errorMessage(); 										//	Pretty error messages from PHPMailer
				} catch (Exception $e) {
					 echo $e->getMessage(); 										//	Boring error messages from anything else!
				};
				
				return $mail;
				
			};
			
		};
		
		//pretty_r($mail);

	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */


?>