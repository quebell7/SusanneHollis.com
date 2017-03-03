<?php



	/*	pretty_r
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

		if(!function_exists('pretty_r')){
		
			function pretty_r($outputArray){
				
				$output = '<pre>'.print_r($outputArray, 1).'</pre>';
				echo $output;
			}
		       
		}
		 
	/*	
	- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

?>