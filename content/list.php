<style>
/*
	.image-block {
	    border: 3px solid white ;
	    background-color: black;
	    padding: 0px;    
	    margin: 0px;
	    height:200px;
	    text-align: center;
	    vertical-align: bottom;
	}
	
	.image-block > a {
	    text-decoration: none;
	}
	
	.image-block > a > p {
	    width: 100%;
	    height: 100%;
	    font-weight: normal;
	    font-size: 1.25rem;
	    padding-top: 100px;
	    background-color: rgba(3,3,3,0.0);
	    color: rgba(6,6,6,0.0);
	}
	.image-block:hover > a > p {
	    background-color: rgba(2,  2,  2, 0.26);    
	    color: white; 
	}
*/
	

</style>

<?php

	$page 			= (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1 );
	$maxNumber		= 20;
	$skipCount		= 0;
		($page > 0 ? $skipCount = ($page-1)*$maxNumber: '');

	$subCat 	= (isset($_REQUEST['subCat']) 	? $_REQUEST['subCat'] : '' );
	$sort 		= (isset($_REQUEST['sort']) 	? $_REQUEST['sort'] : '' );
	
	$found		= 0;

	if($subCat == ''){
		header("Location: index.php");
	}
	
	$search = $fmpConnection->newFindCommand('web_list');	
		$search->addFindCriterion('Category',			'=='.$subCat);
		$search->addFindCriterion('Status',				'Active');
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
	
	//	FILEMAKER_SORT_ASCEND
	
	//pretty_r($searchResults);

	$showResults = false;
	if(!FileMaker::isError($searchResults)) {
		$showResults	= true;
		$results 		= $searchResults->getRecords();
		$found 			= $searchResults->getFoundSetCount();

	}/*
else{
		
		echo "Error: " . $searchResults->getCode() . "\n";
		echo "Error: " . $searchResults->getMessage() . "\n";
		
	}
*/


/*
	echo $found;
	echo $skip;
	echo $maxRecords;
	
	
*/
	
/*
	SH_Height') != ''){
					array_push($dimensionsArray, 'H ' . $thisRecord->getField('SH_Height').'"');
				}
				
				
				if($thisRecord->getField('SH_Width') != ''){
					array_push($dimensionsArray, 'W ' . $thisRecord->getField('SH_Width').'"');
				}
		
				if($thisRecord->getField('SH_Depth
*/
	
	//$foundCount			= 0
	
	
	$previousNumber 	= $page - 1;
	$nextNumber			= $page + 1;
	$numberOfPages 		= ceil((double)($found)/(double)($maxNumber));

	

		
		$sortHeight_asc = '<button type="button" class="btn btn-default sortResults" field="height" order="asc" subcat="' . $subCat . '">Sort Height <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span></button>';
		$sortHeight_des = '<button type="button" class="btn btn-default sortResults" field="height" order="desc" subcat="' . $subCat . '">Sort Height <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span></button>';

		$sortWidth_asc = '<button type="button" class="btn btn-default sortResults" field="width" order="asc" subcat="' . $subCat . '">Sort Width <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span></button>';
		$sortWidth_des = '<button type="button" class="btn btn-default sortResults" field="width" order="desc" subcat="' . $subCat . '">Sort Width <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span></button>';
		
		$sortDepth_asc = '<button type="button" class="btn btn-default sortResults" field="depth" order="asc" subcat="' . $subCat . '">Sort Depth <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span></button>';
		$sortDepth_des = '<button type="button" class="btn btn-default sortResults" field="depth" order="desc" subcat="' . $subCat . '">Sort Depth <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span></button>';

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


		<div class="row visible-xs">
			<div class="col-xs-12">
				<a href="search.php?category=<?php echo $subCat;?>"><button type="button" class="btn btn-success btn-block spaceBottom">Refine Results <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
			</div>
			<br><br>
		</div>


	<div class="row">
		
		<div class="col-xs-12">
			
			<div class="btn-toolbar" role="toolbar" aria-label="">
				
				<div class="btn-group hidden-xs" role="group" aria-label="">
					<a href="search.php?category=<?php echo $subCat;?>"><button type="button" class="btn btn-success">Refine Results <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></a>
				</div>

				<div class="btn-group" role="group" aria-label="">
					<?php echo $sortButtons;?>
				</div>
				
	
			</div>
		</div>
		
	</div>	





<div class="page-header">
  <h1><?php echo (array_key_exists($subCat,$furnitureArray) ? 'Furniture - ' : '') . $allCategoryArray[$subCat];?> <small><?php echo $found; ?> found</small></h1>
</div>

	<div class="row">
		<div class="col-xs-3 col-xs-offset-1">
			<?php 
				if( $page > 1){
					echo '<a href="?subCat='. $subCat . '&page=' . $previousNumber . '" aria-label="Previous"><button type="submit" class="btn btn-primary btn-block spaceBottom">&laquo;</button></a>';
				}
			?>
		</div>
		<div class="col-xs-4 text-center">
			Page <?php echo $page . ' of ' . $numberOfPages ;?>
		</div>
		<div class="col-xs-3">
			<?php 
			if( ($page * $maxNumber) < $found){
					echo '<a href="?subCat='. $subCat . '&page=' . $nextNumber . '" aria-label="Next"><button type="submit" class="btn btn-primary btn-block spaceBottom">&raquo;</button></a>';
				}
			?>
		</div>

	</div>
	<br><br>
	
<?php
	if(!$showResults){
		echo '<h4>We do not currently have any items in stock that meet your search criteria.</h4>';
	}
?>


<?php include_once('results_listing.php');?>


	<div class="row">
		<div class="col-xs-3 col-xs-offset-1">
			<?php 
				if( $page > 1){
					echo '<a href="?subCat='. $subCat . '&page=' . $previousNumber . '" aria-label="Previous"><button type="submit" class="btn btn-primary btn-block spaceBottom">&laquo;</button></a>';
				}
			?>
		</div>
		<div class="col-xs-4 text-center">
			Page <?php echo $page . ' of ' . $numberOfPages ;?>
		</div>
		<div class="col-xs-3">
			<?php 
			if( ($page * $maxNumber) < $found){
					echo '<a href="?subCat='. $subCat . '&page=' . $nextNumber . '" aria-label="Next"><button type="submit" class="btn btn-primary btn-block spaceBottom">&raquo;</button></a>';
				}
			?>
		</div>

	</div>
