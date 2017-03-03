<?php

	/*		FileMaker Pro config stuff
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

				
        require_once('filemaker.php');
	
		$databaseName		= 'SH_FMSP';
		$dbUserName 		= 'php';
		$dbPassword 		= 'iSolutions2016';	   	   
		$dbHostspec 		= '127.0.0.1';	   
		$fmpConnection 		= new FileMaker($databaseName, 		$dbHostspec, $dbUserName, $dbPassword);		
	

	/*		
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */


?>