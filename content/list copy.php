<style>
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
/* 	    text-decoration: none; */
	}
	.image-block:hover > a > p {
	    background-color: rgba(2,  2,  2, 0.26);    
	    color: white; 
	}
	

</style>

<?php
	
	$subCat = $_REQUEST['subCat'];
	
	$search = $fmpConnection->newFindCommand('web_products');	
		$search->addFindCriterion('Category',			'=='.$subCat);
		$search->addFindCriterion('Status',				'Active');
	$searchResults = $search->execute();
	
	//pretty_r($searchResults);

	$showResults = false;
	if(!FileMaker::isError($searchResults)) {
		$showResults	= true;
		$results 		= $searchResults->getRecords();
		$found 			= $searchResults->getFoundSetCount();

	}
	
	//pretty_r($results);

	
?>

<div class="page-header">
  <h1>Example page header <small>Subtext for header</small></h1>
</div>


   <div class="container-fluid">
  	 <div class="row">
<?php  
	
	
	//$colSmArray = array(4,8,4,4,4,8,4,4,4,4);
	if(!$showResults){
		echo '<h4>We do not currently have any items in stock that meet your search criteria.</h4>';
	}
	
	if($showResults){
		$loopCount = 0;
		
		echo '<h4>' . $categoryArray[$subCat] . ' - ' . $found . ' found</h4>';
		
		
		foreach($results as $thisRecord){
		
?>   
        <div class="thumbnail image-block col-xs-6 col-sm-4 " style="background: url(<?php echo 'image_serve.php?url=' . urlencode($thisRecord->getField('Image_Data')); ?>		
) no-repeat center top;background-size:cover;">
<!--             <a href="item_detail.php?id=<?php echo $thisRecord->getRecordID();?>"><p><?php echo $thisRecord->getField('Product');?></p></a>         -->
            <a href="item_detail.php?sku=<?php echo urlencode($thisRecord->getField('SKU_Number'));?>"><p><?php echo $thisRecord->getField('Product');?></p></a>        
        </div>

<?php
			$loopCount++;
		}
	}
?>
	</div>
</div>