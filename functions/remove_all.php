<?php

	/*------------------------------		
		Version: 	1.0
		Created:	John Morris			
		Modified:	02/19/2010
		
		
		Usage: 
			
			this will remove all array items that are empty:
				$myArray = removeAll($myArray,'');
			
			this will remove all array items that are = 'John':
				$myArray = removeAll($myArray,'John');
			
	------------------------------*/
	
	
	/*	removeAll function
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		if(!function_exists('removeAll')){
			function removeAll( $array, $val = '', $preserve_keys = true) {
				
				if ( empty($array) || !is_array($array)) return false;
				
				if (!in_array($val, $array)) return $array;
				
				foreach($array as $key => $value) {	
					if ($value == $val) unset($array[$key]);
				
				}
				
				return ($preserve_keys === true) ? $array : array_values($array);
			
			}
		}
	/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -*/	


	
?>