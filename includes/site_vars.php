<?php

	
	

	/*		misc. vars
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		
		$_development = true;
		
		if($_development){
			ini_set('display_errors', 1);
			//ini_set('error_reporting', E_ALL);
			ini_set('error_reporting', E_ALL & ~E_STRICT & ~E_WARNING);
		}else{
			ini_set('display_errors', 0);
			ini_set('error_reporting', E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE & ~E_WARNING);
		}
		
		ini_set('memory_limit', '256M');
		ini_set('max_execution_time', 60);
		

		$path 						= dirname(__FILE__);
		$clientIP					= $_SERVER['REMOTE_ADDR'];
		$killNav 					= false;
		$currentFile 				= basename($_SERVER['PHP_SELF']);
		$contentFile 				= basename($_SERVER['PHP_SELF']);
		$pageTitle 					= 'Susanne Hollis';
		$cryptKey					= 'iSolutions2016';
		$displayMessage				= '';
		$errorMessage				= '';
		$siteURL					= 'http://64.83.204.186/hollis/';

	/*		
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	




	/*		functions
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		require_once(dirname(__FILE__).'/../functions/session_management.php'); 			// start/load/kill/lock session function
		require_once(dirname(__FILE__).'/../functions/clean_params.php'); 					// cleans the paramaters fo any extended characters
		require_once(dirname(__FILE__).'/../functions/vars_from_params.php'); 				// turn params to vars function
		require_once(dirname(__FILE__).'/../functions/encrypt.php'); 						// encryption/decryption functions
		require_once(dirname(__FILE__).'/../functions/contain.php'); 						// string contains function
		require_once(dirname(__FILE__).'/../functions/remove_all.php'); 					// removeAll from array function
		require_once(dirname(__FILE__).'/../functions/encode_utf8.php'); 					// strange characters from FMP to normal ones on the web ' and " especially
		require_once(dirname(__FILE__).'/../functions/notify_developer.php');
		require_once(dirname(__FILE__).'/../functions/timer.php'); 	
		require_once(dirname(__FILE__).'/../functions/pretty_r.php'); 	
		require_once(dirname(__FILE__).'/../functions/generate_password.php'); 	
		require_once(dirname(__FILE__).'/../functions/project_specific.php'); 	

		varsFromParams('');																	// function to set all form params to vars, it's in site_vars 


	/*		
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	
	
	
	/*		session stuff; 		sessions expires in seconds.....
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		$sessionName	= 'isol_susanne_hollis';
		sessionLoad($sessionName, 3600, 'silent');	// start/load session
		
		$_sessionLockEnforce		= false;
		$_sessionLockLogic 			= !isset( $_SESSION['affiliateFMPID'] ) || $_SESSION['affiliateFMPID'] == '' || $_SESSION['affiliateID'] == '0';
		
		$logedin = false;
		if(isset($_SESSION['contactID']) && $_SESSION['contactID'] != ''){
			$logedin = true;
		}

		
				//	30 min	= 1800
				//	1 hour	= 3600
				//	1 day	= 86400
				//	1 week	= 604800
		
		
	/*		
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */


	
	/*		FileMaker Pro config stuff
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		require_once(dirname(__FILE__).'/../includes/db_connection.php');

	/*		
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */




	/*		pre set date vars
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		
		$currentDate_MySQL 		= date("Y-m-d");
		$currentDate_USA 		= date("m/d/Y");
		$currentTime 			= date("H:i:s");
		$currentTimeStamp		= date("YmdHis");
		
		$currentDateTime_MySQL	= $currentDate_MySQL . ' ' . $currentTime;
		$currentDateTime_USA 	= $currentDate_USA . ' ' . $currentTime;	
	
	/*		
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	
	
	/*	main upload vars
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
	
	/*
			$allowed_ext 		= 'jpg||pdf|gif|doc|docx|txt|rtf|xls|xlsx|ppt'; 	// These are the allowed extensions of the files that are uploaded
			$max_size 			= '5000000'; 	// 50000 is the same as 50kb
			$uploadFolder 		= 'uploads/' . $_SESSION['serialNumber'] . '/';	// upload folder
			$uploadOutput		= ''; 	// var for the output
			$fileNameUpload 	= '';
			$saveAs			= '';
			$permission		= 0777;	// Sets the permissions for all file upload directories
	*/
		
	/*		
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

	$subCat = (isset($_REQUEST['subCat']) ? $_REQUEST['subCat'] : '');

	$otherCategoryArray = array();
		$otherCategoryArray['CARPET'] 			= 'Carpet';
		$otherCategoryArray['CLOISONNE'] 		= 'Cloisonne';
		$otherCategoryArray['FABRIC'] 			= 'Fabric';
		$otherCategoryArray['GLASS'] 			= 'Glass';
		$otherCategoryArray['IVORY'] 			= 'Ivory';
		$otherCategoryArray['JEWELRY'] 			= 'Jewelry';
		$otherCategoryArray['LACQUER'] 			= 'Lacquer';
		$otherCategoryArray['METAL'] 			= 'Metal';
		$otherCategoryArray['MISCELLANEOUS'] 	= 'Miscellaneous';
		$otherCategoryArray['PORCELAIN'] 		= 'Porcelain';
		$otherCategoryArray['REPRODUCTION'] 	= 'Reproduction';
		$otherCategoryArray['SILVER'] 			= 'Silver';
		$otherCategoryArray['STONE'] 			= 'Stone';
		$otherCategoryArray['STRAW'] 			= 'Straw';
		$otherCategoryArray['TEXTILES'] 		= 'Textiles';
		$otherCategoryArray['WOOD'] 			= 'Wood';
		$otherCategoryArray['TERRA-COTTA'] 		= 'Terra-Cotta';
		$otherCategoryArray['Clock'] 			= 'Clock';

	
	$categoryArray = array();
		$categoryArray['Furniture'] 		= 'Furniture';
		$categoryArray['LIGHTING'] 			= 'Lighting';
		$categoryArray['PICTURES'] 			= 'Pictures (art, not Fine Art Gallery)';
		$categoryArray['Collections'] 		= 'Collections';

	$furnitureArray = array();
		$furnitureArray['FURN - BED'] 		= 'Bed';
		$furnitureArray['FURN - BENCH'] 	= 'Bench';
		$furnitureArray['FURN - BOX'] 		= 'Box';
		$furnitureArray['FURN - CABINET'] 	= 'Cabinet';
		$furnitureArray['FURN - CHAIR'] 	= 'Chair';
		$furnitureArray['FURN - CHEST'] 	= 'Chest';
		$furnitureArray['FURN - CONSOLE'] 	= 'Console';
		$furnitureArray['FURN - DESK'] 		= 'Desk';
		$furnitureArray['FURN - DOOR'] 		= 'Door';
		$furnitureArray['FURN - HEADBOARD'] = 'Headboard';
		$furnitureArray['FURN - MIRROR'] 	= 'Mirror';
		$furnitureArray['FURN - MISC'] 		= 'Misc';
		$furnitureArray['FURN - PANEL'] 	= 'Panel';
		$furnitureArray['FURN - RACK'] 		= 'Rack';
		$furnitureArray['FURN - SCREEN'] 	= 'Screen';
		$furnitureArray['FURN - SECRETARY']	= 'Secretary';
		$furnitureArray['FURN - SIDEBOARD'] = 'Sideboard';
		$furnitureArray['FURN - SOFA'] 		= 'Sofa';
		$furnitureArray['FURN - STAND'] 	= 'Stand';
		$furnitureArray['FURN - STOOL'] 	= 'Stool';
		$furnitureArray['FURN - TABLE'] 	= 'Table';
		$furnitureArray['FURN - TANSU'] 	= 'Transu';
		$furnitureArray['FURN - TRUNK'] 	= 'Trunk';

	$allCategoryArray = array_merge($categoryArray,$furnitureArray, $otherCategoryArray);

?>