$(function(){
	
		// Normalize Carousel Heights - pass in Bootstrap Carousel items.
	$.fn.carouselHeights = function() {
	
	    var items = $(this), //grab all slides
	        heights = [], //create empty array to store height values
	        tallest; //create variable to make note of the tallest slide
	
	    var normalizeHeights = function() {
	
	        items.each(function() { //add heights to array
	            heights.push($(this).height()); 
	        });
	        tallest = Math.max.apply(null, heights); //cache largest value
	        items.each(function() {
	            $(this).css('min-height',tallest + 'px');
	        });
	    };
	
	    normalizeHeights();
	
	    $(window).on('resize orientationchange', function () {
	        //reset vars
	        tallest = 0;
	        heights.length = 0;
	
	        items.each(function() {
	            $(this).css('min-height','0'); //reset min-height
	        }); 
	        normalizeHeights(); //run it again 
	    });
	
	};


    $(window).on('load', function(){
        $('#carousel-example-generic .item').carouselHeights();
    });

	
	
	
	
});	

$( document ).ready(function() {
	    
	    
		 $( window ).load(function() {
			 
			var heights = $(".item").map(function() {
		        return $(this).height();
		    }).get(),
		
		    maxHeight = Math.max.apply(null, heights);
		
		    
/*
		    if($( window ).width() > 768 ){
			    $(".item").height(maxHeight);
			    //$('.addBottom').addClass('bottom-align-text');
			    
		    }
*/
	
			 
			 
		 })
		 
	    
	$('.sortResultsForm').click(function(){
		
		
		var field 	= $(this).attr('field');
		var order 	= $(this).attr('order');
		
		$('#sort').val(field + '_' + order);
		
		$('#sortForm').submit();
		//window.location.assign('list.php?subCat=' + subcat + '&sort=' + field + '_' + order);

		
	});   
	$('.sortResults').click(function(){
		
		
		var subcat 	= $(this).attr('subcat');
		var field 	= $(this).attr('field');
		var order 	= $(this).attr('order');
		
		window.location.assign('list.php?subCat=' + subcat + '&sort=' + field + '_' + order);

		
	});   
	    
	  	    
	$("#ex16b").slider({ min: 0, max: 10, value: [0, 10], focus: true });
	
    $("#width").slider();
    $("#height").slider();
    $("#depth").slider();
	
	
	$("#height").on("change", function(slideEvt) {
		$("#heightSliderVal_xs").text('is between ' + slideEvt.value.newValue[0] + ' inches and ' + slideEvt.value.newValue[1] + ' inches high');
		$("#heightSliderVal").text('is between ' + slideEvt.value.newValue[0] + ' inches and ' + slideEvt.value.newValue[1] + ' inches high');
	});
	
	
	
	$("#width").on("change", function(slideEvt) {
		$("#widthSliderVal_xs").text('is between ' + slideEvt.value.newValue[0] + ' inches and ' + slideEvt.value.newValue[1] + ' inches wide');
		$("#widthSliderVal").text('is between ' + slideEvt.value.newValue[0] + ' inches and ' + slideEvt.value.newValue[1] + ' inches wide');
	});
	
	$("#depth").on("change", function(slideEvt) {
		$("#depthSliderVal_xs").text('is between ' + slideEvt.value.newValue[0] + ' inches and ' + slideEvt.value.newValue[1] + ' inches deep');
		$("#depthSliderVal").text('is between ' + slideEvt.value.newValue[0] + ' inches and ' + slideEvt.value.newValue[1] + ' inches deep');
	});

	

	    
});
