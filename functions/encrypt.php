<?php
	if(!function_exists('encrypt')){
		function encrypt($string, $key) {
		  $result = '';
		  for($i=0; $i<strlen($string); $i++) {
		    $char 		= substr($string, $i, 1);
		    $keychar	= substr($key, ($i % strlen($key))-1, 1);
		    $char 		= chr(ord($char)+ord($keychar));
		    $result.=$char;
		  }
		  
		  $result = base64_encode($result);
		  $result = base64url_encode($result);
		   
		  return $result;

		}
	}	
	if(!function_exists('decrypt')){
		function decrypt($string, $key) {
		  $result = '';
		  
		  
		   $string = base64url_decode($string);

		  $string = base64_decode($string);
		  for($i=0; $i<strlen($string); $i++) {
		    $char 		= substr($string, $i, 1);
		    $keychar	= substr($key, ($i % strlen($key))-1, 1);
		    $char 		= chr(ord($char)-ord($keychar));
		    $result.=$char;
		  }
		  
		  
		  return $result;
		}	
	}
	
	if(!function_exists('base64url_encode')){
		function base64url_encode($data) { 
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
		}
	} 
	
	
	if(!function_exists('base64url_decode')){
		function base64url_decode($data) { 
			return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
		}
	} 
	
	
	
?>