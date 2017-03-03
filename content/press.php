<?php
	
	$pressArray = array();
	
	$thisPressItem['title'] = 'Arroyo Monthly';
	$thisPressItem['image'] = 'SH+in+Arroyo+Monthly.jpeg';
	$thisPressItem['url'] 	= 'https://issuu.com/arroyomonthly/docs/arroyomay2016/1?e=1501275/35380649';
	array_push($pressArray, $thisPressItem);
	
	$thisPressItem['title'] = 'Goop';
	$thisPressItem['image'] = 'SH+in+Goop.png';
	$thisPressItem['url'] 	= 'http://goop.com/shops/california/los-angeles/pasadena/susanne-hollis/';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'LA Times';
	$thisPressItem['image'] = 'LA+Times.jpeg';
	$thisPressItem['url'] 	= 'http://www.latimes.com/home/la-hm-0416-pasadena-showcase-house-20160416-story.html';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'Hometown Pasadena';
	$thisPressItem['image'] = 'Hometown+Pasadena.jpeg';
	$thisPressItem['url'] 	= 'http://hometown-pasadena.com/talk-of-our-towns/ederra-design-studio-showcase-house-master-suite/123494';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'Houzz';
	$thisPressItem['image'] = 'SH+on+Houzz.png';
	$thisPressItem['url'] 	= 'http://www.houzz.com/ideabooks/65243390?utm_source=Houzz&utm_campaign=u2820&utm_medium=email&utm_content=gallery2';
	array_push($pressArray, $thisPressItem);
	
	$thisPressItem['title'] = 'Country Living';
	$thisPressItem['image'] = 'Country+Living.jpeg';
	$thisPressItem['url'] 	= 'http://www.countryliving.com/home-design/decorating-ideas/how-to/g1959/cozy-white-kitchen-decorating-ideas/?slide=4';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'Traditional Home';
	$thisPressItem['image'] = 'SH+in+Traditional+Home.png';
	$thisPressItem['url'] 	= 'http://www.traditionalhome.com/design/beautiful-homes/california-home-decorated-to-feel-tropical-retreat?page=5';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'Elle Decor';
	$thisPressItem['image'] = 'SH+in+Elle+Decor.png';
	$thisPressItem['url'] 	= 'http://www.elledecor.com/design-decorate/house-interiors/';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'House Beautiful';
	$thisPressItem['image'] = 'Sh+in+House+Beautiful.jpeg';
	$thisPressItem['url'] 	= 'http://www.housebeautiful.com/room-decorating/bedrooms/g1/12-romantic-bedrooms/?slide=6';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'House Beautiful';
	$thisPressItem['image'] = 'SH+in+House+Beautiful.png';
	$thisPressItem['url'] 	= 'http://www.housebeautiful.com/design-inspiration/house-tours/g575/malibu-home-by-michael-smith/?slide=2';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'Elle Decor';
	$thisPressItem['image'] = 'SH+in+Elle+Decor-1.png';
	$thisPressItem['url'] 	= 'http://www.elledecor.com/celebrity-style/celebrity-homes/g1556/megan-mullallys-hollywood-haven/';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'The Hollywood Reporter';
	$thisPressItem['image'] = 'Sh+in+The+Hollywood+Reporter.jpeg';
	$thisPressItem['url'] 	= 'http://www.hollywoodreporter.com/gallery/thrs-designer-showhouse-los-angeles-381778/11-designer-to-watch-oliver-m-furth';
	array_push($pressArray, $thisPressItem);

	$thisPressItem['title'] = 'Von Der Ahe Interiors Blog';
	$thisPressItem['image'] = 'SH+in+Von+Der+Ahe+Interiors.jpeg';
	$thisPressItem['url'] 	= 'http://vonderaheinteriors.com/blog/designing-vintage-repurposing-antiques/';
	array_push($pressArray, $thisPressItem);

?>


<div class="page-header">
  <h1>In the Press</h1>
</div>



<div class="row row-eq-height">
<?php  
	foreach($pressArray as $thisItem){
?>   
        
        
	
	<a href="<?php echo $thisItem['url']; ?>" target="_blank" class="">
		<div class="col-xs-12 col-sm-3">
		
			<div class="row ">
				<img src="images/press/<?php echo $thisItem['image']; ?>" class=" img-thumbnail img-responsive center-block" alt="<?php echo $thisItem['title']; ?>" />
			</div>
			<div class="row text-center">
				<?php echo $thisItem['title']; ?>
			</div>
	
		</div>
	</a>



<?php
	}
?>
</div>
