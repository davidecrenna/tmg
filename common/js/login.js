// *************************************************************************************************************************************************
// AJAX PER LOGIN
// *************************************************************************************************************************************************
function comunicazione_ajax(server_page,var_nome,var_valore){
	ajax = create_ajaxRequest();

    ajax.open("POST",server_page,true);
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
    ajax.setRequestHeader("Connection","close"); // no connessioni persistenti.

    ajax.onreadystatechange = function(){
        if (ajax.readyState==4) 
			handler_risposta_server(ajax.responseText);
	}
    var risorsa = escape(var_nome)+ "=" +escape(var_valore);
    ajax.send(risorsa);
    return true;
}

function handler_risposta_server(risposta){
	document.getElementById('copia_sfida').value = risposta.trim();
    return true;
}

function codifica_password()
{
    var sfida = document.getElementById('copia_sfida').value;
    var password_in_chiaro = document.getElementById("pwd").value;
	
	document.getElementById("pwd_codified").value = MD5(sfida+MD5(password_in_chiaro));
    return true;
}

function Login(){
	document.getElementById('login_loading').style.display = "block";
	document.getElementById('log_in_button').onclick = "";
	ajax = create_ajaxRequest();

    ajax.open("POST",'card/php/card_handler.php?__user',true);
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
    ajax.setRequestHeader("Connection","close"); // no connessioni persistenti.

    ajax.onreadystatechange = function(){
        if (ajax.readyState==4){ 
			var risposta = ajax.responseText;
			document.getElementById('copia_sfida').value = risposta.trim();
					
			//creo variabile ajax
			var ajaxRequest = create_ajaxRequest();
			//gestisco risposta ajax
			ajaxRequest.onreadystatechange = function(){
				if(ajaxRequest.readyState == 4){
					var results = ajaxRequest.responseText;
					document.getElementById('login_area').innerHTML = results;
					if(document.getElementById('user_logged').value==1){
						var username = document.getElementById('username').value;
						/*var url_di_provenienza;
						if((url_di_provenienza = document.getElementById('url_di_provenienza'))!=null){
							location.href =  "card/php/"+url_di_provenienza.value+"?u="+username;
						}*/
						document.getElementById("div_banner_sx").style.display = "none";
						change_scheda('scheda_redirect');
						document.getElementById('username_logged').innerHTML = username;
						location.href =  username+"/index.php";
					}
					
				}
			}
			

			var copia_sfida = document.getElementById('copia_sfida').value;
			
			codifica_password();
			
			var pwd = document.getElementById("pwd_codified").value;
			
			//var username = document.getElementById("in_username").value;
			var resta_collegato = document.getElementById("resta_collegato").checked;
			
			var params="user="+user+
			"&pwd="+pwd+
			"&copia_sfida="+copia_sfida+
			"&resta_collegato="+resta_collegato;
			
			ajaxRequest.open("POST", "card/php/login_handler.php?__submit" , true);
			ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajaxRequest.send(params);
			
		}
	}
	
	var user = document.getElementById("user").value;
    var risorsa = escape('user')+ "=" +escape(user);
    ajax.send(risorsa);
    return true;
}
function show_recupero_password(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('personal_login_container').innerHTML = ajaxRequest.responseText;
		}
	}

	var params="Recupero_pass_error="+true;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function invia_recupero(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			if($.trim(ajaxRequest.responseText)=="1")
				Show_Setting_Saved('recupero_saved');
			else
				Show_Setting_Saved('recupero_error');
		}
	}
	
	var email = document.getElementById("in_recupero_email").value;
	var params="Invia_recupero="+true;
	params+="&email="+email;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function torna_login(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('personal_login_container').innerHTML = ajaxRequest.responseText;
		}
	}

	var params="Torna_login_error="+true;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function Show_Setting_Saved(div){
	$("#"+div).show();
	var t=setTimeout("Hide_Setting_Saved('"+div+"')",3000);
}
function Hide_Setting_Saved(div){
	$("#"+div).hide();
}
function Logout(username){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("user_accedi").innerHTML = '<a target="_self" onclick="change_scheda(\'scheda6\');" style="cursor:pointer;"><span style="font-size:13px; font-weight:700; color:#F4CE38;">Iscriviti al gruppo</span></a>';
		}
	}
	var params="Logout="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}