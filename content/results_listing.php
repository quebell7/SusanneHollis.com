<style>
	img.listImage, div.listImage {
		height: 200px;
	}
	
	div.item {
		height: 400px;
	}
	
	.item .caption {
		height: 100px;
	}
	
/*
	
	.viewButton{
		vertical-align: bottom;
		position: absolute;
		top: 25px;
	}
	
	.caption{
		position: relative;
	}
*/
	
	.dimensions{
		height: 25px;
	}
	

</style>

 
  	 <div class="row">
<?php  
	
	if($showResults){
		$loopCount = 1;
				
		foreach($results as $thisRecord){
		
			$thisPrice 		= $thisRecord->getField('Price');
			if($thisPrice != ''){
				$thisPrice	= '$'.number_format($thisPrice, 0, '.', ',');
			}
			
			$dimensionsArray = array();
								
				if($thisRecord->getField('SH_Height') != ''){
					array_push($dimensionsArray, 'H ' . $thisRecord->getField('SH_Height').'"');
				}
				
				
				if($thisRecord->getField('SH_Width') != ''){
					array_push($dimensionsArray, 'W ' . $thisRecord->getField('SH_Width').'"');
				}
		
				if($thisRecord->getField('SH_Depth') != ''){
					array_push($dimensionsArray, 'D ' . $thisRecord->getField('SH_Depth').'"');
				}
				
				$dimensions = implode(' x ', $dimensionsArray);
				
				$showImage = ($thisRecord->getField('Image_Data') == '' ? false : true);

?>   
        
        
  <div class=" col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-3">
    <div class="thumbnail item">
       <div class="caption">
        <h4><small><?php echo $thisRecord->getField('Product');?></small></h4>
      </div>
	  
      <?php
	      if($showImage){
		      echo '<img src="image_serve.php?url=' . urlencode($thisRecord->getField('Image_Data')) . '" class="img-responsive center-block listImage" alt="'.$thisRecord->getField('Product').'" />';
		}else{
			echo '<div class="row text-center listImage"><br><br><br><br><br><small>Image not Available</small></div>';
		}
	 ?>
	 	
	 	<h5 class="text-center dimensions"><?php echo $dimensions;?><br/>
	 	<?php echo ($logedin ? $thisPrice : '<a href="login.php">Login</a> to view prices');?></h5>
	 	
		<div class="caption">
			<div class="row">
			    <div class="viewButton">
				  <a href="item_detail.php?sku=<?php echo urlencode($thisRecord->getField('SKU_Number'));?>" class="btn btn-default col-xs-offset-1 col-xs-10 addBottom" role="button">View</a>
			 	</div>
			</div>
		</div>
    </div>
  </div>


<?php
			$loopCount++;
		}
	}
?>
	</div>
