// JavaScript Document
var overlay_login;
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

	overlay_login = $("#overlay_login a[rel]").overlay({top: top,
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
                Load_login("../");
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
    function PressioneLogin(e) {
        // IE
        var tasto;
        if(window.event){
            tasto = e.keyCode;
        }
        // Netscape/Firefox/Opera
        else if(e.which){
            tasto = e.which;
        }
        if (tasto == 13) {
            Login_submit("../");
        }
    }
	function Login_submit(prepath){
		var sfida = $("#copia_sfida").val();
   	 	var pwd = $("#login_pwd").val();
		var login_user = $("#login_user").val();

		if(pwd == "" || login_user == "" || pwd ==null || login_user == null || !login_user || !pwd) {
			$('#ajax_login').html('<img src="' + prepath + 'image/icone/error.png" style="width:10px; padding-right:1px;" alt="Errore" /> Ricontrolla i tuoi dati.<br/> <a target="_self" onclick="show_recupero_password(\'../\',\'0\')" style="cursor:pointer;color:#000; text-decoration: underline;">Hai dimenticato la password?</a>');
			return false;
		}

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
                  location.href=prepath+obj.user+'/personal_area';
              }else{
                  if(obj.msg==1)
                      $('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="width:10px; padding-right:1px;" alt="Errore" /> Ricontrolla i tuoi dati.<br/> <a target="_self" onclick="show_recupero_password(\''+prepath+'\',\'0\')" style="cursor:pointer;color:#000; text-decoration: underline;">Hai dimenticato la password?</a>');
                  if(obj.msg==2)
                      $('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="width:10px; padding-right:1px;" alt="Errore" /> Account disabilitato. Hai effettuato troppi tentativi di login errati nelle ultime due ore.<br/> Riprova tra due ore o effettua un <a target="_self" onclick="show_recupero_password(\''+prepath+'\',\'0\')" style="color:#000;cursor:pointer;text-decoration: underline;">recupero password</a>');
              }
		  },
		  error:function(){
			// failed request; give feedback to user
			$('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
		  }
		});
	}
    function Logout(prepath){
        var avatar_username = $("#avatar_username").val();
        $.ajax({
            type: 'POST',
            url: prepath+"card/php/card_handler.php",
            data: { Logout: "true",
                Username: avatar_username
            },
            dataType: "html",
            beforeSend:function(){
            },
            success:function(data){
                if(prepath==""){
                    location.href='index.php';
                }else{
                    location.href=prepath+avatar_username;
                }
            },
            error:function(){
                // failed request; give feedback to user
                $('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
            }
        });
    }
function show_recupero_password(prepath,iscard){
	$.ajax({
		type: 'POST',
		url: prepath+"card/php/card_handler.php",
			data: { Load_recupero_pass: "true",
					prepath: prepath,
					iscard: iscard
		},
		dataType: "html",
		beforeSend:function(){
			$('#login_container').html('<img src="'+prepath+'image/icone/spinner-big.gif" style="width:10%" alt="Loading..." />');
		},
		success:function(data){
			$('#login_container').html(data);
		},
		error:function(){
			// failed request; give feedback to user
			$('#login_container').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');

		}
	});
}
function PressioneInvioRecupero(e) {
	// IE
	var tasto;
	if(window.event){
		tasto = e.keyCode;
	}
	// Netscape/Firefox/Opera
	else if(e.which){
		tasto = e.which;
	}
	if (tasto == 13) {
		Invia_recupero();
	}
}
function Invia_recupero(){
	var recupero = $("#personal_login_recupero").val();
	$.ajax({
		type: 'POST',
		url: "../card/php/card_handler.php",
		data: { Invia_recupero: "true",
			recupero: recupero
		},
		dataType: "html",
		beforeSend:function(){
			$('#ajax_recupero').html('<img src="../../image/icone/spinner-big.gif" style="width:10%" alt="Loading..." />');
		},
		success:function(data){
			var obj = jQuery.parseJSON(data);
			if(obj.result==0){
				$('#ajax_recupero').html("Una email è stata inviata all'indirizzo "+obj.address+".");
			}else if(obj.result==2){
				$('#ajax_recupero').html("Account non trovato. L'username o l'indirizzo inserito non è presente nel Database.");
			}else if(obj.result==1){
				$('#ajax_recupero').html("Una email è già stata inviata all'indirizzo "+obj.address+". Se non riesci a recuperare la tua password contattaci all'indirizzo info@topmanagergroup.com");
			}
		},
		error:function(){
			// failed request; give feedback to user
			$('#ajax_recupero').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');

		}
	});

}
function Open_overlay_login(){
    overlay_login.overlay().load();
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
}
