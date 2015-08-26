// JavaScript Document
$(document).ready(function(){
	$(window).resize(function() {
		if(document.documentElement.clientWidth <=615){
			$('#tmgheader_logo_img').attr("src","../../image/banner/logo_headertmg_mobile.png");
		}else{
			$('#tmgheader_logo_img').attr("src","../../image/banner/logo_headertmg.png");
		}
	}).resize();
	$(window).resize(function() {
		if(document.documentElement.clientWidth >=1200){
			$(".apple_overlay_login").width(995);
			$(".apple_overlay_login").height(553);
			$(".apple_overlay_login").css("left",(document.body.clientWidth-995)/2);
			if( ((document.body.clientHeight-553) /2)<50){
				$(".apple_overlay_login").css("top",50);
			}else{
				$(".apple_overlay_login").css("top",(document.body.clientHeight-553)/2);
			}
		}else{
			$(".apple_overlay_login").css("left",0);
			$(".apple_overlay_login").css("top",0);
			$(".apple_overlay_login").height( document.body.clientHeight);
			$(".apple_overlay_login").width( document.body.clientWidth+15);
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	});
	
	var overlay_login = $("#overlay_login a[rel]").overlay({top: top,
			left: 0,
			speed: 500,
			fixed: false,
			closeOnClick: false,
			closeOnEsc: true,
			oneInstance: false,
			onClose: function(){
				/*elem = document.getElementById("overlay");
				elem.style.visibility="visible";
				var username = $("#in_username").val();
				window.location.href = '../' + username; */  
			},
			onBeforeLoad: function() {
				$(window).scrollTop();
			},
			mask: {
				color: '#000'
			}
		}).bind("onLoad", function(e) {
			if(document.documentElement.clientWidth >=1200){
				$(".apple_overlay_login").width(995);
				$(".apple_overlay_login").height(553);
				
				$(".apple_overlay_login").css("left",(document.body.clientWidth-995)/2);
				
				if( ((document.body.clientHeight-553) /2)<50){
					$(".apple_overlay_login").css("top",50);
				}else{
					$(".apple_overlay_login").css("top",(document.body.clientHeight-553)/2);
				}
			}else{
				$(".apple_overlay_login").css("left",0);
				$(".apple_overlay_login").css("top",0);
				$(".apple_overlay_login").height( document.body.clientHeight);
				$(".apple_overlay_login").width( document.body.clientWidth+15);
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
			
			
		}).click(function(){
	  		Load_login("../");
	});
});

	function Load_login(prepath){
		$.ajax({
		  type: 'POST',
		  url: prepath+"card/php/card_handler.php",
		  data: { Load_login: "true",
		  prepath: prepath
				 },
		  dataType: "html",
		  beforeSend:function(){
			$('#ajax_login').html('<img src="'+prepath+'image/icone/ajax_small.gif" alt="Loading..." />');
		  },
		  success:function(data){
			  $('#area_login').html(data);
		  },
		  error:function(){
			// failed request; give feedback to user
			$('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
		  }
		});
	}
	 
	function Login_request_sfida(prepath){
		var user = $("#login_user").val();
		$.ajax({
		  type: 'POST',
		  url: prepath+"card/php/card_handler.php",
		  data: { __user: "true", 
					user: user
				 },
		  dataType: "html",
		  beforeSend:function(){
			//$('#ajax_login').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
		  },
		  success:function(data){
			  $('#copia_sfida').val(data.trim());
		  },
		  error:function(){
			// failed request; give feedback to user
			$('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
		  }
		});
	}
	
	function Login_submit(prepath){
		
		var sfida = $("#copia_sfida").val();
   	 	var pwd = $("#login_pwd").val();
		var pwd = hex_sha512(pwd);
		var login_user = $("#login_user").val();

		$('#login_pwd').val("");
		$("#login_user").val("");
		$.ajax({
		  type: 'POST',
		  url: prepath+"card/php/card_handler.php",
		  data: { __submit: "true", 
					user: login_user,
					pwd: pwd,
					copia_sfida: sfida
				 },
		  dataType: "html",
		  beforeSend:function(){
			$('#ajax_login').html('<img src="'+prepath+'image/icone/ajax_small.gif" alt="Loading..." />');
		  },
		  success:function(data){
			  var obj = jQuery.parseJSON(data);
			  if(obj.result=="true"){
				  var username=$("#in_username").val();
				  /*if(obj.user == username){
					  Load_personal_area();
					  Aggiorna_menu_avatar();
				  }else{*/
				  location.href=prepath+obj.user+'/index.php?personal_area=true';
				  /*}*/
			  }else{
				 $('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Ricontrolla i tuoi dati.<br/> <a target="_self" onclick="Javascript:show_recupero_password()" style="cursor:pointer;">Hai dimenticato la password?</a>');
				  
			  }
		  },
		  error:function(){
			// failed request; give feedback to user
			$('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
		  }
		});
	}
