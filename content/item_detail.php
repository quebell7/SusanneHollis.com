<?php
	
	//$id 	= $_REQUEST['id'];
	$sku 	= urldecode($_REQUEST['sku']);
	$sku 	= str_replace('#', '\#', $sku);
	
	
	$search = $fmpConnection->newFindCommand('web_products');	
		$search->addFindCriterion('SKU_Number',			'=='.$sku);
	$searchResults = $search->execute();
	if(!FileMaker::isError($searchResults)) {
		$showResults	= true;
		$results 		= $searchResults->getRecords();
		$found 			= $searchResults->getFoundSetCount();
		$thisRecord 	= $results[0];
	}else{
		exit;
	}

	$thisPrice 		= $thisRecord->getField('Price');
	if($thisPrice != ''){
		$thisPrice	= '$'.number_format($thisPrice, 0, '.', ',');
	}


	$imageArray = array();
	if($thisRecord->getField('Image_Data') != ''){
		array_push($imageArray, urlencode($thisRecord->getField('Image_Data')));
	}	
	if($thisRecord->getField('products_container',0) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',0)));
	}
	if($thisRecord->getField('products_container',1) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',1)));
	}
	if($thisRecord->getField('products_container',2) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',2)));
	}
	if($thisRecord->getField('products_container',3) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',3)));
	}
	if($thisRecord->getField('products_container',4) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',4)));
	}
	if($thisRecord->getField('products_container',5) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',5)));
	}
	if($thisRecord->getField('products_container',6) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',6)));
	}
	if($thisRecord->getField('products_container',7) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',7)));
	}
	if($thisRecord->getField('products_container',8) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',8)));
	}
	if($thisRecord->getField('products_container',9) != ''){
		array_push($imageArray, urlencode($thisRecord->getField('products_container',9)));
	}


	//pretty_r($imageArray);

?>

<div class="page-header">
  <h1><?php echo $thisRecord->getField('Product'); ?> <small><?php echo ($logedin ? $thisPrice : '');?></h5>
</small></h1>
</div>

 <div class="row ">
	 
	 <div class="col-xs-12 col-sm-6">
		
		 <div class="row">
			<div class="col-xs-12">
				<label>Product: </label> <?php echo $thisRecord->getField('Product'); ?>
			</div>
			
			<div class="col-xs-12 col-sm-4">
				<label>Price: </label> 	 	<?php echo ($logedin ? $thisPrice : '<a href="login.php">Login</a> to view prices');?></h5>

			</div>
			<div class="col-xs-12 col-sm-8">
				<label>SKU: </label> <?php echo $thisRecord->getField('SKU_Number'); ?>
			</div>	
			
			
			<div class="col-xs-12 col-sm-4">
				<label>Height" </label> <?php echo $thisRecord->getField('SH_Height'); ?>
			</div>
				
			<div class="col-xs-12 col-sm-4">
				<label>Width" </label> <?php echo $thisRecord->getField('SH_Width'); ?>
			</div>	
			
			<div class="col-xs-12 col-sm-4">
				<label>Depth" </label> <?php echo $thisRecord->getField('SH_Depth'); ?>
			</div>
				
			<div class="col-xs-12">
				<label>Description: </label> <?php echo $thisRecord->getField('Description'); ?>
			</div>
			
		

		</div>
		
	</div>

	 <div class="col-xs-12 col-sm-6">

		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		    
		    <?php
			   $i = 0;
			   foreach($imageArray as $thisImage){
				   $isActive = ($i == 0 ? 'active' : '');
				   
			   	echo '<li data-target="#carousel-example-generic" data-slide-to="' . $i . '" class="' . $isActive . '"></li>';
			 		$i++;
			   }
			?>
		
		    
		  </ol>
		
		  <div class="carousel-inner" role="listbox">
		    
		   <?php
			   $i = 0;
			   foreach($imageArray as $thisImage){
			   	$i++;
			?>
		    <div class="item <?php echo ($i == 1 ? 'active': '');?>">
		      <img src="image_serve.php?url=<?php echo $thisImage; ?>" style="center-block" />
		    </div>
		    <?php
			   }
			?>
		  </div>
		
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
	
	
	
	
 </div>
  
  
  