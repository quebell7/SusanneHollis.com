<?php
	if(!function_exists('encodeUTF8')){
	
		function encodeUTF8($var){
    		return htmlentities($var, ENT_QUOTES, 'UTF-8');
		}
	}
?>