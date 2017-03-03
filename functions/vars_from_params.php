<?php



	/*----------------------------------------------------------------------------------------------------------
								Function to create all form params to Vars		(Start)
	
			if you want to out put all submitted values, tag output=output in the url, 
			or <input type="hidden" name="output" value="output"/> in a form								
	----------------------------------------------------------------------------------------------------------*/
		
		if(!function_exists('varsFromParams')){
			function varsFromParams($output){
				foreach (array_keys ($_REQUEST) as $currentParam) 
				{
					// Sets the var $currentNamedParam to the $currentParam value
					$currentNamedParam = $_REQUEST[$currentParam];
					global $$currentParam;
					//$$currentParam = cleanParams($currentNamedParam); // took out to allow foreign characters. 3/23/2010
					$$currentParam = $currentNamedParam;
				
					if ($output == 'output')
					{
						echo $currentParam . ' = ' . $$currentParam . '<br />';
					}
				}
			}
		}
	/*--------------------------------------------------------------------------------------------------------*/
	
	
?>