<?php

	/*------------------------------		
		Version: 	1.3
		Created:	John Morris			
		Modified:	4/7/2016
		
		
		Usage: 
		
			sessionLoad('mySession');
			sessionLoad();
				
	------------------------------*/
	

	/*	sessionLoad
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

	if(!function_exists('sessionLoad')){
	
		function sessionLoad($sessionName='default', $sessionTimeout = 1800, $sessionKill='logout'){
			
			if($sessionName == 'default'){
				unset($sessionName);
			}if( isset($sessionName)){
				session_name($sessionName); // sets the session name to the user input
			}

			
			if(!isset($sessionTimeout)){
				$sessionTimeout = 1800; // sets the session expiration time to 30 minutes (in sec)
			}
			
			session_start();
						
		       if (!isset ($_SESSION['sessionID'])) { // these get set on the session load       	
		       		$_SESSION['sessionID'] = session_ID();
					$_SESSION['sessionName'] = session_name();
					$_SESSION['sessionTimeout'] = $sessionTimeout;
					$_SESSION['authType'] = 'x';
		      	    $_SESSION['sessionLastAccess'] = time();	      	    
		      	    $_SESSION['$sessionStatus'] = 'new';		      	    
					$session_duration = time() - $_SESSION['sessionLastAccess'];

		       } else { // these get set on every time but 1st load
					
					$session_duration = time() - $_SESSION['sessionLastAccess'];
					$_SESSION['sessionLastAccess'] = time();
					$_SESSION['$sessionStatus'] = 'load';
		       }
		       
		       
		       if ($session_duration > $sessionTimeout){
		       
		        
					
					if($sessionKill=='logout'){
					
						header('Location: logout.php?reason=1');  // Redirect to Login Page
						exit;
						
					}elseif($sessionKill=='silent'){
					
						if(isset($_COOKIE[session_name($sessionName)])) {
							session_destroy(); // kill any old session
							setcookie($sessionName, '', time(), '/'); // kill any previous session cookie
							unset($_SESSION);
							
							sessionLoad($sessionName, $sessionTimeout, $sessionKill);	// start/load session
							
						}
							
					}
					

		           
		       }
	       
	       }
		 }
		 
	/*	
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

	
	/*	sessionKill
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
			if(!function_exists('sessionKill')){
			function sessionKill($sessionName='default'){
			
				if($sessionName == 'default'){
					unset($sessionName);
				}if( isset($sessionName)){
					session_name($sessionName); // sets the session name to the user input
				}
	
				
				sessionLoad($sessionName); // calls the load session function, so it can delete it
				unset($_SESSION);
				if (isset($_COOKIE[session_name($sessionName)])) {
							    setcookie(session_name($sessionName), '', time()-42000, '/');
							}
				session_destroy();	       
	       }
		}
	
	/*	
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	/*	sessionLock
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
		if(!function_exists('sessionLock')){

			function sessionLock(){
	
				global $_sessionLockEnforce;
				global $_sessionLockLogic;
	
				if($_sessionLockEnforce && $_sessionLockLogic) {
					header('location: logout.php?reason=1');
					exit;		
				}
			}
		}
		
	/*	
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

?>