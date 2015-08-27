var personaloverlay;
var personal_tab_open;
$(".overlay").css("left",0);
$(".overlay").css("top",0);
$(".overlay").css("height","100%");
$(".overlay").css("width","100%");
$(document).ready(function(){
	
	 var collapsed = true;
	  $('nav>h2').click(function() {
		collapsed = !collapsed;
		formatSidebar();
	  });
	  $(window).resize(formatSidebar);
	  formatSidebar();
	 
	  function formatSidebar() {
		if ($(window).width() > 1200) {
		  $('nav').removeClass('collapsible');
		  $('nav ul#menu-principale').show();
		} else {
		  $('nav').addClass('collapsible');
		  if (collapsed) { 
			$('nav ul#menu-principale').hide();
			$('nav > h2').removeClass('minus');
		  } else {
			$('nav ul#menu-principale').show();
			$('nav > h2').addClass('minus');
		  }
		}
	  };
	
	if(document.documentElement.clientWidth <=1199){
		var colsheight = $('.col').outerHeight() + $('.social_container').outerHeight()+$('.card_optionsbutton_container').outerHeight()+80;
		$('.cols').height(colsheight);
	}else{
		$('.cols').height(334);
	}
	
	var t=setTimeout("Inizialize_cols_height()",200);
	
	
	
	$(window).resize(function() {
		if(document.documentElement.clientWidth <=1199){
			var colsheight = $('.col').outerHeight() + $('.social_container').outerHeight()+$('.card_optionsbutton_container').outerHeight()+80;
			$('.cols').height(colsheight);
		}else{
			$('.cols').height(334);
		}
	}).resize();

	
	$(window).resize(function() {
		if (document.documentElement.clientWidth >= 450) {
			if($('#card_slideshow_container').html())
				Carica_photoslide()
			else
				Load_photoslide();
		  }else{
			  $('#card_slideshow_container').html("");
		}
	}).resize();
		

	
	$(".triggers_overlay a[rel]").each(function() {
		var el = $(this);
		var target = el.attr('rel');
		$(target).appendTo('body');
		el.overlay({top: top,
			left: 0,
			speed: 500,
			fixed: false,
			closeOnClick: true,
			closeOnEsc: true,
			oneInstance: true,
			onBeforeLoad: function() {
				if($(target).attr("id")=="biglietto"){
					Load_create_bigliettovisita();	
				}
				if($(target).attr("id")=="fotodocumenti"){
					Load_filebox_public_photo();
					Load_filebox_public_document();	
				}
				if($(target).attr("id")=="file_box"){
					Load_filebox_private();	
				}
				if($(target).attr("id")=="dove_siamo"){
					Load_dove_siamo();
				}
				$(window).scrollTop();
				
				
			},
			mask: {
				color: '#000'
			}
		}).bind("onLoad", function(e) {
			if(document.documentElement.clientWidth >=1200){
				$(".apple_overlay").width(850);
				$(".apple_overlay").height(452);
				
				$(".apple_overlay").css("left",(document.body.clientWidth-850)/2);
				$(".apple_overlay").css("top",(document.body.clientHeight-452)/2);
			}else{
				$(".apple_overlay").height( document.body.clientHeight);
				$(".apple_overlay").width( document.body.clientWidth+15);
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
			
		});
	});
	
	$(window).resize(function() {
		if(document.documentElement.clientWidth >=1200){
			$(".apple_overlay").width(850);
			$(".apple_overlay").height(452);
			
			$(".apple_overlay").css("left",(document.body.clientWidth-850)/2);
			$(".apple_overlay").css("top",(document.body.clientHeight-452)/2);
		}else{
			$(".apple_overlay").css("left",0);
			$(".apple_overlay").css("top",0);
			$(".apple_overlay").height( document.body.clientHeight);
			$(".apple_overlay").width( document.body.clientWidth);
		}
		
		if(document.documentElement.clientWidth >=1200){
			$(".apple_overlay_personal").width(995);
			$(".apple_overlay_personal").height(553);
			
			$(".apple_overlay_personal").css("left",(document.body.clientWidth-995)/2);
			if( ((document.body.clientHeight-553) /2)<50){
				$(".apple_overlay_personal").css("top",50);
			}else{
				$(".apple_overlay_personal").css("top",(document.body.clientHeight-553)/2);
			}
		}else{
			$(".apple_overlay_personal").css("left",0);
			$(".apple_overlay_personal").css("top",0);
			$(".apple_overlay_personal").height( document.body.clientHeight);
			$(".apple_overlay_personal").width( document.body.clientWidth+15);
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	}).resize();
	
	
	
	/*
	var assistenzaoverlay = $("#triggers_assistenza a[rel]").overlay({top: top,
		left: 0,
		speed: 500,
		fixed: false,
		closeOnClick: true,
		closeOnEsc: true,
		oneInstance: true,
		mask: {
			color: '#000'
		}
	});
	
	var abusooverlay = $("#triggers_abuso a[rel]").overlay({top: top,
		left: 0,
		speed: 500,
		fixed: false,
		closeOnClick: true,
		closeOnEsc: true,
		oneInstance: true,
		mask: {
			color: '#000'
		}
	});
	
	var informazionioverlay = $("#triggers_informazioni a[rel]").overlay({top: top,
		left: 0,
		speed: 500,
		fixed: false,
		closeOnClick: true,
		closeOnEsc: true,
		oneInstance: true,
		mask: {
			color: '#000'
		}
	});
	var assistenza=0;
	function openoverlayassistenza(){
		assistenza=1;
		
		assistenzaoverlay.overlay().load();
		personaloverlay.overlay().close();
	}*/
	
	personaloverlay = $("#triggers_personal a[rel]").overlay({top: top,
			left: 0,
			speed: 500,
			fixed: false,
			closeOnClick: false,
			closeOnEsc: true,
			oneInstance: false,
			onClose: function(){
				elem = document.getElementById("overlay");
				elem.style.visibility="visible";
				var username = $("#in_username").val();
				window.location.href = '../' + username;   
			},
			onBeforeLoad: function() {
				$(window).scrollTop();
			},
			mask: {
				color: '#000'
			}
		}).bind("onLoad", function(e) {
			if(document.documentElement.clientWidth >=1200){
				$(".apple_overlay_personal").width(995);
				$(".apple_overlay_personal").height(553);
				
				$(".apple_overlay_personal").css("left",(document.body.clientWidth-995)/2);
				if( ((document.body.clientHeight-553) /2)<50){
					$(".apple_overlay_personal").css("top",50);
				}else{
					$(".apple_overlay_personal").css("top",(document.body.clientHeight-553)/2);
				}
			}else{
				$(".apple_overlay_personal").height( document.body.clientHeight);
				$(".apple_overlay_personal").width( document.body.clientWidth+15);
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
            Load_personal_area(personal_tab_open);
		});
});

function Inizialize_cols_height(){
		if(document.documentElement.clientWidth <=1199){
			var colsheight = $('.col').outerHeight() + $('.social_container').outerHeight()+$('.card_optionsbutton_container').outerHeight()+80;
			$('.cols').height(colsheight);
		}else{
			$('.cols').height(334);
		}
	}
function Open_overlay_personal(tab){
    personal_tab_open = tab;
    personaloverlay.overlay().load();

	if(document.documentElement.clientWidth >=1200){
		$(".apple_overlay_personal").width(995);
		$(".apple_overlay_personal").height(553);

		$(".apple_overlay_personal").css("left",(document.body.clientWidth-995)/2);
		if( ((document.body.clientHeight-553) /2)<50){
			$(".apple_overlay_personal").css("top",50);
		}else{
			$(".apple_overlay_personal").css("top",(document.body.clientHeight-553)/2);
		}
	}else{
		$(".apple_overlay_personal").css("left",0);
		$(".apple_overlay_personal").css("top",0);
		$(".apple_overlay_personal").height( document.body.clientHeight);
		$(".apple_overlay_personal").width( document.body.clientWidth+15);
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}
}