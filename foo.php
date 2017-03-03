<?php
	
	
/*		FileMaker Pro config stuff
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

        require_once('FileMaker.php');
	
		$databaseName		= 'foo';
		$dbUserName 		= 'jmorris';
		$dbPassword 		= 'tk-421';	   	   
		$dbHostspec 		= 'sterlingdb.fmi.filemaker-cloud.com';	   
		//$dbHostspec 		= '127.0.0.1';	   
	    
		$fmpConnection 		= new FileMaker($databaseName, 		$dbHostspec, $dbUserName, $dbPassword);		

			
	/*	FileMaker Search
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
			
	
		$search = $fmpConnection->newFindAllCommand('foo');	
		$searchResults = $search->execute();
	
		$found = 0;
		
		if(FileMaker::isError($searchResults)) {

			echo 'Error: ' . $searchResults->getCode() . ': ' . $searchResults->getMessage() . '\n';
			exit;
	
		}else{
			
			$found = $searchResults->getFoundSetCount();
			echo $found;		

		}




?>