<?php
	


	function timerStart(){
		
		global $_timerStart;
		global $_timerArray;

		$_timerStart = microtime(true);
	}
	
	function timerEnd($label='no label provided'){
		
		global $_timerStart;
		global $_timerArray;
		
		$_timerArray[$label] = (microtime(true) - $_timerStart);
		
	}
	
	function timerDisplay(){
		
		global $_timerArray;
		
		
		$outputHTML = '';
		
		$totalTime = 0.0;
		foreach($_timerArray as $x => $y){
			
			$outputHTML .= '<div>';
			$outputHTML .= '<div class="inlineBlock" style="width: 300px;">'.$x.':</div>';
			$outputHTML .= '<div class="inlineBlock" style="width: 300px;">'.$y.'</div>';
			$outputHTML .= '</div>';
			$totalTime = $totalTime + $y;
		}
			$outputHTML .= '<div>';
			$outputHTML .= '<div class="inlineBlock" style="width: 300px;">Total Time:</div>';
			$outputHTML .= '<div class="inlineBlock" style="width: 300px;">'.$totalTime.'</div>';
			$outputHTML .= '</div>';

		
		return ( $outputHTML);

	}
	

	
?>