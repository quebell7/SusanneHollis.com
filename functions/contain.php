<?php

	/*------------------------------		
		Version: 	1.0
		Created:	John Morris			
		Modified:	02/19/2010
		
		
		Usage: 
		
			$i = 'John Morris';
			
			contain($i, 'jo'); will return true
			
			contain($i, '.'); will return false
			
	------------------------------*/
	
	
	/*	contain function
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		if(!function_exists('contain')){
			function contain( $string, $lookingFor ) {
		
				$output = false;
				
				if ( strlen( strstr( $string, $lookingFor ) ) > 0 ) {
					$output = true;
				}
				
				return $output;
			
			}
		}
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -*/	


	
?>