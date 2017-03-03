<?php
	
	$sort 			= (isset($_REQUEST['sort']) 	? $_REQUEST['sort'] : '' );
	$page 			= (isset($_REQUEST['page']) 	? $_REQUEST['page'] : 1 );
	$maxNumber		= 20;
	$skipCount		= 0;
		($page > 0 ? $skipCount = ($page-1)*$maxNumber: '');

	$addSearch = (!isset($_REQUEST['page']) ? true : false);
	

	$possibleSearchCriteria = array();
	
/*
	if( isset($_REQUEST['sort']) && $_REQUEST['sort'] != '' ){	
		$possibleSearchCriteria['sort'] = $_REQUEST['sort']; 
	}
*/
	if( isset($_REQUEST['category']) && $_REQUEST['category'] != '' ){	
		$possibleSearchCriteria['category'] = $_REQUEST['category']; 
	}
	if( isset($_REQUEST['style']) && $_REQUEST['style'] != '' ){	
		$possibleSearchCriteria['style'] = $_REQUEST['style']; 
	}

	if( isset($_REQUEST['origin']) && $_REQUEST['origin'] != '' ){	
		$possibleSearchCriteria['origin'] = $_REQUEST['origin']; 
	}
	
	if( isset($_REQUEST['circa']) && $_REQUEST['circa'] != '' ){	
		$possibleSearchCriteria['circa'] = $_REQUEST['circa']; 
	}
	
	if( isset($_REQUEST['region']) && $_REQUEST['region'] != '' ){	
		$possibleSearchCriteria['region'] = $_REQUEST['region']; 
	}
	
	if( isset($_REQUEST['width']) && $_REQUEST['width'] != '' && $_REQUEST['width'] != '0,150' ){	
		$possibleSearchCriteria['width'] = $_REQUEST['width']; 
	}
	
	if( isset($_REQUEST['height']) && $_REQUEST['height'] != '' && $_REQUEST['height'] != '0,150' ){	
		$possibleSearchCriteria['height'] = $_REQUEST['height']; 
	}
	
	if( isset($_REQUEST['depth']) && $_REQUEST['depth'] != '' && $_REQUEST['depth'] != '0,150' ){	
		$possibleSearchCriteria['depth'] = $_REQUEST['depth']; 
	}



	$add = $fmpConnection->newAddCommand('web_searchLogs');	
		$add->setField('ipaddress',			$clientIP); 
		$add->setField('browser',			$_SERVER['HTTP_USER_AGENT']); 
		
		if(isset($_SESSION['contactID'])){
			$add->setField('contactID',			$_SESSION['contactID']); 
		}

	$search = $fmpConnection->newFindCommand('web_list');	
		$search->addFindCriterion('Status',				'Active');
		
		if( isset($_REQUEST['category']) && $_REQUEST['category'] != '' ){	
			$search->addFindCriterion('Category',			$_REQUEST['category']); 
			$add->setField('category',			$_REQUEST['category']); 
		}
		
		if( isset($_REQUEST['style']) && $_REQUEST['style'] != '' ){	
			$search->addFindCriterion('SH_style',			$_REQUEST['style']); 
			$add->setField('style',			$_REQUEST['style']); 
		}

		if( isset($_REQUEST['origin']) && $_REQUEST['origin'] != '' ){	
			$search->addFindCriterion('SH_origin',			$_REQUEST['origin']); 
			$add->setField('origin',			$_REQUEST['origin']); 
		}
		
		if( isset($_REQUEST['circa']) && $_REQUEST['circa'] != '' ){	
			$search->addFindCriterion('SH_Circa',			$_REQUEST['circa']); 
			$add->setField('circa',			$_REQUEST['circa']); 
		}
		
		if( isset($_REQUEST['region']) && $_REQUEST['region'] != '' ){	
			$search->addFindCriterion('SH_region',			$_REQUEST['region']); 
			$add->setField('region',			$_REQUEST['region']); 
		}
		
		if( isset($_REQUEST['width']) && $_REQUEST['width'] != '' && $_REQUEST['width'] != '0,150' ){	
			$search->addFindCriterion('SH_Width',			explode(',', $_REQUEST['width'])[0] . '...' . explode(',', $_REQUEST['width'])[1]); 
			$add->setField('width',			$_REQUEST['width']); 
		}
		
		if( isset($_REQUEST['height']) && $_REQUEST['height'] != '' && $_REQUEST['height'] != '0,150' ){	
			$search->addFindCriterion('SH_Height',			explode(',', $_REQUEST['height'])[0] . '...' . explode(',', $_REQUEST['height'])[1]); 
			$add->setField('height',			$_REQUEST['height']); 
		}
		
		if( isset($_REQUEST['depth']) && $_REQUEST['depth'] != '' && $_REQUEST['depth'] != '0,150' ){	
			$search->addFindCriterion('SH_Depth',			explode(',', $_REQUEST['depth'])[0] . '...' . explode(',', $_REQUEST['depth'])[1]); 
			$add->setField('depth',			$_REQUEST['depth']); 
		}
		
		if($sort == 'height_desc'){
			$search->addSortRule('SH_Height', 1, FILEMAKER_SORT_DESCEND);
		}
		if($sort == 'height_asc'){
			$search->addSortRule('SH_Height', 1, FILEMAKER_SORT_ASCEND);
		}
		if($sort == 'width_desc'){
			$search->addSortRule('SH_Width', 1, FILEMAKER_SORT_DESCEND);
		}
		if($sort == 'width_asc'){
			$search->addSortRule('SH_Width', 1, FILEMAKER_SORT_ASCEND);
		}
		if($sort == 'depth_desc'){
			$search->addSortRule('SH_Depth', 1, FILEMAKER_SORT_DESCEND);
		}
		if($sort == 'depth_asc'){
			$search->addSortRule('SH_Depth', 1, FILEMAKER_SORT_ASCEND);
		}

		$search->setRange($skipCount, $maxNumber);
	$searchResults = $search->execute();	
	
	if($addSearch){
		$addResults 	= $add->execute();	
	}

	
	$found	= 0;

	$showResults = false;
	if(!FileMaker::isError($searchResults)) {
		$showResults	= true;
		$results 		= $searchResults->getRecords();
		$found 			= $searchResults->getFoundSetCount();
	}

	$previousNumber 	= $page - 1;
	$nextNumber			= $page + 1;
	$numberOfPages 		= ceil((double)($found)/(double)($maxNumber));

	$formParamArray = array();
	foreach($possibleSearchCriteria as $name => $value){
		//echo $name  . ': ' . $value . '<br>';
		array_push($formParamArray, '<input type="hidden" name="' . $name . '" value="' . $value . '">');
	}
	
	
	$previousForm =	'<form role="form" action="search_results.php" method="post">';
	$previousForm .= implode('', $formParamArray);
	$previousForm .= '<input type="hidden" name="sort" value="' . $sort . '">';
	$previousForm .= '<input type="hidden" name="page" value="' . $previousNumber . '">';
	$previousForm .= '<button type="submit" class="btn btn-primary btn-block spaceBottom">&laquo;</button>';
	$previousForm .= '</form>';
	
	$nextForm =	'<form role="form" action="search_results.php" method="post">';
	$nextForm .= implode('', $formParamArray);
	$nextForm .= '<input type="hidden" name="sort" value="' . $sort . '">';
	$nextForm .= '<input type="hidden" name="page" value="' . $nextNumber . '">';
	$nextForm .= '<button type="submit" class="btn btn-primary btn-block spaceBottom">&raquo;</button>';
	$nextForm .= '</form>';

	
	$sortForm =	'<form role="form" action="search_results.php" id="sortForm" method="post">';
	$sortForm .= implode('', $formParamArray);
	$sortForm .= '<input type="hidden" name="sort" id="sort" value="">';
	$sortForm .= '</form>';

/*
	$sortForm .= '<button type="button" class="btn btn-default btn-block spaceBottom sortResultsForm" field="height" order="asc" >Sort Height <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span></button>';
	$sortForm .= '<button type="button" class="btn btn-default btn-block spaceBottom sortResultsForm" field="height" order="desc" >Sort Height <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span></button>';
*/

		
		$sortHeight_asc = '<button type="button" class="btn btn-default sortResultsForm" field="height" order="asc" subcat="' . $subCat . '">Sort Height <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span></button>';
		$sortHeight_des = '<button type="button" class="btn btn-default sortResultsForm" field="height" order="desc" subcat="' . $subCat . '">Sort Height <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span></button>';

		$sortWidth_asc = '<button type="button" class="btn btn-default sortResultsForm" field="width" order="asc" subcat="' . $subCat . '">Sort Width <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span></button>';
		$sortWidth_des = '<button type="button" class="btn btn-default sortResultsForm" field="width" order="desc" subcat="' . $subCat . '">Sort Width <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span></button>';
		
		$sortDepth_asc = '<button type="button" class="btn btn-default sortResultsForm" field="depth" order="asc" subcat="' . $subCat . '">Sort Depth <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span></button>';
		$sortDepth_des = '<button type="button" class="btn btn-default sortResultsForm" field="depth" order="desc" subcat="' . $subCat . '">Sort Depth <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span></button>';

		$sortButtons = $sortHeight_des . $sortWidth_des . $sortDepth_des;
		
		if($sort == 'height_desc'){
			$sortButtons = $sortHeight_asc . $sortWidth_des . $sortDepth_des;
		}
		if($sort == 'width_desc'){
			$sortButtons = $sortHeight_des . $sortWidth_asc . $sortDepth_des;
		}
		if($sort == 'depth_desc'){
			$sortButtons = $sortHeight_des . $sortWidth_des . $sortDepth_asc;
		}

?>
	<div class="row">
		
		<div class="col-xs-12">
			
			<div class="btn-toolbar" role="toolbar" aria-label="">
				
<!--
				<div class="btn-group hidden-xs" role="group" aria-label="">
					<a href="search.php?category=<?php echo $subCat;?>"><button type="button" class="btn btn-success">Refine Results <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
				</div>
-->
					<?php echo $sortForm;?>

				<div class="btn-group" role="group" aria-label="">
					<?php echo $sortButtons;?>
				</div>
				
	
			</div>
		</div>
		
	</div>	


<div class="page-header">
  <h1>Search Results <small><?php echo $found; ?> found</small></h1>
</div>
<?php
	if(!$showResults){
		echo '<h4>We do not currently have any items in stock that meet your search criteria.</h4>';
	}
?>

	<div class="row">
		<div class="col-xs-3 col-xs-offset-1">
			<?php 
				if( $page > 1){
					
					echo $previousForm;

				}
			?>
		</div>
		<div class="col-xs-4 text-center">
			Page <?php echo $page . ' of ' . $numberOfPages ;?>
		</div>
		<div class="col-xs-3">
			<?php 
				if( ($page * $maxNumber) < $found){
						
						echo $nextForm;
				}
			?>
		</div>

	</div>
	<br><br>
<?php include_once('results_listing.php');?>

	<div class="row">
		<div class="col-xs-3 col-xs-offset-1">
			<?php 
				if( $page > 1){
					
					echo $previousForm;

				}
			?>
		</div>
		<div class="col-xs-4 text-center">
			Page <?php echo $page . ' of ' . $numberOfPages ;?>
		</div>
		<div class="col-xs-3">
			<?php 
				if( ($page * $maxNumber) < $found){
						
						echo $nextForm;
				}
			?>
		</div>

	</div>
