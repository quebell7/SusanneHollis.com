<?php

	$vl_style 	= $fmpConnection->getLayout('web_list')->getValueListTwoFields('PRO_SH_Style');
	$vl_origin 	= $fmpConnection->getLayout('web_list')->getValueListTwoFields('PRO_Sh_Origin');
	$vl_circa 	= $fmpConnection->getLayout('web_list')->getValueListTwoFields('PRO_SH_Circa');
	$vl_region 	= $fmpConnection->getLayout('web_list')->getValueListTwoFields('PRO_SH_Region');

	$category 	= '';
	if( isset($_REQUEST['category']) && $_REQUEST['category'] != '' ){	
		$category = $_REQUEST['category']; 
	}


?>
		
		
		
<div class="page-header">
  <h1>Search our Inventory <small></small></h1>
</div>


<div class="row">
	
	<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
		
		<div class="row">
			
			<form role="form" action="search_results.php" method="post">
				
				
								
				<div class="form-group">
					<div class="row noselect">
						<div class="col-xs-12 col-sm-6 col-md-4">
							<label for="inputSubject" class="control-label">Height</label>
							<span class="visible-xs sliderResults">
								<div id="widthSliderVal_xs" class=" col-xs-12 col-sm-6 col-md-8"></div>
								<br/><br/>
							</span>
							<input id="height" class="col-xs-12 col-sm-6" name="height" data-slider-id="height" type="text" data-slider-min="0" data-slider-max="150" data-slider-step="1" data-slider-value="[0,150]" /> 
						</div>
						<span class="hidden-xs sliderResults">
							<br/>
							<div id="heightSliderVal" class="col-xs-12 col-sm-6 col-md-8"></div>
						</span>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row noselect">
						<div class="col-xs-12 col-sm-6 col-md-4">
							<br/><label for="inputSubject" class="control-label">Width</label>
							<span class="visible-xs sliderResults">
								<div id="heightSliderVal_xs" class="col-xs-12 col-sm-6 col-md-8"></div>
								<br/><br/>
							</span>
							<input id="width" class="col-xs-12 col-sm-6" name="width" data-slider-id="width" type="text" data-slider-min="0" data-slider-max="150" data-slider-step="1" data-slider-value="[0,150]" /> 
						</div>
						<span class="hidden-xs sliderResults">
							<br/>
							<div id="widthSliderVal" class="col-xs-12 col-sm-6 col-md-8"></div>
						</span>

					</div>
				</div>



				<div class="form-group">
					<div class="row noselect">
						<div class="col-xs-12 col-sm-6 col-md-4">
							<br/><label for="inputSubject" class="control-label">Depth</label>
							<span class="visible-xs sliderResults">
								<div id="depthSliderVal_xs" class="col-xs-12 col-sm-6 col-md-8"></div>
								<br/><br/>
							</span>
							<input id="depth" class="col-xs-12 col-sm-6" name="depth" data-slider-id="depth" type="text" data-slider-min="0" data-slider-max="150" data-slider-step="1" data-slider-value="[0,150]" /> 
						</div>
						<span class="hidden-xs sliderResults">
							<br/>
							<div id="depthSliderVal" class="col-xs-12 col-sm-6 col-md-8"></div>
						</span>

					</div>
				</div>

				
				
				<div class="form-group">
					<label for="category" class="control-label">Category</label>
					<option value="">- Select -</option>
					<select class="form-control" id="category" name="category" placeholder="Select the Category">
						<option value="">- Select -</option>
						<?php
							foreach($categoryArray as $x => $y){
								
								$selected = '';
								if($x == $category ){
									$selected = ' selected="selected"';
								}	
									
								if($x != 'Furniture'){
									echo '<option value="' . $x . '" ' . $selected . '>' . $y . '</option>';
								}else{
									echo '<optgroup label="Furniture">';
									foreach($furnitureArray as $x => $y){
										$selected = '';
										if($x == $category ){
											$selected = ' selected="selected"';
										}	

										echo '<option value="' . $x . '" ' . $selected . '>' . $y . '</option>';
									}
									echo ' </optgroup>';
	
								}
								
								
							}
							echo '<optgroup label="All Others">';
							foreach($otherCategoryArray as $x => $y){
								
								$selected = '';
								if($x == $category ){
									$selected = ' selected="selected"';
								}	

								echo '<option value="' . $x . '" ' . $selected . '>' . $y . '</option>';
							}
							echo ' </optgroup>';

						?>
						
						
					</select>	
				</div>
					
				<div class="form-group">
					<label for="style" class="control-label">Style</label>
					<select class="form-control" id="style" name="style">
						<option value="">- Select -</option>
						<?php foreach ($vl_style as $key => $i){
							echo '<option value="' . $i . '">' . $key . '</option>';
						} ?>
					</select>	
				</div>

				<div class="form-group">
					<label for="style" class="control-label">Origin</label>
					<select class="form-control" id="style" name="origin">
						<option value="">- Select -</option>
						<?php foreach ($vl_origin as $key => $i){
							echo '<option value="' . $i . '">' . $key . '</option>';
						} ?>
					</select>	
				</div>
				
				<div class="form-group">
					<label for="style" class="control-label">Circa</label>
					<select class="form-control" id="style" name="circa">
						<option value="">- Select -</option>
						<?php foreach ($vl_circa as $key => $i){
							echo '<option value="' . $i . '">' . $key . '</option>';
						} ?>
					</select>	
				</div>
				
				<div class="form-group">
					<label for="style" class="control-label">Region</label>
					<select class="form-control" id="style" name="region">
						<option value="">- Select -</option>
						<?php foreach ($vl_region as $key => $i){
							echo '<option value="' . $i . '">' . $key . '</option>';
						} ?>
					</select>
				</div>

				



				<div class="form-group">
					<button type="submit" class="btn btn-primary col-xs-offset-1 col-xs-10">Submit</button>
				</div>

			</form>
			
		</div>
		
	</div>
	
</div>
