var itvl;
function Carica_photoslide(){
	$('#slides').stop().animate({marginLeft:'0px'},450);
	clearInterval(itvl);
	if(document.documentElement.clientWidth <=1199){
		var containerheight = $('.main_photo_card').height() - $('.card_nome_professione_container').height();
		containerwidth = (containerheight*350)/250;
		
		$('.card_slide_photo').each(function(i){
			$(this).css( "width", containerwidth);
		});
		$('.photoslide_gallery').width(containerwidth);
		$('.photoslide_gallery').height(containerheight);
	}else{
		$('.card_slide_photo').each(function(i){
			$(this).css( "width", 350);
		});
		$('.photoslide_gallery').width(350);
		$('.photoslide_gallery').height(250);
	}
	var totWidth=0;
	var positions = new Array();

	$('#slides .slide').each(function(i){
		positions[i]= totWidth;
		totWidth += $(this).width();
		
	});
	
	$('#slides').width(totWidth);

	/* Change the cotnainer div's width to the exact width of all the slides combined */

	$('#menu ul li a').click(function(e,keepScroll){

			/* On a thumbnail click */

			$('li.menuItem').removeClass('act').addClass('inact');
			$(this).parent().addClass('act');
			
			var pos = $(this).parent().prevAll('.menuItem').length;
			
			$('#slides').stop().animate({marginLeft:-positions[pos]+'px'},450);
			/* Start the sliding animation */
			
			// Stopping the auto-advance if an icon has been clicked:
			if(!keepScroll) clearInterval(itvl);
	});
	
	$('#menu ul li.menuItem:first').addClass('act').siblings().addClass('inact');
	/* On page load, mark the first thumbnail as active */
	
	
	
	/*****
	 *
	 *	Enabling auto-advance.
	 *
	 ****/
	 
	  autoAdvance()
	var current=1;
	function autoAdvance()
	{
		if(current==-1) return false;
		
		$('#menu ul li a').eq(current%$('#menu ul li a').length).trigger('click',[true]);	// [true] will be passed as the keepScroll parameter of the click function on line 28
		current++;
	}

	// The number of seconds that the slider will auto-advance in:
	
	var changeEvery = 3;

	itvl = setInterval(function(){autoAdvance()},changeEvery*1000);

	/* End of customizations */
}